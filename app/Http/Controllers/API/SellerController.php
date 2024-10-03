<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellerResource;
use App\Repositories\SellerRepository;
use Modules\Seller\Services\ProductService;
use Modules\Seller\Transformers\ProductResource;

/**
 * @group Seller Profile
 *
 * APIs for customer Order
 */
class SellerController extends Controller
{
    protected $sellerRepository, $productService;
    public function __construct(SellerRepository $sellerRepository, ProductService $productService)
    {
        $this->sellerRepository = $sellerRepository;
        $this->productService = $productService;
    }

    public function topPicks()
    {
        $products = $this->productService->getTopPicks();
        return ProductResource::collection($products);
    }


    /**
     * Seller List
     * @response{
     *      "sellers": {
     *       "current_page": 3,
     *       "data": [
     *           {
     *               "id": 7,
     *               "first_name": "Amazcart Ltd",
     *               "last_name": null,
     *               "avatar": "uploads/images/12-08-2021/61151df87d722.jpeg",
     *               "phone": null,
     *               "date_of_birth": "01/01/1970",
     *               "seller_products": [
     *
     *                   product info ...
     *               ],
     *               "seller_reviews": [],
     *               "seller_account": {
     *                   seller account info ...
     *               },
     *               "seller_business_information": {
     *                   business account info ...
     *               }
     *           }
     *       ],
     *       "first_page_url": "http://ecommerce.test/api/seller-list?page=1",
     *       "from": 3,
     *       "last_page": 9,
     *       "last_page_url": "http://ecommerce.test/api/seller-list?page=9",
     *       "links": [
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=2",
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=1",
     *               "label": "1",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=2",
     *               "label": "2",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=3",
     *               "label": "3",
     *               "active": true
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=4",
     *               "label": "4",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=5",
     *               "label": "5",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=6",
     *               "label": "6",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=7",
     *               "label": "7",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=8",
     *               "label": "8",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=9",
     *               "label": "9",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller-list?page=4",
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "next_page_url": "http://ecommerce.test/api/seller-list?page=4",
     *       "path": "http://ecommerce.test/api/seller-list",
     *       "per_page": 1,
     *       "prev_page_url": "http://ecommerce.test/api/seller-list?page=2",
     *       "to": 3,
     *       "total": 9
     *   },
     *   "mesage": "success"
     * }
     */

    public function sellerList()
    {
        $sellers = $this->sellerRepository->GetSellerList();
        if (count($sellers) > 0) {
            return response()->json([
                'sellers' => $sellers,
                'mesage' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Empty list'
            ], 404);
        }
    }


