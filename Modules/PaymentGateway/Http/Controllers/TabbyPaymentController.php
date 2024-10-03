<?php



namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use App\Repositories\OrderRepository;

use Modules\Wallet\Repositories\WalletRepository;

use Brian2694\Toastr\Facades\Toastr;

use Modules\Account\Repositories\TransactionRepository;

use Modules\Account\Entities\Transaction;

use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;

use App\Traits\Accounts;

use Carbon\Carbon;

use Illuminate\Support\Facades\Http;

use Modules\UserActivityLog\Traits\LogActivity;

use Modules\PaymentGateway\Entities\PaymentMethod;

use Modules\PaymentGateway\Entities\SellerWisePaymentGateway;

class TabbyPaymentController extends Controller

{

    use Accounts;



    public function __construct()

    {

        $this->middleware('maintenance_mode');

    }



    public function fees()

    {



        $method = PaymentMethod::where('slug','tabby')->orWhere('method','Tabby')->first();

        $config = getPaymentGatewayInfo($method->id);

        if($config){

            return $config->perameter_3;

        }else{

            return 0;

        }

    }



    public function paymentProcess($data,$items=[], $shipping_address=[])
    {

        $fee = $this->fees();
        $amount = $data['amount'];
        $percentage = ($amount * $fee) /100;
        $payable_amount = $data['amount'] + $percentage;
        $amount = number_format($payable_amount,2,'.','');
        $order_id = date("ymdhis");
        try {
            $credential = $this->getCredential();
            $currency_code = getCurrencyCode();
            $locale = app('general_setting')->language_code;
            if(\Session::has('locale')){
                $locale = \Session::get('locale');
            }
            if(auth()->check()){
                $locale = auth()->user()->lang_code;
            }
            $url = "https://api.tabby.ai/api/v2/checkout";
            $phone = !empty(auth()->user()) ? auth()->user()->phone :'500000001';
            $email = !empty(auth()->user()) ? auth()->user()->email :'card.success@tabby.ai';
            $name = !empty(auth()->user()) ? auth()->user()->first_name :'500000001';
            $created_at = !empty(auth()->user()) ? Carbon::parse(auth()->user()->created_at)->format('c') :Carbon::now()->format('c');

            if(auth()->user()->phone == null)
            {
                Toastr::error("Invalid Phone number or No phone number added on profile. Please update your Phone number","Error");
                return "no-phone";
            }

            if(empty($phone)){
                Toastr::error("Invalid Phone number or No phone number added on profile. Please update your Phone number","Error");
                 return "no-phone";
            }


            $data = [
               "payment" => [

                   "amount" => $amount,
                    "currency" => $currency_code,
                    //"currency" => "AED",
                    "buyer" => [
                       "phone" => $phone,
                       "email" => $email,
                       "name" => $name,
                    ],
                    "shipping_address" => [
                        "city" => $shipping_address['city'],
                        "address" => $shipping_address['address'],
                        "zip" => $shipping_address['zip']
                    ],
                    "order" => [
                        "tax_amount" => 0,
                        "shipping_amount" => 0,
                        "discount_amount" => 0,
                        "updated_at" => Carbon::parse(date("Y-m-d H:i:s"))->format('c'),
                        "reference_id" => $order_id,
                        "items" => $items,
                    ],
                    "buyer_history" => [
                        'registered_since' =>  $created_at,
                        "loyalty_level"=> 0,
                        "wishlist_count" => 0,
                        "is_phone_number_verified"=> true,
                        "is_email_verified"=> true,
                    ],
                    "order_history" => [
                        [
                            "purchased_at" => Carbon::parse(date("Y-m-d H:i:s"))->format('c'),
                            "amount" => $amount,
                            "status" => "new",
                            "buyer" => [
                                "phone" => $phone,
                                "email" => $email,
                                "name" => $name,
                            ],
                        ]
                    ],
                    "meta" => [
                        "order_id" => $order_id,
                        "customer" => auth()->user()->id
                    ],
                    "attachment" => [
                        "body" => "payment_history_simple: ".json_encode([
                            "unique_account_identifier" => auth()->user()->id,
                            "paid_before_flag" => 0,
                            "date_of_last_paid_purchase" => date("Y-m-d"),
                            "date_of_first_paid_purchase" => date("Y-m-d")
                        ]),
                        "content_type" => "application/vnd.tabby.v1+json"
                    ]
                 ],
              "lang" => $locale,
              "merchant_code" => 'FONCY',
              "merchant_urls" => [
                    "success" => route('tabby.success'),
                    "cancel" => route('tabby.canceled'),
                    "failure" => route('tabby.failured')
                ],
              "create_token" => false,
              "token" => null
           ];



            $response = Http::acceptJson()->withToken($credential->perameter_2)->post($url,$data);

            $response = json_decode($response);


            if(!empty($response) && $response->status == 'rejected'){

                Toastr::error('This purchase is above your current spending limit with Tabby, try a smaller cart or use another payment method','Error');
                return false;
            }

            if(!empty($response) && $response->status == 'not_available'){

                Toastr::error('Sorry, Tabby is unable to approve this purchase. Please use an alternative payment method for your order.','Error');
                return false;
            }

             if(!empty($response) && $response->status == 'order_amount_too_high'){

                Toastr::error('This purchase is above your current spending limit with Tabby, try a smaller cart or use another payment method','Error');
                return false;
            }

             if(!empty($response) && $response->status == 'order_amount_too_low'){

                Toastr::error('The purchase amount is below the minimum amount required to use Tabby, try adding more items or use another payment method','Error');
                return false;
            }



            if ($response) {
                if ($response->configuration->available_products->installments[0]->web_url) {
                    return redirect()->to($response->configuration->available_products->installments[0]->web_url)->send();
                }else{
                     Toastr::error("Somthing want wrong",'Error');
                      return false;
                }
            }else{
                 Toastr::error("Somthing want wrong",'Error');
                 return false;
            }

          Toastr::error("Somthing want wrong",'Error');
          return false;
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }



    public function tabbySuccess(Request $request){

        $credential = $this->getCredential();

        $url = "https://api.tabby.ai/api/v2/payments/".$request->payment_id;

        $response = Http::acceptJson()->withToken($credential->perameter_2)->get($url);

        if (session()->has('wallet_recharge')) {

            $walletService = new WalletRepository;

            return $walletService->walletRecharge($response['amount'], $credential->method->id, $response['id']);

        }

        if (session()->has('order_payment')) {

            $amount = $response['amount'];

            $orderPaymentService = new OrderRepository;

            $order_payment = $orderPaymentService->orderPaymentDone($amount, $credential->method->id, $response['id'], (auth()->check())?auth()->user():null);

            if($order_payment == 'failed'){

                Toastr::error('Invalid Payment');

                return redirect(url('/checkout'));

            }

            $payment_id = $order_payment->id;

            $data['payment_id'] = encrypt($payment_id);

            $data['gateway_id'] = encrypt($credential->method->id);

            $data['step'] = 'complete_order';

            Toastr::success(__('common.payment_successfully'),__('common.success'));

            LogActivity::successLog('checkout payment successful.');

            return redirect()->route('frontend.checkout', $data);

        }

        if (session()->has('subscription_payment')) {

            $tnx_check = SubsciptionPaymentInfo::where('txn_id', $response['id'])->first();

            if($tnx_check){

                Toastr::error('Invalid Payment');

            }else{

                $defaultIncomeAccount = $this->defaultIncomeAccount();

                $seller_subscription = getParentSeller()->SellerSubscriptions;

                $transactionRepo = new TransactionRepository(new Transaction);

                $transaction = $transactionRepo->makeTransaction(getParentSeller()->first_name." - Subsriction Payment", "in", "Tabby", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", $seller_subscription, $response['amount'], Carbon::now()->format('Y-m-d'), getParentSellerId(), null, null);

                $seller_subscription->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);

                SubsciptionPaymentInfo::create([

                    'transaction_id' => $transaction->id,

                    'txn_id' => $response['id'],

                    'seller_id' => getParentSellerId(),

                    'subscription_type' => getParentSeller()->sellerAccount->subscription_type,

                    'commission_type' => @$seller_subscription->pricing->name

                ]);

                session()->forget('subscription_payment');

                Toastr::success(__('common.payment_successfully'),__('common.success'));

                LogActivity::successLog('Subscription payment successful.');

            }

            return redirect()->route('seller.dashboard');

        }

        return redirect()->back();

    }

    public function tabbyFailed(Request $request){

        // $credential = $this->getCredential();

        // $url = "https://api.tabby.ai/api/v2/payments/".$request->payment_id;

        // $response = Http::acceptJson()->withToken($credential->perameter_2)->get($url);

        if (session()->has('wallet_recharge')) {

            if (auth()->user()->role->type == 'customer') {

                return redirect(url('wallet/customer/my-wallet-index'));

            } elseif (auth()->user()->role->type == 'seller') {

                return redirect(url('wallet/seller/my-wallet-index'));

            }elseif (auth()->user()->role->type == 'admin') {

                return redirect(url('wallet/admin/my-wallet-index'));

            }

            return redirect(url('/'));

        }elseif (session()->has('order_payment')) {

            return redirect(url('/checkout'));

        }elseif (session()->has('subscription_payment')) {

            return redirect()->route('seller.dashboard');

        }

        return redirect(url('/'));

    }

    public function tabbyCancel(Request $request){

        // $credential = $this->getCredential();

        // $url = "https://api.tabby.ai/api/v2/payments/".$request->payment_id;

        // $response = Http::acceptJson()->withToken($credential->perameter_2)->get($url);

        if (session()->has('wallet_recharge')) {

            if (auth()->user()->role->type == 'customer') {

                return redirect(url('wallet/customer/my-wallet-index'));

            } elseif (auth()->user()->role->type == 'seller') {

                return redirect(url('wallet/seller/my-wallet-index'));

            }elseif (auth()->user()->role->type == 'admin') {

                return redirect(url('wallet/admin/my-wallet-index'));

            }

            return redirect(url('/'));

        }elseif (session()->has('order_payment')) {

            return redirect(url('/checkout'));

        }elseif (session()->has('subscription_payment')) {

            return redirect()->route('seller.dashboard');

        }

        return redirect(url('/'));

    }

    private function getCredential(){

        $url = explode('?',url()->previous());

        if(isset($url[0]) && $url[0] == url('/checkout')){

            $is_checkout = true;

        }else{

            $is_checkout = false;

        }

        if(session()->has('order_payment') && app('general_setting')->seller_wise_payment && session()->has('seller_for_checkout') && $is_checkout){

            $credential = getPaymentInfoViaSellerId(session()->get('seller_for_checkout'), 'tabby');

        }else{

            $credential = getPaymentInfoViaSellerId(1, 'tabby');

        }

        return $credential;

    }

}

