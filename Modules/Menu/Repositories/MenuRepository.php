<?php

namespace Modules\Menu\Repositories;
use App\Models\MediaManager;
use App\Models\UsedMedia;
use App\Traits\ImageStore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\FrontendCMS\Entities\DynamicPage;
use Modules\Menu\Entities\MegaMenuAds;
use Modules\Menu\Entities\MegaMenuBottomPanel;
use Modules\Menu\Entities\MegaMenuRightPanel;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\MenuColumn;
use Modules\Menu\Entities\MenuElement;
use Modules\Menu\Entities\MultiMegaMenu;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Seller\Entities\SellerProduct;
use Modules\Setup\Entities\Tag;

class MenuRepository {
    use ImageStore;
    public function getALl(){
        return Menu::with('elements')->orderBy('order_by')->get();
    }
    public function getById($id){
        return Menu::findOrFail($id);
    }
    public function getMenus(){
        return Menu::where('menu_type','!=','multi_mega_menu')->latest()->get();
    }
    public function getPages(){
        if(isModuleActive('MultiVendor')){
            $pages = DynamicPage::where('status',1)->get();
        }else{
            $pages = DynamicPage::where('status',1)->where('id', '!=', 4)->get();
        }
        if(!isModuleActive('Affiliate')){
            $pages =  $pages->filter(function($item) {
                if($item->module != 'Affiliate'){
                    return $item->id;
                }
            });
        }
        if(!isModuleActive('Lead')){
            $pages =  $pages->filter(function($item) {
                if($item->module != 'Lead'){
                    return $item->id;
                }
            });
        }
        return $pages;
    }
    public function store($data){
        $menu = new Menu();
        $menu->fill($data)->save();
        if($data['menu_type'] == 'mega_menu'){
            $column = new MenuColumn();
            $data['column'] = 'Column 1';
            $data['size'] = '1/3';
            $data['menu_id'] = $menu->id;
            $column->fill($data)->save();
        }
        return true;
    }
    public function update($data){
        $menu = Menu::findOrFail($data['id']);
        $menu->fill($data)->save();
        return true;
    }
    public function addColumn($data){
        $column = new MenuColumn();
        $data['position'] = 987678;
        $data['column'] = $data['row'];
        $column->fill($data)->save();
        return $column;
    }
    public function addElement($data){
        $menu = new MenuElement();
        if (isModuleActive('FrontendMultiLang')) {
            if($data['type'] == 'category'){
                $category = DB::table('categories')->where('id',$data['element_id'])->first();
                if (gettype(json_decode($category->name)) != "object") {
                    $data['title'] = $category->name;
                }else {
                    $categoryName = [];
                    $category_name = json_decode($category->name);
                    foreach ($category_name as $key => $value) {
                        $categoryName[$key] = $value;
                    }
                    $data['title'] = $categoryName;
                }
            }
            if ($data['type'] == 'page') {
                $page = DB::table('dynamic_pages')->where('id',$data['element_id'])->first();
                if (gettype(json_decode($page->title)) != "object") {
                    $data['title'] = $page->title;
                }else {
                    $pageName = [];
                    $page_name = json_decode($page->title);
                    foreach ($page_name as $key => $value) {
                        $pageName[$key] = $value;
                    }
                    $data['title'] = $pageName;
                }
            }
            if($data['type'] == 'product'){
                $product = DB::table('seller_products')->where('id',$data['element_id'])->first();
                if (gettype(json_decode($product->product_name)) != "object") {
                    $data['title'] = $product->product_name;
                }else {
                    $productName = [];
                    $product_name = json_decode($product->product_name);
                    foreach ($product_name as $key => $value) {
                        $productName[$key] = $value;
                    }
                    $data['title'] = $productName;
                }
            }
            if($data['type'] == 'brand'){
                $brand = DB::table('brands')->where('id',$data['element_id'])->first();
                if (gettype(json_decode($brand->name)) != "object") {
                    $data['title'] = $brand->name;
                }else {
                    $brandName = [];
                    $brand_name = json_decode($brand->name);
                    foreach ($brand_name as $key => $value) {
                        $brandName[$key] = $value;
                    }
                    $data['title'] = $brandName;
                }
            }
            if($data['type'] == 'function'){
                $data['title'] = 'Lang & Currency';
            }
            if($data['type'] == 'tag'){
                $tag = Tag::findOrFail($data['element_id']);
                $data['title'] = $tag->name;
            }
            if($data['type'] == 'link'){
                $data['title'] = $data['title'];
            }
        }else{
            if($data['type'] == 'category'){
                $category = Category::findOrFail($data['element_id']);
                $data['title'] = $category->name;
            }
            if ($data['type'] == 'page') {
                $page = DynamicPage::findOrFail($data['element_id']);
                $data['title'] = $page->title;
            }
            if($data['type'] == 'product'){
                $product = SellerProduct::findOrFail($data['element_id']);
                $data['title'] = $product->product->product_name;
            }
            if($data['type'] == 'brand'){
                $brand = Brand::findOrFail($data['element_id']);
                $data['title'] = $brand->name;
            }
            if($data['type'] == 'function'){
                $data['title'] = 'Lang & Currency';
            }
            if($data['type'] == 'tag'){
                $tag = Tag::findOrFail($data['element_id']);
                $data['title'] = $tag->name;
            }
            if($data['type'] == 'link'){
                $data['title'] = $data['title'];
            }
        }
        $data['position'] = 387437;
        $menu->fill($data)->save();
        return $menu;
    }
    public function addMenu($data){
        if (isModuleActive('FrontendMultiLang')) {
            $menu = DB::table('menus')->where('id',$data['menu_id'])->first();
            $menuName = [];
            $menu_name = json_decode($menu->name);
            foreach ($menu_name as $key => $value) {
                $menuName[$key] = $value;
            }
            $data['title'] = $menuName;
        }else{
            $menu = Menu::findOrFail($data['menu_id']);
            $data['title'] = $menu->name;
        }
        $multi_menu = new MultiMegaMenu();
        $multi_menu->fill($data)->save();
        $menu_update = Menu::findOrFail($data['menu_id']);
        $menu_update->update([
            'has_parent' => 1
        ]);
        return true;
    }
    public function addRightPanelData($data){
        $category = Category::findOrFail($data['category_id']);
        return MegaMenuRightPanel::create([
            'title' => $category->name,
            'menu_id' => $data['menu_id'],
            'category_id' => $data['category_id']
        ]);
    }
    public function addBottomPanelData($data){
        $brand = Brand::findOrFail($data['brand_id']);
        return MegaMenuBottomPanel::create([
            'title' => $brand->name,
            'menu_id' => $data['menu_id'],
            'brand_id' => $data['brand_id']
        ]);
    }
    public function sort($data){
        foreach($data['ids'] as $key => $id){
            $menu = Menu::find($id);
            $menu->update([
                'order_by' => $key + 1
            ]);
        }
        return true;
    }
    public function sortElement($data){
        foreach($data['ids'] as $key => $id){
            $element = MenuElement::find($id);
            $element->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }
    public function sortColumn($data){
        foreach($data['ids'] as $key => $id){
            $element = MenuColumn::find($id);
            $element->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }
    public function sortRightPanelData($data){
        foreach($data['ids'] as $key => $id){
            $item = MegaMenuRightPanel::find($id);
            $item->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }
    public function sortBottomPanelData($data){
        foreach($data['ids'] as $key => $id){
            $item = MegaMenuBottomPanel::find($id);
            $item->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }
    public function sortMenuForMultiMenu($data){
        foreach($data['ids'] as $key => $id){
            $menu = MultiMegaMenu::find($id);
            $menu->update([
                'position' => $key + 1
            ]);
        }
        return true;
    }
    public function addToColumn($data){
        $element = MenuElement::find($data['element']);
        return $element->update([
            'column_id' => $data['column_id']
        ]);
    }
    public function removeFromColumn($data){
        $element = MenuElement::find($data['element']);
        return $element->update([
            'column_id' => null
        ]);
    }
    public function columnUpdate($data){
        $column = MenuColumn::findOrFail($data['column_id']);
        $column->fill($data)->save();
        return $column;
    }
    public function deleteById($id){
        $menu = Menu::where('id', $id)->first();
        Cache::forget('MegaMenu');
        $used_in_multi_mega_menu = MultiMegaMenu::where('menu_id', $id)->first();
        if($used_in_multi_mega_menu){
            return 'not_possible';
        }else{
            if(count($menu->menus) > 0){
                $menus = $menu->menus->pluck('id');
                MultiMegaMenu::destroy($menus);
            }
            if(count($menu->allElements) > 0){
                $elements = $menu->allElements->pluck('id');
                MenuElement::destroy($elements);
            }
            if(count($menu->columns) > 0){
                $columns = $menu->columns->pluck('id');
                MenuColumn::destroy($columns);
            }
            $menu->delete();
            return 'possible';
        }
    }
    public function deleteColumn($id){
        $column = MenuColumn::find($id);
        $element = MenuElement::where('column_id',$id)->pluck('id');
        MenuElement::destroy($element);
        $column->delete();
        return true;
    }
    public function deleteElement($id){
        $element = MenuElement::find($id);
        if(count($element->childs) > 0){
            foreach($element->childs as $child){
                $child->update([
                    'parent_id' => $element->parent_id
                ]);
            }
        }
        $element->delete();
        return true;
    }
    public function deleteMenuForMultiMenu($data){
        $menu = MultiMegaMenu::where('multi_mega_menu_id',$data['menu_id'])->where('id',$data['id'])->firstOrFail();
        $menu->delete();
        return true;
    }
    public function deleteRightPanelData($id){
        MegaMenuRightPanel::find($id)->delete();
        return true;
    }
    public function deleteBottomPanelData($id){
        MegaMenuBottomPanel::find($id)->delete();
        return true;
    }
    public function editElementById($id){
        return MenuElement::findOrFail($id);
    }
    public function elementUpdate($data){
        if($data['type'] == 'category'){
            $data['element_id'] = $data['category'];
        }elseif($data['type'] == 'page'){
            $data['element_id'] = $data['page'];
        }elseif($data['type'] == 'product'){
            $data['element_id'] = $data['product'];
        }elseif($data['type'] == 'brand'){
            $data['element_id'] = $data['brand'];
        }elseif($data['type'] == 'tag'){
            $data['element_id'] = $data['tag'];
        }elseif($data['type'] == 'function'){
            $data['element_id'] = $data['function'];
        }
        $menu =  MenuElement::where('id',$data['id'])->first();
        $data['show'] = isset($data['show'])?$data['show']:0;
        $data['is_newtab'] = isset($data['is_newtab'])?$data['is_newtab']:0;
        $menu->fill($data)->save();
        return $menu;
    }
    public function updateMenuForMultiMenu($data){
        $menu = MultiMegaMenu::findOrFail($data['id']);
        $menu->update([
            'title' => $data['title'],
            'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0,
            'menu_id' => $data['menu']
        ]);
        Menu::where('id',$data['menu'])->first()->update([
            'has_parent' => 1
        ]);
        return true;
    }
    public function updateRightPanelData($data){
        $item = MegaMenuRightPanel::findOrFail($data['id']);
        $item->update([
            'title' => $data['title'],
            'category_id' => $data['category'],
            'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
        ]);
    }
    public function updateBottomPanelData($data){
        $item = MegaMenuBottomPanel::findOrFail($data['id']);
        $item->update([
            'title' => $data['title'],
            'brand_id' => $data['brand'],
            'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
        ]);
    }
    public function statusChange($data){
        $menu = Menu::findOrFail($data['id']);
        $menu->update([
            'status' => $data['status']
        ]);
        return true;
    }
    public function adsUpdate($data){
        $ads = MegaMenuAds::where('menu_id', $data['menu_id'])->first();
        $host = activeFileStorage();
        if ($ads) {
            if (isset($data['menu_ads_image']) && $data['menu_ads_image'] != @$ads->menu_ads_image_media->media_id) {
                if(@$ads->image != null){
                    ImageStore::deleteImage($ads->image);
                }
                $media_img = MediaManager::find($data['menu_ads_image']);
                if($media_img->storage == 'local'){
                    $file = asset_path($media_img->file_name);
                }else{
                    $file = $media_img->file_name;
                }
                $menu_ads_image = ImageStore::saveImage($file, 330, 300);
                if ($host == 'Dropbox') {
                    $data['image'] = $menu_ads_image['images_source'];
                    $data['file_dropbox'] = $menu_ads_image['file_dropbox'];
                }else{
                    $data['image'] = $menu_ads_image;
                }
                if ($ads) {
                    $prev_meta = UsedMedia::where('usable_id', $ads->id)->where('usable_type', get_class($ads))->where('used_for', 'menu_ads_image')->first();
                }else {
                    $prev_meta = '';
                }
                if($prev_meta){
                    $prev_meta->update([
                        'media_id' => $media_img->id
                    ]);
                }else{
                    UsedMedia::create([
                        'media_id' => $media_img->id,
                        'usable_id' => $ads->id,
                        'usable_type' => get_class($ads),
                        'used_for' => 'menu_ads_image'
                    ]);
                    return true;
                }
            }else{
                if($ads->menu_ads_image_media != null && !isset($data['menu_ads_image'])){
                    $ads->menu_ads_image_media->delete();
                    ImageStore::deleteImage($ads->image);
                    $data['image'] = null;
                }else{
                    $data['image'] = $ads->image;
                }
            }
            $ads->fill($data)->save();
            return true;
        }else {
            $ads = new MegaMenuAds();
            $thumbnail_image = null;
            if(isset($data['menu_ads_image'])){
                $media_img = MediaManager::find($data['menu_ads_image']);
                if($media_img){
                    if($media_img->storage == 'local'){
                        $file = asset_path($media_img->file_name);
                    }else{
                        $file = $media_img->file_name;
                    }
                    $thumbnail_image = ImageStore::saveImage($file, 330, 300);
                }
                if ($host == 'Dropbox') {
                    $data['image'] = $thumbnail_image['images_source'];
                    $data['file_dropbox'] = $thumbnail_image['file_dropbox'];
                }else{
                    $data['image'] = $thumbnail_image;
                }
            }
            $ads->fill($data)->save();
            if (isset($data['menu_ads_image'])) {
                UsedMedia::create([
                    'media_id' => $data['menu_ads_image'],
                    'usable_id' => $ads->id,
                    'usable_type' => get_class($ads),
                    'used_for' => 'menu_ads_image'
                ]);
            }
            return true;
        }
    }
}
