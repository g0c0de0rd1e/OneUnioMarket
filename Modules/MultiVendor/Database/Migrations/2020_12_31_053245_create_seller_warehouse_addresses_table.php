<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\MultiVendor\Entities\SellerWarehouseAddress;
use App\Models\User;

class CreateSellerWarehouseAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_warehouse_addresses')){
            Schema::create('seller_warehouse_addresses', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('user_id');
                $table->string('warehouse_name')->nullable();
                $table->string('warehouse_address')->nullable();
                $table->string('warehouse_phone')->nullable();
                $table->string('warehouse_country')->nullable();
                $table->string('warehouse_state')->nullable();
                $table->string('warehouse_city')->nullable();
                $table->string('warehouse_postcode')->nullable();

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
        Schema::dropIfExists('seller_warehouse_addresses');
    }
}
