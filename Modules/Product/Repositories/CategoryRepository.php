<?php
namespace Modules\Product\Repositories;
use App\Traits\ImageStore;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\CategoryImage;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Product\Imports\CategoryImport;
use Modules\Product\Export\CategoryExport;
use App\Models\MediaManager;
use App\Models\UsedMedia;

use function Clue\StreamFilter\fun;

class CategoryRepository
{
    use ImageStore;
    protected $category;
    protected $ids = [];

    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function category()
    {
        return Category::with(['brands', 'categoryImage', 'groups.categories','subCategories'])->where("parent_id", 0)->paginate(10);
    }
    public function activeCategory()
    {
        return Category::with(['brands', 'categoryImage', 'groups.categories','subCategories'])->where("parent_id", 0)->where('status', 1)->paginate(20);
    }

    public function getAllCategories()
    {
        return Category::with(['brands', 'categoryImage', 'groups.categories','subCategories','subCategories.subCategories'])->where("parent_id", 0)->where('status', 1)->select(['id','name','slug'])->paginate(20);
    }

    public function getData(){
        return Category::with(['subCategories','categoryImage'])->latest();
    }
    public function subcategory($category)
    {
        return Category::where("parent_id", $category)->where('status', 1)->get();
    }
    public function allSubCategory()
    {
        return Category::where("parent_id", "!=", 0)->get();
    }
    public function getAllSubSubCategoryID($category_id){
        $subcats = $this->subcategory($category_id);
        $this->unlimitedSubCategory($subcats);
        return $this->ids;
    }
    private function unlimitedSubCategory($subcats){
        foreach($subcats as $subcat){
            $this->ids[] = $subcat->id;
            $this_subcats = $this->subcategory($subcat->id);
            if($this_subcats->count() > 0){
                $this->unlimitedSubCategory($this_subcats);
            }
        }
    }
    public function getModel(){
        return $this->category;
    }
    public function getAll()
    {
        if(isModuleActive('Affiliate')){
            return Category::with(['parentCategory','categoryImage','brands','affiliateCategoryCommission'])->take(100)->get();
        }else{
            return Category::with(['parentCategory','categoryImage','brands'])->take(100)->get();
        }

    }
    public function getActiveAll(){
        return Category::with('categoryImage', 'parentCategory', 'subCategories')->where('status', 1)->latest()->get();
    }
    public function getCategoryByTop(){

        return Category::with('categoryImage', 'parentCategory', 'subCategories')->where('status', 1)->orderBy('total_sale', 'desc')->get();
    }
    public function save($data)
    {
        if(isset($data['category_type'])){
            $parent_depth = Category::where('id', $data['parent_id'])->first();
            $data['depth_level'] = $parent_depth->depth_level + 1;
        }else{
            $data['depth_level'] = 1;
        }
        $data['commission_rate'] = isset($data['commission_rate'])?$data['commission_rate']:0;
        $data['parent_id'] = isset($data['category_type'])?$data['parent_id']:0;
        $data['google_product_category_id'] = isset($data['google_product_category_id'])?$data['google_product_category_id']:0;
        $category = new Category();
        $category->fill($data)->save();
        $host = activeFileStorage();
        $thumbnail_image = null;
        if(isset($data['category_image'])){
            $media_img = MediaManager::find($data['category_image']);
            if($media_img){
                if($media_img->storage == 'local'){
                    $file = asset_path($media_img->file_name);
                }else{
                    $file = $media_img->file_name;
                }
                $thumbnail_image = ImageStore::saveImage($file, 225, 225);
            }
            if ($host == 'Dropbox') {
                $data['image'] = $thumbnail_image['images_source'];
                $data['file_dropbox'] = $thumbnail_image['file_dropbox'];
            }else{
                $data['image'] = $thumbnail_image;
            }
          $cat_image = CategoryImage::create([
                'category_id' => $category->id,
                'image' => $data['image']
            ]);
            if (isset($data['category_image'])) {
                UsedMedia::create([
                    'media_id' => $data['category_image'],
                    'usable_id' => $cat_image->id,
                    'usable_type' => get_class($cat_image),
                    'used_for' => 'category_image'
                ]);
            }
        }
        return true;
    }
    public function update($data, $id)
    {
        $category = Category::find($id);
        if(isset($data['category_type'])){
            $parent_depth = Category::find($data['parent_id']);
            $data['depth_level'] = $parent_depth->depth_level + 1;
        }else{
            $data['depth_level'] = 1;
        }
        $data['commission_rate'] = isset($data['commission_rate'])?$data['commission_rate']:0;
        $data['parent_id'] = isset($data['category_type'])?$data['parent_id']:0;
        $data['google_product_category_id'] = isset($data['google_product_category_id'])?$data['google_product_category_id']:0;
        $category->fill($data)->save();
        $host = activeFileStorage();
        if (isset($data['category_image']) && $data['category_image'] != @$category->category_image_media->media_id) {

            if(@$category->categoryImage->image != null){
                ImageStore::deleteImage($category->categoryImage->image);
            }

            $media_img = MediaManager::find($data['category_image']);
            if($media_img->storage == 'local'){
                $file = asset_path($media_img->file_name);
            }else{
                $file = $media_img->file_name;
            }

            $category_image = ImageStore::saveImage($file, 225, 225);
            if ($host == 'Dropbox') {
                $data['image'] = $category_image['images_source'];
                $data['file_dropbox'] = $category_image['file_dropbox'];
            }else{
                $data['image'] = $category_image;
            }

            if ($category->categoryImage) {
                $prev_meta = UsedMedia::where('usable_id', $category->categoryImage->id)->where('usable_type', get_class($category->categoryImage))->where('used_for', 'category_image')->first();
            }else {
                $prev_meta = '';
            }
            if($prev_meta){
                $prev_meta->update([
                    'media_id' => $media_img->id
                ]);
            }else{
                   CategoryImage::where('category_id',$id)->delete();
                   $categoryImage =  CategoryImage::create([
                        'category_id' => $id,
                        'image' => $data['image']
                    ]);

                UsedMedia::create([
                    'media_id' => $media_img->id,
                    'usable_id' => $categoryImage->id,
                    'usable_type' => get_class($categoryImage),
                    'used_for' => 'category_image'
                ]);
                return true;
            }
        }else{
            if($category->categoryImage->category_image_media != null && !isset($data['category_image'])){
                $category->categoryImage->category_image_media->delete();
                ImageStore::deleteImage($category->categoryImage->image);
                $data['image'] = null;
            }else{
                $data['image'] = $category->categoryImage->image;
            }
        }

        if(!empty($data['category_image'])){

            if(@$category->categoryImage->image){
                ImageStore::deleteImage(@$category->categoryImage->image);
                @$category->categoryImage->update([
                    'image' => $data['image']
                ]);
            }else{
                CategoryImage::create([
                    'category_id' => $id,
                    'image' => $data['image']
                ]);
            }
         }
        return true;
    }
    public function delete($id)
    {
        $category = Category::find($id);;
        if (count($category->products) > 0 || count($category->subCategories) > 0
        || count($category->newUserZoneCategories) > 0 || count($category->newUserZoneCouponCategories) > 0 ||
         count($category->MenuElements) > 0 || count($category->MenuRightPanel) > 0 || count($category->Silders) > 0 || count($category->headerCategoryPanel) > 0 ||
          count($category->homepageCustomCategories) > 0) {
            return "not_possible";
        }else {
            if ($category->categoryImage->image) {
                ImageStore::deleteImage($category->categoryImage->image);
            }
            UsedMedia::where('usable_id', $category->categoryImage->id)->where('usable_type', get_class($category->categoryImage))->where('used_for', 'category_image')->delete();
            $category->delete();
            return 'possible';
        }
    }
    public function checkParentId($id){
         Category::where('parent_id',$id)->get();
    }
    public function show($id)
    {
        $category = $this->category->with('categoryImage', 'parentCategory', 'subCategories.categoryImage', 'subCategories.subCategories.categoryImage')->where('id', $id)->first();
        return $category;
    }
    public function edit($id){
        $category = $this->category->findOrFail($id);
        return $category;
    }
    public function findBySlug($slug)
    {
        return $this->category->where('slug', $slug)->first();
    }
    public function csvUploadCategory($data)
    {

        Excel::import(new CategoryImport, $data['file']);
    }
    public function csvDownloadCategory()
    {
        if (file_exists(storage_path("app/category_list.xlsx"))) {
          unlink(storage_path("app/category_list.xlsx"));
        }
        return Excel::store(new CategoryExport, 'category_list.xlsx');
    }
    public function getCategoryBySearch($search,$depend){
        $items = collect();
        if($search != ''){
            if ($depend) {
                $items = Category::with('subCategories')->where('status', 1)->where('parent_id', '!=' , $depend)->where('name', 'LIKE', "%{$search}%")->paginate(10);
            }else {
                $items = Category::with('subCategories')->where('status', 1)->where('name', 'LIKE', "%{$search}%")->paginate(10);
            }
        }else{
            if ($depend) {
                $items =  Category::with(['subCategories'])->where('parent_id', 0)->where('parent_id', '!=' , $depend)->where('status', 1)->paginate(10);
            }else {
                $items = Category::with(['subCategories'])->where('parent_id', 0)->where('status', 1)->paginate(10);
            }
        }
        $response = [];
        foreach($items as $category){
            if($depend && $category->id == $depend){
                if($category->subCategories->count() > 1){
                    $subData = $this->recuseSub($category->subCategories, $response, $depend);
                    $response = $subData;
                }
            }else {
                $level = '';
                for($i = 1; $i <= $category->depth_level ; $i++){
                    $level .= '-';
                }
                $level .= '> ';
                $response[]  =[
                    'id'    =>$category->id,
                    'text'  => $level.$category->name
                ];
                if($category->subCategories->count() > 1){
                    $subData = $this->recuseSub($category->subCategories, $response, $depend);
                    $response = $subData;
                }
            }

        }
        return  $response;
    }
    private function recuseSub($subcategories, $response, $depend = null){
        foreach($subcategories as $subcat){
            if($depend && $subcat->id == $depend ){
                if($subcat->subCategories->count() > 1){
                    $subData = $this->recuseSub($subcat->subCategories, $response, $depend);
                    $response = $subData;
                }
            } else{
                $level = '';
                for($i = 1; $i <= $subcat->depth_level ; $i++){
                    $level .= '-';
                }
                $level .= '> ';
                $response[]  =[
                    'id'    =>$subcat->id,
                    'text'  =>$level.$subcat->name
                ];
                if($subcat->subCategories->count() > 1){
                    $subData = $this->recuseSub($subcat->subCategories, $response, $depend);
                    $response = $subData;
                }
            }

        }
        return $response;
    }
    public function firstCategory(){
        $category = Category::where('parent_id', 0)->where('status', 1)->first();
        if($category){
            return $category;
        }
        return null;
    }
    public function getParentCategoryBySearch($search){
        $items = collect();
        if($search != ''){
            $items = Category::where('status', 1)->where('parent_id', 0)->where('name', 'LIKE', "%{$search}%")->paginate(10);
        }else{
            $items = Category::where('parent_id', 0)->where('status', 1)->paginate(10);
        }
        $response = [];
        foreach($items as $category){
            $level = '';
            for($i = 1; $i <= $category->depth_level ; $i++){
                $level .= '-';
            }
            $level .= '> ';
            $response[]  =[
                'id'    =>$category->id,
                'text'  => $level.$category->name
            ];
        }
        return $response;
    }
}
