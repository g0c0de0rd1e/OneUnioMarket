<?php

namespace Modules\Seller\Http\Controllers\API;

use App\Services\FilterService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Seller\Services\ProductService;
use Modules\Seller\Transformers\ProductResource;

/**
* @group Product Management
*
* APIs for Product Management
*/
class ProductController extends Controller
{
    protected $productService;
    protected $filterService;

    public function __construct(ProductService $productService, FilterService $filterService)
    {
        $this->productService = $productService;
        $this->filterService = $filterService;
    }

    /**
     * Seller Products
     * @response{
     * "data": [
     *   {
     *       "id": 2,
     *       "user_id": 4,
     *       "product_id": 4,
     *       "tax": 5,
     *       "tax_type": "0",
     *       "discount": 5,
     *       "discount_type": "0",
     *       "discount_start_date": "05/25/2021",
     *       "discount_end_date": "06/30/2021",
     *       "product_name": "Xiaomi MI 5X",
     *       "slug": "xiaomi-mi-5x-4",
     *       "thum_img": null,
     *       "status": 1,
     *       "stock_manage": 0,
     *       "is_approved": 0,
     *       "min_sell_price": 200,
     *       "max_sell_price": 220,
     *       "total_sale": 3,
     *       "avg_rating": 4.03,
     *       "recent_view": "2021-06-08 10:06:56",
     *       "created_at": "2021-05-29T10:25:59.000000Z",
     *       "updated_at": "2021-06-08T04:06:56.000000Z",
     *       "variantDetails": [
     *           {
     *               "value": [
     *                   "4GB-32GB",
     *                   "4GB-64GB"
     *               ],
     *               "code": [
     *                   "4GB-32GB",
     *                   "4GB-64GB"
     *               ],
     *               "attr_val_id": [
     *                   13,
     *                   14
     *               ],
     *               "name": "Storage",
     *               "attr_id": 3
     *           }
     *       ],
     *       "MaxSellingPrice": 220,
     *       "hasDeal": {
     *           "id": 1,
     *           "flash_deal_id": 1,
     *           "seller_product_id": 2,
     *           "discount": 20,
     *           "discount_type": 0,
     *           "status": 1,
     *           "created_at": "2021-06-01T12:56:18.000000Z",
     *           "updated_at": "2021-06-02T10:36:20.000000Z"
     *       },
     *       "rating": 0,
     *       "product": {
     *           "id": 4,
     *           "product_name": "Xiaomi MI 5X",
     *           "product_type": 2,
     *           "unit_type_id": 1,
     *           "brand_id": 1,
     *           "category_id": 6,
     *           "thumbnail_image_source": "uploads/images/29-05-2021/60b1eed81a7fb.jpeg",
     *           "barcode_type": "C39",
     *           "model_number": "mi 5x",
     *           "shipping_type": 0,
     *           "shipping_cost": 0,
     *           "discount_type": "1",
     *           "discount": 0,
     *           "tax_type": "0",
     *           "tax": 5,
     *           "pdf": null,
     *           "video_provider": "youtube",
     *           "video_link": null,
     *           "description": "<p>test product</p>",
     *           "specification": "<p>test product</p>",
     *           "minimum_order_qty": 1,
     *           "max_order_qty": 5,
     *           "meta_title": null,
     *           "meta_description": null,
     *           "meta_image": null,
     *           "is_physical": 1,
     *           "is_approved": 1,
     *           "display_in_details": 1,
     *           "requested_by": 1,
     *           "created_by": 1,
     *           "slug": "xiaomi-mi-5x",
     *           "updated_by": null,
     *           "created_at": "2021-05-29T07:35:52.000000Z",
     *           "updated_at": "2021-05-29T07:35:52.000000Z",
     *           "brand": {
     *               "id": 1,
     *               "name": "Xiaomi",
     *               "logo": "uploads/images/29-05-2021/60b1d5f554a07.png",
     *               "description": null,
     *               "link": null,
     *               "status": 1,
     *               "featured": 1,
     *               "meta_title": null,
     *               "meta_description": null,
     *               "sort_id": null,
     *               "total_sale": 3,
     *               "avg_rating": 0,
     *               "slug": "xiaomi",
     *               "created_by": null,
     *               "updated_by": 5,
     *               "created_at": "2021-05-29T05:49:41.000000Z",
     *               "updated_at": "2021-06-07T13:18:43.000000Z",
     *
     *           },
     *           "category": {
     *               "id": 6,
     *               "name": "Mobile",
     *               "slug": "mobile",
     *               "parent_id": 3,
     *               "depth_level": 2,
     *               "icon": "fas fa-mobile-alt",
     *               "searchable": 1,
     *               "status": 1,
     *               "total_sale": 3,
     *               "avg_rating": 0,
     *               "commission_rate": 0,
     *               "created_at": "2021-05-29T07:27:11.000000Z",
     *               "updated_at": "2021-06-07T13:18:43.000000Z",
     *
     *           },
     *           "unit_type": {
     *               "id": 1,
     *               "name": "Pcs",
     *               "description": null,
     *               "status": 1,
     *               "created_by": null,
     *               "updated_by": null,
     *               "created_at": "2021-05-29T05:50:02.000000Z",
     *               "updated_at": "2021-05-29T05:50:02.000000Z"
     *           },
     *           "variations": [
     *               {
     *                   "id": 3,
     *                   "product_id": 4,
     *                   "product_sku_id": 5,
     *                   "attribute_id": 3,
     *                   "attribute_value_id": 13,
     *                   "created_by": null,
     *                   "updated_by": null,
     *                   "created_at": "2021-05-29T07:35:52.000000Z",
     *                   "updated_at": "2021-05-29T07:35:52.000000Z"
     *               }
     *           ],
     *           "skus": [
     *               {
     *                   "id": 5,
     *                   "product_id": 4,
     *                   "sku": "XM5-4GB-32GB-Black",
     *                   "purchase_price": 0,
     *                   "selling_price": 200,
     *                   "additional_shipping": 10,
     *                   "variant_image": "uploads/images/29-05-2021/60b1eed8672b3.jpeg",
     *                   "status": 1,
     *                   "created_at": "2021-05-29T07:35:52.000000Z",
     *                   "updated_at": "2021-05-29T07:35:52.000000Z"
     *               }
     *
     *           ],
     *           "tags": [
     *               {
     *                   "id": 6,
     *                   "product_id": 4,
     *                   "tag": "mi",
     *                   "created_at": "2021-05-29T07:35:52.000000Z",
     *                   "updated_at": "2021-05-29T07:35:52.000000Z"
     *               }
     *           ],
     *           "gallary_images": [
     *               {
     *                   "id": 7,
     *                   "product_id": 4,
     *                   "images_source": "uploads/images/29-05-2021/60b1eed829096.jpeg",
     *                   "created_at": "2021-05-29T07:35:52.000000Z",
     *                   "updated_at": "2021-05-29T07:35:52.000000Z"
     *               }
     *           ],
     *           "related_products": [],
     *           "up_sales": [],
     *           "cross_sales": [],
     *           "shipping_methods": [
     *               {
     *                   "id": 4,
     *                   "product_id": 4,
     *                   "shipping_method_id": 3,
     *                   "created_by": null,
     *                   "updated_by": null,
     *                   "created_at": "2021-05-29T07:35:52.000000Z",
     *                   "updated_at": "2021-05-29T07:35:52.000000Z"
     *               }
     *           ]
     *       },
     *       "seller": {
     *           "id": 4,
     *           "first_name": "Amazcart Ltd",
     *           "last_name": null,
     *           "username": "0156356563235",
     *           "photo": null,
     *           "role_id": 5,
     *           "mobile_verified_at": null,
     *           "email": "amazcart@gmail.com",
     *           "is_verified": 1,
     *           "verify_code": "74d68bde279426442de115eb532f9f51a21eb448",
     *           "email_verified_at": null,
     *           "notification_preference": "mail",
     *           "is_active": 1,
     *           "avatar": null,
     *           "phone": null,
     *           "date_of_birth": null,
     *           "description": null,
     *           "secret_login": 0,
     *           "secret_logged_in_by_user": null,
     *           "created_at": "2021-05-29T07:15:56.000000Z",
     *           "updated_at": "2021-05-29T07:15:56.000000Z"
     *       },
     *       "reviews": [
     *           {
     *               "id": 1,
     *               "customer_id": 5,
     *               "seller_id": 4,
     *               "product_id": 2,
     *               "order_id": 5,
     *               "package_id": 8,
     *               "review": "test product review",
     *               "rating": 4,
     *               "is_anonymous": 1,
     *               "status": 0,
     *               "created_at": "2021-06-08T12:31:32.000000Z",
     *               "updated_at": "2021-06-08T12:31:32.000000Z"
     *           }
     *       ],
     *       "skus": [
     *           {
     *               "id": 1,
     *               "user_id": 4,
     *               "product_id": 2,
     *               "product_sku_id": "5",
     *               "product_stock": 0,
     *               "purchase_price": 0,
     *               "selling_price": 200,
     *               "status": 1,
     *               "created_at": "2021-05-29T10:25:59.000000Z",
     *               "updated_at": "2021-05-29T10:25:59.000000Z",
     *               "product_variations": [
     *                   {
     *                       "id": 3,
     *                       "product_id": 4,
     *                       "product_sku_id": 5,
     *                       "attribute_id": 3,
     *                       "attribute_value_id": 13,
     *                       "created_by": null,
     *                       "updated_by": null,
     *                       "created_at": "2021-05-29T07:35:52.000000Z",
     *                       "updated_at": "2021-05-29T07:35:52.000000Z",
     *                       "attribute_value": {
     *                           "id": 13,
     *                           "value": "4GB-32GB",
     *                           "attribute_id": 3,
     *                           "created_at": "2021-05-29T07:31:25.000000Z",
     *                           "updated_at": null,
     *                           "color": null
     *                       },
     *                       "attribute": {
     *                           "id": 3,
     *                           "name": "Storage",
     *                           "display_type": "radio_button",
     *                           "description": null,
     *                           "status": 1,
     *                           "created_by": null,
     *                           "updated_by": null,
     *                           "created_at": "2021-05-29T07:31:25.000000Z",
     *                           "updated_at": "2021-05-29T07:31:25.000000Z"
     *                       }
     *                   }
     *               ]
     *           }
     *       ]
     *   }
     *   ],
     *   "links": {
     *       "first": "http://ecommerce.test/api/seller/products?page=1",
     *       "last": "http://ecommerce.test/api/seller/products?page=1",
     *       "prev": null,
     *       "next": null
     *   },
     *   "meta": {
     *       "current_page": 1,
     *       "from": 1,
     *       "last_page": 1,
     *       "links": [
     *           {
     *               "url": null,
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller/products?page=1",
     *               "label": "1",
     *               "active": true
     *           },
     *           {
     *               "url": null,
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "path": "http://ecommerce.test/api/seller/products",
     *       "per_page": 10,
     *       "to": 4,
     *       "total": 4
     *   }
     * }
     */

