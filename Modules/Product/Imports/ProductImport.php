<?php

namespace Modules\Product\Imports;

use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\ProductTag;
use Modules\Shipping\Entities\ProductShipping;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Product\Entities\CategoryProduct;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;
use App\Models\MediaManager;
use App\Traits\ImageStore;
use Modules\Product\Entities\ProductGalaryImage;
use File;
use Modules\Setup\Entities\Tag;

class ProductImport implements ToCollection, WithHeadingRow
{
    use ImageStore;

    public function collection(Collection $rows)
    {
        $host = activeFileStorage();
        foreach ($rows as $row) {
            $thumbnail_image = null;
            $galary_image = [];
            $media_ids = '';
         if(isset($row['media_ids'])){
            $imagies = explode(',', $row['media_ids']);
            $numItems = count($imagies);
            $i = 0;
            foreach ($imagies as $key => $img) {
                $media_img = MediaManager::find($img);
                if ($media_img) {
                    if($media_img->storage == 'local'){
                        if (File::exists(asset_path($media_img->file_name))) {
                            $file = asset_path($media_img->file_name);
                        }else{
                            $file = null;
                        }
                    }else{
                        $file = $media_img->file_name;
                    }
                    if ($file) {
                        if($key == 0){
                            $thumbnail_image = ImageStore::saveImage($file, 300, 300);
                        }
                        $galary_image[] = ImageStore::saveImage($file,1000,1000);

                        if(++$i === $numItems) {
                            $media_ids .= $media_img->id;
                        }else{
                            $media_ids .= $media_img->id.',';
                        }
                    }
                }
            }
          }
            if ($host == 'Dropbox') {
                $row['thumbnail_image_source'] = $thumbnail_image['images_source'];
                $row['file_dropbox'] = $thumbnail_image['file_dropbox'];
            }else{
                $row['thumbnail_image_source'] = $thumbnail_image;
            }
            if (auth()->user()->role->type != "seller") {  
                $is_approved = 1;
            }else{
                $is_approved = 0;
            }
            $row['is_approved'] = $is_approved;
            $row['media_ids'] = $media_ids;
            $product = new Product();
            $product->fill($row->toArray())->save();
            if (count($galary_image) > 0) {
                $media_ids = explode(',', $media_ids);
                foreach ($galary_image as $i => $image) {
                    $product_galary_image = new ProductGalaryImage;
                    $product_galary_image->product_id = $product->id;
                    if ($host == 'Dropbox') {
                        $product_galary_image->images_source = $image['images_source'];
                        $product_galary_image->file_dropbox = $image['file_dropbox'];
                    }else{
                        $product_galary_image->images_source = $image;
                    }
                    $product_galary_image->media_id = $media_ids[$i];
                    $product_galary_image->save();
                }
            }
            $tags = explode(',', $row['tags']);
            foreach ($tags as $key => $tag) {
                $tagsearch = Tag::where('id', 'LIKE', '%' . $tag . '%')->orWhere('name', 'LIKE', '%' . $tag . '%')->first();
                if ($tagsearch == null) {
                   $tagid = Tag::create([
                        'name' => $tag
                    ]);
                    $product_tag = new ProductTag;
                    $product_tag->product_id = $product->id;
                    $product_tag->tag_id = $tagid->id;
                    $product_tag->save();
                }else{
                    $product_tag = new ProductTag;
                    $product_tag->product_id = $product->id;
                    $product_tag->tag_id = $tagsearch->id;
                    $product_tag->save();
                }
            }
            $category_ids = explode(',', $row['category_id']);
            foreach ($category_ids as $key => $category_id) {
                $category_product = new CategoryProduct();
                $category_product->product_id = $product->id;
                $category_product->category_id = $category_id;
                $category_product->save();
            }
            ProductShipping::create([
                'shipping_method_id' => 2,
                'product_id' => $product->id
            ]);
            $product_sku = new ProductSku;
            $product_sku->product_id = $product->id;
            $product_sku->sku = $row['sku'];
            $product_sku->selling_price = $row['selling_price'];
            $product_sku->additional_shipping = $row['additional_shipping'];
            $product_sku->status = 1;
            $product_sku->save();
            if (auth()->user()->role->type != "seller") {       
                $sellerProduct = SellerProduct::create([
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'stock_manage' => 0,
                    'tax' => $product->tax,
                    'tax_type' => $product->tax_type,
                    'discount' => $product->discount,
                    'discount_type' => $product->discount_type,
                    'is_digital' => 0,
                    'user_id' => getParentSellerId(),
                    'slug' => strtolower(str_replace(' ', '-', $product->product_name)).'-'.rand(111,999) . '-' . 1,
                    'is_approved' => 1,
                    'status' => 1
                ]);
                SellerProductSKU::create([
                    'user_id' => 1,
                    'product_id' => $sellerProduct->id,
                    'product_sku_id' => $product_sku->id,
                    'selling_price' => $product_sku->selling_price,
                    'status' => 1
                ]);
            }
        }
    }
}
