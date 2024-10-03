<?php

namespace Modules\Blog\Services;
use App\Models\MediaManager;
use App\Models\UsedMedia;
use \Modules\Blog\Repositories\BlogCategoryRepository;
use App\Traits\ImageStore;

class BlogCategoryService
{
    protected $blogCategoryRepository;

    public function __construct(BlogCategoryRepository  $blogCategoryRepository)
    {
        $this->blogCategoryRepository= $blogCategoryRepository;
    }

    public function getAll()
    {
        return $this->blogCategoryRepository->getAll();
    }

    public function create(array $data)
    {
        $host = activeFileStorage();
        $thumbnail_image = null;
        if(isset($data['blog_image'])){
            $media_img = MediaManager::find($data['blog_image']);
            if($media_img){
                if($media_img->storage == 'local'){
                    $file = asset_path($media_img->file_name);
                }else{
                    $file = $media_img->file_name;
                }
                $thumbnail_image = ImageStore::saveImage($file, 64,64);
            }
        }
        if ($host == 'Dropbox') {
            $data['image_url'] = $thumbnail_image['images_source'];
            $data['file_dropbox'] = $thumbnail_image['file_dropbox'];
        }else{
            $data['image_url'] = $thumbnail_image;
        }
        return $this->blogCategoryRepository->create($data);
    }
    public function find($id)
    {   
        return $this->blogCategoryRepository->find($id);
    }
    public function update(array $data, $id)
    {
        $host = activeFileStorage();
        $editData = $this->find($id);
        if (isset($data['blog_image']) && $data['blog_image'] != @$editData->blog_cat_image_media->media_id) {
            if(@$editData->image_url != null){
                ImageStore::deleteImage($editData->image_url);
            }
            $media_img = MediaManager::find($data['blog_image']);
            if($media_img->storage == 'local'){
                $file = asset_path($media_img->file_name);
            }else{
                $file = $media_img->file_name;
            }
            $blog_image = ImageStore::saveImage($file, 64,64);
            if ($host == 'Dropbox') {
                $data['image_url'] = $blog_image['images_source'];
                $data['file_dropbox'] = $blog_image['file_dropbox'];
            }else{
                $data['image_url'] = $blog_image;
            }
            $prev_meta = UsedMedia::where('usable_id', $editData->id)->where('usable_type', get_class($editData))->where('used_for', 'blog_cat_image')->first();
            if($prev_meta){
                $prev_meta->update([
                    'media_id' => $media_img->id
                ]);
            }else{
                UsedMedia::create([
                    'media_id' => $media_img->id,
                    'usable_id' => $editData->id,
                    'usable_type' => get_class($editData),
                    'used_for' => 'blog_cat_image'
                ]);
            }
        }else{
            if($editData->blog_cat_image_media != null && !isset($data['blog_image'])){
                $editData->blog_cat_image_media->delete();
                ImageStore::deleteImage($editData->image_url);
                $data['image_url'] = null;
            }else{
                $data['image_url'] = $editData->image_url;
            }
        }
        return $this->blogCategoryRepository->update($data,$id);
    }

    public function delete($id)
    {
        return $this->blogCategoryRepository->delete($id);
    }

}
