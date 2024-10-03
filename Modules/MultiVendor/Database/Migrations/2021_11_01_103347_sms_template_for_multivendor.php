<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SmsTemplateForMultivendor extends Migration
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
                    ['type_id' => 27, 'subject' => 'Seller product approval Template', 'module' => 'MultiVendor', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
                    ['type_id' => 28, 'subject' => 'Seller product update Template', 'module' => 'MultiVendor', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
                    ['type_id' => 29, 'subject' => 'Seller payout Template', 'module' => 'MultiVendor', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
                    ['type_id' => 30, 'subject' => 'Seller payout request Template', 'module' => 'MultiVendor', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
                    ['type_id' => 31, 'subject' => 'Seller approved Template', 'module' => 'MultiVendor', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
                    ['type_id' => 32, 'subject' => 'Seller suspended Template', 'module' => 'MultiVendor', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
                ];
                DB::table('sms_templates')->insert($sql);
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