    /**
     * Single Seller
     * @urlParam id integer required seller_id
     * @response{
     *      "seller": {
     *       "id": 7,
     *       "first_name": "Amazcart Ltd",
     *       "last_name": null,
     *       "avatar": "uploads/images/12-08-2021/61151df87d722.jpeg",
     *       "phone": null,
     *       "date_of_birth": "01/01/1970",
     *       "seller_products": [
     *           {
     *               "id": 1,
     *               "user_id": 7,
     *               "product_id": 2,
     *               "tax": 10,
     *               "tax_type": "0",
     *               "discount": 0,
     *               "discount_type": "1",
     *               "discount_start_date": null,
     *               "discount_end_date": null,
     *               "product_name": "Exclusive MI 5x",
     *               "slug": "exclusive-mi-5x-7",
     *               "thum_img": "uploads/images/09-08-2021/6110aca709597.jpeg",
     *               "status": 1,
     *               "stock_manage": 0,
     *               "is_approved": 0,
     *               "min_sell_price": 160,
     *               "max_sell_price": 190,
     *               "total_sale": 1,
     *               "avg_rating": 0,
     *               "recent_view": "2021-08-15 16:30:02",
     *               "created_at": "2021-08-09T04:18:47.000000Z",
     *               "updated_at": "2021-08-15T10:30:02.000000Z",
     *               "variantDetails": [
     *                   variant info...
     *               ],
     *               "MaxSellingPrice": 190,
     *               "hasDeal": {
     *                   "id": 1,
     *                   "flash_deal_id": 1,
     *                   "seller_product_id": 1,
     *                   "discount": 5,
     *                   "discount_type": 0,
     *                   "status": 1,
     *                   "created_at": "2021-08-11T06:59:06.000000Z",
     *                   "updated_at": "2021-08-11T06:59:06.000000Z"
     *               },
     *               "rating": 0,
     *               "product": {
     *                   product info...
     *               },
     *               "skus": [
     *                   sku list ...
     *               ],
     *               "reviews": []
     *           }
     *       ],
     *       "seller_reviews": [],
     *       "seller_account": {
     *           "id": 4,
     *           "user_id": 7,
     *           "seller_commission_id": 1,
     *           "commission_rate": 0,
     *           "seller_id": "BDEXCJ6590091",
     *           "banner": null,
     *           "subscription_type": "2",
     *           "seller_phone": "231656565896",
     *           "seller_shop_display_name": "Amazcart",
     *           "holiday_mode": 0,
     *           "holiday_type": null,
     *           "holiday_date": null,
     *           "holiday_date_start": null,
     *           "holiday_date_end": null,
     *           "is_trusted": 0,
     *           "total_sale_qty": 1,
     *           "created_at": "2021-08-08T04:34:08.000000Z",
     *           "updated_at": "2021-08-14T11:42:36.000000Z"
     *       },
     *       "seller_business_information": {
     *           "id": 3,
     *           "user_id": 7,
     *           "business_owner_name": null,
     *           "business_address1": null,
     *           "business_address2": null,
     *           "business_country": null,
     *           "business_state": null,
     *           "business_city": null,
     *           "business_postcode": null,
     *           "business_person_in_charge_name": null,
     *           "business_registration_number": null,
     *           "business_document": null,
     *           "business_seller_tin": null,
     *           "created_at": "2021-08-08T04:34:08.000000Z",
     *           "updated_at": "2021-08-08T04:34:08.000000Z",
     *           "claim_gst": 0,
     *           "country": null,
     *           "state": null,
     *           "city": null
     *       }
     *   },
     *   "categoryList": [
     *       related category list ...
     *   ],
     *   "brandList": [
     *       related brand list ....
     *   ],
     *   "lowestPrice": 160,
     *   "heightPrice": 600,
     *   "message": "success"
     * }
     */

