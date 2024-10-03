<?php

namespace Modules\MultiVendor\Http\Controllers;

use Exception;
use App\Models\User;
use App\Traits\Notification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Setup\Entities\Country;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Modules\FrontendCMS\Entities\Pricing;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\MultiVendor\Services\ProfileService;
use Modules\Refund\Entities\RefundRequestDetail;
use Modules\MultiVendor\Rules\SellerValidateRule;
use Modules\MultiVendor\Services\MerchantService;
use Modules\Refund\Repositories\RefundRepository;
use Modules\OrderManage\Services\OrderManageService;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\MultiVendor\Repositories\CommisionRepository;
use Modules\GeneralSetting\Entities\UserNotificationSetting;
use Modules\MultiVendor\Http\Requests\SellerPassordChangeRequest;

class MerchantController extends Controller
{
    use Notification;
    
    protected $merchantService, $profileService, $refundRepository, $ordermanageService;
    

    public function __construct(MerchantService $merchantService, ProfileService $profileService ,RefundRepository $refundRepository ,OrderManageService $ordermanageService)
    {
        $this->middleware('maintenance_mode');
        $this->merchantService = $merchantService;
        $this->profileService = $profileService;
        $this->refundRepository = $refundRepository;
        $this->ordermanageService = $ordermanageService;
    }

    public function index()
    {
        return view('multivendor::merchants.index');
    }

    public function inactiveMerchants()
    {
        return view('multivendor::merchants.inactive_merchants');
    }

    public function secretLogin($id)
    {
        $present_id = auth()->user()->id;
        User::findOrFail($id)->update([
            'secret_login' => 1,
        ]);
        Auth::logout();
        session()->flush();
        session()->put('secret_logged_in_by_user',$present_id);
        Auth::loginUsingId($id);
        Toastr::success(__('auth.logged_in_successfully'), __('common.success'));
        return redirect()->route('seller.dashboard');
    }

    public function getData(Request $request){
        
        if($request->type == "deactive"){
            $seller = $this->merchantService->getInactive();
        }else{

            $seller = $this->merchantService->getActive();
        }
        return DataTables::of($seller)
            ->filterColumn('name', function($query, $keyword) {
                $sql = "CONCAT(users.first_name,' ',users.last_name)  like ?";
                $query->whereRaw($sql, ["%{$keyword}%"]);
            })
            ->addIndexColumn()
            ->addColumn('name', function($seller){
                return view('multivendor::merchants.components._name_td',compact('seller'));
            })
            ->addColumn('email', function($seller){
                return @$seller->user->email;
            })
            ->addColumn('phone', function($seller){
                return getNumberTranslate(@$seller->user->username ?? 'X');
            })
            ->addColumn('commission_type', function($seller){
                return view('multivendor::merchants.components._commission_rate_td',compact('seller'));
            })
            ->addColumn('is_trusted', function($seller){
                return view('multivendor::merchants.components._is_trusted_td',compact('seller'));
            })
            ->addColumn('gst', function($seller){
                return view('multivendor::merchants.components.gst_status',compact('seller'));
            })
            ->addColumn('shop_name', function($seller){
                return @$seller->seller_shop_display_name ?? 'X';
            })
            ->addColumn('wallet_balance', function($seller){
                return single_price(@$seller->user->SellerCurrentWalletAmounts);
            })
            ->addColumn('total_orders', function($seller){
                return getNumberTranslate(count(@$seller->user->order_packages));
            })
            ->addColumn('action', function($seller){
                return view('multivendor::merchants.components._action_td',compact('seller'));
            })
            ->rawColumns(['commission_type','is_trusted','action'])
            ->toJson();
    }

    public function show($id)
    {
        $data['user'] = $this->merchantService->findUserByID($id);
        return view('multivendor::merchants.show_details', $data);
    }

    public function getOrders($id){
        $user = $this->merchantService->findUserByID($id);
        $order_package = $user->order_packages;

        return DataTables::of($order_package)
            ->addIndexColumn()
            
            ->addColumn('date', function($order_package){
                return dateConvert($order_package->created_at);
            })
            ->addColumn('order_number', function($order_package){
                return @$order_package->order->order_number;
            })
            ->addColumn('email', function($order_package){
                return @$order_package->order->customer->email;

            })
            ->addColumn('no_of_product', function($order_package){
                return view('multivendor::merchants.components._show_no_of_product_td',compact('order_package'));
            })
            ->addColumn('total_amount',function($order_package){
                return single_price($order_package->products->sum('total_price') + $order_package->shipping_cost + $order_package->tax_amount);

            })
            ->addColumn('order_status', function($order_package){
                return view('multivendor::merchants.components._show_order_status_td',compact('order_package'));
            })
            ->addColumn('delivery_status',function($order_package){
                return @$order_package->delivery_process->name;
            })
            ->addColumn('order_action',function($order_package){
                return view('multivendor::merchants.components._order_action_td',compact('order_package'));
            })
            ->rawColumns(['no_of_product','order_status','order_action'])
            ->toJson();
    }

