<?php

namespace Modules\Wallet\Http\Controllers;
use App\Traits\Accounts;
use App\Traits\Notification;
use Illuminate\Http\Request;
use Modules\Setup\Entities\City;
use Modules\Setup\Entities\State;
use Illuminate\Routing\Controller;
use Modules\Setup\Entities\Country;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Modules\Account\Entities\Transaction;
use Modules\Wallet\Services\WalletService;
use Modules\GeneralSetting\Entities\Currency;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\Bkash\Http\Controllers\BkashController;
use Modules\Account\Repositories\TransactionRepository;
use Modules\Clickpay\Http\Controllers\ClickpayController;
use Modules\PaymentGateway\Services\PaymentGatewayService;
use Modules\PaymentGateway\Http\Controllers\PaytmController;
use Modules\PaymentGateway\Http\Controllers\PayPalController;
use Modules\PaymentGateway\Http\Controllers\StripeController;
use Modules\MercadoPago\Http\Controllers\MercadoPagoController;
use Modules\PaymentGateway\Http\Controllers\JazzCashController;
use Modules\PaymentGateway\Http\Controllers\MidtransController;
use Modules\PaymentGateway\Http\Controllers\PaystackController;
use Modules\PaymentGateway\Http\Controllers\RazorpayController;
use Modules\PaymentGateway\Http\Controllers\InstamojoController;
use Modules\PaymentGateway\Http\Controllers\PayUmoneyController;
use Modules\SslCommerz\Library\SslCommerz\SslCommerzNotification;
use Modules\PaymentGateway\Http\Controllers\BankPaymentController;
use Modules\PaymentGateway\Http\Controllers\FlutterwaveController;
use Modules\PaymentGateway\Http\Controllers\TabbyPaymentController;

class WalletController extends Controller
{
    use Accounts, Notification;
    protected $walletService;

    public function __construct(WalletService  $walletService)
    {
        $this->middleware('maintenance_mode');
        $this->walletService = $walletService;
    }


    public function index()
    {
        $data['users'] = $this->walletService->getAllUsers();
        return view('wallet::backend.admin.recharge_request_index', $data);
    }

    public function rechargeRequestGetData()
    {
        $transaction = $this->walletService->getAllRequests()->whereIn('payment_method', ['3','4','5','6','8','9','10','11','12','13','14','18','19']);
        return DataTables::of($transaction)
            ->addIndexColumn()
            ->addColumn('date', function ($transaction) {
                return dateConvert($transaction->created_at);
            })
            ->addColumn('email', function ($transaction) {
                return @$transaction->user->email;
            })
            ->addColumn('txn_id', function ($transaction) {
                return view('wallet::backend.admin.components._txn_id_td', compact('transaction'));
            })
            ->addColumn('amount', function ($transaction) {
                return single_price($transaction->amount);
            })
            ->addColumn('GatewayName', function ($transaction) {
                return $transaction->GatewayName;
            })
            ->addColumn('approval', function ($transaction) {
                return view('wallet::backend.admin.components._approval_td', compact('transaction'));
            })
            ->rawColumns(['txn_id', 'approval'])
            ->toJson();
    }

    public function BankRechargeIndex(){
        return view('wallet::backend.admin.bank_request_index');
    }

    public function bankRechargeRequestGetData()
    {
        $transaction = $this->walletService->getAllRequests()->where('payment_method', 'BankPayment');
        return DataTables::of($transaction)
            ->addIndexColumn()
            ->addColumn('date', function ($transaction) {
                return dateConvert($transaction->created_at);
            })
            ->addColumn('email', function ($transaction) {
                return @$transaction->user->email;
            })
            ->addColumn('txn_id', function ($transaction) {
                return view('wallet::backend.admin.components._txn_id_td', compact('transaction'));
            })
            ->addColumn('amount', function ($transaction) {
                return single_price($transaction->amount);
            })
            ->addColumn('type', function ($transaction) {
                return $transaction->type;
            })
            ->addColumn('GatewayName', function ($transaction) {
                return $transaction->GatewayName;
            })
            ->addColumn('approval', function ($transaction) {
                return view('wallet::backend.admin.components._approval_td', compact('transaction'));
            })
            ->rawColumns(['txn_id', 'approval'])
            ->toJson();
    }

    public function offline_index()
    {
        $data['users'] = $this->walletService->getAllUsers()->where('role_id', 4)->where('is_active', 1);

        return view('wallet::backend.admin.offline_index', $data);
    }

