<?php
namespace App\Traits;

use App\Models\MediaManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use File;
use App\Traits\BunnyCDN;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductGalaryImage;
use Modules\Product\Entities\ProductSku;
use Modules\Seller\Entities\SellerProduct;

trait ImageStore
{
public static function saveImage($image, $height = null ,$lenght = null , $aspectration = true)
{

    if(isset($image)){

        $current_date  = Carbon::now()->format('d-m-Y');
        $image_extention = str_replace('image/','',Image::make($image)->mime());

        $host = activeFileStorage();
        if($host == 'AmazonS3' || $host == 'DigitalOcean' || $host == 'GoogleDrive' || $host == 'Wasabi' || $host == 'Backblaze' || $host == 'Dropbox' || $host == 'GoogleCloud' || $host == 'BunnyCDN' || $host == 'Contabo'){
             $img = Image::make($image);
            if($height != null && $lenght != null ){
                if ($aspectration) {
                    $img_size = getimagesize($image);
                    $original_width = $img_size[0];
                    $original_height = $img_size[1];
                    if($original_width > $original_height){
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $img->resize($lenght, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }elseif($original_width < $original_height){
                        // resize the image to a height of 200 and constrain aspect ratio (auto width)
                        $img->resize(null, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }else{
                        if($lenght>$height){
                            $img->resize(null,$lenght, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }elseif($lenght<$height){
                            $img->resize($height,null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }else{
                            $img->resize($height,null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }
                    }
                }else {
                    $img->resize($height,$lenght);
                }
            }
            if ($host == 'DigitalOcean') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('do')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('do')->url($img_name_for_db);
                return $url;
            }
            elseif ($host == 'GoogleDrive') {
                dd("Drive");
                $img_name_for_db = uniqid().'.'.$image_extention;
                Storage::disk('google')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('google')->url($img_name_for_db);


                return $url;
            }
            elseif ($host == 'Wasabi') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('Wasabi')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('Wasabi')->url($img_name_for_db);
                return $url;
            }
            elseif ($host == 'Backblaze') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('b2')->put($img_name_for_db, $img->stream(), 'public');
                $url = 'https://'.env('BACKBLAZE_BUCKET_NAME').'.'.env('BACKBLAZE_END_POINT').'/'.$img_name_for_db;
                return $url;
            }
            elseif ($host == 'Dropbox') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('dropbox')->put($img_name_for_db, $img->stream(), 'public');
                $url['images_source'] = Storage::disk('dropbox')->url($img_name_for_db);
                $url['file_dropbox'] = $img_name_for_db;
                return $url;
            }
            elseif ($host == 'GoogleCloud') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('gcs')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('gcs')->url($img_name_for_db);
                return $url;
            }
            elseif ($host == 'BunnyCDN') {
                $dir = 'public/temp';
                \File::ensureDirectoryExists($dir);
                $temp_img = $dir.'/'.uniqid().'.'.$image_extention;
                $img->save($temp_img);
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                $bunnyCDNStorage = new BunnyCDN(env('BUNNY_STORAGE_ZONE_NAME'), env('BUNNY_API_ACCESS_KEY') , env('BUNNY_STORAGE_ZONE_REGION'));
                $bunnyCDNStorage->uploadFile($temp_img , "/".env('BUNNY_STORAGE_ZONE_NAME')."/".$img_name_for_db);
                $file = "https://".env('BUNNY_STORAGE_ZONE_NAME').".b-cdn.net/".$img_name_for_db;
                \File::delete($temp_img);
                return $file;
            }
            elseif ($host == 'Contabo') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('contabo')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('contabo')->url($img_name_for_db);
                return $url;
            }
            else{
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('s3')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('s3')->url($img_name_for_db);
                return $url;
            }
        }else{
            if(!File::isDirectory(asset_path('uploads/images/').$current_date)){
                File::makeDirectory(asset_path('uploads/images/').$current_date, 0777, true, true);
            }
            $image_extention = str_replace('image/','',Image::make($image)->mime());
            $img = Image::make($image);
            if($height != null && $lenght != null ){
                if ($aspectration) {
                    $img_size = getimagesize($image);
                    $original_width = $img_size[0];
                    $original_height = $img_size[1];
                    if($original_width > $original_height){
                        // resize the image to a width of 300 and constrain aspect ratio (auto height)
                        $img->resize($lenght, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }elseif($original_width < $original_height){
                        // resize the image to a height of 200 and constrain aspect ratio (auto width)
                        $img->resize(null, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }else{
                        if($lenght>$height){
                            $img->resize(null,$lenght, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }elseif($lenght<$height){
                            $img->resize($height,null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }else{
                            $img->resize($height,null, function($constraint){
                                $constraint->aspectRatio();
                            });
                        }
                    }
                }else {
                    $img->resize($height,$lenght);
                }
            }
            $img_name_for_db = 'uploads/images/'.$current_date.'/'.uniqid().'.'.$image_extention;
            $img_name_for_file = asset_path($img_name_for_db);
            $img->save($img_name_for_file);
            return $img_name_for_db;
        }
    }else{
        return null ;
    }
}
public static function saveFlag($image, $name , $height = null ,$lenght = null)
{
    if(isset($image)){
        $flag_name = str_replace(' ','-',$name);
        $image_extention = str_replace('image/','',Image::make($image)->mime());
        $img = Image::make($image);
        if($height != null && $lenght != null ){
            $img_size = getimagesize($image);
            $original_width = $img_size[0];
            $original_height = $img_size[1];
            if($original_width > $original_height){
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $img->resize($lenght, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }elseif($original_width < $original_height){
                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                if($lenght>$height){
                    $img->resize(null,$lenght, function($constraint){
                        $constraint->aspectRatio();
                    });
                }elseif($lenght<$height){
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }else{
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }
            }
        }
        $img_name = 'flags'.'/flag-of-'.$flag_name.'-'.rand(11111,99999).'.'.$image_extention;
        $img_save = asset_path($img_name);
        $img->save($img_save);
        return $img_name;
    }else{
        return null ;
    }
}
public static function saveSettingsImage($image, $height = null ,$lenght = null)
{
    if(isset($image)){
        $current_date  = Carbon::now()->format('d-m-Y');
        $image_extention = str_replace('image/','',Image::make($image)->mime());
        $img = Image::make($image);
        if($height != null && $lenght != null ){
            $img_size = getimagesize($image);
            $original_width = $img_size[0];
            $original_height = $img_size[1];
            if($original_width > $original_height){
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $img->resize($lenght, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }elseif($original_width < $original_height){
                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                if($lenght>$height){
                    $img->resize(null,$lenght, function($constraint){
                        $constraint->aspectRatio();
                    });
                }elseif($lenght<$height){
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }else{
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }
            }
        }
        $img_name = 'uploads/settings'.'/'.uniqid().'.'.$image_extention;
        $img_save = asset_path($img_name);
        $img->save($img_save);
        return $img_name;
    }else{
        return null ;
    }
}
public static function deleteImage($url)
{
    if(isset($url)){
        if($url){
            if(strpos($url, 'amazonaws.com') != false){
                $url = explode('images', $url);
                $path = '/images'.$url[1];
                return Storage::disk('s3')->delete($path);
            }
            elseif(strpos($url, 'digitaloceanspaces.com') != false){
                $url = explode('images', $url);
                $path = '/images'.$url[1];
                return Storage::disk('do')->delete($path);
            }
            elseif(strpos($url, 'drive.google.com') != false){
                $url = explode('id=', $url);
                $url = $url[1];
                $url = explode('&export=', $url);
                $path = $url[0];
                return Storage::disk('google')->delete($path);
            }
            elseif(strpos($url, 'wasabisys.com') != false){
                $url = explode('images', $url);
                $path = '/images'.$url[1];
                return Storage::disk('Wasabi')->delete($path);
            }
            elseif(strpos($url, 'backblazeb2.com') != false){
                $url = explode('images', $url);
                $path = '/images'.$url[1];
                return Storage::disk('b2')->delete($path);
            }
            elseif(strpos($url, 'dropboxusercontent.com') != false){
                $file = MediaManager::where('file_name', $url)->where('user_id', getParentSellerId())->first();
                if ($file == '') {
                    $gallery = ProductGalaryImage::where('images_source',$url)->first();
                    $product = Product::where('thumbnail_image_source',$url)->first();
                    $productmeta = Product::where('meta_image',$url)->first();
                    $sellerproduct = SellerProduct::where('thum_img',$url)->where('user_id', getParentSellerId())->first();
                    $productsku = ProductSku::where('variant_image',$url)->first();
                    if ($gallery != '') {
                        return Storage::disk('dropbox')->delete($gallery->file_dropbox);
                    }
                    if ($product != '') {
                        return Storage::disk('dropbox')->delete($product->file_dropbox);
                    }
                    if ($productmeta != '') {
                        return Storage::disk('dropbox')->delete($productmeta->meta_file_dropbox);
                    }
                    if ($sellerproduct != '') {
                        return Storage::disk('dropbox')->delete($sellerproduct->file_dropbox);
                    }
                    if ($productsku != '') {
                        return Storage::disk('dropbox')->delete($productsku->file_dropbox);
                    }
                }
                return Storage::disk('dropbox')->delete($file->file_dropbox);
            }
            elseif(strpos($url, 'storage.googleapis.com') != false){
                $url = explode('images', $url);
                $path = '/images'.$url[1];
                return Storage::delete($path);
            }
            elseif(strpos($url, 'b-cdn.net') != false){
                $bunnyCDNStorage = new BunnyCDN(env('BUNNY_STORAGE_ZONE_NAME'), env('BUNNY_API_ACCESS_KEY') , env('BUNNY_STORAGE_ZONE_REGION'));
                $url = explode('images', $url);
                $path = '/images'.$url[1];
                return $bunnyCDNStorage->deleteObject("/".env('BUNNY_STORAGE_ZONE_NAME')."/".$path);
            }
            elseif(strpos($url, 'contabostorage.com') != false){
                $url = explode('images', $url);
                $path = '/images'.$url[1];
                return Storage::disk('contabo')->delete($path);
            }
            else{
                if (File::exists(asset_path($url))) {
                    File::delete(asset_path($url));
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return null;
        }
    }else{
        return null ;
    }
}

public function saveAvatar($image, $height = null ,$lenght = null)
{
    if(isset($image)){
        $current_date  = Carbon::now()->format('d-m-Y');
        if(!File::isDirectory(asset_path('uploads/avatar/').$current_date)){
            File::makeDirectory(asset_path('uploads/avatar/').$current_date, 0777, true, true);
        }
        $image_extention = str_replace('image/','',Image::make($image)->mime());
        $img = Image::make($image);
        if($height != null && $lenght != null ){
            $img_size = getimagesize($image);
            $original_width = $img_size[0];
            $original_height = $img_size[1];
            if($original_width > $original_height){
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $img->resize($lenght, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }elseif($original_width < $original_height){
                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                if($lenght>$height){
                    $img->resize(null,$lenght, function($constraint){
                        $constraint->aspectRatio();
                    });
                }elseif($lenght<$height){
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }else{
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }
            }
        }
        $img_name = 'uploads/avatar/'.$current_date.'/'.uniqid().'.'.$image_extention;
        $img_save = asset_path($img_name);
        $img->save($img_save);
        return $img_name;
    }else{
        return null ;
    }
}
public static function PaymentLogo($image, $height = null ,$lenght = null){
    if(isset($image)){
        $current_date  = Carbon::now()->format('d-m-Y');
        if(!File::isDirectory(asset_path('payment_gateway'))){
            File::makeDirectory(asset_path('payment_gateway'), 0777, true, true);
        }
        $image_extention = str_replace('image/','',Image::make($image)->mime());
        $img = Image::make($image);
        if($height != null && $lenght != null ){
            $img_size = getimagesize($image);
            $original_width = $img_size[0];
            $original_height = $img_size[1];
            if($original_width > $original_height){
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $img->resize($lenght, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }elseif($original_width < $original_height){
                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                if($lenght>$height){
                    $img->resize(null,$lenght, function($constraint){
                        $constraint->aspectRatio();
                    });
                }elseif($lenght<$height){
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }else{
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }
            }
        }
        $img_name = 'payment_gateway/'.uniqid().'.'.$image_extention;
        $img_save = asset_path($img_name);
        $img->save($img_save);
        return $img_name;
    }else{
        return null ;
    }
}

public static function CarrierLogo($image, $height = null ,$lenght = null){
    if(isset($image)){
        $current_date  = Carbon::now()->format('d-m-Y');
        if(!File::isDirectory(asset_path('carrier'))){

            File::makeDirectory(asset_path('carrier'), 0777, true, true);

        }
        $image_extention = str_replace('image/','',Image::make($image)->mime());
        $img = Image::make($image);
        if($height != null && $lenght != null ){
            $img_size = getimagesize($image);
            $original_width = $img_size[0];
            $original_height = $img_size[1];
            if($original_width > $original_height){
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $img->resize($lenght, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }elseif($original_width < $original_height){
                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                if($lenght>$height){
                    $img->resize(null,$lenght, function($constraint){
                        $constraint->aspectRatio();
                    });
                }elseif($lenght<$height){
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }else{
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }
            }
        }
        $img_name = 'carrier/'.uniqid().'.'.$image_extention;
        $img_save = asset_path($img_name);
        $img->save($img_save);
        return $img_name;
    }else{
        return null ;
    }
}
public function savePWAIcon($image){
    if(isset($image)){
        if(!File::isDirectory(asset_path('images/icons'))){
            File::makeDirectory(asset_path('images/icons'), 0777, true, true);
        }
        if (File::exists(asset_path('images/icons/icon-72x72.png'))) {
            File::delete(asset_path('images/icons/icon-72x72.png'));
        }
        if (File::exists(asset_path('images/icons/icon-96x96.png'))) {
            File::delete(asset_path('images/icons/icon-96x96.png'));
        }
        if (File::exists(asset_path('images/icons/icon-128x128.png'))) {
            File::delete(asset_path('images/icons/icon-128x128.png'));
        }
        if (File::exists(asset_path('images/icons/icon-144x144.png'))) {
            File::delete(asset_path('images/icons/icon-144x144.png'));
        }
        if (File::exists(asset_path('images/icons/icon-152x152.png'))) {
            File::delete(asset_path('images/icons/icon-152x152.png'));
        }
        if (File::exists(asset_path('images/icons/icon-192x192.png'))) {
            File::delete(asset_path('images/icons/icon-192x192.png'));
        }
        if (File::exists(asset_path('images/icons/icon-384x384.png'))) {
            File::delete(asset_path('images/icons/icon-384x384.png'));
        }
        if (File::exists(asset_path('images/icons/icon-512x512.png'))) {
            File::delete(asset_path('images/icons/icon-512x512.png'));
        }
        $img = Image::make($image);
        $img->resize(72,72);
        $img_save_72 = asset_path('images/icons/icon-72x72.png');
        $img->save($img_save_72);
        $img = Image::make($image);
        $img->resize(96,96);
        $img_save_96 = asset_path('images/icons/icon-96x96.png');
        $img->save($img_save_96);
        $img = Image::make($image);
        $img->resize(128,128);
        $img_save_128 = asset_path('images/icons/icon-128x128.png');
        $img->save($img_save_128);
        $img = Image::make($image);
        $img->resize(144,144);
        $img_save_144 = asset_path('images/icons/icon-144x144.png');
        $img->save($img_save_144);
        $img = Image::make($image);
        $img->resize(152,152);
        $img_save_152 = asset_path('images/icons/icon-152x152.png');
        $img->save($img_save_152);
        $img = Image::make($image);
        $img->resize(192,192);
        $img_save_192 = asset_path('images/icons/icon-192x192.png');
        $img->save($img_save_192);
        $img = Image::make($image);
        $img->resize(384,384);
        $img_save_384 = asset_path('images/icons/icon-384x384.png');
        $img->save($img_save_384);
        $img = Image::make($image);
        $img->resize(512,512);
        $img_save_512 = asset_path('images/icons/icon-512x512.png');
        $img->save($img_save_512);
        return true;
    }
}
public function savePWASplash($image){
    if(isset($image)){
        if(!File::isDirectory(asset_path('images/icons'))){
            File::makeDirectory(asset_path('images/icons'), 0777, true, true);
        }
        $site_log_sizes = [
            ['640', '1136'],
            ['750', '1334'],
            ['828', '1792'],
            ['1125', '2436'],
            ['1242', '2208'],
            ['1242', '2688'],
            ['1536', '2048'],
            ['1668', '2224'],
            ['1668', '2388'],
            ['2048', '2732'],
        ];
        if ($image->extension() != "svg") {
            foreach ($site_log_sizes as $size) {
                $rowImage = Image::canvas($size[0], $size[1], '#fff');
                $rowImage->insert($image, 'center');
                $rowImage->save(asset_path("images/icons/splash-{$size[0]}x{$size[1]}.png"));
            }
        }
        return true;
    }
}

public static function mediaUpload($image, $height = null ,$lenght = null)
{
    if(isset($image)){
        $orginal_name = $image->getClientOriginalName();
        $host = activeFileStorage();
        $image_extention = str_replace('image/','',Image::make($image)->mime());
        $img_size = getimagesize($image);
        $img_in_kb = round(filesize($image)/1024);
        if($host == 'AmazonS3' || $host == 'DigitalOcean' || $host == 'GoogleDrive' || $host == 'Wasabi' || $host == 'Backblaze' || $host == 'Dropbox' || $host == 'GoogleCloud' || $host == 'BunnyCDN' || $host == 'Contabo'){
            $img = Image::make($image);
            if($height != null && $lenght != null ){
                $original_width = $img_size[0];
                $original_height = $img_size[1];
                if($original_width > $original_height){
                    // resize the image to a width of 300 and constrain aspect ratio (auto height)
                    $img->resize($lenght, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }elseif($original_width < $original_height){
                    // resize the image to a height of 200 and constrain aspect ratio (auto width)
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }else{
                    if($lenght>$height){
                        $img->resize(null,$lenght, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }elseif($lenght<$height){
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }else{
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }
                }
            }
            if ($host == 'DigitalOcean') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('do')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('do')->url($img_name_for_db);
                $data['file_name'] = $url;
                $data['storage'] = 'do';
            }
            elseif ($host == 'GoogleDrive') {
                $img_name_for_db = uniqid().'.'.$image_extention;
                Storage::disk('google')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('google')->url($img_name_for_db);
                $data['file_name'] = $url;
                $data['storage'] = 'google';
            }
            elseif ($host == 'Wasabi') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('Wasabi')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('Wasabi')->url($img_name_for_db);
                $data['file_name'] = $url;
                $data['storage'] = 's3';
            }
            elseif ($host == 'Backblaze') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('b2')->put($img_name_for_db, $img->stream(), 'public');
                $url = 'https://'.env('BACKBLAZE_BUCKET_NAME').'.'.env('BACKBLAZE_END_POINT').'/'.$img_name_for_db;
                $data['file_name'] = $url;
                $data['storage'] = 'b2';
            }
            elseif ($host == 'Dropbox') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('dropbox')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('dropbox')->url($img_name_for_db);
                $data['file_name'] = $url;
                $data['file_dropbox'] = $img_name_for_db;
                $data['storage'] = 'dropbox';
            }
            elseif ($host == 'GoogleCloud') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('gcs')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('gcs')->url($img_name_for_db);
                $data['file_name'] = $url;
                $data['storage'] = 'gcs';
            }
            elseif ($host == 'BunnyCDN') {
                $bunnyCDNStorage = new BunnyCDN(env('BUNNY_STORAGE_ZONE_NAME'), env('BUNNY_API_ACCESS_KEY') , env('BUNNY_STORAGE_ZONE_REGION'));
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                $bunnyCDNStorage->uploadFile($image , "/".env('BUNNY_STORAGE_ZONE_NAME')."/".$img_name_for_db);
                $file = "https://".env('BUNNY_STORAGE_ZONE_NAME').".b-cdn.net/".$img_name_for_db;
                $data['file_name'] = $file;
                $data['storage'] = 'bunny';
            }
            elseif ($host == 'Contabo') {
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('contabo')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('contabo')->url($img_name_for_db);
                $data['file_name'] = $url;
                $data['storage'] = 'contabo';
            }
            else{
                $img_name_for_db = 'images/'.uniqid().'.'.$image_extention;
                Storage::disk('s3')->put($img_name_for_db, $img->stream(), 'public');
                $url = Storage::disk('s3')->url($img_name_for_db);
                $data['file_name'] = $url;
                $data['storage'] = 's3';
            }
        }else{
            if(!File::isDirectory(asset_path('uploads/all/'))){
                File::makeDirectory(asset_path('uploads/all/'), 0777, true, true);
            }
            $img = Image::make($image);
            if($height != null && $lenght != null ){
                $original_width = $img_size[0];
                $original_height = $img_size[1];
                if($original_width > $original_height){
                    // resize the image to a width of 300 and constrain aspect ratio (auto height)
                    $img->resize($lenght, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }elseif($original_width < $original_height){
                    // resize the image to a height of 200 and constrain aspect ratio (auto width)
                    $img->resize(null, $height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }else{
                    if($lenght>$height){
                        $img->resize(null,$lenght, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }elseif($lenght<$height){
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }else{
                        $img->resize($height,null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }
                }
            }
            $img_name_for_db = 'uploads/all/'.uniqid().'.'.$image_extention;
            $img_name_for_file = asset_path($img_name_for_db);
            $img->save($img_name_for_file);

            $data['file_name'] = $img_name_for_db;
            $data['storage'] = 'local';

        }
        $data['orginal_name'] = $orginal_name;
        $data['extension'] = $image_extention;
        $data['type'] = 'image';
        $data['size'] = $img_in_kb;
        return $data;
    }else{
        return null ;
    }
}

    public function saveGalleryImgFromPrev($image, $height = null ,$lenght = null){

        $image_extention = str_replace('image/','',Image::make($image)->mime());
        $img_size = getimagesize($image);
        $img_in_kb = round(filesize($image)/1024);
        if(!File::isDirectory(asset_path('uploads/all/'))){
            File::makeDirectory(asset_path('uploads/all/'), 0777, true, true);
        }
        $img = Image::make($image);
        if($height != null && $lenght != null ){
            $original_width = $img_size[0];
            $original_height = $img_size[1];
            if($original_width > $original_height){
                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $img->resize($lenght, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }elseif($original_width < $original_height){
                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }else{
                if($lenght>$height){
                    $img->resize(null,$lenght, function($constraint){
                        $constraint->aspectRatio();
                    });
                }elseif($lenght<$height){
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }else{
                    $img->resize($height,null, function($constraint){
                        $constraint->aspectRatio();
                    });
                }
            }
        }
        $img_name_for_db = 'uploads/all/'.uniqid().'.'.$image_extention;
        $img_name_for_file = asset_path($img_name_for_db);
        $img->save($img_name_for_file);
        $data['file_name'] = $img_name_for_db;
        $data['storage'] = 'local';
        $data['orginal_name'] = 'image_'.rand(11,100).'.'.$image_extention;
        $data['extension'] = $image_extention;
        $data['type'] = 'image';
        $data['size'] = $img_in_kb;
        return $data;
    }
}
