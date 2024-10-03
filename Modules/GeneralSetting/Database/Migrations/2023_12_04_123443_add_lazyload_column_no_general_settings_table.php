<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLazyloadColumnNoGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('general_settings','lazyload')){
            Schema::table('general_settings', function (Blueprint $table) {
                $table->integer('lazyload')->default(1);
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
        if(Schema::hasColumn('general_settings','lazyload')){
            Schema::table('general_settings', function (Blueprint $table) {
                $table->dropColumn('lazyload');
            });
        }
    }
}
