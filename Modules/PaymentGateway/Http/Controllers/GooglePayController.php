<?php

namespace Modules\PaymentGateway\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\OrderRepository;
use Brian2694\Toastr\Facades\Toastr;
use \Modules\Wallet\Repositories\WalletRepository;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Account\Entities\Transaction;
use Modules\FrontendCMS\Entities\SubsciptionPaymentInfo;
use App\Traits\Accounts;
use Carbon\Carbon;
use Modules\UserActivityLog\Traits\LogActivity;

class GooglePayController extends Controller
{
    use Accounts;

    public function __construct()
    {
        $this->middleware('maintenance_mode');
    }  

    public function paymentStatus(Request $request)
    {
        $credential = $this->getCredential();
        if ($request->purpose == "wallet_recharge") {
            $amount = $request->amount;
            $response = $request->requestId;
            $walletService = new WalletRepository;
            return $walletService->walletRecharge($amount, $credential->method->id, $response);
        }
        if ($request->purpose == "order_payment") {
            $amount = $request->amount;
            $response = $request->requestId;
            try {
                $orderPaymentService = new OrderRepository;
                $order_payment = $orderPaymentService->orderPaymentDone($amount, $credential->method->id, $response, (auth()->check())?auth()->user():null);
                if($order_payment == 'failed'){
                    Toastr::error('Invalid Payment');
                    return redirect(url('/checkout'));
                }
                $payment_id = $order_payment->id;
                $data['payment_id'] = encrypt($payment_id);
                $data['gateway_id'] = encrypt($credential->method->id);
                $data['step'] = 'complete_order';
                LogActivity::successLog('Order payment successful.');
                return route('frontend.checkout', $data);
            } catch (\Exception $e) {
                LogActivity::errorLog($e->getMessage());
                return 0;
            }
        }
        if ($request->purpose == "subscription_payment") {
            $amount = $request->amount;
            $response = $request->requestId;
            try {
                $defaultIncomeAccount = $this->defaultIncomeAccount();
                $seller_subscription = getParentSeller()->SellerSubscriptions;
                $transactionRepo = new TransactionRepository(new Transaction);
                $transaction = $transactionRepo->makeTransaction(getParentSeller()->first_name." - Subsriction Payment", "in", "Google Pay", "subscription_payment", $defaultIncomeAccount, "Subscription Payment", $seller_subscription, $amount, Carbon::now()->format('Y-m-d'), getParentSellerId(), null, null);
                $seller_subscription->update(['last_payment_date' => Carbon::now()->format('Y-m-d')]);
                SubsciptionPaymentInfo::create([
                    'transaction_id' => $transaction->id,
                    'txn_id' => $response,
                    'seller_id' => getParentSellerId(),
                    'subscription_type' => getParentSeller()->sellerAccount->subscription_type,
                    'commission_type' => @$seller_subscription->pricing->name
                ]);
                session()->forget('subscription_payment');
                Toastr::success(__('common.paymeny_successfully'),__('common.success'));
                LogActivity::successLog('Subscription payment successful.');
                return redirect()->route('seller.dashboard');
            } catch (\Exception $e) {
                LogActivity::errorLog($e->getMessage());
                return 0;
            }
        }
    }
    private function getCredential(){
        $url = explode('?',url()->previous());
        if(isset($url[0]) && $url[0] == url('/checkout')){
            $is_checkout = true;
        }else{
            $is_checkout = false;
        }
        if(session()->has('order_payment') && app('general_setting')->seller_wise_payment && session()->has('seller_for_checkout') && $is_checkout){
            $credential = getPaymentInfoViaSellerId(session()->get('seller_for_checkout'), 'google-pay');
        }else{
            $credential = getPaymentInfoViaSellerId(1, 'google-pay');
        }
        return $credential;
    }
}
