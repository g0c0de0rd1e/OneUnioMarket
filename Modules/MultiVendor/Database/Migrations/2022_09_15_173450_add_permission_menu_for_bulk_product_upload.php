<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\Backendmenu;

class AddPermissionMenuForBulkProductUpload extends Migration
{
    
    public function up()
    {
        if(Schema::hasTable('permissions')){
            $sql = [
                ['id' => 725, 'module_id' => 32, 'parent_id' => 469, 'name' => 'Product','module' => 'MultiVendor', 'route' => 'seller.bulk_product_upload', 'type' => 2]
            ];
            DB::table('permissions')->insert($sql);


            $count_review_permission = \Modules\RolePermission\Entities\Permission::where('id', 498)->first();
            if($count_review_permission){
                $count_review_permission->delete();
                DB::table('permissions')->insert([['id' => 498, 'module_id' => 15, 'parent_id' => 281, 'name' => 'My Reviews', 'module' => 'MultiVendor', 'route' => 'seller.my-reviews.index', 'type' => 2 ]]);
            }
            
            $my_review = Permission::where('route', 'my-reviews.index')->first();
            if($my_review){
                $my_review->update([
                    'route' => 'seller.my-reviews.index'
                ]);
            }
            
        }

        if(Schema::hasTable('backendmenus')){
            $menu_sql = [
                ['is_admin' => 0,'is_seller' => 1, 'icon' =>'fa fa-product-hunt', 'module' => 'MultiVendor', 'name' => 'product.bulk_product_upload','parent_route' => 'seller_product_module', 'route' => 'seller.bulk_product_upload', 'position' => 7]//Submenu
            ];

            foreach($menu_sql as $menu){
                $children = null;
                $parent = null;
                if(array_key_exists('children',$menu)){
                    $children = $menu['children'];
                    unset( $menu['children']);
                }
                if(array_key_exists('parent_route', $menu) && !array_key_exists('parent_id', $menu)){
                    $parent = Backendmenu::where('route', $menu['parent_route'])->where('is_seller', $menu['is_seller'])->first();
                    unset( $menu['parent_route']);
                    $menu['parent_id'] = $parent->id;
                    $parent = Backendmenu::create($menu);
                }else{
                    $parent = Backendmenu::create($menu);
                }
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

            $my_review_backend = Backendmenu::where('route', 'my-reviews.index')->first();
            if($my_review_backend){
                $my_review_backend->update([
                    'route' => 'seller.my-reviews.index'
                ]);
            }

        }
    }

    
    public function down()
    {
        Permission::destroy([725]);
    }
}
