<?php

namespace Modules\Product\Repositories;

use App\Models\UsedMedia;
use Modules\Product\Entities\Brand;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Imports\BrandImport;
use Modules\Product\Export\BrandExport;
use App\Traits\ImageStore;

class BrandRepository
{
    public function getAll()
    {
        return Brand::latest()->get();
    }
    public function getAllCount(){
        return Brand::query()->count();
    }
    public function getActiveAll(){
        return Brand::where('status', 1)->latest()->take(100)->get();
    }
    public function getBySearch($data)
    {
        return Brand::where('name','LIKE','%'.$data.'%')->take(10)->get();
    }
    public function getByPaginate($count)
    {
        return Brand::latest()->paginate($count);
    }
    public function getBySkipTake($skip, $take)
    {
        return Brand::skip($skip)->take($take)->latest()->get();
    }
    public function getbrandbySort()
    {
        return Brand::orderBy("sort_id","asc")->get();
    }
    public function create(array $data)
    {
        $brand = new Brand();
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = strtolower(str_replace(' ','-',$data['name'][auth()->user()->lang_code]));
        }else{
            $data['slug'] = strtolower(str_replace(' ','-',$data['name']));
        }
        $data['featured'] = isset($data['featured']) ? true: false;
        $brand->fill($data)->save();
        if (isset($data['brand_image'])) {
            UsedMedia::create([
                'media_id' => $data['brand_image'],
                'usable_id' => $brand->id,
                'usable_type' => get_class($brand),
                'used_for' => 'brand_image'
            ]);
        }
        return true;
    }
    public function find($id)
    {
        return Brand::find($id);
    }
    public function update(array $data, $id)
    {
        $brand = Brand::findOrFail($id);
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = strtolower(str_replace(' ','-',$data['name'][auth()->user()->lang_code]));
        }else{
            $data['slug'] = strtolower(str_replace(' ','-',$data['name']));
        }
        $data['featured'] = isset($data['featured']) ? true: false;
        $brand->fill($data)->save();
    }
    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        if (count($brand->products) > 0 || count($brand->MenuElements) > 0 || count($brand->MenuBottomPanel) > 0 || count($brand->Silders) > 0 ||
         count($brand->homepageCustomBrands) > 0) {
            return "not_possible";
        }else {
            ImageStore::deleteImage($brand->logo);
            UsedMedia::where('usable_id', $brand->id)->where('usable_type', get_class($brand))->where('used_for', 'brand_image')->delete();
            $brand->delete();
            return 'possible';
        }

    }
    public function getBrandForSpecificCategory($category_id, $category_ids)
    {
        $brand_list = Brand::select('brands.*')->where('brands.status', 1)->join('products', function($q) use($category_ids, $category_id){
            return $q->on('products.brand_id', '=', 'brands.id')->join('category_product', function($q1) use($category_ids, $category_id){
                return $q1->on('category_product.product_id', '=', 'products.id')->whereRaw("category_product.category_id in('". implode("','",$category_ids). "')");
            });
        })->distinct('brands.id')->take(20)->get();
        return $brand_list;
    }
    public function findBySlug($slug)
    {
        return Brand::where('slug', $slug)->first();
    }
    public function csvUploadBrand($data)
    {
        Excel::import(new BrandImport, $data['file']->store('temp'));
    }
    public function csvDownloadBrand()
    {
        if (file_exists(storage_path("app/brand_list.xlsx"))) {
          unlink(storage_path("app/brand_list.xlsx"));
        }
        return Excel::store(new BrandExport, 'brand_list.xlsx');
    }
    public function getBrandsByAjax($search){
        if($search == ''){
            $brands = Brand::select('id','name')->where('status',1)->paginate(10);
        }else{
            $brands = Brand::select('id','name')->where('status',1)
                ->where('name', 'LIKE', "%{$search}%")
                ->paginate(10);
        }
        $response = [];
        foreach($brands as $brand){
            $response[]  =[
                'id'    =>$brand->id,
                'text'  =>$brand->name
            ];
        }
        return  $response;
    }
}
