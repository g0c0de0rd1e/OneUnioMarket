<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\OrderPackageDetail;
use App\Services\ProductReviewService;
use Exception;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Modules\Review\Entities\ProductReview;
use Modules\UserActivityLog\Traits\LogActivity;

class ProductReviewController extends Controller
{
    protected $productReviewService;
    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
        $this->middleware('maintenance_mode');
    }
    public function index(Request $request){

         $package = OrderPackageDetail::findOrFail(base64_decode($request->package_id));
        return view(theme('pages.review'),compact('package'));
    }

    public function store(Request $request){
        foreach ($request->product_id as $product) {
            $request->validate([
                'product_images_'.$product.'.*' => 'nullable',
            ]);
        }
        $review = $this->productReviewService->store($request->except('_token'), auth()->user());
            if($review){
                DB::commit();
                Toastr::success(__('review.review_done_thanks_for_review'), __('common.success'));
                LogActivity::successLog('product review store successful.');
                return redirect(url('/my-purchase-orders'));
            }else{
                Toastr::error(__('review.review_already_exsist'),__('common.error'));
                return back();
            }


        DB::beginTransaction();
        try{
            $review = $this->productReviewService->store($request->except('_token'), auth()->user());
            if($review){
                DB::commit();
                Toastr::success(__('review.review_done_thanks_for_review'), __('common.success'));
                LogActivity::successLog('Review added');
                return redirect(url('/my-purchase-orders'));
            }else{
                Toastr::error(__('review.review_already_exsist'),__('common.error'));
                return back();
            }
        }catch(Exception $e){
            DB::rollBack();
            LogActivity::errorLog($e->getMessage());
            Toastr::error($e->getMessage(), 'Error!!');
            return back();
        }

    }

    public function filterReview(Request $request)
    {
        $data = $request->all();
        $reviews = ProductReview::where('rating',$data['rating'])->where('status',1)->with(['customer','product','images']);
        if($data['rating'] != 0){
            $reviews = $reviews->where('product_id',$data['product_id']);
        }
        $reviews = $reviews->paginate(10);
        $view = view(theme('partials._review_filter'),compact('reviews'))->render();
        return response()->json([
            "status" =>1,
            "html" => $view
        ],200);

    }

}
