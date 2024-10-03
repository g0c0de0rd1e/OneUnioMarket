<?php

namespace Modules\FrontendCMS\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Session;
use Modules\FooterSetting\Services\FooterSettingService;
use Modules\FrontendCMS\Entities\LoginPage;
use Modules\FrontendCMS\Repositories\LoginPageRepository;
use \Modules\GeneralSetting\Repositories\GeneralSettingRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class FrontendCMSController extends Controller
{
    protected $loginPageRepository;
    protected $footerService;
    public function __construct(LoginPageRepository $loginPageRepository, FooterSettingService $footerService)
    {
        $this->footerService = $footerService;
        $this->middleware('maintenance_mode');
        $this->loginPageRepository = $loginPageRepository;
    }
    public function index()
    {
        return view('frontendcms::index');
    }
    public function title_index()
    {
        $FooterContent = $this->footerService->getAll();
        return view('frontendcms::title_settings.index',compact('FooterContent'));
    }
    public function title_update(Request $request)
    {
        try {
            $generalSettingService = new GeneralSettingRepository();
            $generalSettingService->update($request->except("_token"));
            LogActivity::successLog('Title updated.');
            Toastr::success(__('frontendCms.title_has_been_updated_successfully'), __('common.success'));
            return back();
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }
    public function loginPage(){
        $getAllLoginPageInfo = LoginPage::all();
        return view('frontendcms::login-page.index', compact('getAllLoginPageInfo'));
    }
    public function loginPageUpdate(Request $request){
        $request->validate([
            'title' => 'nullable',
            'sub_title' => 'nullable',
            'cover_image' => 'nullable|mimes:png,jpg,jpeg,bmp,webp',
            "success_url" => "nullable",
        ]);
        try{
            $this->loginPageRepository->loginPageUpdate($request->except("_token"));
            Toastr::success(__('common.updated_successfully'),__('common.success'));
            return redirect()->route('frontendcms.login_page');

        } catch(Exception $e){
            Toastr::error(__('common.error_message'),__('common.error'));
            return redirect()->route('frontendcms.login_page');
        }
    }
    public function loginPageTab($id){
        Session::put('login_tab',$id);
        return 'done';
    }
}
