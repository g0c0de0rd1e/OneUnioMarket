<?php

namespace Modules\MultiVendor\Http\Controllers;
use Illuminate\Routing\Controller;
use Modules\MultiVendor\Http\Requests\SellerCommisionTypeRequest;
use Modules\MultiVendor\Services\CommisionService;
use Modules\UserActivityLog\Traits\LogActivity;

class CommisionController extends Controller
{
    protected $commisionService;
    public function __construct(CommisionService $commisionService)
    {
        $this->middleware('maintenance_mode');
        $this->commisionService = $commisionService;
    }
    public function index()
    {
        $data['items'] = $this->commisionService->getAll();
        return view('multivendor::seller_commission.index', $data);
    }
    public function item_index()
    {
        $data['items'] = $this->commisionService->getAll();
        return view('multivendor::seller_commission.item_list', $data);
    }
    public function edit($id)
    {
        try {
            return $this->commisionService->findById($id);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ],503);
        }
    }
    public function update(SellerCommisionTypeRequest $request)
    {
        try {
            $this->commisionService->update($request->except("_token"));
            LogActivity::successLog('Commision Updated Successfully');
            return response()->json(["message" => "Commision Updated Successfully"], 200);
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return response()->json(["message" => "Something Went Wrong","error" => $e->getMessage()], 503);
        }
    }
}
