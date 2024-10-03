<?php

namespace Modules\MultiVendor\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MultiVendor\Repositories\FollowRepository;


class FollowController extends Controller
{

    protected $followRepo;

    public function __construct(FollowRepository $followRepo)
    {
        $this->followRepo = $followRepo;
    }
    
    public function follow_index()
    {
        return view('multivendor::index');
    }

    public function store(Request $request)
    { 
        try{

           $result = $this->followRepo->saveFollow($request->except("_token"));
           if($result){
            return response()->json([
                'status'    =>  true,
                'message'   =>  'success'
            ],201);       
           }
           return response()->json([
            'message'   =>  'Allredi Exist'
        ],403);   
        }catch(Exception $e){
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ],500);       
         }

    }

    public function unfollow(Request $request){
        try{

        $result = $this->followRepo->unFollow($request->except("_token"));
        if($result){
            return response()->json([
                'status'    =>  true,
                'message'   =>  'success'
            ],201);       
        }
        return response()->json([
            'message'   =>  'invalid'
        ],404);   
        }catch(Exception $e){
            return response()->json([
                'status'    =>  false,
                'message'   =>  $e->getMessage()
            ],500);       
        }
    }

}
