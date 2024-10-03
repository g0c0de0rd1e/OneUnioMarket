<?php

namespace Modules\Product\Services;

use App\Models\MediaManager;
use App\Models\UsedMedia;
use \Modules\Product\Repositories\BrandRepository;
use App\Traits\ImageStore;

class BrandService
{
    use ImageStore;
    protected $brandRepository;
    public function __construct(BrandRepository  $brandRepository)
    {
        $this->brandRepository= $brandRepository;
    }
    public function save($data)
    {
        $host = activeFileStorage();
        $thumbnail_image = null;
        if(isset($data['brand_image'])){
            $media_img = MediaManager::find($data['brand_image']);
            if($media_img){
                if($media_img->storage == 'local'){
                    $file = asset_path($media_img->file_name);
                }else{
                    $file = $media_img->file_name;
                }
                $thumbnail_image = ImageStore::saveImage($file, 150,150);
            }
        }
        if ($host == 'Dropbox') {
            $data['logo'] = $thumbnail_image['images_source'];
            $data['file_dropbox'] = $thumbnail_image['file_dropbox'];
        }else{
            $data['logo'] = $thumbnail_image;
        }
        return $this->brandRepository->create($data);
    }
    public function update($data,$id)
    {
        $host = activeFileStorage();
        $editData = $this->findById($id);
        if (isset($data['brand_image']) && $data['brand_image'] != @$editData->brand_image_media->media_id) {
            if(@$editData->logo != null){
                ImageStore::deleteImage($editData->logo);
            }
            $media_img = MediaManager::find($data['brand_image']);
            if($media_img->storage == 'local'){
                $file = asset_path($media_img->file_name);
            }else{
                $file = $media_img->file_name;
            }
            $brand_image = ImageStore::saveImage($file, 150,150);
            if ($host == 'Dropbox') {
                $data['logo'] = $brand_image['images_source'];
                $data['file_dropbox'] = $brand_image['file_dropbox'];
            }else{
                $data['logo'] = $brand_image;
            }
            $prev_meta = UsedMedia::where('usable_id', $editData->id)->where('usable_type', get_class($editData))->where('used_for', 'brand_image')->first();
            if($prev_meta){
                $prev_meta->update([
                    'media_id' => $media_img->id
                ]);
            }else{
                UsedMedia::create([
                    'media_id' => $media_img->id,
                    'usable_id' => $editData->id,
                    'usable_type' => get_class($editData),
                    'used_for' => 'brand_image'
                ]);
            }
        }else{
            if($editData->brand_image_media != null && !isset($data['brand_image'])){
                $editData->brand_image_media->delete();
                ImageStore::deleteImage($editData->logo);
                $data['logo'] = null;
            }else{
                $data['logo'] = $editData->logo;
            }
        }
        return $this->brandRepository->update($data, $id);
    }
    public function getAll()
    {
        return $this->brandRepository->getAll();
    }
    public function getAllCount(){
        return $this->brandRepository->getAllCount();
    }
    public function getActiveAll()
    {
        return $this->brandRepository->getActiveAll();
    }
    public function getBySearch($data)
    {
        return $this->brandRepository->getBySearch($data);
    }
    public function getByPaginate($count)
    {
        return $this->brandRepository->getByPaginate($count);
    }
    public function getBySkipTake($skip, $take)
    {
        return $this->brandRepository->getBySkipTake($skip, $take);
    }
    public function getbrandbySort()
    {
        return $this->brandRepository->getbrandbySort();
    }
    public function deleteById($id)
    {
        return $this->brandRepository->delete($id);
    }
    public function findById($id)
    {
        return $this->brandRepository->find($id);
    }
    public function findBySlug($slug)
    {
        return $this->brandRepository->findBySlug($slug);
    }
    public function csvUploadBrand($data)
    {
        return $this->brandRepository->csvUploadBrand($data);
    }
    public function csvDownloadBrand()
    {
        return $this->brandRepository->csvDownloadBrand();
    }
    public function getBrandsByAjax($search){
        return $this->brandRepository->getBrandsByAjax($search);
    }
}
