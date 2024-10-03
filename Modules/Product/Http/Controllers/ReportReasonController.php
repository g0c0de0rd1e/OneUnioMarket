<?php

namespace Modules\Product\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Modules\UserActivityLog\Traits\LogActivity;
use Modules\Product\Services\ReportReasonService;

class ReportReasonController extends Controller
{
    protected $reason;

    public function __construct(ReportReasonService $reportReasonService){
        $this->reason = $reportReasonService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        try{
            $reasons = $this->reason->get();
            return view('product::report_reasons.index',compact('reasons'));
        }catch(Exception $e){

            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
        }
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       $data = $request->validate([
        "name" => "required",
        "status" => "required"
       ]);
       try{
          $create = $this->reason->store($data);
          if($create){
            Toastr::success(__('common.added_successfully'),__('common.success'));
            return back();
          }

          Toastr::error(__('common.operation_failed'));
          return back();
       }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return back();
       }
    }


    public function edit($id)
    {

        try{
            $reason = $this->reason->show(['id' => $id]);
            return view('product::report_reasons.components._edit',compact('reason'));

        }catch(Exception $e){

            LogActivity::errorLog($e->getMessage());
            return response()->json([
                "status" => 0,
                "msg" => __('common.operation_failed'),
            ]);
        }
    }




    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "name" => "required",
            "status" => "required"
           ]);
        try{
            $update = $this->reason->update($data,$id);
            if($update){
                Toastr::success(__('common.update_successfully'),__('common.success'));
                return back();
            }

            Toastr::error(__('common.operation_failed'));
            return back();
        }catch(Exception $e){
             LogActivity::errorLog($e->getMessage());
             Toastr::error(__('common.operation_failed'));
             return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $data = $request->validate([
            "id" => "required",
        ]);

        try{
            $delete = $this->reason->delete(['id' => $data['id']]);
            if($delete){
                Toastr::success(__('common.added_successfully'),__('common.success'));
                return response()->json([
                    "status" => 1,
                ]);
            }
            Toastr::error(__('common.operation_failed'));
            return response()->json([
                "status" => 0,
            ]);
        }catch(Exception $e){
             LogActivity::errorLog($e->getMessage());
             Toastr::error(__('common.operation_failed'));
             return response()->json([
                "status" => 0,
            ]);
        }
    }
}