    public function getWalletHistory($id){
        $user = $this->merchantService->findUserByID($id);
        $transaction = $user->wallet_balances;
        return DataTables::of($transaction)
            ->addIndexColumn()
            ->addColumn('date', function($transaction){
                return dateConvert($transaction->created_at);
            })
            ->addColumn('user',function($transaction){
                return  @$transaction->user->first_name . ' '. @$transaction->user->last_name;

            })
            ->addColumn('amount',function($transaction){
                return  single_price($transaction->amount);

            })
            ->addColumn('payment_method', function($transaction){
                return $transaction->GatewayName;

            })
            ->addColumn('approval', function($transaction){
                return view('multivendor::merchants.components._show_wallet_approval_td',compact('transaction'));
            })
            ->rawColumns(['approval'])
            ->toJson();
    }

    public function getProduct($id){
        $user = $this->merchantService->findUserByID($id);
        $product = $user->seller_products;
        return DataTables::of($product)
        ->addIndexColumn()
        ->addColumn('product_name', function($product){
            return view('multivendor::merchants.components._show_product_name_td',compact('product'));
        })
        ->addColumn('category', function($product){
            return @$product->product->category->name;
        })
        ->addColumn('brand', function($product){
            return @$product->product->brand->name;
        })
        ->addColumn('logo', function($product){
            return view('multivendor::merchants.components._show_product_logo_td',compact('product'));
        })
        ->addColumn('stock', function($product){
            return view('multivendor::merchants.components._show_product_stock_td',compact('product'));
        })
        ->addColumn('status', function($product){
            return view('multivendor::merchants.components._show_product_status_td',compact('product'));
        })
        ->addColumn('action',function($product){
            return view('multivendor::merchants.components._show_product_action_td',compact('product'));
        })
        ->rawColumns(['product_name','logo','stock','status','action'])
        ->toJson();
    }

    public function edit($id)
    {
        $data['seller'] = $this->profileService->getData($id);
        $data['countries'] = Country::all();
        $commissionRepo = new CommisionRepository();
        $data['commissions'] = $commissionRepo->getAllActive();
        $data['pricings'] = Pricing::where('status', 1)->get();
        return view('multivendor::profile.index', $data);
    }

