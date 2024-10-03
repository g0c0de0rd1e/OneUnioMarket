<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddGiftCardsTable extends Migration
{
    public function up()
    {
        Schema::create('add_gift_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('gift_card_value')->nullable();
            $table->integer('gift_selling_price')->nullable();
            $table->unsignedTinyInteger('gift_discount_type')->nullable()->comment('1 = percentage, 0 = percentage');
            $table->integer('gift_discount_amount')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('number_of_gift_card')->nullable();
            $table->foreignId('digilat_gift_id');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('add_gift_cards');
    }
}
