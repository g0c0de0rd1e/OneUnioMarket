<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinMaxPhoneNumberColumnOnGeneralSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('general_settings','max_digit')){
            Schema::table('general_settings',function($table){
                $table->integer('max_digit')->default(11);
            });
        }

        if(!Schema::hasColumn('general_settings','min_digit')){
            Schema::table('general_settings',function($table){
                $table->integer('min_digit')->default(1);
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
        if(Schema::hasColumn('general_settings','min_digit')){
            Schema::table('general_settings',function($table){
                $table->dropColumn('min_digit');
            });
        }

        if(Schema::hasColumn('general_settings','max_digit')){
            Schema::table('general_settings',function($table){
                $table->dropColumn('max_digit');
            });
        }
    }
}
