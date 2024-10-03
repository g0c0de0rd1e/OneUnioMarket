<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersLoginCheckoutColumnOnGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('general_settings','user_login_checkout')){
            Schema::table('general_settings',function(Blueprint $table){
                $table->integer('user_login_checkout')->default(0)->after('disable_seller_plan');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasColumn('general_settings','user_login_checkout')){
            Schema::table('general_setting',function(Blueprint $table){
                $table->dropColumn('user_login_checkout');
            });
        }
    }
}
