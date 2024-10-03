<?php

namespace Modules\MultiVendor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MultiVendor\Entities\FollowSeller;
use Yajra\DataTables\Facades\DataTables;

class FollowSellerController extends Controller
{
    


    public function index()
    {
        return view('multivendor::follow.index');
    }
    public function seller_followers(Request $request)
    {
        $data = FollowSeller::with('customer')->where('seller_id',getParentSellerId());
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('date', function ($data) {
                return date(app('general_setting')->dateFormat->format, strtotime($data->created_at));
            })
            ->addColumn('name', function ($data) {
                return $data->customer->name;
            })
            ->addColumn('image', function ($data) {
                return view('multivendor::follow.components._image_td', compact('data'));
            })
            ->addColumn('No of Orders', function ($data) {
                return getNumberTranslate($data->customer->sellerWiseOrderCount());
            })
            ->addColumn('action', function ($data) {
                return view('multivendor::follow.components._action_td', compact('data'));
            })
            ->rawColumns(['image','action'])
            ->toJson();
    }

    public function removeFollower(Request $request){
        $request->validate([
            'customer_id' => 'required'
        ]);
        $follower = FollowSeller::where('customer_id', $request->customer_id)->where('seller_id', getParentSellerId())->first();
        if($follower){
            $follower->delete();
            return response()->json([
                'msg' => 'success'
            ],200);
        }
        return response()->json([
            'msg' => 'error'
        ],404);
    }

}
