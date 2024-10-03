<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Modules\Product\Entities\Category;
use Modules\Product\Repositories\AttributeRepository;
use Modules\Product\Repositories\CategoryRepository;

class AuctionFrontController extends Controller
{
    protected $filterService;
    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
        $this->middleware('maintenance_mode');
    }
    public function showProductGallary()
    {
        $data['products'] = $this->filterService->getAllActiveProduct(null, null);
        $catRepo = new CategoryRepository(new Category());
        $data['CategoryList'] = $catRepo->activeCategory();
        $attributeRepo = new AttributeRepository;
        $data['attributeLists'] = $attributeRepo->getActiveAllWithoutColor()->where('status', 1);
        $data['color'] = $attributeRepo->getColorAttr();
        if (session()->has('filterDataFromCat')) {
            session()->forget('filterDataFromCat');
        }
        $product_min_price = $this->filterService->filterProductMinPrice();
        $product_max_price = $this->filterService->filterProductMaxPrice();
        $product_min_price = $this->filterService->getConvertedMin($product_min_price);
        $product_max_price = $this->filterService->getConvertedMax($product_max_price);
        $data['min_price_lowest'] = $product_min_price;
        $data['max_price_highest'] = $product_max_price;
        return view(theme('pages.auction_product_gallary'), $data);
    }
}