    public function index()
    {
        $products = $this->productService->getAllSellerProduct();
        return ProductResource::collection($products);
    }


    /**
     * Show single product
     * @response{
     * "data": {
     *   "id": 2,
     *   "user_id": 4,
     *   "product_id": 4,
     *   "tax": 5,
     *   "tax_type": "0",
     *   "discount": 5,
     *   "discount_type": "0",
     *   "discount_start_date": "05/25/2021",
     *   "discount_end_date": "06/30/2021",
     *   "product_name": "Xiaomi MI 5X",
     *   "slug": "xiaomi-mi-5x-4",
     *   "thum_img": null,
     *   "status": 1,
     *   "stock_manage": 0,
     *   "is_approved": 0,
     *   "min_sell_price": 200,
     *   "max_sell_price": 220,
     *   "total_sale": 3,
     *   "avg_rating": 4.03,
     *   "recent_view": "2021-06-08 10:06:56",
     *   "created_at": "2021-05-29T10:25:59.000000Z",
     *   "updated_at": "2021-06-08T04:06:56.000000Z",
     *   "variantDetails": [
     *       {
     *           "value": [
     *               "4GB-32GB",
     *               "4GB-64GB"
     *           ],
     *           "code": [
     *               "4GB-32GB",
     *               "4GB-64GB"
     *           ],
     *           "attr_val_id": [
     *               13,
     *               14
     *           ],
     *           "name": "Storage",
     *           "attr_id": 3
     *       }
     *   ],
     *   "MaxSellingPrice": 220,
     *   "hasDeal": {
     *       "id": 1,
     *       "flash_deal_id": 1,
     *       "seller_product_id": 2,
     *       "discount": 20,
     *       "discount_type": 0,
     *       "status": 1,
     *       "created_at": "2021-06-01T12:56:18.000000Z",
     *       "updated_at": "2021-06-02T10:36:20.000000Z"
     *   },
     *   "rating": 0,
     *   "product": {
     *       "id": 4,
     *       "product_name": "Xiaomi MI 5X",
     *       "product_type": 2,
     *       "unit_type_id": 1,
     *       "brand_id": 1,
     *       "category_id": 6,
     *       "thumbnail_image_source": "uploads/images/29-05-2021/60b1eed81a7fb.jpeg",
     *       "barcode_type": "C39",
     *       "model_number": "mi 5x",
     *       "shipping_type": 0,
     *       "shipping_cost": 0,
     *       "discount_type": "1",
     *       "discount": 0,
     *       "tax_type": "0",
     *       "tax": 5,
     *       "pdf": null,
     *       "video_provider": "youtube",
     *       "video_link": null,
     *       "description": "<p>test product</p>",
     *       "specification": "<p>test product</p>",
     *       "minimum_order_qty": 1,
     *       "max_order_qty": 5,
     *       "meta_title": null,
     *       "meta_description": null,
     *       "meta_image": null,
     *       "is_physical": 1,
     *       "is_approved": 1,
     *       "display_in_details": 1,
     *       "requested_by": 1,
     *       "created_by": 1,
     *       "slug": "xiaomi-mi-5x",
     *       "updated_by": null,
     *       "created_at": "2021-05-29T07:35:52.000000Z",
     *       "updated_at": "2021-05-29T07:35:52.000000Z",
     *       "brand": {
     *           "id": 1,
     *           "name": "Xiaomi",
     *           "logo": "uploads/images/29-05-2021/60b1d5f554a07.png",
     *           "description": null,
     *           "link": null,
     *           "status": 1,
     *           "featured": 1,
     *           "meta_title": null,
     *           "meta_description": null,
     *           "sort_id": null,
     *           "total_sale": 3,
     *           "avg_rating": 0,
     *           "slug": "xiaomi",
     *           "created_by": null,
     *           "updated_by": 5,
     *           "created_at": "2021-05-29T05:49:41.000000Z",
     *           "updated_at": "2021-06-07T13:18:43.000000Z",
     *
     *       },
     *       "category": {
     *           "id": 6,
     *           "name": "Mobile",
     *           "slug": "mobile",
     *           "parent_id": 3,
     *           "depth_level": 2,
     *           "icon": "fas fa-mobile-alt",
     *           "searchable": 1,
     *           "status": 1,
     *           "total_sale": 3,
     *           "avg_rating": 0,
     *           "commission_rate": 0,
     *           "created_at": "2021-05-29T07:27:11.000000Z",
     *           "updated_at": "2021-06-07T13:18:43.000000Z",
     *
     *       },
     *       "unit_type": {
     *           "id": 1,
     *           "name": "Pcs",
     *           "description": null,
     *           "status": 1,
     *           "created_by": null,
     *           "updated_by": null,
     *           "created_at": "2021-05-29T05:50:02.000000Z",
     *           "updated_at": "2021-05-29T05:50:02.000000Z"
     *       },
     *       "variations": [
     *           {
     *               "id": 3,
     *               "product_id": 4,
     *               "product_sku_id": 5,
     *               "attribute_id": 3,
     *               "attribute_value_id": 13,
     *               "created_by": null,
     *               "updated_by": null,
     *               "created_at": "2021-05-29T07:35:52.000000Z",
     *               "updated_at": "2021-05-29T07:35:52.000000Z"
     *           }
     *       ],
     *       "skus": [
     *           {
     *               "id": 5,
     *               "product_id": 4,
     *               "sku": "XM5-4GB-32GB-Black",
     *               "purchase_price": 0,
     *               "selling_price": 200,
     *               "additional_shipping": 10,
     *               "variant_image": "uploads/images/29-05-2021/60b1eed8672b3.jpeg",
     *               "status": 1,
     *               "created_at": "2021-05-29T07:35:52.000000Z",
     *               "updated_at": "2021-05-29T07:35:52.000000Z"
     *           }
     *       ],
     *       "tags": [
     *           {
     *               "id": 6,
     *               "product_id": 4,
     *               "tag": "mi",
     *               "created_at": "2021-05-29T07:35:52.000000Z",
     *               "updated_at": "2021-05-29T07:35:52.000000Z"
     *           }
     *       ],
     *       "gallary_images": [
     *           {
     *               "id": 7,
     *               "product_id": 4,
     *               "images_source": "uploads/images/29-05-2021/60b1eed829096.jpeg",
     *               "created_at": "2021-05-29T07:35:52.000000Z",
     *               "updated_at": "2021-05-29T07:35:52.000000Z"
     *           }
     *       ],
     *       "related_products": [],
     *       "up_sales": [],
     *       "cross_sales": [],
     *       "shipping_methods": [
     *           {
     *               "id": 4,
     *               "product_id": 4,
     *               "shipping_method_id": 3,
     *               "created_by": null,
     *               "updated_by": null,
     *               "created_at": "2021-05-29T07:35:52.000000Z",
     *               "updated_at": "2021-05-29T07:35:52.000000Z"
     *           }
     *       ]
     *   },
     *   "seller": {
     *       "id": 4,
     *       "first_name": "Amazcart Ltd",
     *       "last_name": null,
     *       "username": "0156356563235",
     *       "photo": null,
     *       "role_id": 5,
     *       "mobile_verified_at": null,
     *       "email": "amazcart@gmail.com",
     *       "is_verified": 1,
     *       "verify_code": "74d68bde279426442de115eb532f9f51a21eb448",
     *       "email_verified_at": null,
     *       "notification_preference": "mail",
     *       "is_active": 1,
     *       "avatar": null,
     *       "phone": null,
     *       "date_of_birth": null,
     *       "description": null,
     *       "secret_login": 0,
     *       "secret_logged_in_by_user": null,
     *       "created_at": "2021-05-29T07:15:56.000000Z",
     *       "updated_at": "2021-05-29T07:15:56.000000Z"
     *   },
     *   "reviews": [
     *       {
     *           "id": 1,
     *           "customer_id": 5,
     *           "seller_id": 4,
     *           "product_id": 2,
     *           "order_id": 5,
     *           "package_id": 8,
     *           "review": "test product review",
     *           "rating": 4,
     *           "is_anonymous": 1,
     *           "status": 0,
     *           "created_at": "2021-06-08T12:31:32.000000Z",
     *           "updated_at": "2021-06-08T12:31:32.000000Z"
     *       }
     *   ],
     *   "skus": [
     *       {
     *           "id": 1,
     *           "user_id": 4,
     *           "product_id": 2,
     *           "product_sku_id": "5",
     *           "product_stock": 0,
     *           "purchase_price": 0,
     *           "selling_price": 200,
     *           "status": 1,
     *           "created_at": "2021-05-29T10:25:59.000000Z",
     *           "updated_at": "2021-05-29T10:25:59.000000Z",
     *           "product_variations": [
     *               {
     *                   "id": 3,
     *                   "product_id": 4,
     *                   "product_sku_id": 5,
     *                   "attribute_id": 3,
     *                   "attribute_value_id": 13,
     *                   "created_by": null,
     *                   "updated_by": null,
     *                   "created_at": "2021-05-29T07:35:52.000000Z",
     *                   "updated_at": "2021-05-29T07:35:52.000000Z",
     *                   "attribute_value": {
     *                       "id": 13,
     *                       "value": "4GB-32GB",
     *                       "attribute_id": 3,
     *                       "created_at": "2021-05-29T07:31:25.000000Z",
     *                       "updated_at": null,
     *                       "color": null
     *                   },
     *                   "attribute": {
     *                       "id": 3,
     *                       "name": "Storage",
     *                       "display_type": "radio_button",
     *                       "description": null,
     *                       "status": 1,
     *                       "created_by": null,
     *                       "updated_by": null,
     *                       "created_at": "2021-05-29T07:31:25.000000Z",
     *                       "updated_at": "2021-05-29T07:31:25.000000Z"
     *                   }
     *               }
     *           ]
     *       }
     *   ]
     *}
     * }
     */

