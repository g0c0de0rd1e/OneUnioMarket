<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarketingModulePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->where('route','marketing.coupon.get-data')->update([
            "route" => 'marketing.coupon'
        ]);

        DB::table('permissions')->where('route','marketing.news-letter.get-data')->update([
            "route" => 'marketing.news-letter'
        ]);


        DB::table('permissions')->where('route','marketing.marketing.subscriber.get-data')->update([
            "route" => 'marketing.subscriber'
        ]);

        DB::table('permissions')->where('route','marketing.bulk-sms.get-data')->update([
            "route" => 'marketing.bulk_sms'
        ]);

        DB::table('permissions')->where('route','marketing.referral-code.get-data')->update([
            "route" => 'marketing.referral-code'
        ]);

        DB::table('permissions')->where('route','wallet_recharge.get-data')->update([
            "route" => 'wallet_recharge.index'
        ]);

        DB::table('permissions')->where('route','wallet_recharge.offline_index_get_data')->update([
            "route" => 'wallet_recharge.offline_index'
        ]);

            //contact Request backend menu
            DB::table('backendmenus')->where('name','contactRequest.contact_mail')->update([
                "name" => "contactRequest.contact_mail_list"
            ]);
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
