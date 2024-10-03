<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SmsTemplateTypeForMultivendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('sms_template_types')){

            $exsist = DB::table('sms_template_types')->where('id', 27)->first();
            if(!$exsist){
                $sql = [
                    ['id' => 27, 'type' => 'Seller product approval', 'module' => 'MultiVendor', 'created_at' => now(), 'updated_at' => now()],
                    ['id' => 28, 'type' => 'Seller product update', 'module' => 'MultiVendor', 'created_at' => now(), 'updated_at' => now()],
                    ['id' => 29, 'type' => 'Seller payout', 'module' => 'MultiVendor', 'created_at' => now(), 'updated_at' => now()],
                    ['id' => 30, 'type' => 'Seller payout request', 'module' => 'MultiVendor', 'created_at' => now(), 'updated_at' => now()],
                    ['id' => 31, 'type' => 'Seller approved', 'module' => 'MultiVendor', 'created_at' => now(), 'updated_at' => now()],
                    ['id' => 32, 'type' => 'Seller suspended', 'module' => 'MultiVendor', 'created_at' => now(), 'updated_at' => now()]
                ];

                DB::table('sms_template_types')->insert($sql);
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