    public function show($id){
        $product = $this->productService->getSellerProductById($id);
        if($product){
            return new ProductResource($product);
        }else{
            return response([
                'message' => 'not found'
            ],404);
        }
    }

    /**
     * sku wise price
     * @response
     * "data": {
     *       "id": 5,
     *       "user_id": 4,
     *       "product_id": 2,
     *       "product_sku_id": "9",
     *       "product_stock": 0,
     *       "purchase_price": 0,
     *       "selling_price": 220,
     *       "status": 1,
     *       "created_at": "2021-05-29T10:25:59.000000Z",
     *       "updated_at": "2021-05-29T10:25:59.000000Z",
     *       "sku": {
     *           "id": 9,
     *           "product_id": 4,
     *           "sku": "XM5-4GB-64GB-Red",
     *           "purchase_price": 0,
     *           "selling_price": 220,
     *           "additional_shipping": 10,
     *           "variant_image": null,
     *           "status": 1,
     *           "created_at": "2021-05-29T07:35:52.000000Z",
     *           "updated_at": "2021-05-29T07:35:52.000000Z"
     *       },
     *       "product": {
     *
     *       }
     *   }
     *
     * @bodyParam  "id" :["14-3","6-1"] required
     *  @bodyParam   *"product_id" : "2" required
     *  @bodyParam   *"user_id" : "4" required

     * @return [string] message
    */

