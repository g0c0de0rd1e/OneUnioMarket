<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FilterRepository;
use Modules\Product\Services\BrandService;
use Modules\Product\Transformers\BrandResource;
use Modules\Product\Repositories\AttributeRepository;

class BrandController extends Controller
{
    protected $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }
    public function products()
    {
        $brands = $this->brandService->getActiveAll();

        if (count($brands) > 0) {
            return BrandResource::collection($brands);
        } else {
            return response()->json([
                'message' => 'Brnad not found'
            ], 404);
        }
    }
    public function brandProducts($id)
    {
        $brand = $this->brandService->findById($id);
        $attributeRepo = new AttributeRepository;
        $attributes = $attributeRepo->getAttributeForSpecificBrand($id);
        $color = $attributeRepo->getColorAttributeForSpecificBrand($id);
        $filterRepo = new FilterRepository;
        $categories = $filterRepo->filterCategoryBrandWise($id);
        $products = $brand->sellerProductsAll()->pluck('id')->toArray();
        $lowest_price = $filterRepo->filterProductMinPrice($products);
        $height_price = $filterRepo->filterProductMaxPrice($products);
        if ($brand) {
            $brand = new BrandResource($brand);
            return response()->json([
                'data' => $brand,
                'attributes' => $attributes,
                'color' => $color,
                'categories' => $categories,
                'lowest_price' => $lowest_price,
                'height_price' => $height_price
            ]);
        } else {
            return response()->json([
                'message' => 'Brnad not found'
            ], 404);
        }
    }
}
