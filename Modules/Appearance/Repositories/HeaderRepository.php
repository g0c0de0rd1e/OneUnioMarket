<?php

namespace Modules\Appearance\Repositories;
use App\Models\MediaManager;
use App\Models\UsedMedia;
use Modules\Appearance\Entities\Header;
use Modules\Appearance\Entities\HeaderCategoryPanel;
use Modules\Appearance\Entities\HeaderNewUserZonePanel;
use Modules\Appearance\Entities\HeaderProductPanel;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\Marketing\Entities\NewUserZone;
use Modules\Product\Entities\Category;
use Modules\Seller\Entities\SellerProduct;
use App\Traits\ImageStore;

class HeaderRepository {
    use ImageStore;
    public function getAllZones(){
        return NewUserZone::where('status',1)->latest()->get();
    }
    public function getHeaders(){
        if(app('theme')->folder_path == 'default'){
            return Header::all();
        }elseif(app('theme')->folder_path == 'amazy'){
            return Header::where('id', 1)->get();
        }
    }
    public function getById($id){
        return Header::findOrFail($id);
    }
    public function update($data){
        Header::where('id',$data['id'])->first()->update([
            'column_size' => $data['column_size'],
            'is_enable' => isset($data['is_enable'])?$data['is_enable']:0
        ]);
        return true;
    }
    public function addElement($data){
        $header = Header::findOrFail($data['id']);
        if($header->type == 'category'){
            foreach($data['category'] as $key => $id){
                $category = Category::findOrFail($id);
                HeaderCategoryPanel::create([
                    'title' => $category->name,
                    'category_id' => $id,
                    'status' => 1,
                    'is_newtab' => 0
                ]);
            }
            return true;
        }
        elseif($header->type == 'product'){
            foreach($data['product'] as $key => $id){
                $product = SellerProduct::findOrFail($id);
                HeaderProductPanel::create([
                    'title' => $product->product->product_name,
                    'product_id' => $id,
                    'status' => 1,
                    'is_newtab' => 0
                ]);
            }
            return true;
        }elseif($header->type == 'slider'){
            $host = activeFileStorage();
            $thumbnail_image = null;
            if(isset($data['slider_image_media'])){
                $media_img = MediaManager::find($data['slider_image_media']);
                if($media_img){
                    if($media_img->storage == 'local'){
                        $file = asset_path($media_img->file_name);
                    }else{
                        $file = $media_img->file_name;
                    }
                    if (app('theme')->folder_path == 'default') {
                        $value = [660 ,365];
                    }else {
                        $value = [1920 , 600];
                    }
                    $thumbnail_image = ImageStore::saveImage($file, $value[0], $value[1],false);
                }
            }
            if ($host == 'Dropbox') {
                $data['slider_image'] = $thumbnail_image['images_source'];
                $data['file_dropbox'] = $thumbnail_image['file_dropbox'];
            }else{
                $data['slider_image'] = $thumbnail_image;
            }
            $slider = new HeaderSliderPanel();
            $data['url'] = (isset($data['data_type']) && $data['data_type'] == 'url' && isset($data['data_id']))?$data['data_id']:null;
            $data['data_type'] = isset($data['data_type'])?$data['data_type']:null;
            $data['data_id'] = (isset($data['data_type']) && $data['data_type'] != 'url' && isset($data['data_id']))?$data['data_id']:null;
            $data['is_newtab'] = isset($data['is_newtab'])?$data['is_newtab']:0;
            $slider->fill($data)->save();
            if (isset($data['slider_image_media'])) {
                UsedMedia::create([
                    'media_id' => $data['slider_image_media'],
                    'usable_id' => $slider->id,
                    'usable_type' => get_class($slider),
                    'used_for' => 'slider_image'
                ]);
            }
            return true;
        }
        else{
            return false;
        }
    }
    public function updateElement($data){
        $header = Header::findOrFail($data['header_id']); 
        if($header->type == 'category'){
            HeaderCategoryPanel::where('id',$data['id'])->first()->update([
                'title' => $data['title'],
                'category_id' => $data['category'],
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
            return true;
        }
        elseif($header->type == 'product'){
            HeaderProductPanel::where('id',$data['id'])->first()->update([
                'title' => $data['title'],
                'product_id' => $data['product'],
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
            return true;
        }
        elseif($header->type == 'new_user_zone'){
            HeaderNewUserZonePanel::first()->update([
                'navigation_label' => $data['navigation_label'],
                'title' => $data['title'],
                'pricing' => $data['pricing'],
                'new_user_zone_id' => $data['new_user_zone_id'],
            ]);
            return true;
        }
        elseif($header->type == 'slider'){
            $slider = HeaderSliderPanel::findOrFail($data['id']);
            $host = activeFileStorage();
            if (isset($data['slider_image_media']) && $data['slider_image_media'] != @$slider->slider_image_media->media_id) {
                if(@$slider->slider_image != null){
                    ImageStore::deleteImage($slider->slider_image);
                }
                $media_img = MediaManager::find($data['slider_image_media']);
                if($media_img->storage == 'local'){
                    $file = asset_path($media_img->file_name);
                }else{
                    $file = $media_img->file_name;
                }
                if (app('theme')->folder_path == 'default') {
                    $value = [660 ,365];
                }else {
                    $value = [1920 , 600];
                }
                $slider_image = ImageStore::saveImage($file, $value[0], $value[1],false);
                if ($host == 'Dropbox') {
                    $data['slider_image'] = $slider_image['images_source'];
                    $data['file_dropbox'] = $slider_image['file_dropbox'];
                }else{
                    $data['slider_image'] = $slider_image;
                }
                $prev_meta = UsedMedia::where('usable_id', $slider->id)->where('usable_type', get_class($slider))->where('used_for', 'slider_image')->first();
                if($prev_meta){
                    $prev_meta->update([
                        'media_id' => $media_img->id
                    ]);
                }else{
                    UsedMedia::create([
                        'media_id' => $media_img->id,
                        'usable_id' => $slider->id,
                        'usable_type' => get_class($slider),
                        'used_for' => 'slider_image'
                    ]);
                }
            }else{
                if($slider->slider_image_media != null && !isset($data['slider_image_media'])){
                    $slider->slider_image_media->delete();
                    ImageStore::deleteImage($slider->slider_image);
                    $data['slider_image'] = null;
                }else{
                    $data['slider_image'] = $slider->slider_image;
                }
            }
            $slider->update([
                'name' => $data['name'],
                'url' => (isset($data['data_type']) && $data['data_type'] == 'url' && isset($data['data_id']))?$data['data_id']:null,
                'data_type' => isset($data['data_type'])?$data['data_type']:null,
                'data_id' => (isset($data['data_type']) && $data['data_type'] != 'url' && isset($data['data_id']))?$data['data_id']:null,
                'slider_image' => $data['slider_image'],
                'status' => $data['status'],
                'is_newtab' => isset($data['is_newtab'])?$data['is_newtab']:0
            ]);
            return true;
        }
        else{
            return false;
        }
    }
    public function deleteElement($data){
        $header = Header::findOrFail($data['header_id']);
        if($header->type == 'category'){
            HeaderCategoryPanel::where('id',$data['id'])->first()->delete();
            return true;
        }
        elseif($header->type == 'product'){
            HeaderProductPanel::where('id',$data['id'])->first()->delete();
            return true;
        }
        elseif($header->type == 'slider'){
            $slider = HeaderSliderPanel::findOrFail($data['id']);
            ImageStore::deleteImage($slider->slider_image);
            UsedMedia::where('usable_id', $slider->id)->where('usable_type', get_class($slider))->where('used_for', 'slider_image')->delete();
            $slider->delete();
            return true;
        }
        else{
            return false;
        }
    }
    public function sortElement($data){
        $header = Header::findOrFail($data['header_id']);
        if($header->type == 'category'){
            foreach($data['ids'] as $key => $id){
                HeaderCategoryPanel::where('id',$id)->first()->update([
                    'position' => $key + 1
                ]);
            }
            return true;
        }
        elseif($header->type == 'product'){
            foreach($data['ids'] as $key => $id){
                HeaderProductPanel::where('id',$id)->first()->update([
                    'position' => $key + 1
                ]);
            }
            return true;
        }
        elseif($header->type == 'slider'){
            foreach($data['ids'] as $key => $id){
                HeaderSliderPanel::where('id',$id)->first()->update([
                    'position' => $key + 1
                ]);
            }
            return true;
        }
        else{
            return false;
        }
    }
    public function getSliders(){
        return HeaderSliderPanel::where('status', 1)->latest()->get();
    }
    public function getSingleSlider($id){
        return HeaderSliderPanel::where('status', 1)->where('id', $id)->firstOrFail();
    }
    public function updateEnableStatus($data)
    {
        return Header::where('id',$data['id'])->first()->update([
            'is_enable' => isset($data['status']) ? $data['status'] : 0
        ]);
    }
}