    public function getSKUWisePrice(Request $request){
        return $this->productService->get_seller_product_sku_wise_price($request->except('_token'));
    }

    /**
     * Recomanded product
     * @response{
     *      "data": [
     *           {
     *               "id": 2,
     *               "user_id": 6,
     *               "product_id": 3,
     *               "tax": 10,
     *               "tax_type": "0",
     *               "discount": 5,
     *               "discount_type": "0",
     *               "discount_start_date": "07/01/2021",
     *               "discount_end_date": "07/31/2021",
     *               "product_name": "Xiaomi Mi 5X",
     *               "slug": "xiaomi-mi-5x-6",
     *               "thum_img": null,
     *               "status": 1,
     *               "stock_manage": 0,
     *               "is_approved": 0,
     *               "min_sell_price": 190,
     *               "max_sell_price": 220,
     *               "total_sale": 1,
     *               "avg_rating": 0,
     *               "recent_view": "2021-07-11 11:44:45",
     *               "created_at": "2021-07-03T08:05:47.000000Z",
     *               "updated_at": "2021-07-11T05:47:34.000000Z",
     *               "variantDetails": [
     *
     *               ],
     *               "MaxSellingPrice": 220,
     *               "hasDeal": 0,
     *               "rating": 0,
     *               "product": {
     *                   "id": 3,
     *                   "product_name": "Xiaomi Mi 5X",
     *                   ...
     *                   "shipping_methods": [
     *
     *                   ],
     *                   "up_sales": [],
     *                   "cross_sales": [],
     *                   "related_products": [],
     *                   "gallary_images": [
     *
     *                   ],
     *                   "brand": {
     *
     *                   },
     *                   "category": {
     *
     *                   },
     *                   "unit_type": {
     *
     *                   },
     *                   "variations": [
     *
     *                   ],
     *                   "skus": [
     *
     *                   ],
     *                   "tags": [
     *
     *                   ]
     *               },
     *               "skus": [
     *
     *               ],
     *               "reviews": []
     *           },
     *       ],
     *       "links": {
     *           "first": "http://ecommerce.test/api/seller/product/recomanded-product?page=1",
     *           "last": "http://ecommerce.test/api/seller/product/recomanded-product?page=1",
     *           "prev": null,
     *           "next": null
     *       },
     *       "meta": {
     *           "current_page": 1,
     *           "from": 1,
     *           "last_page": 1,
     *           "links": [
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "http://ecommerce.test/api/seller/product/recomanded-product?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": null,
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           ],
     *           "path": "http://ecommerce.test/api/seller/product/recomanded-product",
     *           "per_page": 10,
     *           "to": 5,
     *           "total": 5
     *       }
     * }
     */
    public function recomandedProduct(){
        $products = $this->productService->getRecomandedProduct();
        if(count($products) > 0){
            return ProductResource::collection($products);
        }else{
            return response()->json([
                'message' => 'product not found'
            ], 404);
        }
    }

