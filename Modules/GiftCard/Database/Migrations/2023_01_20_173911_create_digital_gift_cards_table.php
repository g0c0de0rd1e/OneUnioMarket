<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDigitalGiftCardsTable extends Migration
{
    public function up()
    {
        Schema::create('digital_gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('gift_name');
            $table->text('descriptionOne')->nullable();
            $table->string('thumbnail_image_one')->nullable();
            $table->string('thumbnail_image_two')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('digital_gift_cards');
    }
}
