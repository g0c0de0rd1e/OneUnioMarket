<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingAmountBackRefundComplete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_configurations', function (Blueprint $table) {
            $table->boolean('shipping_amount_back_refund_complete')->default(1)->after('amount_multiply_with_qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_configurations', function (Blueprint $table) {
            $table->dropColumn('shipping_amount_back_refund_complete');
        });
    }
}
