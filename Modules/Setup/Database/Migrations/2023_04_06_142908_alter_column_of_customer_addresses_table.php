<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnOfCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('customer_addresses')){
            Schema::table('customer_addresses', function (Blueprint $table) {
                $table->string('address')->nullable()->change();
                $table->string('city')->nullable()->change();
                $table->string('state')->nullable()->change();
                $table->string('country')->nullable()->change();
                $table->string('postal_code')->nullable()->change();
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
        Schema::table('customer_addresses', function (Blueprint $table) {
                $table->string('address')->nullable(false)->change();
                $table->string('city')->nullable()->change();
                $table->string('state')->nullable(false)->change();
                $table->string('country')->nullable(false)->change();
                $table->string('postal_code')->nullable()->change();
        });
    }
}