    /**
     * Top Picks
     * @response{
     *      *      "data": [
     *           {
     *               "id": 2,
     *               "user_id": 6,
     *               "product_id": 3,
     *               "tax": 10,
     *               "tax_type": "0",
     *               "discount": 5,
     *               "discount_type": "0",
     *               "discount_start_date": "07/01/2021",
     *               "discount_end_date": "07/31/2021",
     *               "product_name": "Xiaomi Mi 5X",
     *               "slug": "xiaomi-mi-5x-6",
     *               "thum_img": null,
     *               "status": 1,
     *               "stock_manage": 0,
     *               "is_approved": 0,
     *               "min_sell_price": 190,
     *               "max_sell_price": 220,
     *               "total_sale": 1,
     *               "avg_rating": 0,
     *               "recent_view": "2021-07-11 11:44:45",
     *               "created_at": "2021-07-03T08:05:47.000000Z",
     *               "updated_at": "2021-07-11T05:47:34.000000Z",
     *               "variantDetails": [
     *
     *               ],
     *               "MaxSellingPrice": 220,
     *               "hasDeal": 0,
     *               "rating": 0,
     *               "product": {
     *                   "id": 3,
     *                   "product_name": "Xiaomi Mi 5X",
     *                   ...
     *                   "shipping_methods": [
     *
     *                   ],
     *                   "up_sales": [],
     *                   "cross_sales": [],
     *                   "related_products": [],
     *                   "gallary_images": [
     *
     *                   ],
     *                   "brand": {
     *
     *                   },
     *                   "category": {
     *
     *                   },
     *                   "unit_type": {
     *
     *                   },
     *                   "variations": [
     *
     *                   ],
     *                   "skus": [
     *
     *                   ],
     *                   "tags": [
     *
     *                   ]
     *               },
     *               "skus": [
     *
     *               ],
     *               "reviews": []
     *           },
     *       ],
     *       "links": {
     *           "first": "http://ecommerce.test/api/seller/product/recomanded-product?page=1",
     *           "last": "http://ecommerce.test/api/seller/product/recomanded-product?page=1",
     *           "prev": null,
     *           "next": null
     *       },
     *       "meta": {
     *           "current_page": 1,
     *           "from": 1,
     *           "last_page": 1,
     *           "links": [
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "http://ecommerce.test/api/seller/product/recomanded-product?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": null,
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           ],
     *           "path": "http://ecommerce.test/api/seller/product/recomanded-product",
     *           "per_page": 10,
     *           "to": 5,
     *           "total": 5
     *       }
     * }
     */
    public function topPicks(){
        $products = $this->productService->getTopPicks();
        return ProductResource::collection($products);
    }

