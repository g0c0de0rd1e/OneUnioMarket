<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\FrontendCMS\Entities\DynamicPage;
use Modules\GiftCard\Entities\GiftCard;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\UnitType;
use Modules\Seller\Entities\SellerProduct;
use SebastianBergmann\LinesOfCode\Counter;

class DemoController extends Controller
{
    public function translate()
    {
        $categories = DB::table('categories')->get();
        foreach($categories as $category)
        {
            $name = $category->slug;
            $cat = Category::find($category->id);
            $cat->name = ucwords(str_replace('-',' ',$name));
            $cat->save();
        }


        $products = DB::table('products')->get();
        foreach($products as $product)
        {
            $name = $product->slug;
            $pro = Product::find($product->id);
            $pro->product_name = ucwords(str_replace('-',' ',$name));
            $pro->save();
        }

        $sellerProducts = DB::table('seller_products')->get();
        foreach($sellerProducts as $sp)
        {
            $name = $sp->slug;
            $sellerP = SellerProduct::find($sp->id);
            $sellerP->product_name = ucwords(str_replace('-',' ',$name));
            $sellerP->save();
        }

        $brands = DB::table('brands')->get();
        foreach($brands as $brand)
        {
            $name = $brand->slug;
            $br = Brand::find($brand->id);
            $br->name = ucwords(str_replace('-',' ',$name));
            $br->save();
        }



        $unit_types = DB::table('unit_types')->get();
        foreach($unit_types as $utypes)
        {
            $name = $utypes->name;
            str_replace('enenen','',preg_replace('/[^A-Za-z0-9\-]/', '', $name));
            $ut = UnitType::find($utypes->id);
            $ut->name = $name;
            $ut->save();
        }

        $attributes = DB::table('attributes')->get();
        foreach($attributes as $atr)
        {
            $name = $atr->name;
            str_replace('enenen','',preg_replace('/[^A-Za-z0-9\-]/', '', $name));
            $at = Attribute::find($atr->id);
            $at->name = $name;
            $at->save();
        }

        if(Schema::hasColumn('customer_addresses','is_updated'))
        {
            Schema::table('customer_addresses',function($table){
                $table->integer('is_updated')->default(0);
            });
        }



    }
}
