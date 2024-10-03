<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\Backendmenu;
use Illuminate\Support\Facades\DB;
class CreatePermissionForCheckoutFieldVisibilitySetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        {
            $permission = [
                ['id' => 746, 'module_id' => 16, 'parent_id' => 290, 'name' => 'Checkout Field Manager', 'route' => 'setup.checkout.page.setup', 'type' => 2],
                ['id' => 748, 'module_id' => 16, 'parent_id' => 290, 'name' => 'One Click Order Complete', 'route' => 'setup.one.click.order.receive', 'type' => 2],
                ['id' => 749, 'module_id' => 20, 'parent_id' => 347, 'name' => 'Algolia Search Setup', 'route' => 'setup.algolia.search.config', 'type' => 2]
                // ['id' => 750, 'module_id' => 16, 'parent_id' => 290, 'name' => 'Partial Payment Setup', 'route' => 'setup.partial.payment.config', 'type' => 2]
            ];
            try{
                DB::table('permissions')->insert($permission);
            }catch(Exception $e){
            }
            if(Schema::hasTable('backendmenus')){
                $sql = [
                    ['parent_id' => 41, 'is_admin' => 1,'is_seller' => 0, 'icon' =>null, 'name' => 'setup.checkout_field_manager', 'route' => 'setup.checkout.page.setup', 'position' => 1], //Submenu
                    ['parent_id' => 41, 'is_admin' => 1,'is_seller' => 0, 'icon' =>null, 'name' => 'setup.one_click_order_complete', 'route' => 'setup.one.click.order.receive', 'position' => 1], //Submenu
                    ['parent_id' => 152, 'is_admin' => 1,'is_seller' => 0, 'icon' =>null, 'name' => 'setup.algolia_search_setup', 'route' => 'setup.algolia.search.config', 'position' => 1] //Submenu
                    // ['parent_id' => 41, 'is_admin' => 1,'is_seller' => 0, 'icon' =>null, 'name' => 'setup.partial_payment_setup', 'route' => 'setup.partial.payment.config', 'position' => 1] //Submenu
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
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::destroy([746,748,749]); //250
        Backendmenu::destroy([253,255,256]); //257
    }
}