    /**
     * Sort Before Filter
     * @urlParam sort_by string required example: new, old
     * @urlParam paginate_by integer required example: 10
     * @urlParam requestItem integer required id from requested item example: 2
     * @urlParam requestItemType string required request item type example: category, brand, tag
     * @urlParam page integer page number example: 2
     *
     * @response{
     *  "data": [
     *
     *   ],
     *   "links": {
     *       "first": "http://ecommerce.test/api/seller/product/sort-before-filter?page=1",
     *       "last": "http://ecommerce.test/api/seller/product/sort-before-filter?page=1",
     *       "prev": null,
     *       "next": null
     *   },
     *   "meta": {
     *       "current_page": 1,
     *       "from": 1,
     *       "last_page": 1,
     *       "links": [
     *           {
     *               "url": null,
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller/product/sort-before-filter?page=1",
     *               "label": "1",
     *               "active": true
     *           },
     *           {
     *               "url": null,
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "path": "http://ecommerce.test/api/seller/product/sort-before-filter",
     *       "per_page": "10",
     *       "to": 1,
     *       "total": 1
     *   }
     * }
     */

    public function sortProductBeforeFilter(Request $request){
        $request->validate([
            'requestItem' => 'required',
            'requestItemType' => 'required'
        ]);
        $paginate_by = null;
        $sort_by = null;
        if($request->has('sort_by')){
            $sort_by = $request->sort_by;
        }
        if($request->has('paginate_by')){
            $paginate_by = $request->paginate_by;
        }


        $products = $this->filterService->productSortByCategory($request->requestItemType,$request->requestItem, $sort_by, $paginate_by);

        return ProductResource::collection($products);

    }


