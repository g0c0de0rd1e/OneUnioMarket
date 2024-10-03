<?php

namespace Modules\FrontendCMS\Repositories;

use App\Models\MediaManager;
use App\Models\UsedMedia;
use App\Traits\ImageStore;
use \Modules\FrontendCMS\Entities\SubscribeContent;

class SubcribeContentRepository
{
    use ImageStore;
    protected $subcribe;
    public function __construct(SubscribeContent $subcribe)
    {
        $this->subcribe = $subcribe;
    }
    public function getAllContent()
    {
        return $this->subcribe->get();
    }
    public function update($data, $id)
    {
        $subcribeContent = SubscribeContent::findOrFail($id);
        $host = activeFileStorage();
        if (isset($data['popup_image']) && $data['popup_image'] != @$subcribeContent->popup_image_media->media_id) {
            if(@$subcribeContent->image != null){
                ImageStore::deleteImage($subcribeContent->image);
            }
            $media_img = MediaManager::find($data['popup_image']);
            if($media_img->storage == 'local'){
                $file = asset_path($media_img->file_name);
            }else{
                $file = $media_img->file_name;
            }
            $popup_image = ImageStore::saveImage($file, 327, 446);
            if ($host == 'Dropbox') {
                $data['image'] = $popup_image['images_source'];
                $data['file_dropbox'] = $popup_image['file_dropbox'];
            }else{
                $data['image'] = $popup_image;
            }
            if ($subcribeContent) {
                $prev_meta = UsedMedia::where('usable_id', $subcribeContent->id)->where('usable_type', get_class($subcribeContent))->where('used_for', 'popup_image')->first();
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
                    'usable_id' => $subcribeContent->id,
                    'usable_type' => get_class($subcribeContent),
                    'used_for' => 'popup_image'
                ]);
            }
        }else{
            if($subcribeContent->popup_image_media != null && !isset($data['popup_image'])){
                $subcribeContent->popup_image_media->delete();
                ImageStore::deleteImage($subcribeContent->image);
                $data['image'] = null;
            }else{
                $data['image'] = $subcribeContent->image;
            }
        }
         $subcribeContent->update([
            'title' => isset($data['title'])?$data['title']:null,
            'subtitle' => isset($data['subtitle'])?$data['subtitle']:null,
            'description' => isset($data['description'])?$data['description']:null,
            'second' => isset($data['second'])?$data['second']:null,
            'status' => (isset($data['status']) && $data['status'] == 1)?1:0,
            'image' => $data['image']
        ]);
        return $subcribeContent;
    }
    public function edit($id)
    {
        $subcribe = $this->subcribe->findOrFail($id);
        return $subcribe;
    }
}
