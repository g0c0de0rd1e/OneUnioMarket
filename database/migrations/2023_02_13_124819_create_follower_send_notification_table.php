<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\NotificationSetting;

class CreateFollowerSendNotificationTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('notification_settings')) {
                $store = new NotificationSetting();
                $store->event = 'Seller Add New Product';
                $store->delivery_process_id = null;
                $store->type = 'system';
                $store->message = 'Seller Add New Product';
                $store->user_access_status = 1;
                $store->seller_access_status = 1;
                $store->admin_access_status = 1;
                $store->staff_access_status = 1;
                $store->save();
        }
    }

    public function down()
    {
        
    }
}
