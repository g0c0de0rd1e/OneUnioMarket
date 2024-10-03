<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerSubcriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_subcriptions')){
            Schema::create('seller_subcriptions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('seller_id')->nullable();
                $table->unsignedBigInteger('pricing_id')->nullable();
                $table->boolean('is_paid')->default(0);
                $table->date('last_payment_date')->nullable();
                $table->date('expiry_date')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('seller_subcriptions');
    }
}
