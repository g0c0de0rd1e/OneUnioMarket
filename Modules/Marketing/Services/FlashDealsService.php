<?php

namespace Modules\Marketing\Services;
use \Modules\Marketing\Repositories\FlashDealsRepository;
use App\Traits\ImageStore;
use Modules\Marketing\Entities\FlashDeal;
use App\Models\MediaManager;
use App\Models\UsedMedia;

class FlashDealsService{
    use ImageStore;

    protected $flashDealsRepository;

    public function __construct(FlashDealsRepository $flashDealsRepository)
    {
        $this->flashDealsRepository = $flashDealsRepository;
    }
    public function getAll(){
        return $this->flashDealsRepository->getAll();
    }
    public function store($data){
        $host = activeFileStorage();
        $thumbnail_image = null;
        if(isset($data['flash_deal_banner_image'])){
            $media_img = MediaManager::find($data['flash_deal_banner_image']);
            if($media_img){
                if($media_img->storage == 'local'){
                    $file = asset_path($media_img->file_name);
                }else{
                    $file = $media_img->file_name;
                }
                $thumbnail_image = ImageStore::saveImage($file, null,null, false);
            }
        }
        if ($host == 'Dropbox') {
            $data['banner_image'] = $thumbnail_image['images_source'];
            $data['file_dropbox'] = $thumbnail_image['file_dropbox'];
        }else{
            $data['banner_image'] = $thumbnail_image;
        }
        return $this->flashDealsRepository->store($data);
    }
    public function update($data, $id){
        $flash_deal = FlashDeal::findOrFail($id);
        $host = activeFileStorage();
        if (isset($data['flash_deal_banner_image']) && $data['flash_deal_banner_image'] != @$flash_deal->flash_deal_banner_image_media->media_id) {
            if(@$flash_deal->banner_image != null){
                ImageStore::deleteImage($flash_deal->banner_image);
            }
            $media_img = MediaManager::find($data['flash_deal_banner_image']);
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
            $prev_meta = UsedMedia::where('usable_id', $flash_deal->id)->where('usable_type', get_class($flash_deal))->where('used_for', 'flash_deal_banner_image')->first();
            if($prev_meta){
                $prev_meta->update([
                    'media_id' => $media_img->id
                ]);
            }else{
                UsedMedia::create([
                    'media_id' => $media_img->id,
                    'usable_id' => $flash_deal->id,
                    'usable_type' => get_class($flash_deal),
                    'used_for' => 'flash_deal_banner_image'
                ]);
            }
        }else{
            if($flash_deal->flash_deal_banner_image_media != null && !isset($data['flash_deal_banner_image'])){
                $flash_deal->flash_deal_banner_image_media->delete();
                ImageStore::deleteImage($flash_deal->banner_image);
                $data['banner_image'] = null;
            }else{
                $data['banner_image'] = $flash_deal->banner_image;
            }
        }
        return $this->flashDealsRepository->update($data, $id);
    }
    public function statusChange($data){
        return $this->flashDealsRepository->statusChange($data);
    }
    public function featuredChange($data){
        return $this->flashDealsRepository->featuredChange($data);
    }
    public function editById($id){
        return $this->flashDealsRepository->editById($id);
    }
    public function deleteById($id){
        return $this->flashDealsRepository->deleteById($id);
    }
    public function getSellerProduct(){
        return $this->flashDealsRepository->getSellerProduct();
    }
    public function getActiveFlashDeal(){
        return $this->flashDealsRepository->getActiveFlashDeal();
    }
}
