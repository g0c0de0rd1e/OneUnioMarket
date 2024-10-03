<?php

namespace Modules\PaymentGateway\Http\Controllers\API;

use App\Repositories\OrderRepository;
use App\Traits\ImageStore;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\PaymentGateway\Services\PaymentGatewayService;
use Modules\PaymentGateway\Transformers\PaymentMethodResource;
use Modules\Wallet\Entities\BankPayment;

/**
* @group Payment Gateway
*
* APIs for Payment gateways
*/
class PaymentMethodController extends Controller
{
    use ImageStore;

    protected $paymentGatewayService;

    public function __construct(PaymentGatewayService $paymentGatewayService)
    {
        $this->paymentGatewayService = $paymentGatewayService;
    }

    /**
     * Pament Gateway List
     * @response{
     *      "data": [
     *           {
     *               "id": 1,
     *               "method": "Cash On Delivery",
     *               "type": "System",
     *               "active_status": 1,
     *               "module_status": 1,
     *               "logo": "frontend/gateway/cod.jpg",
     *               "created_by": 1,
     *               "updated_by": 1,
     *               "created_at": "2021-07-01T09:51:48.000000Z",
     *               "updated_at": "2021-07-01T09:51:48.000000Z"
     *           },
     *           {
     *               "id": 7,
     *               "method": "Bank Payment",
     *               "type": "System",
     *               "active_status": 0,
     *               "module_status": 1,
     *               "logo": "",
     *               "created_by": 1,
     *               "updated_by": 1,
     *               "created_at": "2021-07-01T09:51:48.000000Z",
     *               "updated_at": "2021-07-01T09:51:48.000000Z"
     *           },
     *           {
     *               "id": 9,
     *               "method": "PayTM",
     *               "type": "System",
     *               "active_status": 0,
     *               "module_status": 1,
     *               "logo": "",
     *               "created_by": 1,
     *               "updated_by": 1,
     *               "created_at": "2021-07-01T09:51:48.000000Z",
     *               "updated_at": "2021-07-01T09:51:48.000000Z"
     *           },
     *       ]
     * }
     */
    public function index(){
        $gateway_activations = $this->paymentGatewayService->gateway_activations();
        return PaymentMethodResource::collection($gateway_activations);
    }

    /**
     * Single Payment Gateway
     * @response{
     *      "data": {
     *           "id": 7,
     *           "method": "Bank Payment",
     *           "type": "System",
     *           "active_status": 1,
     *           "module_status": 1,
     *           "logo": "",
     *           "created_by": 1,
     *           "updated_by": 1,
     *           "created_at": "2021-07-01T09:51:48.000000Z",
     *           "updated_at": "2021-07-01T09:51:48.000000Z"
     *       }
     * }
     */

    public function show($id){
        $payment_method = $this->paymentGatewayService->findById($id);
        if($payment_method){
            return new PaymentMethodResource($payment_method);
        }else{
            return response()->json([
                'message' => 'not found'
            ], 404);
        }
    }

    /**
     * Bank Payment info
     * @response{
     *      "bank_info": {
     *           "bank_name": "Dutch Bangla",
     *           "branch_name": "Panthapath, Dhaka",
     *           "account_number": "5468656665655",
     *           "account_holder": "Amazcart"
     *       },
     *       "message": "success"
     * }
     */

    public function getBankInfo(){
        $bank_info = [
            'bank_name' => env('BANK_NAME'),
            'branch_name' => env('BRANCH_NAME'),
            'account_number' => env('ACCOUNT_NUMBER'),
            'account_holder' => env('ACCOUNT_HOLDER')
        ];
        $gateway = DB::table('payment_methods')->where('slug','bank-payment')->first();

        if($gateway)
        {
            $bank = DB::table('seller_wise_payment_gateways')->where('payment_method_id',$gateway->id)->first();
            $bank_info = [
                'bank_name' => $bank->perameter_1,
                'branch_name' => $bank->perameter_2,
                'account_number' => $bank->perameter_3,
                'account_holder' => $bank->perameter_4
            ];
        }
        return response()->json([
            'bank_info' => $bank_info,
            'message' => 'success'
        ], 200);
    }

    /**
     * bank payment data store
     * @bodyParam payment_for string required example: order_payment or wallet_payment
     * @bodyParam payment_method integer required example: 7
     * @bodyParam bank_name string required example: Dutch Bangla Bank
     * @bodyParam branch_name string required example: Savar Branch
     * @bodyParam account_number string required example: 8719832453948
     * @bodyParam account_holder string required example: Hafijur Rahman
     * @bodyParam bank_amount double required example: 510
     * @bodyParam image file nullable checque image
     * @response{
     *  "payment_info": {
     *       "user_id": 8,
     *       "amount": "500",
     *       "payment_method": 7,
     *       "txn_id": "none",
     *       "updated_at": "2021-07-11T07:26:49.000000Z",
     *       "created_at": "2021-07-11T07:26:49.000000Z",
     *       "id": 4
     *   },
     *   "bank_details": {
     *       "bank_name": "test bank name",
     *       "branch_name": "test branch name",
     *       "account_number": "354655356565",
     *       "account_holder": "holder name",
     *       "image_src": null,
     *       "updated_at": "2021-07-11T07:26:49.000000Z",
     *       "created_at": "2021-07-11T07:26:49.000000Z",
     *       "id": 3
     *   },
     *   "message": "success"
     * }
     */

    public function bankPaymentDataStore(Request $request){
        $request->validate([
            'payment_for' => 'required',
            'bank_name' => 'required',
            'payment_method' => 'required',
            'branch_name' => 'required',
            'account_number' => 'required',
            'account_holder' => 'required'
        ]);

        if(isset($request->image)){
            $image = $this->saveImage($request->image);
        }
        $bank_payment = BankPayment::create([
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'image_src' => isset($request->image)?$image:null
        ]);

        if($request->payment_for == 'order_payment'){

            $order_paymentRepo = new OrderRepository;
            $order_payment = $order_paymentRepo->orderPaymentDone($request->bank_amount, 7, "none", $request->user());
            return response()->json([
                'payment_info' => $order_payment,
                'bank_details' => $bank_payment,
                'message' => 'success'
            ], 201);
        }
    }

}
