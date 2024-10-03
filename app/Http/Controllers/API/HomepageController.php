<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeaturedBrandResource;
use App\Http\Resources\FlashDealResource;
use App\Http\Resources\NewUserZoneResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\TopCategoryResource;
use App\Http\Resources\ToppicksResource;
use Illuminate\Http\Request;
use Modules\Appearance\Entities\HeaderSliderPanel;
use Modules\FrontendCMS\Entities\HomepageCustomCategory;
use Modules\FrontendCMS\Entities\HomePageSection;
use Modules\Marketing\Entities\FlashDeal;
use Modules\Marketing\Entities\NewUserZone;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;

class HomepageController extends Controller
{
    public function index(){

            $homepagesection = HomePageSection::where('section_name', 'feature_categories')->first();

            $categories = Category::with(['sellerProducts.product', 'sellerProducts.seller','categoryImage', 'parentCategory', 'subCategories'])->whereHas('sellerProducts');
            if ($homepagesection->type == 1) {
                $categories = $categories->orderByDesc('total_sale');
            }
            if ($homepagesection->type == 2) {
                $categories = $categories->latest();
            }
            if ($homepagesection->type == 3) {
                $categories = $categories->orderByDesc('total_sale');
            }
            if ($homepagesection->type == 4) {
                $categories = $categories->orderByDesc('avg_rating');
            }
            if ($homepagesection->type == 6) {
                $category_ids = HomepageCustomCategory::where('section_id', $homepagesection->id)->pluck('category_id')->toArray();
                $categories = $categories->whereRaw("id in ('". implode("','",$category_ids)."')");
            }
            $paginate = 12;
            if(app('theme')->folder_path == 'amazy'){
                $paginate = 8;
            }
            if ($homepagesection->type == 5) {
                $categories = $categories->withCount('sellerProducts')->orderByDesc('seller_products_count')->take(12)->get();
            }else {
                $categories = $categories->take($paginate)->get();
            }
        $top_categories = TopCategoryResource::collection($categories);
        $brands = Brand::where('status', 1)->where('featured', 1)->latest()->take(20)->get();
        $featured_brands = FeaturedBrandResource::collection($brands);
        $sliders = HeaderSliderPanel::where('status', 1)->where('data_type','!=','url')->orderBy('position')->get();
        $sliders = SliderResource::collection($sliders);
        $new_user_zone = NewUserZone::with('coupon.coupon')->where('status', 1)->first();
        if($new_user_zone){
            $new_user_zone = new NewUserZoneResource($new_user_zone);
        }else{
            $new_user_zone = null;
        }
        $flash_deal = FlashDeal::where('status', 1)->first();
        if($flash_deal){
            $flash_deal = new FlashDealResource($flash_deal);
        }else{
            $flash_deal = null;
        }
        $section = HomePageSection::where('section_name', 'top_picks')->first();

        if($section){
            $top_picks = ToppicksResource::collection($section->getApiProductByQuery());
        }else{
            $top_picks = [];
        }

        return response()->json([
            'top_categories' => $top_categories,
            'featured_brands' => $featured_brands,
            'sliders' => $sliders,
            'new_user_zone' => $new_user_zone,
            "flash_deal" => $flash_deal,
            "top_picks" => $top_picks,
            'msg' => 'success'
        ],200);
    }

    public function recomandedProduct()
    {
        $products = HomePageSection::where('section_name','more_products')->first()->getHomePageProductByQuery();
        return $products;
    }
    public function getTopCategoryData()
    {
        $homepagesection = HomePageSection::where('section_name', 'feature_categories')->first();
        $categories = Category::with(['sellerProducts.product', 'sellerProducts.seller','categoryImage', 'parentCategory', 'subCategories'])->whereHas('sellerProducts');
        if ($homepagesection->type == 1) {
            $categories = $categories->orderByDesc('total_sale');
        }
        if ($homepagesection->type == 2) {
            $categories = $categories->latest();
        }
        if ($homepagesection->type == 3) {
            $categories = $categories->orderByDesc('total_sale');
        }
        if ($homepagesection->type == 4) {
            $categories = $categories->orderByDesc('avg_rating');
        }
        if ($homepagesection->type == 6) {
            $category_ids = HomepageCustomCategory::where('section_id', $homepagesection->id)->pluck('category_id')->toArray();
            $categories = $categories->whereRaw("id in ('". implode("','",$category_ids)."')");
        }
        $paginate = 12;
        if(app('theme')->folder_path == 'amazy'){
            $paginate = 8;
        }
        if ($homepagesection->type == 5) {
            $categories = $categories->withCount('sellerProducts')->orderByDesc('seller_products_count')->take(12)->get();
        }else {
            $categories = $categories->take($paginate)->get();
        }
        $top_categories = TopCategoryResource::collection($categories);
        if(count($top_categories) > 0){
            return response()->json([
                'top_categories' => $top_categories,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'No data found',
            ],404);
        }
    }

    public function getFeaturedBrandData()
    {
        $brands = Brand::where('status', 1)->where('featured', 1)->latest()->take(20)->get();
        $featured_brands = FeaturedBrandResource::collection($brands);
        if(count($featured_brands) > 0){
            return response()->json([
                'featured_brands' => $featured_brands,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'No data found',
            ],404);
        }
    }
    public function getSliderData()
    {
        $sliders = HeaderSliderPanel::where('status', 1)->where('data_type','!=','url')->orderBy('position')->get();
        $sliders = SliderResource::collection($sliders);
        if(count($sliders) > 0){
            return response()->json([
                'sliders' => $sliders,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'No data found',
            ],404);
        }
    }

    public function getTopPickData()
    {
        $section = HomePageSection::where('section_name', 'top_picks')->first();
        if($section){
            $top_picks = ToppicksResource::collection($section->getApiProductByQuery());
        }else{
            $top_picks = [];
        }
        if(count($top_picks) > 0){
            return response()->json([
                'top_picks' => $top_picks,
                'message' => 'success'
            ],200);
        }else{
            return response()->json([
                'message' => 'No data found',
            ],404);
        }
    }
}
