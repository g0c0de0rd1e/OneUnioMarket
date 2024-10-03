<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductReportColumnOnGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('general_settings','product_report')){
            Schema::table('general_settings', function (Blueprint $table) {
                $table->integer('product_report')->default(1);
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
        if(Schema::hasColumn('general_settings','product_report')){
            Schema::table('general_settings', function (Blueprint $table) {
                $table->dropColumn('product_report');
            });
        }
    }
}
