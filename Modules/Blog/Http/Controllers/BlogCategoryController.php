<?php

namespace Modules\Blog\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Services\BlogCategoryService;
use Modules\Blog\Entities\BlogCategory;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Blog\Http\Requests\BlogCategoryRequest;
use Modules\UserActivityLog\Traits\LogActivity;

class BlogCategoryController extends Controller
{
    use ImageStore;
    protected $blogCategoryService;

    public function __construct(BlogCategoryService $blogCategoryService)
    {
        $this->blogCategoryService = $blogCategoryService;
        $this->middleware('maintenance_mode');
        $this->middleware('prohibited_demo_mode')->only('store','update','destroy');
    }
    public function index()
    {
        try{
            $data['itemCategories']  = $this->blogCategoryService->getAll();
            return view('blog::category.category',$data);
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }
    public function store(BlogCategoryRequest $request)
    {
         try{
            $this->blogCategoryService->create($request->except("_token"));
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog category added');
            return redirect()->back();
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        try{
            $data['itemCategories']  = $this->blogCategoryService->getAll();
            $data['editData']   = $this->blogCategoryService->find($id);
            return view('blog::category.category',$data);
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }
    public function update(BlogCategoryRequest $request, $id)
    {
        try{
            $this->blogCategoryService->update($request->except("_token"),$id);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog category updated');
            return redirect()->route('blog.categories.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        try{
            $this->blogCategoryService->delete($id);
            Toastr::success(__('common.operation_done_successfully'),__('common.success'));
            LogActivity::successLog('blog category deleted.');
            return redirect()->route('blog.categories.index');
        }catch (\Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.operation_failed'));
            return $e->getMessage().$e->getLine();
            return redirect()->route('blog.categories.index');
        }
    }
}
