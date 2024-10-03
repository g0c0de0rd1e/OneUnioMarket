<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTaxIdColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('products')){
            Schema::table('products', function (Blueprint $table) {
                $table->foreignId('tax_id')->nullable()->after('gst_group_id');
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
        if(Schema::hasTable('products')){
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('tax_id');
            });
        }
    }
}
