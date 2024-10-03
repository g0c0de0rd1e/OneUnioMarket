<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserInfoUpdateColumnOnGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('general_settings','user_info_update')){
            Schema::table('general_settings', function (Blueprint $table) {
                $table->integer('user_info_update')->default(1);
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
        if(Schema::hasColumn('general_settings','user_info_update')){
            Schema::table('general_settings', function (Blueprint $table) {
                $table->dropColumn('user_info_update');
            });
        }
    }
}