    public function create()
    {
        $commisionRepo = new CommisionRepository();
        $data['commissions'] = $commisionRepo->getAllActive();
        return view('multivendor::merchants.create', $data);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        DB::beginTransaction();
        
        try {

            $user = $this->merchantService->create($request->except("_token"));
            DB::commit();
            // User Notification Setting Create
            (new UserNotificationSetting())->createForRegisterUser($user->id);
            $this->adminNotificationUrl = '/admin/merchants';
            $this->routeCheck = 'admin.merchants_list';
            $this->typeId = EmailTemplateType::where('type', 'seller_create_email_template')->first()->id; //register email templete typeid
            $notification = NotificationSetting::where('slug','seller-created')->first();
            if ($notification) {
                $this->notificationSend($notification->id, $user->id);
            }
            LogActivity::successLog('New Merchant has been added.');
            Toastr::success(__('common.created_successfully'),__('common.success'));
            return redirect()->route('admin.merchants_list');

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.operation_failed'));
            return back();

        }

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'commission_id' => 'required',
            'commission_rate' => 'required',
            'shop_name' => ['required','max:100','unique:seller_accounts,seller_shop_display_name', new SellerValidateRule($data['shop_name'])]
        ],
        [
            'name.required' => "This Name Filed is required",
            'email.required' => "This Email is required",
            'email.email' => "This is not a valid email",
            'email.unique' => "Email has already taken",
            'password.required' => "This Password Filed is required",
            'subscription_type.required' => 'Please Select a Subscription Type'
        ]);
    }

    public function change_merchant_trusted_status($id)
    {
        try {
            $this->merchantService->changeTrustedStatus($id);
            LogActivity::successLog('Trusted Status has been changed.');
            Toastr::success(__('common.status_change_message'),__('common.success'));
            return redirect()->route('admin.merchants_list');

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function update_commission(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->merchantService->update_commission($request->except("_token"));
            DB::commit();
            LogActivity::successLog('Commision has been Updated to '. $request->rate . ' %');
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            return redirect()->back();

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function gst_status_update(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->merchantService->gstStatusUpdate($request->except("_token"));
            LogActivity::successLog('Gst status update successful.');
            DB::commit();
            return 1;

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            return 0;
        }

    }


    public function seller_configuration()
    {
        try {
            $sellerConfiguration = $this->merchantService->getsellerConfiguration();
            return view('multivendor::merchants.seller_configuration', compact('sellerConfiguration'));
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }

    public function seller_configuration_update(Request $request)
    {
        try {
            $this->merchantService->sellerConfigurationUpdate($request->except('_token'));
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
            return back();
        } catch (\Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }

    }

    public function update_status($userId)
    {
        try {
            $this->merchantService->update_status($userId);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            LogActivity::successLog('seller updated.');
            return back();
        } catch (Exception $e) {
            Toastr::error(__('common.operation_failed'));
            LogActivity::errorLog($e->getMessage());
            return back();
        }
    }
    public function csv_category_download()
    {
        try {
            $this->merchantService->csvDownloadCategory();
            $filePath = storage_path("app/seller/category_list.xlsx");
        	$headers = ['Content-Type: text/xlsx'];
        	$fileName = time().'-category_list.xlsx';
            return response()->download($filePath, $fileName, $headers);

            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
    public function csv_brand_download()
    {
        try {
            $this->merchantService->csvDownloadBrand();
            $filePath = storage_path("app/seller/brand_list.xlsx");
        	$headers = ['Content-Type: text/xlsx'];
        	$fileName = time().'-brand_list.xlsx';
            return response()->download($filePath, $fileName, $headers);

            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
    public function csv_unit_download()
    {
        try {
            $this->merchantService->csvDownloadUnit();
            $filePath = storage_path("app/seller/unit_list.xlsx");
        	$headers = ['Content-Type: text/xlsx'];
        	$fileName = time().'-unit_list.xlsx';
            return response()->download($filePath, $fileName, $headers);

            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
    public function csv_media_ids_download()
    {
        try {
            $this->merchantService->csvDownloadMediaIds();
            $filePath = storage_path("app/seller/media_ids_list.xlsx");
        	$headers = ['Content-Type: text/xlsx'];
        	$fileName = time().'-media_ids_list.xlsx';
            return response()->download($filePath, $fileName, $headers);

            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }

    public function getOrderRefund($id){
        $refund_package = RefundRequestDetail::with('refund_request', 'seller', 'refund_products', 'order_package')->where('seller_id', $id)->latest();
        return DataTables::of($refund_package)
            ->addIndexColumn()
            ->addColumn('date', function($refund_package){
                return dateConvert($refund_package->created_at);
            })
            ->addColumn('refund_number', function($refund_package){
                return @$refund_package->refund_request->order->order_number;
            })
            ->addColumn('email', function($refund_package){
                return @$refund_package->refund_request->customer->email;

            })
            ->addColumn('refund_total_amount',function($refund_package){
                return single_price($refund_package->refund_request->total_return_amount);

            })
            ->addColumn('order_refund_status', function ($refund_package) {
                if ($refund_package->refund_request->is_confirmed == 1)
                    return '<h6><span class="badge_1">' . __("common.confirmed") . '</span></h6>';
                elseif ($refund_package->refund_request->is_confirmed == 2)
                    return '<h6><span class="badge_4">' . __("common.declined") . ' </span></h6>';
                else
                    return '<h6><span class="badge_4">' . __("common.pending") . ' </span></h6>';
            })
            ->addColumn('is_refunded', function ($refund_package) {
                if ($refund_package->is_refunded == 1)
                    return '<h6><span class="badge_1">' . __('common.refunded') . '</span></h6>';
                else
                    return '<h6><span class="badge_4">' . __('common.pending') . '</span></h6>';
            })
            ->addColumn('refund_action',function($refund_package){
             return view('multivendor::merchants.components._refund_action_td',compact('refund_package'));
            })
            ->rawColumns(['order_refund_status','is_refunded','refund_action'])
            ->toJson();
    }
   
    public function merchant_show(Request $request){
        try{
            $merchant = $this->refundRepository->findDetailByID($request->id);
            return view('multivendor::merchants._merchant_refund_show_details',compact('merchant'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }

    }
    public function orders_show(Request $request){
        try{
            $order_package = $this->ordermanageService->findOrderByID($request->id);
            return view('multivendor::merchants._merchant_order_show_details',compact('order_package'));
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }

    }

    public function changeSellerPasswordStore(SellerPassordChangeRequest $request){
        try{
            $this->profileService->sellerChangePassword($request->all());
            return response()->json(['sucess'=>true]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(['error' => $e->getMessage()],503);
        }
    }
}
