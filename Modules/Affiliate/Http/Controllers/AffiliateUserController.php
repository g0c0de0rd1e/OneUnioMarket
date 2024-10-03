<?php

namespace Modules\Affiliate\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Affiliate\Repositories\AffiliateUserRepository;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class AffiliateUserController extends Controller
{
    protected $affiliateUserRepo;

    public function __construct(AffiliateUserRepository $affiliateUserRepo)
    {
        $this->affiliateUserRepo = $affiliateUserRepo;
    }

    public function approved($id)
    {
        try{
            $this->affiliateUserRepo->approved($id);
            return response()->json(['status' => 200]);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }
    }
    public function disableEnable($id)
    {
        try{
            $this->affiliateUserRepo->disableEnable($id);
            return response()->json(['status' => 200]);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }
    }

    public function userRequest()
    {
        try{
            User::where('id',Auth::id())->update([
                'affiliate_request' => 1,
                'accept_affiliate_request' => affiliateConfig('admin_approval_need') == 1 ? 0 : 1,
            ]);
            Toastr::success('Affiliate Program Join Request Sent Successfully');
            return back();
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }
    }

    public function index()
    {
        try{
            $data['data'] = $this->affiliateUserRepo->all();
            return view('affiliate::user.index',$data);
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }
    }

    public function datatable(){
        try{

            if(isset($_GET['table'])){
                $table = $_GET['table'];
                if($table == 'all_users'){
                    $data = $this->affiliateUserRepo->query();
                }
                elseif($table == 'active_users'){
                    $data = $this->affiliateUserRepo->query()->where('accept_affiliate_request',1);
                }elseif($table == 'inactive_users'){
                    $data = $this->affiliateUserRepo->query()->where('accept_affiliate_request',0);
                }
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('avatar', function($row){
                        return view('affiliate::user.components._avatar_td',['row' => $row]);
                    })

                    ->addColumn('status', function($row){
                        return view('affiliate::user.components._status_td',['row' => $row]);
                    })
                    ->addColumn('action',function($row){
                        return view('affiliate::user.components._action_td',['row' => $row]);
                    })
                    ->rawColumns(['avatar','status','action'])
                    ->make(true);
            }
            else{
                return [];
            }
        }catch(Exception $e){
            Toastr::error($e->getMessage(), 'Error!!');
            return response()->json(['error' => $e->getMessage()],503);
        }

    }

    public function show($id){
        $user = $this->affiliateUserRepo->getUserById($id);
        $links = $this->affiliateUserRepo->getLinksByUserId($id);
        $user_income_data = $this->affiliateUserRepo->userIncomeDataByUserId($id);
        $user_transaction_data = $this->affiliateUserRepo->userTransectionDataByUserId($id);
        return view('affiliate::user.show',compact('user','links','user_income_data','user_transaction_data'));
    }

}
