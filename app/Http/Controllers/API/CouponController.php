<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CouponService;
use Modules\Marketing\Entities\Coupon;
use Modules\Marketing\Entities\CustomerCouponStore;

/**
* @group Coupon
*
* APIs for customer coupon
*/
class CouponController extends Controller
{
    protected $couponService;
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    /**
     * Customer Coupon list
     * @response{
     *      "coupons": [
     *           {
     *               "id": 1,
     *               "customer_id": 5,
     *               "coupon_id": 2,
     *               "created_at": "2021-06-12T04:41:38.000000Z",
     *               "updated_at": "2021-06-12T04:41:38.000000Z",
     *               "coupon": {
     *                   "id": 2,
     *                   "title": "coupon on product",
     *                   "coupon_code": "356966565645656",
     *                   "coupon_type": 1,
     *                   "start_date": "2021-06-06",
     *                   "end_date": "2021-07-31",
     *                   "discount": 20,
     *                   "discount_type": 1,
     *                   "minimum_shopping": null,
     *                   "maximum_discount": null,
     *                   "created_by": 1,
     *                   "updated_by": null,
     *                   "is_expire": 0,
     *                   "is_multiple_buy": 1,
     *                   "created_at": "2021-06-07T10:54:27.000000Z",
     *                   "updated_at": "2021-06-07T10:54:27.000000Z"
     *               }
     *           }
     *       ],
     *       "message": "success"
     * }
     */

     public function index(Request $request){

        $coupons = CustomerCouponStore::with('coupon')->where('customer_id', auth()->id())->get();

        if(count($coupons) > 0){
            return response()->json([
                'coupons' => $coupons,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'coupon not found'
            ],404);
        }

    }

    /**
     * Customer coupon store
     * @bodyParam code string required Code from coupon
     *
     * @response{
     *      "message": "coupon Stored Successfully"
     * }
     */

    public function store(Request $request){
        $request->validate([
            'code' => 'required'
        ]);
        $coupon = Coupon::where('coupon_code',$request->code)->first();
        if(isset($coupon)){
            $storeCheck = CustomerCouponStore::where('customer_id',auth()->user()->id)->where('coupon_id',$coupon->id)->first();
            if(!isset($storeCheck)){
                if(date('Y-m-d')>=$coupon->start_date && date('Y-m-d')<=$coupon->end_date){
                    $this->couponService->store($coupon->id, $request->user()->id);
                    return response()->json([
                        'message' => 'coupon Stored Successfully'
                    ],201);
                }else{
                    return response()->json([
                        'error' => 'Coupon Is Expired.'
                    ]);
                }
            }else{
                return response()->json([
                    'error' => 'Coupon Already Stored.'
                ]);
            }


        }else{
            return response()->json([
                'error' => 'Coupon Is Invalid.'
            ]);
        }
    }

    /**
     * Customer coupon delete
     * @bodyParam id number required id from coupon list
     * @response{
     *      "message": "coupon deleted successfully"
     * }
     */

    public function destroy(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $result = $this->couponService->deleteById($request->id, $request->user()->id);

        if($result){
            return response()->json([
                'message' => 'coupon deleted successfully'
            ],200);
        }else{
            return response()->json([
                'message' => 'coupon not found'
            ],500);
        }

    }

}