    public function getSellerById($id)
    {
        $seller = $this->sellerRepository->getSellerByIDAPI($id);
        $categoryList = $this->sellerRepository->getCategoryList($id);
        $brandList = $this->sellerRepository->getBrandList($id);
        $lowestPrice = $this->sellerRepository->getProductLowestPrice($id);
        $heightPrice = $this->sellerRepository->getProductHighestPrice($id);
        if ($seller == 'seller not found') {
            return response()->json([
                'message' => 'Seller not found'
            ], 404);
        } elseif ($seller) {
            return response()->json([
                'seller' => new SellerResource($seller),
                'categoryList' => $categoryList,
                'brandList' => $brandList,
                'lowestPrice' => $lowestPrice,
                'heightPrice' => $heightPrice,
                'message' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }

    /**
     * Filter From Seller
     * @bodyParam  filterType string required "filterType" :[{"filterTypeId" : "brand","filterTypeValue" : [1]},{"filterTypeId" : "3","filterTypeValue" : [13]}
     * @bodyParam seller_id integer required seller id
     * @bodyParam paginate integer required 10
     * @bodyParam sort_by string required example: new, old
     * @response{
     *      "products": {
     *       "current_page": 1,
     *       "data": [
     *           {
     *               "id": 1,
     *               "user_id": 7,
     *               "product_id": 2,
     *               "tax": 10,
     *               "tax_type": "0",
     *               "discount": 0,
     *               "discount_type": "1",
     *               "discount_start_date": null,
     *               "discount_end_date": null,
     *               "product_name": "Exclusive MI 5x",
     *               "slug": "exclusive-mi-5x-7",
     *               "thum_img": "uploads/images/09-08-2021/6110aca709597.jpeg",
     *               "status": 1,
     *               "stock_manage": 0,
     *               "is_approved": 0,
     *               "min_sell_price": 160,
     *               "max_sell_price": 190,
     *               "total_sale": 1,
     *               "avg_rating": 0,
     *               "recent_view": "2021-08-15 16:30:02",
     *               "created_at": "2021-08-09T04:18:47.000000Z",
     *               "updated_at": "2021-08-15T10:30:02.000000Z",
     *               "variantDetails": [
     *                   {
     *                       "value": [
     *                           "4GB-32GB",
     *                           "4GB-64GB"
     *                       ],
     *                       "code": [
     *                           "4GB-32GB",
     *                           "4GB-64GB"
     *                       ],
     *                       "attr_val_id": [
     *                           14,
     *                           15
     *                       ],
     *                       "name": "Storage",
     *                       "attr_id": 3
     *                   },
     *                   {
     *                       "value": [
     *                           "Black",
     *                           "Red",
     *                           "Golden"
     *                       ],
     *                       "code": [
     *                           "black",
     *                           "red",
     *                           "#fce5cd"
     *                       ],
     *                       "attr_val_id": [
     *                           1,
     *                           2,
     *                           10
     *                       ],
     *                       "name": "Color",
     *                       "attr_id": 1
     *                   }
     *               ],
     *               "MaxSellingPrice": 190,
     *               "hasDeal": {
     *                   "id": 1,
     *                   "flash_deal_id": 1,
     *                   "seller_product_id": 1,
     *                   "discount": 5,
     *                   "discount_type": 0,
     *                   "status": 1,
     *                   "created_at": "2021-08-11T06:59:06.000000Z",
     *                   "updated_at": "2021-08-11T06:59:06.000000Z"
     *               },
     *               "rating": 0,
     *               "skus": [
     *                   skus list ...
     *               ],
     *               "product": {
     *                   product info ....
     *
     *               },
     *               "reviews": []
     *           }
     *       ],
     *       "first_page_url": "http://ecommerce.test/api/seller/filter-by-type?page=1",
     *       "from": 1,
     *       "last_page": 1,
     *       "last_page_url": "http://ecommerce.test/api/seller/filter-by-type?page=1",
     *       "links": [
     *           {
     *               "url": null,
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller/filter-by-type?page=1",
     *               "label": "1",
     *               "active": true
     *           },
     *           {
     *               "url": null,
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "next_page_url": null,
     *       "path": "http://ecommerce.test/api/seller/filter-by-type",
     *       "per_page": "10",
     *       "prev_page_url": null,
     *       "to": 1,
     *       "total": 1
     *   },
     *   "message": "success"
     * }
     */

    public function filterByType(Request $request)
    {

        $request->validate([
            'seller_id' => 'required'
        ]);

        $sort_by = 'old';
        $paginate = 1;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        $products = $this->sellerRepository->filterProductBlade($request->except("_token"), $sort_by, $paginate, $request->seller_id);

        return response()->json([
            'products' => $products,
            'message' => 'success'
        ], 200);
    }

    /**
     * Sort After Filter
     * * @bodyParam filterDataFromCat required "filterDataFromCat" : {
     *       "requestItemType" : "category",
     *       "requestItem" : "2",
     *       "filterType" : [{
     *           "filterTypeId" : "2",
     *           "filterTypeValue" : [6]
     *       }]
     *   },
     *   "paginate" : "16",
     *   "sort_by" : "new",
     *   "requestItemType" : "category",
     *   "requestItem" : "2"
     * @response{
     *      "products": {
     *      "current_page": 1,
     *      "data": [
     *           {
     *               "id": 1,
     *               "user_id": 7,
     *               "product_id": 2,
     *               "tax": 10,
     *               "tax_type": "0",
     *               "discount": 0,
     *               "discount_type": "1",
     *               "discount_start_date": null,
     *               "discount_end_date": null,
     *               "product_name": "Exclusive MI 5x",
     *               "slug": "exclusive-mi-5x-7",
     *               "thum_img": "uploads/images/09-08-2021/6110aca709597.jpeg",
     *               "status": 1,
     *               "stock_manage": 0,
     *               "is_approved": 0,
     *               "min_sell_price": 160,
     *               "max_sell_price": 190,
     *               "total_sale": 1,
     *               "avg_rating": 0,
     *               "recent_view": "2021-08-15 16:30:02",
     *               "created_at": "2021-08-09T04:18:47.000000Z",
     *               "updated_at": "2021-08-15T10:30:02.000000Z",
     *               "variantDetails": [
     *                   {
     *                       "value": [
     *                           "4GB-32GB",
     *                           "4GB-64GB"
     *                       ],
     *                       "code": [
     *                           "4GB-32GB",
     *                           "4GB-64GB"
     *                       ],
     *                       "attr_val_id": [
     *                           14,
     *                           15
     *                       ],
     *                       "name": "Storage",
     *                       "attr_id": 3
     *                   },
     *                   {
     *                       "value": [
     *                           "Black",
     *                           "Red",
     *                           "Golden"
     *                       ],
     *                       "code": [
     *                           "black",
     *                           "red",
     *                           "#fce5cd"
     *                       ],
     *                       "attr_val_id": [
     *                           1,
     *                           2,
     *                           10
     *                       ],
     *                       "name": "Color",
     *                       "attr_id": 1
     *                   }
     *               ],
     *               "MaxSellingPrice": 190,
     *               "hasDeal": {
     *                   "id": 1,
     *                   "flash_deal_id": 1,
     *                   "seller_product_id": 1,
     *                   "discount": 5,
     *                   "discount_type": 0,
     *                   "status": 1,
     *                   "created_at": "2021-08-11T06:59:06.000000Z",
     *                   "updated_at": "2021-08-11T06:59:06.000000Z"
     *               },
     *               "rating": 0,
     *               "skus": [
     *                   skus list ...
     *               ],
     *               "product": {
     *                   product info ....
     *
     *               },
     *               "reviews": []
     *           }
     *       ],
     *       "first_page_url": "http://ecommerce.test/api/seller/filter-by-type-after-sort?page=1",
     *       "from": null,
     *       "last_page": 1,
     *       "last_page_url": "http://ecommerce.test/api/seller/filter-by-type-after-sort?page=1",
     *       "links": [
     *           {
     *               "url": null,
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller/filter-by-type-after-sort?page=1",
     *               "label": "1",
     *               "active": true
     *           },
     *           {
     *               "url": null,
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "next_page_url": null,
     *       "path": "http://ecommerce.test/api/seller/filter-by-type-after-sort",
     *       "per_page": 6,
     *       "prev_page_url": null,
     *       "to": null,
     *       "total": 0
     *   },
     *   "message": "success"
     * }
     */

    public function filterAfterSort(Request $request)
    {
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        if ($request->filterDataFromSeller) {
            $products = $this->sellerRepository->filterSortProductBlade($request->except("_token"), $request->filterDataFromSeller, $request->seller_id);
        } else {
            $products = $this->sellerRepository->getProduct($request->seller_id, $sort_by, $paginate);
        }

        return response()->json([
            'products' => $products,
            'message' => 'success'
        ], 200);
    }

    public function productById($id)
    {
        $product = $this->productService->getSellerProductById($id);
        if ($product) {
            return new ProductResource($product);
        } else {
            return response([
                'message' => 'not found'
            ], 404);
        }
    }
}
