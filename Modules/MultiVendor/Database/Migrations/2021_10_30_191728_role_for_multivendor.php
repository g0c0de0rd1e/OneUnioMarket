<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Entities\BusinessSetting;

class RoleForMultivendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('roles')){

            $exsist = DB::table('roles')->where('type', 'seller')->first();
            if(!$exsist){
                $sql = [
                    ['name' => 'Seller', 'type' => 'seller', 'module' => 'MultiVendor', 'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')],
                    ['name' => 'Sub Seller', 'type' => 'seller', 'module' => 'MultiVendor' , 'created_at' => date('Y-m-d h:i:s'),'updated_at' => date('Y-m-d h:i:s')]
                ];

                DB::table('roles')->insert($sql);

            }
        }
        if(Schema::hasTable('business_settings')){
            $multi_vendor_setting = BusinessSetting::where('type', 'Multi-Vendor System Activate')->first();
            if($multi_vendor_setting){
                $multi_vendor_setting->update([
                    'status' => 1
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
        //
    }
}
