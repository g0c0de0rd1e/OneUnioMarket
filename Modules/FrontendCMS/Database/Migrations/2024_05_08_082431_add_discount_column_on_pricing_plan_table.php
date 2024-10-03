<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDiscountColumnOnPricingPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('pricings','discount_type')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->integer('discount_type')->default(0);
            });
        }
        if(!Schema::hasColumn('pricings','discount')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->integer('discount')->default(0);
            });
        }
        if(!Schema::hasColumn('pricings','gst_tax_id')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->unsignedBigInteger('gst_tax_id')->nullable();
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
        if(Schema::hasColumn('pricings','discount_type')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->dropColumn('discount_type');
            });
        }
        if(Schema::hasColumn('pricings','discount')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->dropColumn('discount');
            });
        }
        if(Schema::hasColumn('pricings','gst_tax_id')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->dropColumn('gst_tax_id');
            });
        }
    }
}