    /**
     * Filter Product from single Category, brand, etc
     * @response{
     * "data": [
     *       {
     *           "id": 2,
     *           "user_id": 4,
     *           "product_id": 4,
     *           "tax": 5,
     *           "tax_type": "0",
     *           "discount": 5,
     *           "discount_type": "0",
     *           "discount_start_date": "05/25/2021",
     *           "discount_end_date": "06/30/2021",
     *           "product_name": "Xiaomi MI 5X",
     *           "slug": "xiaomi-mi-5x-4",
     *           "thum_img": null,
     *           "status": 1,
     *           "stock_manage": 0,
     *           "is_approved": 0,
     *           "min_sell_price": 200,
     *           "max_sell_price": 220,
     *           "total_sale": 3,
     *           "avg_rating": 4.03,
     *           "recent_view": "2021-06-10 13:42:23",
     *           "created_at": "2021-05-29T10:25:59.000000Z",
     *           "updated_at": "2021-06-10T07:42:23.000000Z",
     *           "variantDetails": [
     *
     *           ],
     *           "MaxSellingPrice": 220,
     *           "hasDeal": {
     *
     *           },
     *           "rating": 0,
     *           "skus": [
     *
     *           ],
     *           "reviews": [
     *           ]
     *       }
     *   ],
     *   "links": {
     *       "first": "http://ecommerce.test/api/seller/product/filter/filter-product-by-type?page=1",
     *       "last": "http://ecommerce.test/api/seller/product/filter/filter-product-by-type?page=1",
     *       "prev": null,
     *       "next": null
     *   },
     *   "meta": {
     *       "current_page": 1,
     *       "from": 1,
     *       "last_page": 1,
     *       "links": [
     *           {
     *               "url": null,
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller/product/filter/filter-product-by-type?page=1",
     *               "label": "1",
     *               "active": true
     *           },
     *           {
     *               "url": null,
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "path": "http://ecommerce.test/api/seller/product/filter/filter-product-by-type",
     *       "per_page": "1",
     *       "to": 1,
     *       "total": 1
     *   }
     * }
     *
     *
     *
     * @bodyParam  filterType string required "filterType" :[{"filterTypeId" : "brand","filterTypeValue" : [1]},{"filterTypeId" : "3","filterTypeValue" : [13]}
     * @bodyParam requestItem number required category number
     * @bodyParam requestItemType string required category
     * @bodyParam paginate_by number required 10
     * @bodyParam sort_by string required new
     *

    * @return [string] message
     *
    */

    public function filterProductByType(Request $request){

        $paginate_by = null;
        $sort_by = null;
        if($request->has('sort_by')){
            $sort_by = $request->sort_by;
        }
        if($request->has('paginate_by')){
            $paginate_by = $request->paginate_by;
        }


        $products = $this->filterService->filterProductBlade($request->except("_token"), $sort_by, $paginate_by);

        return ProductResource::collection($products);
    }