    public function offline_index_get_data()
    {
        $transaction = $this->walletService->getAllOfflineRecharge();
        return DataTables::of($transaction)
            ->addIndexColumn()
            ->addColumn('date', function ($transaction) {
                return dateConvert($transaction->created_at);
            })
            ->addColumn('email', function ($transaction) {
                return @$transaction->user->email;
            })
            ->addColumn('txn_id', function ($transaction) {
                return view('wallet::backend.admin.components._offline_txn_id_td', compact('transaction'));
            })
            ->addColumn('amount', function ($transaction) {
                return single_price($transaction->amount);
            })
            ->addColumn('payment_method', function ($transaction) {
                return $transaction->GatewayName;
            })
            ->addColumn('approval', function ($transaction) {
                return view('wallet::backend.admin.components._offline_approval_td', compact('transaction'));
            })
            ->addColumn('action', function ($transaction) {
                return view('wallet::backend.admin.components._offline_action_td', compact('transaction'));
            })
            ->rawColumns(['txn_id', 'approval', 'action'])
            ->toJson();
    }

    public function getUserByRole(Request $request){
        return $this->walletService->getAllUsers()->where('role_id', $request->role_id)->where('is_active', 1);
    }


    public function my_index()
    {
        $data['transactions'] = $this->walletService->getAll();
        if (auth()->user()->role->type != "customer") {
            return view('wallet::backend.seller.my_wallet_index');
        } else {
            return view(theme('pages.profile.wallets.my_wallet_index'), $data);
        }
    }

    public function my_index_get_data()
    {

        $transaction = $this->walletService->getAll();

        return DataTables::of($transaction)
            ->addIndexColumn()
            ->addColumn('date', function ($transaction) {
                return dateConvert($transaction->created_at);
            })

            ->addColumn('amount', function ($transaction) {
                return single_price($transaction->amount);
            })
            ->addColumn('payment_method', function ($transaction) {
                return $transaction->GatewayName;
            })
            ->addColumn('approval', function ($transaction) {
                return view('wallet::backend.seller.components._approval_td', compact('transaction'));
            })
            ->rawColumns(['approval'])
            ->toJson();
    }


    public function create(Request $request, PaymentGatewayService $paymentGatewayService)
    {
        $request->validate([
            'recharge_amount' => 'required|numeric|min:1',
        ]);
        $data['payment_gateways'] = $this->walletService->activePaymentGayteway();
        $currency_code = auth()->user()->currency_code;
        $currency = Currency::where('code', $currency_code)->first();
        if($currency){
            $data['converted_amount'] = $request->recharge_amount / $currency->convert_rate;
        }else{
            $data['converted_amount'] = $request->recharge_amount;
        }
        $data['recharge_amount'] = $request->recharge_amount;

        $data['gateway_activations'] = $paymentGatewayService->gateway_active();

        if (auth()->user()->role->type != "customer") {
            return view('wallet::backend.seller.my_wallet_recharge_create', $data);
        } else {
            return view(theme('pages.profile.wallets.my_wallet_recharge_create'), $data);
        }
    }


    public function walletRecharge($amount, $method, $response)
    {
        $this->walletService->walletRecharge($amount, $method, $response);
        LogActivity::successLog('wallet recharge successful.');
    }

