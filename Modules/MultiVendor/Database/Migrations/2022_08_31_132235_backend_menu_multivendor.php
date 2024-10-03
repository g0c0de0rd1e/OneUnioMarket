<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\Backendmenu;
use Modules\SidebarManager\Entities\BackendmenuUser;

class BackendMenuMultivendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('backendmenus')){
            $sql = [
                // seller dashboard
                ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' =>'fas fa-th', 'parent_id' => 1, 'name' => 'common.dashboard', 'route' => 'seller.dashboard','position' => 1], //Main menu

                //frontend cms
                ['is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor', 'icon' => 'fas fa-user', 'parent_id' => 14, 'name' => 'frontendCms.merchant_content', 'route' => 'frontendcms.merchant-content.index', 'position' => 4],

                //seller manage
                [ 'is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor', 'icon' => 'fas fa-user', 'parent_id' => 2, 'name' => 'seller.manage_seller', 'route' => 'manage_seller','position' => 4, 'children' => [
                    [ 'is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor',  'name' => 'seller.seller_list', 'route' => 'admin.merchants_list', 'position' => 1],
                    [ 'is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor',  'name' => 'seller.Request/Inactive seller list', 'route' => 'admin.inactiveMerchants', 'position' => 2],
                    ['is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor',  'name' => 'seller.commision_setup', 'route' => 'admin.seller_commission_index', 'position' => 3],
                    [ 'is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor',  'name' => 'frontendCms.pricing_plan', 'route' => 'admin.pricing.index', 'position' => 4],
                    [ 'is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor',  'name' => 'seller.subscription_payment', 'route' => 'admin.subscription_payment_list', 'position' => 5],
                    [ 'is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor', 'name' => 'seller.Seller setting', 'route' => 'admin.seller_configuration', 'position' => 6],
                ]],
               

                // seller order manage
                [ 'is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-shopping-cart', 'parent_id' => 40, 'name' => 'seller.Seller Order Manage', 'route' => 'seller_order_manage','position' => 30, 'children' => [
                    [ 'is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-shopping-cart', 'name' => 'order.my_order', 'route' => 'order_manage.my_sales_index', 'position' => 1],
                ]],
               

                //wallet manage
                [ 'is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor','icon' => 'fas fa-wallet', 'parent_id' => 97, 'name' => 'wallet.withdraw_requests', 'route' => 'wallet.withdraw_requests', 'position' => 2],

                //my wallet
                ['is_admin' => 1,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-wallet','parent_id' => 88, 'name' => 'wallet.my_wallet', 'route' => 'my_wallet','position' => 10,'children' => [
                    ['is_admin' => 1,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-wallet', 'name' => 'common.transactions', 'route' => 'my-wallet.index', 'position' => 1],
                    ['is_admin' => 1,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-wallet', 'name' => 'wallet.withdraw', 'route' => 'my-wallet.withdraw_index', 'position' => 2],
                ]],
                

                // seller staff manage
                [ 'is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-user', 'parent_id' => 2, 'name' => 'seller.my_staff', 'route' => 'seller.sub_seller.index','position' => 10],

                //seller subscription payment
                ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-wallet', 'parent_id' => 88, 'name' => 'common.subscription_payment', 'route' => 'seller.my_subscription_payment_list','position' => 11],

                //products
                ['is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor', 'icon' => 'fas fa-money-bill', 'parent_id' => 54, 'name' => 'product.inhouse_product_list', 'route' => 'admin.my-product.index', 'position' => 5],

                //reviews
                ['is_admin' => 1,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fa fa-product-hunt', 'parent_id' => 63, 'name' => 'review.my_product_review', 'route' => 'seller.product-reviews.index', 'position' => 5],
                ['is_admin' => 1,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-user', 'parent_id' => 63, 'name' => 'review.my_review', 'route' => 'seller.my-reviews.index', 'position' => 6],

                //seller products
                ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fa fa-product-hunt', 'parent_id' => 53, 'name' => 'product.products', 'route' => 'seller_product_module','position' => 10,'children' =>[
                    ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fa fa-product-hunt', 'name' => 'product.my_product_list', 'route' => 'seller.product.index', 'position' => 1],
                ]],
                

                //order manages
                ['is_admin' => 1,'is_seller' => 0, 'module' => 'MultiVendor', 'icon' => 'fas fa-shopping-cart', 'parent_id' => 41, 'name' => 'order.my_order', 'route' => 'order_manage.my_sales_index', 'position' => 2],

                //refund manage
                ['is_admin' => 1,'is_seller' => 1, 'module' => 'MultiVendor','icon' => 'fas fa-shopping-cart', 'parent_id' => 47, 'name' => 'refund.my_refund_requests', 'route' => 'refund.my_refund_list', 'position' => 2],

                // Support Ticket
                ['is_admin' => 0, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-headphone-alt', 'parent_id' => 121, 'name' => 'ticket.my_tickets', 'route' => 'seller.support-ticket.index', 'position' => 2],

                // admin report
                ['is_admin' => 1, 'is_seller' => 0, 'module' => 'MultiVendor', 'icon' => 'ti-agenda', 'parent_id' => 108, 'name' => 'report.seller_wise_sales', 'route' => 'report.seller_wise_sales', 'position' => 10],
                ['is_admin' => 1, 'is_seller' => 0, 'module' => 'MultiVendor', 'icon' => 'ti-agenda', 'parent_id' => 108, 'name' => 'dashboard.top_sellers', 'route' => 'report.top_seller', 'position' => 11],

                // seller report
                ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-agenda' , 'parent_id' => 102, 'name' => 'report.my_reports', 'route' => 'seller_report','position' => 32,'children' => [
                    ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-agenda' , 'name' => 'common.product', 'route' => 'seller_report.product', 'position' => 1],
                    ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-agenda' , 'name' => 'dashboard.top_customers', 'route' => 'seller_report.top_customer', 'position' => 2],
                    ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-agenda' , 'name' => 'report.top_selling_item', 'route' => 'seller_report.top_selling_item', 'position' => 3],
                    ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-agenda' , 'name' => 'common.order', 'route' => 'seller_report.order', 'position' => 4],
                    ['is_admin' => 0,'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-agenda' , 'name' => 'review.review', 'route' => 'seller_report.review', 'position' => 5]
                ]],

                // Customer Panel
                ['is_admin' => 1,'is_seller' => 1, 'parent_id' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-th', 'name' => 'Customer Panel', 'route' => 'customer_panel','position' => 2, 'children' => [
                    ['is_admin' => 1, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-shopping-cart' , 'name' => 'My Purchase Orders', 'route' => 'frontend.my_purchase_order_list', 'position' => 1],
                    ['is_admin' => 1, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-gift' , 'name' => 'My Giftcards', 'route' => 'frontend.purchased-gift-card', 'position' => 2],
                    ['is_admin' => 1, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-file' , 'name' => 'My Digital Products', 'route' => 'frontend.digital_product', 'position' => 3],
                    ['is_admin' => 1, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-heart' , 'name' => 'My Wishlists', 'route' => 'frontend.my-wishlist', 'position' => 4],
                    ['is_admin' => 1, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-shopping-cart' , 'name' => 'My Refund Desputes', 'route' => 'refund.frontend.index', 'position' => 5],
                    ['is_admin' => 1, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'ti-gift' , 'name' => 'My Coupons', 'route' => 'customer_panel.coupon', 'position' => 6],
                    ['is_admin' => 1, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-user' , 'name' => 'My Profiles', 'route' => 'frontend.customer_profile', 'position' => 7],
                    ['is_admin' => 1, 'is_seller' => 1, 'module' => 'MultiVendor', 'icon' => 'fas fa-user' , 'name' => 'My Referral', 'route' => 'customer_panel.referral', 'position' => 8],
                ]],
                
                

            ];

            foreach($sql as $menu){
                $children = null;
                if(array_key_exists('children',$menu)){
                    $children = $menu['children'];
                    unset( $menu['children']);
                }
                $parent = Backendmenu::create($menu);
                if($children){
                    foreach($children as $menu){
                        $sub_children = null;
                        if(array_key_exists('children',$menu)){
                            $sub_children = $menu['children'];
                            unset( $menu['children']);
                        }
                        $menu['parent_id'] = $parent->id;
                        $parent_children = Backendmenu::create($menu);
                        if($sub_children){
                            foreach($sub_children as $menu){
                                $subsubmenu['parent_id'] = $parent_children->id;
                                Backendmenu::create($subsubmenu);
                            }
                        }
                    }
                }
            }
        }

        if(Schema::hasTable('permissions')){
            $my_review = Permission::where('route', 'my-reviews.index')->first();
            if($my_review){
                $my_review->update([
                    'route' => 'seller.my-reviews.index'
                ]);
            }

            $withdraw_request = Permission::where('route', 'wallet.withdraw_requests.get_data')->first();
            if($withdraw_request){
                $withdraw_request->update([
                    'route' => 'wallet.withdraw_requests'
                ]);
            }
            $seller_subscription = Permission::where('id',515)->where('route', 'seller_subscription_payment')->first();
            if($seller_subscription){
                $seller_subscription->update([
                    'route' => 'seller.my_subscription_payment_list'
                ]);
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
        if(Schema::hasTable('backendmenus')){
            $backend_menus = Backendmenu::where('module', 'MultiVendor')->pluck('id')->toArray();
            $backend_menu_users = BackendmenuUser::whereIn('backendmenu_id', $backend_menus)->pluck('id')->toArray();
            Backendmenu::destroy($backend_menus);
            BackendmenuUser::destroy($backend_menu_users);
        }
    }
}
