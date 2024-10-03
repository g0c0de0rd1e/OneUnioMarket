<?php

namespace App\Http\Controllers\API;

use App\Services\FilterService;
use App\Http\Controllers\Controller;
use Modules\Product\Entities\Attribute;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Color;
use Modules\Product\Repositories\CategoryRepository;
use Modules\Product\Repositories\AttributeRepository;

class CategoryController extends Controller
{
    private $filterService;
    public function __construct(FilterService $filterService)
    {
        $this->filterService = $filterService;
    }
    public function index(){
        $categories = Category::with('categoryImage', 'parentCategory', 'subCategories')->where('status', 1)->where('parent_id',0)->paginate(10);

        return response()->json([
            'data' => $categories,
            'msg' => 'success'
        ],200);
    }

    public function productCat($categoryId)
    {
        $id = $categoryId;
        $category_id = Category::find($id)->id;
        $catRepo = new CategoryRepository(new Category);

        $category_ids = $catRepo->getAllSubSubCategoryID($category_id);
        $category_ids[] = $category_id;
        $attributeRepo = new AttributeRepository;

        $data['data'] = Category::find($id)->with(['subCategories','categoryImage','parentCategory'])->first();
        $data['attributes'] = Attribute::first();

        $data['color'] = $attributeRepo->getColorAttributeForSpecificCategory($category_id, $category_ids) ?? (object)[];
        $data['brands'] = (new Category)->brands;
        $data['lowest_price'] = $this->filterService->filterProductMinPrice();
        $data['height_price'] = $this->filterService->filterProductMaxPrice();
        return $data;
    }
}
