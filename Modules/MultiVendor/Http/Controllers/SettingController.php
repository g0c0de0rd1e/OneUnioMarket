<?php

namespace Modules\MultiVendor\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MultiVendor\Services\SettingService;
use Modules\Shipping\Repositories\ShippingRepository;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Modules\UserActivityLog\Traits\LogActivity;

class SettingController extends Controller
{
    protected $seller;

    public function __construct(SettingService $seller)
    {
        $this->middleware('maintenance_mode');
        $this->seller = $seller;
    }

    public function index()
    {
        $id = Auth::user()->id;
        if(isset($id)){
            $data['seller'] = $this->seller->getData($id);
            $data['socialLinks'] = $this->seller->getSocialLink($id);
            $shippingRepo = new ShippingRepository;
            $data['shipping_methods'] = $shippingRepo->getActiveAll();
            $data['unapproved_shipping_methods'] = $shippingRepo->getRequestedSellerOwnShippingMethod();
            return view('multivendor::setting.index',$data);
        }
    }


    public function logoUpdate(Request $request, $id){

        try{
            $this->seller->logoUpdate($request->except('_token'),$id);
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            LogActivity::successLog('Logo update successful.');
            return redirect()->route('seller.setting.index');
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }

    }

    public function socialLinkStore(Request $request){

        $request->validate([
            'url' => 'required|max:255',
            'icon' => 'required|max:255',
            'status' => 'required|max:255'
        ]);
        $this->seller->SaveSocilaLink($request->except('_token'));
        LogActivity::successLog('Social link store successful.');
        return $this->loadSocialList();

    }
    public function socialLinkUpdate(Request $request){
        $request->validate([
            'url' => 'required|max:255',
            'icon' => 'required|max:255',
            'status' => 'required|max:255'
        ]);
        $this->seller->UpdateSocialLink($request->except('_token'),$request->id);
        LogActivity::successLog('Social link update successful.');
        return $this->loadSocialList();
    }
    public function socialLinkDelete(Request $request){
        try {
            $this->seller->linkById($request->id);
            LogActivity::successLog('Social link delete successful.');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ]);
        }

        return $this->loadSocialList();
    }

    private function loadSocialList()
    {
        try {
            $id  =Auth::user()->id;
            $socialLinks = $this->seller->getSocialLink($id);

            return response()->json([
                'TableData' =>  (string)view('multivendor::setting.components.social_list', compact('socialLinks'))
            ],200);

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }

    public function sectionControl($id){
        Session::put('seller_setting_tab',$id);
        return 'done';
    }


}
