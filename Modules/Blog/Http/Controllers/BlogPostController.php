<?php

namespace Modules\Blog\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Http\Requests\BlogPostRequest;
use Modules\Blog\Services\BlogPostService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\UserActivityLog\Traits\LogActivity;
use Yajra\DataTables\Facades\DataTables;

class BlogPostController extends Controller
{
    protected $blogPostService;

    public function __construct(BlogPostService $blogPostService)
    {
        $this->blogPostService = $blogPostService;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
    }
    public function index()
    {
        $data['CategoryList']=$this->blogPostService->categoryList();
        $data['TagList']=$this->blogPostService->tagList();
        if (auth()->user()->role->type == 'superadmin') {
            $data['PostList']=$this->blogPostService->getAll();
        }
        else{
            $data['PostList']=$this->blogPostService->getUserPost();
        }
        return view('blog::post.index',$data);
    }
    public function getData(){
        if (auth()->user()->role->type == 'superadmin') {
            $value = $this->blogPostService->getAll();
        }
        else{
            $value = $this->blogPostService->getUserPost();
        }
        return DataTables::of($value)
            ->addIndexColumn()
            ->addColumn('title', function($value){
                return Str::limit($value->title,15);
            })
            ->addColumn('author', function($value){
                return $value->user->getFullNameAttribute();
            })
            ->addColumn('approved', function($value){
                return view('blog::post.components._approve_td',compact('value'));
            })
            ->addColumn('status', function($value){
                return view('blog::post.components._status_td',compact('value'));
            })
            ->addColumn('published_at', function($value){
                return \Carbon\Carbon::parse($value->published_at)->toDayDateTimeString();
            })
            ->addColumn('action', function($value){
                return view('blog::post.components._action_td',compact('value'));
            })
            ->rawColumns(['approved','status','action'])
            ->toJson();
    }
    public function create()
    {
        $data['CategoryList']=$this->blogPostService->categoryParentList();
        $data['TagList']=$this->blogPostService->tagList();
        return view('blog::post.create',$data);
    }
    public function store(BlogPostRequest $request)
    {
        DB::beginTransaction();
        try{
            $this->blogPostService->create($request->except("_token"));
            DB::commit();
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog post added.');
            return redirect()->route('blog.posts.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }
    public function show($id)
    {
        $data=$this->blogPostService->findWithRelModal($id);
        return view('blog::post.show',compact('data'));
    }
    public function edit($id)
    {
         $data['post']=$this->blogPostService->findWithRelModal($id);
        $data['cat_id']=[];
        foreach ($data['post']->categories as $value) {
            array_push($data['cat_id'], $value->id);
        }
         $data['CategoryList']=$this->blogPostService->categoryParentList();

        $data['TagList']=$this->blogPostService->tagList();
        return view('blog::post.edit',$data);
    }
    public function update(BlogPostRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $this->blogPostService->update($request->except("_token"),$id);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            DB::commit();
            LogActivity::successLog('blog post updated.');
            return redirect()->route('blog.posts.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            DB::rollBack();
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        try {
                $this->blogPostService->delete($id);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog post deleted.');
            return redirect()->route('blog.posts.index');
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
           Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }
    //approval
    public function approval(Request $request){
        try {
            $post = $this->blogPostService->approvalUpdate($request->except("_token"));
            if ($post->is_approved == 1) {
                LogActivity::successLog('post approved.');
                return response()->json([
                    'success'=>__('blog.post_successfully_approved')
                ]);
            }else {
                LogActivity::successLog('post disapproved.');
                return response()->json([
                    'success'=>__('blog.post_successfully_disapproved')
                ]);
            }
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
    //change status
    public function statusUpdate(Request $request)
    {
        try {
             $this->blogPostService->statusUpdate($request->except("_token"));
            LogActivity::successLog('blog status update successful.');
            return response()->json([
                'success'=>__('blog.blog_status_update_successful')
            ]);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            return $e->getMessage();
        }
    }
}
