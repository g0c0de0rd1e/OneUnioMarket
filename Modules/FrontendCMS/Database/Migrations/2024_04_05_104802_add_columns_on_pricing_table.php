<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnPricingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(!Schema::hasColumn('pricings','expire_in')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->integer('expire_in')->default(0);
            });
        }

        if(!Schema::hasColumn('pricings','image')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->text('image')->nullable();
            });
        }

        if(!Schema::hasColumn('pricings','plan_price')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->integer('plan_price')->default(0);
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
        if(Schema::hasColumn('pricings','expire_in')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->dropColumn('expire_in');
            });
        }

        if(Schema::hasColumn('pricings','image')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->dropColumn('image');
            });
        }

        if(Schema::hasColumn('pricings','plan_price')){
            Schema::table('pricings', function (Blueprint $table) {
                $table->dropColumn('plan_price');
            });
        }
    }
}
