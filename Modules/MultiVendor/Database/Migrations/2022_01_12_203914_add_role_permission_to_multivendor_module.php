<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Role;

class AddRolePermissionToMultivendorModule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $seller = Role::where('type', 'seller')->first();
        $sub_seller = Role::where('type', 'seller')->orderByDesc('id')->first();
        $seller_id = $seller->id;
        $sub_seller_id = $sub_seller->id;
        if(Schema::hasTable('role_permission')){
            $lists = [
                ['permission_id' => 16,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 17,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 18,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 19,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 20,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 21,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 22,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 23,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 24,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 25,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 153,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 154,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 155,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 156,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 157,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 158,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 159,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 160,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 161,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 162,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 163,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 164,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 165,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 166,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 167,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 493,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 494,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 495,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 496,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 497,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 608,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 512,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 531,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 609,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 610,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 611,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 612,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 613,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 614,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 615,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 616,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 617,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 618,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 619,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 620,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 621,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 622,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 623,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 624,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 625,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 281,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 489,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 490,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 491,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 498,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 312,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 317,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 407,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 514,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 515,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 504,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 505,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 506,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 507,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 508,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 509,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 510,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 511,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 574,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 705,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 706,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 707,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 708,'role_id' => $seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],

                ['permission_id' => 496,'role_id' => $sub_seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 497,'role_id' => $sub_seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                ['permission_id' => 608,'role_id' => $sub_seller_id,'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
            ];

            DB::table('role_permission')->insert($lists);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('role_permission')){
            try{
                $seller = Role::where('type', 'seller')->first();
                $sub_seller = Role::where('type', 'seller')->orderByDesc('id')->first();
                $seller_id = $seller->id;
                $sub_seller_id = $sub_seller->id;

                DB::table('role_permission')->where('role_id', $seller_id)->orWhere('role_id', $sub_seller_id)->delete();
            }catch(Exception $e){
                
            }
        }
    }
}
