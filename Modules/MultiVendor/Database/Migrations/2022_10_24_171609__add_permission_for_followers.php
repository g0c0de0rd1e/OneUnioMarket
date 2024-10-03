<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\Backendmenu;
use Modules\SidebarManager\Entities\BackendmenuUser;

class AddPermissionForFollowers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = [

            ['id'  => 736, 'module_id' => 50, 'parent_id' => null, 'module' => 'MultiVendor','name' => 'Followers', 'route' => 'seller.seller_follow', 'type' => 1 ],

        ];

        try{
            DB::table('permissions')->insert($permission);
        }catch(Exception $e){

        }
        if(Schema::hasTable('backendmenus')){
            $sql = [
                ['id' => 228, 'parent_id' => 1, 'is_admin' => 1, 'module' => 'MultiVendor','is_seller' => 1, 'icon' =>'fas fa-users', 'name' => 'amazy.Followers', 'route' => 'seller.seller_follow', 'position' => 13],//Submenu
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::destroy([736]);
        if(Schema::hasTable('backendmenus')){
            $backend_menus = Backendmenu::where('module', 'MultiVendor')->pluck('id')->toArray();
            $backend_menu_users = BackendmenuUser::whereIn('backendmenu_id', $backend_menus)->pluck('id')->toArray();
            Backendmenu::destroy($backend_menus);
            BackendmenuUser::destroy($backend_menu_users);
        }
    }
}
