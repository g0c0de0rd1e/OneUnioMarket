<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\MultiVendor\Entities\SellerReturnAddress;
use App\Models\User;

class CreateSellerReturnAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_return_addresses')){
            Schema::create('seller_return_addresses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->boolean('same_as_warehouse')->default(1);
                $table->string('return_name')->nullable();
                $table->string('return_address')->nullable();
                $table->string('return_phone')->nullable();
                $table->string('return_country')->nullable();
                $table->string('return_state')->nullable();
                $table->string('return_city')->nullable();
                $table->string('return_postcode')->nullable();

                $table->timestamps();
                $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
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
        Schema::dropIfExists('seller_return_addresses');
    }
}
