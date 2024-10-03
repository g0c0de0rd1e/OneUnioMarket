<?php

namespace Modules\Utilities\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Support\Renderable;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\SidebarManager\Entities\Backendmenu;
use Modules\SidebarManager\Entities\BackendmenuUser;
use Modules\Utilities\Repositories\UtilitiesRepository;

class UtilitiesController extends Controller
{
    protected $utilitiesRepository;

    public function __construct(UtilitiesRepository $utilitiesRepository)
    {
        $this->middleware('maintenance_mode');
        $this->utilitiesRepository = $utilitiesRepository;
    }

    public function index(Request $request)
    {

        try{
            if($request->has('utilities') && $request->get('utilities')!=null){
                if(env('APP_SYNC')){
                    Toastr::error(__('common.restricted_in_demo_mode'));
                    return redirect()->back();
                }
                if($request->utilities == 'xml_sitemap'){
                    return redirect()->route('utilities.xml_sitemap');
                }
                $result = $this->utilitiesRepository->updateUtility($request->utilities);
                if($result == 'done'){
                    Toastr::success(__('common.operation_done_successfully'), __('common.success'));
                    LogActivity::successLog('Utility Operation Done.');
                }else{
                    Toastr::error(__('common.error_message'),__('common.error'));
                }
                return redirect()->back();

            }else{
                $sitemap_config = $this->utilitiesRepository->getSitemapConfig();
                return view('utilities::index', compact('sitemap_config'));
            }
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }

    public function xml_sitemap(Request $request){
        if($request->sitemap){
            $data = $this->utilitiesRepository->get_xml_data($request);
            if($data){
                return redirect(route('utilities.xml_sitemap_public'));
            }else{
                Toastr::error(__('utilities.choose_sitemap_option'), __('common.error'));
                return back();
            }
        }else{
            Toastr::error(__('utilities.choose_sitemap_option'), __('common.error'));
            return back();
        }
    }

    public function xml_sitemap_public(){

        $data = $this->utilitiesRepository->xml_sitemap_public();
        return response()->view('utilities::xml_sitemap', $data)->header('Content-Type', 'text/xml');
    }

    public function reset_database(Request $request)
    {

        // DB::beginTransaction();

        try {

            if ($request->password == ""){
                Toastr::error(__('common.enter_your_password'));

            }
            elseif (Hash::check($request->password, auth()->user()->password)) {
                $this->utilitiesRepository->reset_database($request);
                // DB::commit();
                Toastr::success(__('utilities.database_reset_successful'));
            }else{

                Toastr::error(__('common.invalid_password'));
            }

            return back();
        }catch(Exception $e){
            // DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }

    public function import_demo_database(Request $request){
        try{
            if ($request->password == ""){
                Toastr::error(__('common.enter_your_password'));
            }
            elseif (Hash::check($request->password, auth()->user()->password)) {
                $this->utilitiesRepository->import_demo_database($request->except('_token'));
                $this->setupSidebar(auth()->user());
                Toastr::success(__('utilities.import_demo_database_successful'));
            }else{
                Toastr::error(__('common.invalid_password'));
            }
            return redirect()->back();

        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }

    public function remove_Visitor(Request $request){

        try{
            if ($request->password == ""){
                Toastr::error(__('common.enter_your_password'));
            }
            elseif (Hash::check($request->password, auth()->user()->password)) {
                $this->utilitiesRepository->remove_visitor($request->except('_token'));
                Toastr::success(__('utilities.remove_visitor_successful'));
            }else{
                Toastr::error(__('common.invalid_password'));
            }
            return redirect()->back();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }
    }
    public function setupSidebar($user)
    {
        $role_id = $user->role->type;
        if ($role_id == 'seller') {
            $backend_menus = Backendmenu::where(function($q){
                $q->where('user_id', auth()->id())->orWhereNull('user_id');
            })->where('is_seller', 1)->get();
        }else{
            $backend_menus = Backendmenu::where(function($q){
                $q->where('user_id', auth()->id())->orWhereNull('user_id');
            })->where('is_admin', 1)->get();

        }
        $backendMenuUser = BackendmenuUser::with('backendMenu')->where('user_id', $user->id)->get();
            if($backendMenuUser->count() != $backend_menus->count()){

                $backend_menu_not_exsist = $backend_menus->whereNotIn('id', $backendMenuUser->pluck('backendmenu_id')->toArray());
                foreach($backend_menu_not_exsist as $menu){

                    $parent_id = null;
                    $position = 0;
                    if($menu->parent_id){
                        $parentMenu = BackendmenuUser::where('backendmenu_id', $menu->parent_id)->where('user_id', $user->id)->first();
                        if($parentMenu){
                            $parent_id  = $parentMenu->id;
                            $position = BackendmenuUser::where('parent_id', $parent_id)->where('user_id', $user->id)->count() + 1;
                        }
                    }

                    BackendmenuUser::create(['parent_id' => $parent_id, 'user_id' => $user->id, 'backendmenu_id' => $menu->id, 'position' => $position]);
                }
            }
    }

}
