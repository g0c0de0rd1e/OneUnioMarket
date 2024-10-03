<?php

namespace Modules\GeneralSetting\Http\Controllers;


use Exception;
use App\Traits\ImageStore;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Modules\Product\Entities\Product;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Contracts\Support\Renderable;
use Modules\GeneralSetting\Entities\Currency;
use Modules\GeneralSetting\Entities\GeneralSetting;
use Modules\GeneralSetting\Services\GeneralSettingService;

class ImageSettingsController extends Controller
{
    protected $general_setting;
    public function __construct(GeneralSettingService $generalSettingService)
    {
        $this->general_setting = $generalSettingService;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('generalsetting::image_setting.index');
    }



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $request->validate([
            "image_convert" => "required|integer"
        ]);

        try{
            if($this->general_setting->update($request->except("_token"))){
                Toastr::success('Operation Successful','Success');
                return back();
            }

            Toastr::error('something want wrong','Error');
            return back();
        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Error');
            return back();
        }

    }

    public function convertImages(Request $request)
    {
        $request->validate(['password' => "required"]);

        try{
             if(Hash::check($request->password, Auth::user()->password)){
                $this->convertAllImages();
                Toastr::success('operation Successful','Success');
                return back();
             }

             Toastr::error("password not matched",'Error');
             return back();

        }catch(Exception $e){
            Toastr::error($e->getMessage(),'Error');
            return back();
        }


    }


    public function convertAllImages()
    {
            ini_set('max_execution_time', 900);
            $images = DB::table('product_galary_images')->get();
            foreach($images as $img)
            {
                if(file_exists(public_path($img->images_source))){
                        $current_image_path = $img->images_source;
                        $img_path_array = explode('.',$img->images_source);
                        if(isset($img_path_array[0]) && isset($img_path_array[1]) && $img_path_array[1] != 'webp'){
                            $image =  Image::make(public_path($current_image_path))->encode('webp', 65);
                            $file_name = public_path($img_path_array[0] . '.webp');
                            $db_file_name =$img_path_array[0] . '.webp';
                            $image->save($file_name);
                            DB::table('product_galary_images')->where('id',$img->id)->update([
                                'images_source' => $db_file_name
                            ]);
                            unlink(public_path($img->images_source));
                        }
                }
            }

            //change Products Images
            $products = Product::all();
            foreach($products as $pro)
            {
                if(file_exists(public_path($pro->thumbnail_image_source))){
                        $current_image_path = $pro->thumbnail_image_source;
                        $img_path_array = explode('.',$pro->thumbnail_image_source);
                        if(isset($img_path_array[0]) && isset($img_path_array[1]) && $img_path_array[1] != 'webp'){
                            $image =  Image::make(public_path($current_image_path))->encode('webp', 65);
                            $file_name = public_path($img_path_array[0] . '.webp');
                            $db_file_name =$img_path_array[0] . '.webp';
                            $image->save($file_name);
                            Product::where('id',$pro->id)->update([
                                'thumbnail_image_source' => $db_file_name
                            ]);
                            unlink(public_path($pro->thumbnail_image_source));
                        }
                }
            }

            //change Media Manager Images
            $medias = DB::table('media_managers')->get();
            foreach($medias as $media)
            {
                if(file_exists(public_path($media->file_name))){
                        $current_image_path = $media->file_name;
                        $img_path_array = explode('.',$media->file_name);
                        if(isset($img_path_array[0]) && isset($img_path_array[1]) && $img_path_array[1] != 'webp'){
                            $image =  Image::make(public_path($current_image_path))->encode('webp', 65);
                            $file_name = public_path($img_path_array[0] . '.webp');
                            $db_file_name =$img_path_array[0] . '.webp';
                            $image_name = explode('.',$media->orginal_name);
                            $db_name = isset($image_name[0]) ? $image_name[0].'.webp':$media->orginal_name;
                            $image->save($file_name);
                             DB::table('media_managers')->where('id',$media->id)->update([
                                 'file_name' => $db_file_name,
                                 'orginal_name' => $db_name
                             ]);
                            unlink(public_path($media->file_name));
                        }
                }
            }

            //category Images
            $categories = DB::table('category_images')->get();
            foreach($categories as $category)
            {
                if(file_exists(public_path($category->image))){
                    $current_image_path = $category->image;
                    $img_path_array = explode('.',$category->image);
                    if(isset($img_path_array[0]) && isset($img_path_array[1]) && $img_path_array[1] != 'webp'){
                        $image =  Image::make(public_path($current_image_path))->encode('webp', 65);
                        $file_name = public_path($img_path_array[0] . '.webp');
                        $db_file_name =$img_path_array[0] . '.webp';
                        $image->save($file_name);
                        DB::table('category_images')->where('id',$category->id)->update([
                            'image' => $db_file_name
                        ]);
                        unlink(public_path($category->image));
                    }
                }
            }


            //Slider Image
            $header_slider_panels = DB::table('header_slider_panels')->get();
            foreach($header_slider_panels as $panel)
            {
                if(file_exists(public_path($panel->slider_image))){
                    $current_image_path = $panel->slider_image;
                    $img_path_array = explode('.',$panel->slider_image);
                    if(isset($img_path_array[0]) && isset($img_path_array[1]) && $img_path_array[1] != 'webp'){
                        $image =  Image::make(public_path($current_image_path))->encode('webp', 65);
                        $file_name = public_path($img_path_array[0] . '.webp');
                        $db_file_name =$img_path_array[0] . '.webp';
                        $image->save($file_name);
                        DB::table('category_images')->where('id',$panel->id)->update([
                            'slider_image' => $db_file_name
                        ]);
                        unlink(public_path($panel->slider_image));
                    }
                }
            }



            $brands = DB::table('brands')->get();
            foreach($brands as $brand)
            {
                if(file_exists(public_path($brand->slider_image))){
                    $current_image_path = $brand->slider_image;
                    $img_path_array = explode('.',$brand->slider_image);
                    if(isset($img_path_array[0]) && isset($img_path_array[1]) && $img_path_array[1] != 'webp'){
                        $image =  Image::make(public_path($current_image_path))->encode('webp', 65);
                        $file_name = public_path($img_path_array[0] . '.webp');
                        $db_file_name =$img_path_array[0] . '.webp';
                        $image->save($file_name);
                        DB::table('category_images')->where('id',$brand->id)->update([
                            'slider_image' => $db_file_name
                        ]);
                        unlink(public_path($brand->slider_image));
                    }
                }
            }
    }
}