    /**
     * sort after filter product
     * @bodyParam filterDataFromCat required "filterDataFromCat" : {
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
     *
     * @response{
     * "data": [
     *       {
     *           "id": 2,
     *           "user_id": 4,
     *           "product_id": 4,
     *           "tax": 5,
     *           "tax_type": "0",
     *           "discount": 5,
     *           "discount_type": "0",
     *           "discount_start_date": "05/25/2021",
     *           "discount_end_date": "06/30/2021",
     *           "product_name": "Xiaomi MI 5X",
     *           "slug": "xiaomi-mi-5x-4",
     *           "thum_img": null,
     *           "status": 1,
     *           "stock_manage": 0,
     *           "is_approved": 0,
     *           "min_sell_price": 200,
     *           "max_sell_price": 220,
     *           "total_sale": 3,
     *           "avg_rating": 4.03,
     *           "recent_view": "2021-06-10 13:42:23",
     *           "created_at": "2021-05-29T10:25:59.000000Z",
     *           "updated_at": "2021-06-10T07:42:23.000000Z",
     *           "variantDetails": [
     *               {
     *                   "value": [
     *                       "4GB-32GB",
     *                       "4GB-64GB"
     *                   ],
     *                   "code": [
     *                       "4GB-32GB",
     *                       "4GB-64GB"
     *                   ],
     *                   "attr_val_id": [
     *                       13,
     *                       14
     *                   ],
     *                   "name": "Storage",
     *                   "attr_id": 3
     *               },
     *               {
     *                   "value": [
     *                       "Black",
     *                       "Red",
     *                       "Gold"
     *                   ],
     *                   "code": [
     *                       "black",
     *                       "#f40c0c",
     *                       "#fff2cc"
     *                   ],
     *                   "attr_val_id": [
     *                       5,
     *                       6,
     *                       12
     *                   ],
     *                   "name": "Color",
     *                   "attr_id": 1
     *               }
     *           ],
     *           "MaxSellingPrice": 220,
     *           "hasDeal": {
     *               "id": 1,
     *               "flash_deal_id": 1,
     *               "seller_product_id": 2,
     *               "discount": 20,
     *               "discount_type": 0,
     *               "status": 1,
     *               "created_at": "2021-06-01T12:56:18.000000Z",
     *               "updated_at": "2021-06-02T10:36:20.000000Z"
     *           },
     *           "rating": 0,
     *           "skus": [
     *
     *           ],
     *           "reviews": [
     *           ]
     *       }
     *   ],
     *   "links": {
     *       "first": "http://ecommerce.test/api/seller/product/filter/filter-sort-product-by-type?page=1",
     *       "last": "http://ecommerce.test/api/seller/product/filter/filter-sort-product-by-type?page=1",
     *       "prev": null,
     *       "next": null
     *   },
     *   "meta": {
     *       "current_page": 1,
     *       "from": 1,
     *       "last_page": 1,
     *       "links": [
     *           {
     *               "url": null,
     *               "label": "&laquo; Previous",
     *               "active": false
     *           },
     *           {
     *               "url": "http://ecommerce.test/api/seller/product/filter/filter-sort-product-by-type?page=1",
     *               "label": "1",
     *               "active": true
     *           },
     *           {
     *               "url": null,
     *               "label": "Next &raquo;",
     *               "active": false
     *           }
     *       ],
     *       "path": "http://ecommerce.test/api/seller/product/filter/filter-sort-product-by-type",
     *       "per_page": "16",
     *       "to": 1,
     *       "total": 1
     *   }
     * }
     *
     * @bodyParam paginate number required "10"
     * @bodyParam sort_by string required "new"
     * @bodyParam requestItem number required "6"
     * @bodyParam requestItemType string required "category"
     *
     */

    public function filterSortProductByType (Request $request){
        if ($request->has('filterDataFromCat')) {
            $products = $this->filterService->filterSortProductBlade($request->except("_token"),$request->filterDataFromCat);
        }
        else {
            $products = $this->filterService->productSortByCategory($request->requestItemType,$request->requestItem, $request->sort_by, $request->paginate);
        }

        return ProductResource::collection($products);

    }

    /**
     * Filter product By Type than paginate
     * @bodyParam bodydata required "filterDataFromCat" : {
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
     *   "requestItem" : "2",
     *   "page" : "2"
     */


    public function fetchFilterPagenateDataByType(Request $request){

        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        $products = $this->filterService->filterProductAPI($request->filterDataFromCat, $sort_by, $paginate);

        return ProductResource::collection($products);
    }

    /**
     * Filter Product From Main Category Page
     */


    public function filterProductByTypeGlobal(Request $request){
        $products = $this->filterService->filterProductFromCategoryBlade($request->except("_token"), null, null);
        return ProductResource::collection($products);
    }

    /**
     * Fetch Product From Main Category Page
     */

    public function fetchDataGlobal(Request $request){
        $sort_by = null;
        $paginate = null;
        if ($request->has('sort_by')) {
            $sort_by = $request->sort_by;
        }
        if ($request->has('paginate')) {
            $paginate = $request->paginate;
        }
        $products = $this->filterService->getAllActiveProduct($sort_by, $paginate);

        return ProductResource::collection($products);
    }



}