    public function store(Request $request)
    {
        session()->put('wallet_recharge', '1');
        if ($request->method == "Stripe") {
            $stripeController = new StripeController;
            $response = $stripeController->stripePost($request->all());
        }
        if ($request->method == "RazorPay") {
            $razorpayController = new RazorpayController;
            $response = $razorpayController->payment($request->all());
        }
        if ($request->method == "Paypal") {
            $paypalController = new PayPalController;
            $response = $paypalController->payment($request->all());
        }
        if ($request->method == "Paystack") {
            $paystackController = new PaystackController;
            return $paystackController->redirectToGateway();
        }
        if ($request->method == "BankPayment") {
            $bankController = new BankPaymentController;
            $response = $bankController->store($request->all());
        }
        if ($request->method == "PayTm") {
            $paytm = new PaytmController;
            return $paytm->payment($request->all());
        }
        if ($request->method == "Instamojo") {
            $instamojo = new InstamojoController;
            return $instamojo->paymentProcess($request->all());
        }
        if ($request->method == "Midtrans") {
            $midtrans = new MidtransController;
            return $midtrans->paymentProcess($request->all());
        }
        if ($request->method == "PayUMoney") {
            $PayUMoney = new PayUmoneyController;
            return $PayUMoney->payment($request->all());
        }
        if ($request->method == "JazzCash") {
            $JazzCash = new JazzCashController;
            return $JazzCash->paymentProcess($request->all());
        }
        if ($request->method == "flutterwave") {
            $flutterWaveController = new FlutterwaveController;
            return $flutterWaveController->payment($request->all());
        }
        if ($request->method == "Bkash") {
            $data['gateway_id'] = encrypt(15);
            $bkashController = new BkashController();
            $response = $bkashController->bkashSuccess($request->all());
        }

        if ($request->method == "SslCommerz") {

            $post_data = array();
            $post_data['total_amount'] = $request->amount; # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = uniqid(); // tran_id must be unique

            # CUSTOMER INFORMATION
            $post_data['cus_name'] = 'Customer Name';
            $post_data['cus_email'] = 'customer@mail.com';
            $post_data['cus_add1'] = 'Customer Address';
            $post_data['cus_add2'] = "";
            $post_data['cus_city'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_postcode'] = "";
            $post_data['cus_country'] = "Bangladesh";
            $post_data['cus_phone'] = '8801XXXXXXXXX';
            $post_data['cus_fax'] = "";

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = "Store Test";
            $post_data['ship_add1'] = "Dhaka";
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = "1000";
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Computer";
            $post_data['product_category'] = "Goods";
            $post_data['product_profile'] = "physical-goods";

            # OPTIONAL PARAMETERS
            $post_data['value_a'] = "ref001";
            $post_data['value_b'] = "ref002";
            $post_data['value_c'] = "ref003";
            $post_data['value_d'] = "ref004";

            session(['ssl_payment_type' => $request->type]);
            $sslc = new SslCommerzNotification();
            $payment_options = $sslc->makePayment($post_data);
            $payment_options = \GuzzleHttp\json_decode($payment_options);
            if ($payment_options->status == "success") {
                return Redirect::to($payment_options->data);
            } else {
                return redirect()->route('my-wallet.index', auth()->user()->role->type);

            }
        }

        if ($request->method == "MercadoPago") {
            $mercadoPagoController = new MercadoPagoController();
            $response = $mercadoPagoController->payment($request->all());
            return $response;
        }
        if ($request->method == "Tabby") {
            $tabbyPaymentController = new TabbyPaymentController();
            $response = $tabbyPaymentController->paymentProcess($request->all());
            return $response;
        }

        if($request->method  == 'Clickpay')
        {

            $customer['name'] = $request->customer_name;
            $customer['amount'] = round($request->amount,2);
            $customer['email'] = $request->customer_email;
            $customer['phone'] = $request->customer_phone;
            $customer['zip'] = $request->customer_postal_code;
            $customer['description'] = "Products Checkout";
            $customer['callback'] = route('clickpay.callback');
            $customer['return'] = route('clickpay.return');
            $customer['address'] = $request->customer_address;
            $state = State::find($request->customer_state);
            $customer['state'] = !empty($state) ?$state->name:'Riyad';
            $city = City::find($request->customer_city);
            $customer['city'] = !empty($city) ? $city->name:'Ar-Riyad';
            $country = Country::find($request->customer_country);
            $customer['country'] = !empty($country) ? $country->code:'SA';
            $customer['payment_for'] = 'wallet-recharge';
            $customer['entry_payment_id'] = auth()->id();
            $clickpay = new ClickpayController();
            $response = $clickpay->payment($customer);
            if($response != false){
                return redirect()->to($response)->send();
            }else{
                Toastr::error(trans('common.Something Went Wrong'),trans('common.error'));
                return back();
            }

        }

        if ($request->method != "Stripe") {
            Toastr::success(__('common.successful'), __('common.success'));
        }

        LogActivity::successLog('wallet recharge successful.');
        return redirect()->route('my-wallet.index', auth()->user()->role->type);
    }

    public function offline_recharge_store(Request $request)
    {
        $this->walletService->walletOfflineRecharge($request->all());


        LogActivity::successLog('offline wallet recharge successful.');
        Toastr::success(__('common.successful'), __('common.success'));
        return redirect()->back();
    }

    public function offline_recharge_update(Request $request)
    {
        $this->walletService->walletOfflineRechargeUpdate($request->all());

        LogActivity::successLog('offline wallet recharge update successful.');
        Toastr::success(__('common.updated_successfully'), __('common.success'));
        return redirect()->route('wallet_recharge.offline_index');
    }



    public function recharge_status(Request $request)
    {
        try {
            $wallet = $this->walletService->findById($request->id);
            $wallet->status = $request->status;

            $defaultIncomeAccount = $this->defaultIncomeAccount();

            if ($wallet->save()) {
                if ($wallet->status == 1) {
                    $transactionRepo = new TransactionRepository(new Transaction);
                    $transactionRepo->makeTransaction("Wallet Recharge by customer", "in", $wallet->GatewayName, "wallet_recharge", $defaultIncomeAccount, "Wallet Recharge by customer", $wallet, $wallet->amount, \Carbon\Carbon::now()->format('Y-m-d'), auth()->id(), null, null);
                }


                LogActivity::successLog('wallet recharge status change successful.');
                return 1;
            }
            return 0;
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return 0;
        }
    }

    public function wallet_configuration()
    {
        try {
            $walletConfiguration = $this->walletService->getWalletConfiguration();
            return view('wallet::backend.admin.wallet_configuration', compact('walletConfiguration'));

        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function wallet_configuration_update(Request $request)
    {
        try {
            $this->walletService->walletConfigurationUpdate($request);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('Wallet configuration updated.');
            return back();
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

}
