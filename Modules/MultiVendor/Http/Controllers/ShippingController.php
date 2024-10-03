<?php

namespace Modules\MultiVendor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Shipping\Services\ShippingService;
use Modules\Shipping\Http\Requests\CreateShippingRequest;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserActivityLog\Traits\LogActivity;

class ShippingController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService  $shippingService)
    {
        $this->middleware('maintenance_mode');
        $this->shippingService = $shippingService;
    }

    public function index()
    {
        $data['methods'] = $this->shippingService->getAll();
        return view('shipping::shipping_methods.index', $data);
    }

    public function store(CreateShippingRequest $request)
    {
        try {
            $this->shippingService->store($request->except("_token"));
            LogActivity::successLog('New Shipping method added');
            Toastr::success(__('common.added_successfully'),__('common.success'));
            return back();

        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }


    public function destroy(Request $request)
    {
        try {
            $result = $this->shippingService->delete($request->id);
            if ($result == "not_possible") {
                return response()->json([
                    'msg' => __('common.related_data_exist_in_multiple_directory')
                ]);
            }
            LogActivity::successLog('Shipping Method has been destroyed.');
            return redirect()->route('seller.setting.index');
        } catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));
            return back();
        }
    }
}
