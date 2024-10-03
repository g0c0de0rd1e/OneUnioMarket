<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddNotificationSettingsAndOrderSmsTempleteItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('sms_template_types')){
            $sql = [
                ['id' => 39, 'type' => 'order_processing_templete', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 40, 'type' => 'order_shipped_templete', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 41, 'type' => 'order_recieved_templete', 'created_at' => now(), 'updated_at' => now()]
            ];
            DB::table('sms_template_types')->insert($sql);
        }
        if(Schema::hasTable('sms_templates')){
            $sqlt = [
                ['id' => 36, 'type_id' => 39, 'subject' => 'Order Processing', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 37, 'type_id' => 40, 'subject' => 'Order Shipped', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 38, 'type_id' => 41, 'subject' => 'Order Recieved', 'value' => 'write where', 'is_active' => 1, 'relatable_type' => null, 'relatable_id' => null, 'reciepnt_type' => '["customer"]', 'created_at' => now(), 'updated_at' => now()]
            ];
            DB::table('sms_templates')->insert($sqlt);
        }
        if(Schema::hasTable('notification_settings')){
            $sqln = [
                ['delivery_process_id' => null, 'event' => 'Order Declined', 'slug' => 'order-declined','type' => 'system', 'message' => 'Order Declined', 'user_access_status' => 1, 'seller_access_status' => 1, 'admin_access_status' => 1, 'staff_access_status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ];
            DB::table('notification_settings')->insert($sqln);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
    }
}
