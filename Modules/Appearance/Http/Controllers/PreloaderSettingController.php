<?php

namespace Modules\Appearance\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Appearance\Repositories\PreloaderRepository;
use Modules\UserActivityLog\Traits\LogActivity;

class PreloaderSettingController extends Controller
{
    protected $preloaderRepo;
    public function __construct(PreloaderRepository $preloaderRepo)
    {
        $this->preloaderRepo = $preloaderRepo;
    }

    public function index(){
        return view('appearance::preloader.index');
    }

    public function update(Request $request){
        $request->validate([
            'preloader_status' => 'required',
            'preloader_type' => 'required',
            'preloader_image' => 'nullable|mimes:jpg,jpeg,png,bmp,gif'
        ],[
            'preloader_status.required' => 'Status is required',
            'preloader_type.required' => 'Preloder type is required',
            "preloader_image.mimes" => "Only jpg,jpeg,png,bmp,gif images are supported"
        ]);

        $this->preloaderRepo->updatePreloader($request);
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->back();

        try{
            $this->preloaderRepo->updatePreloader($request->except('_token'));
            Toastr::success(__('common.updated_successfully'), __('common.success'));
            return redirect()->back();
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.error_message'), __('common.error'));
            return redirect()->back();
        }

    }
}
