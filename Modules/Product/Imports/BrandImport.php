<?php

namespace Modules\Product\Imports;

use App\Models\MediaManager;
use Modules\Product\Entities\Brand;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Traits\ImageStore;

class BrandImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $host = activeFileStorage();
        $thumbnail_image = null;
        if(isset($row['media_id'])){
            $media_img = MediaManager::find($row['media_id']);
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
            $row['logo'] = $thumbnail_image['images_source'];
            $row['file_dropbox'] = $thumbnail_image['file_dropbox'];
        }else{
            $row['logo'] = $thumbnail_image;
        }
        $brand = new Brand();
        $brand->fill($row)->save();
    }
}
