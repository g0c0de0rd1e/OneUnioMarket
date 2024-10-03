<?php

namespace Modules\MultiVendor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MultiVendor\Services\SubSellerService;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Modules\MultiVendor\Entities\SubSeller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\RolePermission\Entities\Permission;
use Modules\UserActivityLog\Traits\LogActivity;

class SubSellerController extends Controller
{
    protected $subSellerService;
    public function __construct(SubSellerService $subSellerService)
    {
        $this->middleware('maintenance_mode');
        $this->subSellerService = $subSellerService;
    }

    public function index()
    {
        try{
            $data['sub_sellers'] = $this->subSellerService->getAll();
            return view('multivendor::sub_sellers.index', $data);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function create()
    {
        if (auth()->user()->role->type == "seller") {
            if (auth()->user()->SellerAccount->seller_commission_id == 3) {
                if (auth()->user()->role->type == 'seller' && auth()->user()->sub_seller->seller_id) {
                    $seller_id = auth()->user()->sub_seller->seller_id;
                }else {
                    $seller_id = auth()->user()->id;
                }
                $total_member = SubSeller::where('seller_id', $seller_id)->count();
                if (auth()->user()->SellerSubscriptions->pricing->team_size > $total_member && auth()->user()->SellerSubscriptions->is_paid == 1) {
                    return view('multivendor::sub_sellers.create');
                }
                else {
                    Toastr::warning(__('seller.add_member_is_disabled_according_to_your_package_right_now'), __('common.warning'));
                    return back();
                }
            }else {
                return view('multivendor::sub_sellers.create');
            }
        }
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        DB::beginTransaction();
        try {
            $this->subSellerService->create($request->except("_token"));
            DB::commit();
            LogActivity::successLog('New Sub Seller has been added to '. auth()->user()->first_name);
            Toastr::success(__('common.added_successfully'), __('common.success'));
            return redirect(url('/seller/my-staff'));

        } catch (\Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }

    }

    public function show($id)
    {
        $data['user'] = $this->subSellerService->findUserByID($id);
        return view('seller::admin.merchants.show_details', $data);
    }

    public function edit($id)
    {
        $data['user'] = $this->subSellerService->findUserByID($id);
        return view('multivendor::sub_sellers.edit', $data);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => 'nullable|mimes:jpg,jpeg,png,bmp'
        ],
        [
            'first_name.required' => "This Name Filed is required",
            'email.required' => "This Email is required",
            'email.email' => "This is not a valid email",
            'email.unique' => "Email has already taken",
            'password.required' => "This Password Filed is required",
        ]);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'nullable|max:255',
            'email' => 'required|max:100|unique:users,email,'.$id,
            'phone' => 'nullable|max:20',
            'photo' => 'nullable|mimes:jpg,jpeg,png,bmp'
        ]);

        if($request->password != null){
            $request->validate([
                'password' => 'required|confirmed|min:8|max:20|string'
            ]);
        }

        DB::beginTransaction();
        try {
            $this->subSellerService->update($request->except("_token"), $id);
            DB::commit();
            LogActivity::successLog('Sub Seller Updated From '. auth()->user()->first_name);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect(url('/seller/my-staff'));

        } catch (\Exception $e) {
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function delete($id)
    {
        try {
            $this->subSellerService->delete($id);
            LogActivity::successLog('Staff has been destroyed.');
            Toastr::success(__('common.deleted_successfully'), __('common.success'));
            return back();

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function access_permission($id)
    {
        try{
            $data['user'] = $this->subSellerService->findUserByID($id);
            $PermissionList = Permission::whereIn('module_id',['2','11','12','17','24','31','25','15','29','28','35','37','44','45'])->get();
            $subModuleList = $PermissionList->where('type', 2)->whereIn('id', ['489','498','317','318', '514','505','506','507','508','509',
            '510','511','163','164','165','166','167','154','155','156','157','158','159','160','161','17','18','19','20','21','22','23','24','25',
            '492','493','494','495','532','533','534','535','536','569','571','574','609','615','625','619','620','621','624','364','681','687','679','690','706','707','708','711','712','713']);
            $data['MainMenuList'] = $PermissionList->where('type',1);
            $data['SubMenuList'] = $subModuleList;
            $data['ActionList'] = $PermissionList->where('type',3);
            $data['PermissionList'] =  $PermissionList;
            return view('multivendor::sub_sellers.access_permission', $data);

        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return back();
        }
    }

    public function access_permission_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => "required",
            'module_id' => "required|array"
        ]);
        if($validator->fails()){
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
        try{
            DB::beginTransaction();
                $seller_staff  = $this->subSellerService->findUserByID($request->user_id);
                $seller_staff->permissions()->detach();
                $seller_staff->permissions()->attach(array_unique($request->module_id));
            DB::commit();
            LogActivity::successLog('Permission given Successfully');
            Toastr::success(__('hr.permission_given_successfully'), __('common.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollback();
            Toastr::error(__('common.error_message'), __('common.error'));
           return redirect()->back();
        }
    }
}
