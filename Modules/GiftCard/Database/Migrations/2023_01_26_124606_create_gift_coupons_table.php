<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('gift_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('gift_selling_coupon')->nullable();     
            $table->unsignedBigInteger('add_gift_id');
            $table->foreign('add_gift_id')->on('add_gift_cards')->references('id')->onDelete('cascade');
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('gift_coupons');
    }
}
