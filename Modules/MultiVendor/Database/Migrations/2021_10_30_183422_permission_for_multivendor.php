<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Permission;

class PermissionForMultivendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('permissions')){

            $exsist = DB::table('permissions')->where('id', 578)->first();
            if(!$exsist){
                $mywallets = Permission::where('module_id', 25)->pluck('id')->toArray();
                Permission::destroy($mywallets);
                $sql = [

                    // Dashboard
                    ['id' => 578, 'module_id' => 1, 'parent_id' => 2, 'module' => 'MultiVendor', 'name' => 'Total Seller', 'route' => 'widget_total_seller', 'type' => 3 ],
                    ['id' => 592, 'module_id' => 1, 'parent_id' => 589, 'module' => 'MultiVendor', 'name' => 'Sellers', 'route' => 'dashboard_graph_sellers', 'type' => 3 ],
                    ['id' => 597, 'module_id' => 1, 'parent_id' => 1, 'module' => 'MultiVendor', 'name' => 'Top Ten Seller', 'route' => 'dashboard_top_ten_seller', 'type' => 2 ],

                    // seller dashboard
                    ['id' => 608, 'module_id' => 37, 'parent_id' => null,'module' => 'MultiVendor', 'name' => 'Seller Dashboard', 'route' => 'seller.dashboard', 'type' => 1 ],
                    ['id' => 609, 'module_id' => 37, 'parent_id' => 608, 'module' => 'MultiVendor', 'name' => 'Widgets', 'route' => 'seller_widgets', 'type' => 2 ],
                    ['id' => 610, 'module_id' => 37, 'parent_id' => 609, 'module' => 'MultiVendor', 'name' => 'Total Product', 'route' => 'seller_widgets_total_product', 'type' => 3 ],
                    ['id' => 611, 'module_id' => 37, 'parent_id' => 609, 'module' => 'MultiVendor', 'name' => 'Total Order', 'route' => 'seller_widgets_total_order', 'type' => 3 ],
                    ['id' => 612, 'module_id' => 37, 'parent_id' => 609, 'module' => 'MultiVendor', 'name' => 'Total delivery Order', 'route' => 'seller_widgets_total_delivery_order', 'type' => 3 ],
                    ['id' => 622, 'module_id' => 37, 'parent_id' => 609, 'module' => 'MultiVendor', 'name' => 'Total Non-delivery Order', 'route' => 'seller_widgets_non_total_delivery_order', 'type' => 3 ],
                    ['id' => 623, 'module_id' => 37, 'parent_id' => 609, 'module' => 'MultiVendor', 'name' => 'Total Sale', 'route' => 'seller_widgets_total_sale', 'type' => 3 ],
                    ['id' => 613, 'module_id' => 37, 'parent_id' => 609, 'module' => 'MultiVendor', 'name' => 'Shop Review', 'route' => 'seller_widgets_shop_review', 'type' => 3 ],
                    ['id' => 614, 'module_id' => 37, 'parent_id' => 609, 'module' => 'MultiVendor', 'name' => 'Total Product Refund', 'route' => 'seller_widgets_total_product_refund', 'type' => 3 ],

                    ['id' => 615, 'module_id' => 37, 'parent_id' => 608, 'module' => 'MultiVendor', 'name' => 'Graphs', 'route' => 'seller_graphs', 'type' => 2 ],
                    ['id' => 616, 'module_id' => 37, 'parent_id' => 615, 'module' => 'MultiVendor', 'name' => 'Total Order Summary', 'route' => 'seller_graphs_total_order_summary', 'type' => 3 ],
                    ['id' => 617, 'module_id' => 37, 'parent_id' => 615, 'module' => 'MultiVendor', 'name' => 'Total Sale Summary', 'route' => 'seller_graphs_total_sale_summary', 'type' => 3 ],
                    ['id' => 618, 'module_id' => 37, 'parent_id' => 615, 'module' => 'MultiVendor', 'name' => 'Sales Vs Refund', 'route' => 'seller_graphs_sales_vs_refund', 'type' => 3 ],

                    ['id' => 625, 'module_id' => 37, 'parent_id' => 608, 'module' => 'MultiVendor', 'name' => 'Top Sale Products', 'route' => 'seller_top_sale_products', 'type' => 2 ],
                    ['id' => 619, 'module_id' => 37, 'parent_id' => 608, 'module' => 'MultiVendor', 'name' => 'Latest Uploaded Products', 'route' => 'seller_latest_uploaded_products', 'type' => 2 ],
                    ['id' => 620, 'module_id' => 37, 'parent_id' => 608, 'module' => 'MultiVendor', 'name' => 'Latest Orders', 'route' => 'seller_latest_orders', 'type' => 2 ],
                    ['id' => 621, 'module_id' => 37, 'parent_id' => 608, 'module' => 'MultiVendor', 'name' => 'Latest Refund Request', 'route' => 'seller_latest_refund_request', 'type' => 2 ],
                    ['id' => 624, 'module_id' => 37, 'parent_id' => 608, 'module' => 'MultiVendor', 'name' => 'Subscription Payment', 'route' => 'seller_subscription_payments', 'type' => 2 ],

                    // Manage Seller
                    ['id' => 101, 'module_id' => 7, 'parent_id' => null, 'module' => 'MultiVendor', 'name' => 'Manage Seller', 'route' => 'manage_seller', 'type' => 1 ],
                    ['id' => 102, 'module_id' => 7, 'parent_id' => 101, 'module' => 'MultiVendor', 'name' => 'Seller List', 'route' => 'admin.merchants_list', 'type' => 2 ],
                    ['id' => 103, 'module_id' => 7, 'parent_id' => 102, 'module' => 'MultiVendor', 'name' => 'Create', 'route' => 'admin.merchants_create', 'type' => 3 ],
                    ['id' => 104, 'module_id' => 7, 'parent_id' => 102, 'module' => 'MultiVendor', 'name' => 'Details', 'route' => 'admin.merchant_show_details', 'type' => 3 ],
                    ['id' => 105, 'module_id' => 7, 'parent_id' => 102, 'module' => 'MultiVendor', 'name' => 'Secret Login', 'route' => 'admin.secret_login', 'type' => 3 ],
                    ['id' => 106, 'module_id' => 7, 'parent_id' => 102, 'module' => 'MultiVendor', 'name' => 'Trusted Status', 'route' => 'admin.change_merchant_trusted_status', 'type' => 3 ],
                    ['id' => 107, 'module_id' => 7, 'parent_id' => 102, 'module' => 'MultiVendor', 'name' => 'Update', 'route' => 'admin.merchant_edit_profile', 'type' => 3 ],
                    ['id' => 109, 'module_id' => 7, 'parent_id' => 102, 'module' => 'MultiVendor', 'name' => 'GST Claim', 'route' => 'gst_claim_status', 'type' => 3 ],
                    
                    ['id' => 35, 'module_id' => 7, 'parent_id' => 101, 'module' => 'MultiVendor', 'name' => 'Pricing', 'route' => 'admin.pricing.index', 'type' => 2 ],
                    ['id' => 36, 'module_id' => 7, 'parent_id' => 35, 'module' => 'MultiVendor', 'name' => 'Create', 'route' => 'admin.pricing.store', 'type' => 3 ],
                    ['id' => 37, 'module_id' => 7, 'parent_id' => 35, 'module' => 'MultiVendor', 'name' => 'Update', 'route' => 'admin.pricing.update', 'type' => 3 ],
                    ['id' => 38, 'module_id' => 7, 'parent_id' => 35, 'module' => 'MultiVendor', 'name' => 'Destroy', 'route' => 'admin.pricing.delete', 'type' => 3 ],
                    ['id' => 39, 'module_id' => 7, 'parent_id' => 35, 'module' => 'MultiVendor', 'name' => 'Status Change', 'route' => 'admin.pricing.status', 'type' => 3 ],

                    ['id' => 110, 'module_id' => 7, 'parent_id' => 101, 'module' => 'MultiVendor', 'name' => 'Commission Setup', 'route' => 'admin.seller_commission_index', 'type' => 2 ],
                    ['id' => 111, 'module_id' => 7, 'parent_id' => 110, 'module' => 'MultiVendor', 'name' => 'Commission Rate Edit', 'route' => 'admin.seller_commission_edit', 'type' => 3 ],
                    ['id' => 108, 'module_id' => 7, 'parent_id' => 110, 'module' => 'MultiVendor', 'name' => 'Commission Update', 'route' => 'admin.seller_commission_update', 'type' => 3 ],
                    ['id' => 638, 'module_id' => 7, 'parent_id' => 101, 'module' => 'MultiVendor', 'name' => 'Manage Seller Configuration', 'route' => 'admin.seller_configuration', 'type' => 2 ],
                    ['id' => 639, 'module_id' => 7, 'parent_id' => 638, 'module' => 'MultiVendor', 'name' => 'Update', 'route' => 'admin.seller_configuration_update', 'type' => 3 ],

                    ['id' => 640, 'module_id' => 7, 'parent_id' => 101, 'module' => 'MultiVendor', 'name' => 'Subscription Payments', 'route' => 'admin.subscription_payment_list', 'type' => 2 ],
                    ['id' => 641, 'module_id' => 7, 'parent_id' => 640, 'module' => 'MultiVendor', 'name' => 'Approve', 'route' => 'admin.subscription_payment_approve', 'type' => 3 ],


                    // Seller Order Manage
                    ['id' => 153, 'module_id' => 11, 'parent_id' => null, 'module' => 'MultiVendor', 'name' => 'Seller Order Manage', 'route' => 'seller_order_manage', 'type' => 1 ],
                    ['id' => 154, 'module_id' => 11, 'parent_id' => 153, 'module' => 'MultiVendor', 'name' => 'My Order', 'route' => 'order_manage.my_sales_index', 'type' => 2 ],
                    ['id' => 155, 'module_id' => 11, 'parent_id' => 153, 'module' => 'MultiVendor', 'name' => 'Complete Order', 'route' => 'complete_orders', 'type' => 2 ],
                    ['id' => 156, 'module_id' => 11, 'parent_id' => 153, 'module' => 'MultiVendor', 'name' => 'Confirmed Order', 'route' => 'confirmed_orders', 'type' => 2 ],
                    ['id' => 157, 'module_id' => 11, 'parent_id' => 153, 'module' => 'MultiVendor', 'name' => 'Pending Order', 'route' => 'pending_orders', 'type' => 2 ],
                    ['id' => 158, 'module_id' => 11, 'parent_id' => 153, 'module' => 'MultiVendor', 'name' => 'Cancelled Order', 'route' => 'cancelled_orders', 'type' => 2 ],
                    ['id' => 159, 'module_id' => 11, 'parent_id' => 153, 'module' => 'MultiVendor', 'name' => 'Order Detail view', 'route' => 'order_manage.show_details_mine', 'type' => 2 ],
                    ['id' => 160, 'module_id' => 11, 'parent_id' => 153, 'module' => 'MultiVendor', 'name' => 'Delivery Status Update', 'route' => 'order_manage.update_delivery_status', 'type' => 2 ],
                    ['id' => 161, 'module_id' => 11, 'parent_id' => 153, 'module' => 'MultiVendor', 'name' => 'Order Invoice Print', 'route' => 'order_manage.print_order_details', 'type' => 2 ],

                    //  Seller Staff
                    ['id' => 162, 'module_id' => 12, 'parent_id' => null, 'module' => 'MultiVendor', 'name' => 'Seller Staff Manage', 'route' => 'seller_staff_manage', 'type' => 1 ],
                    ['id' => 163, 'module_id' => 12, 'parent_id' => 162, 'module' => 'MultiVendor', 'name' => 'Staff List', 'route' => 'seller.sub_seller.index', 'type' => 2 ],
                    ['id' => 164, 'module_id' => 12, 'parent_id' => 162, 'module' => 'MultiVendor', 'name' => 'Create staff', 'route' => 'seller.sub_seller.create', 'type' => 2 ],
                    ['id' => 165, 'module_id' => 12, 'parent_id' => 162, 'module' => 'MultiVendor', 'name' => 'Edit Staff', 'route' => 'seller.sub_seller.edit', 'type' => 2 ],
                    ['id' => 166, 'module_id' => 12, 'parent_id' => 162, 'module' => 'MultiVendor', 'name' => 'Delete Staff', 'route' => 'seller.sub_seller.delete', 'type' => 2 ],
                    ['id' => 167, 'module_id' => 12, 'parent_id' => 162, 'module' => 'MultiVendor', 'name' => 'Permission Access Provide', 'route' => 'seller.sub_seller.access_permission', 'type' => 2 ],

                    // subscription payment
                    ['id' => 515, 'module_id' => 29, 'parent_id' => null, 'module' => 'MultiVendor', 'name' => 'Subscription Payment', 'route' => 'seller.my_subscription_payment_list', 'type' => 1 ],

                    // admin reports
                    ['id' => 517, 'module_id' => 34, 'parent_id' => 516,'module' => 'MultiVendor', 'name' => 'Seller Wise report', 'route' => 'report.seller_wise_sales', 'type' => 2],
                    ['id' => 524, 'module_id' => 34, 'parent_id' => 516,'module' => 'MultiVendor', 'name' => 'Top Sellers', 'route' => 'report.top_seller', 'type' => 2],
                
                    // seller reports
                    ['id' => 531, 'module_id' => 35, 'parent_id' => null, 'module' => 'MultiVendor', 'name' => 'Seller Report', 'route' => 'seller_report', 'type' => 1],
                    ['id' => 532, 'module_id' => 35, 'parent_id' => 531, 'module' => 'MultiVendor', 'name' => 'Products', 'route' => 'seller_report.product', 'type' => 2],
                    ['id' => 533, 'module_id' => 35, 'parent_id' => 531, 'module' => 'MultiVendor', 'name' => 'Top Customers', 'route' => 'seller_report.top_customer', 'type' => 2],
                    ['id' => 534, 'module_id' => 35, 'parent_id' => 531, 'module' => 'MultiVendor', 'name' => 'Top Selling Items', 'route' => 'seller_report.top_selling_item', 'type' => 2],
                    ['id' => 535, 'module_id' => 35, 'parent_id' => 531, 'module' => 'MultiVendor', 'name' => 'Orders', 'route' => 'seller_report.order', 'type' => 2],
                    ['id' => 536, 'module_id' => 35, 'parent_id' => 531, 'module' => 'MultiVendor', 'name' => 'Seller Reviews', 'route' => 'seller_report.review', 'type' => 2],

                    // FrontendCMS
                    ['id' => 33, 'module_id' => 3, 'parent_id' => 26, 'module' => 'MultiVendor', 'name' => 'Merchant Content', 'route' => 'frontendcms.merchant-content.index', 'type' => 2 ],
                    ['id' => 34, 'module_id' => 3, 'parent_id' => 33, 'module' => 'MultiVendor', 'name' => 'Content Update', 'route' => 'frontendcms.merchant-content.update', 'type' => 3 ],

                    // Product Module
                    ['id' => 204, 'module_id' => 14, 'parent_id' => 198, 'module' => 'MultiVendor', 'name' => 'Seller Request Product', 'route' => 'product.request-get-data', 'type' => 3 ],
                    ['id' => 208, 'module_id' => 14, 'parent_id' => 198, 'module' => 'MultiVendor', 'name' => 'Seller Product Approval', 'route' => 'product.request.approved', 'type' => 3 ],
                    ['id' => 213, 'module_id' => 14, 'parent_id' => 175, 'module' => 'MultiVendor', 'name' => 'Inhouse Product', 'route' => 'admin.my-product.index', 'type' => 2 ],
                    ['id' => 214, 'module_id' => 14, 'parent_id' => 213, 'module' => 'MultiVendor', 'name' => 'Create', 'route' => 'admin.my-product.create', 'type' => 3 ],
                    ['id' => 215, 'module_id' => 14, 'parent_id' => 213, 'module' => 'MultiVendor', 'name' => 'Update Product', 'route' => 'admin.my-product.edit', 'type' => 3 ],
                    ['id' => 216, 'module_id' => 14, 'parent_id' => 213, 'module' => 'MultiVendor', 'name' => 'Alert List', 'route' => 'seller_alert_product', 'type' => 3 ],
                    ['id' => 217, 'module_id' => 14, 'parent_id' => 213, 'module' => 'MultiVendor', 'name' => 'Out of Stock List', 'route' => 'seller_out_of_stock_product', 'type' => 3 ],
                    ['id' => 218, 'module_id' => 14, 'parent_id' => 213, 'module' => 'MultiVendor', 'name' => 'Disable Product List', 'route' => 'seller_disabled_product', 'type' => 3 ],
                    ['id' => 279, 'module_id' => 14, 'parent_id' => 213, 'module' => 'MultiVendor', 'name' => 'Product List', 'route' => 'seller.product.index', 'type' => 3 ],

                    // Seller Product
                    ['id' => 16, 'module_id' => 2, 'parent_id' => null, 'module' => 'MultiVendor', 'name' => 'Seller Product Manage', 'route' => 'seller_product_module', 'type' => 1 ],
                    ['id' => 17, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Product List', 'route' => 'seller.product.index', 'type' => 2 ],
                    ['id' => 18, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Own Product List', 'route' => 'seller_own_product', 'type' => 2 ],
                    ['id' => 19, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Alert List', 'route' => 'seller_alert_product', 'type' => 2 ],
                    ['id' => 20, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Out of Stock List', 'route' => 'seller_out_of_stock_product', 'type' => 2 ],
                    ['id' => 21, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Disable Product List', 'route' => 'seller_disabled_product', 'type' => 2 ],
                    ['id' => 22, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Product Create', 'route' => 'seller.product.create', 'type' => 2 ],
                    ['id' => 23, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Product Edit', 'route' => 'seller.product.edit', 'type' => 2 ],
                    ['id' => 24, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Product info Show', 'route' => 'product_info_show', 'type' => 2 ],
                    ['id' => 25, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Product Delete', 'route' => 'product_destroy', 'type' => 2 ],
                    ['id' => 493, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Self Product Edit', 'route' => 'product.edit', 'type' => 2 ],
                    ['id' => 494, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Self Product Clone', 'route' => 'product.clone', 'type' => 2 ],
                    ['id' => 495, 'module_id' => 2, 'parent_id' => 16, 'module' => 'MultiVendor', 'name' => 'Self Product Delete', 'route' => 'product.destroy', 'type' => 2 ],

                    // Order Manage
                    

                    //refund manage
                    ['id' => 317, 'module_id' => 17, 'parent_id' => 312, 'module' => 'MultiVendor', 'name' => 'My Refund List', 'route' => 'refund.my_refund_list', 'type' => 2 ],

                    //support ticket
                    ['id' => 514, 'module_id' => 31, 'parent_id' => 407, 'module' => 'MultiVendor', 'name' => 'My Tickets', 'route' => 'seller.support-ticket.index', 'type' => 2 ],

                    // Manage Wallet
                    ['id' => 117, 'module_id' => 8, 'parent_id' => 112, 'module' => 'MultiVendor', 'name' => 'Withdraw Request', 'route' => 'wallet.withdraw_requests.get_data', 'type' => 2 ],
                    ['id' => 118, 'module_id' => 8, 'parent_id' => 117, 'module' => 'MultiVendor', 'name' => 'Show Details', 'route' => 'wallet.withdraw_requests.show', 'type' => 3 ],
                    ['id' => 119, 'module_id' => 8, 'parent_id' => 117, 'module' => 'MultiVendor', 'name' => 'Approval', 'route' => 'wallet.withdraw_request_status_update', 'type' => 3 ],

                    //my wallet
                    ['id' => 497, 'module_id' => 25, 'parent_id' => null, 'module' => 'MultiVendor', 'name' => 'My Wallet', 'route' => 'my_wallet', 'type' => 1 ],
                    ['id' => 569, 'module_id' => 25, 'parent_id' => 497, 'module' => 'MultiVendor', 'name' => 'Transections', 'route' => 'my-wallet.index', 'type' => 2 ],
                    ['id' => 570, 'module_id' => 25, 'parent_id' => 569, 'module' => 'MultiVendor', 'name' => 'Recharge', 'route' => 'my-wallet.store', 'type' => 3 ],
                    ['id' => 571, 'module_id' => 25, 'parent_id' => 497, 'module' => 'MultiVendor', 'name' => 'Withdraw', 'route' => 'my-wallet.withdraw_index', 'type' => 2 ],
                    ['id' => 572, 'module_id' => 25, 'parent_id' => 571, 'module' => 'MultiVendor', 'name' => 'Send Request', 'route' => 'my-wallet.withdraw_request_sent', 'type' => 3 ],
                    ['id' => 573, 'module_id' => 25, 'parent_id' => 571, 'module' => 'MultiVendor', 'name' => 'Update Send Request', 'route' => 'my-wallet.withdraw_request_update', 'type' => 3 ],

                    //reviews
                    ['id' => 482, 'module_id' => 15, 'parent_id' => 281, 'name' => 'Seller Reviews','module' => 'MultiVendor', 'route' => 'review.seller.index', 'type' => 2 ],
                    ['id' => 498, 'module_id' => 15, 'parent_id' => 281, 'name' => 'My Reviews', 'module' => 'MultiVendor', 'route' => 'seller.my-reviews.index', 'type' => 2 ],

                    ['id' => 537, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Seller Reviews','module' => 'MultiVendor', 'route' => 'report.seller_review', 'type' => 2]

                ];

                DB::table('permissions')->insert($sql);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
