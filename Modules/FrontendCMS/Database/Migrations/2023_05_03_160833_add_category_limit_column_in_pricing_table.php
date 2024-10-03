<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryLimitColumnInPricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('pricings')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->unsignedBigInteger('category_limit')->nullable()->after('stock_limit');
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
        if(Schema::hasTable('pricings')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->dropColumn('category_limit');
            });
        }
    }
}
