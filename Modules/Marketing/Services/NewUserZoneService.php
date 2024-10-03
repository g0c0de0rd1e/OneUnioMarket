<?php

namespace Modules\Marketing\Services;
use \Modules\Marketing\Repositories\NewUserZoneRepository;
use App\Traits\ImageStore;
use App\Models\MediaManager;
use App\Models\UsedMedia;
use Modules\Marketing\Entities\NewUserZone;

class NewUserZoneService{
    use ImageStore;
    protected $newUserZoneRepository;
    public function __construct(NewUserZoneRepository $newUserZoneRepository)
    {
        $this->newUserZoneRepository = $newUserZoneRepository;
    }
    public function getAll(){
        return $this->newUserZoneRepository->getAll();
    }
    public function store($data){
        $host = activeFileStorage();
        $thumbnail_image = null;
        if(isset($data['new_user_zone_banner_image'])){
            $media_img = MediaManager::find($data['new_user_zone_banner_image']);
            if($media_img){
                if($media_img->storage == 'local'){
                    $file = asset_path($media_img->file_name);
                }else{
                    $file = $media_img->file_name;
                }
                $thumbnail_image = ImageStore::saveImage($file, 1920,500);
            }
        }
        if ($host == 'Dropbox') {
            $data['banner_image'] = $thumbnail_image['images_source'];
            $data['file_dropbox'] = $thumbnail_image['file_dropbox'];
        }else{
            $data['banner_image'] = $thumbnail_image;
        }
        return $this->newUserZoneRepository->store($data);
    }
    public function update($data, $id){
        $flash_deal = NewUserZone::findOrFail($id);
        $host = activeFileStorage();
        if (isset($data['new_user_zone_banner_image']) && $data['new_user_zone_banner_image'] != @$flash_deal->banner_image_media->media_id) {
            if(@$flash_deal->banner_image != null){
                ImageStore::deleteImage($flash_deal->banner_image);
            }
            $media_img = MediaManager::find($data['new_user_zone_banner_image']);
            if($media_img->storage == 'local'){
                $file = asset_path($media_img->file_name);
            }else{
                $file = $media_img->file_name;
            }
            $banner_image = ImageStore::saveImage($file, 1920,500);
            if ($host == 'Dropbox') {
                $data['banner_image'] = $banner_image['images_source'];
                $data['file_dropbox'] = $banner_image['file_dropbox'];
            }else{
                $data['banner_image'] = $banner_image;
            }
            $prev_meta = UsedMedia::where('usable_id', $flash_deal->id)->where('usable_type', get_class($flash_deal))->where('used_for', 'banner_image')->first();
            if($prev_meta){
                $prev_meta->update([
                    'media_id' => $media_img->id
                ]);
            }else{
                UsedMedia::create([
                    'media_id' => $media_img->id,
                    'usable_id' => $flash_deal->id,
                    'usable_type' => get_class($flash_deal),
                    'used_for' => 'banner_image'
                ]);
            }
        }else{
            if($flash_deal->banner_image_media != null && !isset($data['new_user_zone_banner_image'])){
                $flash_deal->banner_image_media->delete();
                ImageStore::deleteImage($flash_deal->banner_image);
                $data['banner_image'] = null;
            }else{
                $data['banner_image'] = $flash_deal->banner_image;
            }
        }
        return $this->newUserZoneRepository->update($data, $id);
    }
    public function statusChange($data){
        return $this->newUserZoneRepository->statusChange($data);
    }
    public function featuredChange($data){
        return $this->newUserZoneRepository->featuredChange($data);
    }
    public function editById($id){
        return $this->newUserZoneRepository->editById($id);
    }
    public function deleteById($id){
        $flash_deal = NewUserZone::findOrFail($id);
        ImageStore::deleteImage($flash_deal->banner_image);
        return $this->newUserZoneRepository->deleteById($id);
    }
    public function getSellerProduct(){
        return $this->newUserZoneRepository->getSellerProduct();
    }
    public function getCategories(){
        return $this->newUserZoneRepository->getCategories();
    }
    public function getCoupons(){
        return $this->newUserZoneRepository->getCoupons();
    }
    public function getActiveNewUserZone(){
        return $this->newUserZoneRepository->getActiveNewUserZone();
    }
    public function getAllCategory(){
        return $this->newUserZoneRepository->getAllCategory();
    }
}
