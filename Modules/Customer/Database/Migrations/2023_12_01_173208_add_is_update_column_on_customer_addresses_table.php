<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsUpdateColumnOnCustomerAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('customer_addresses','is_updated')){
            Schema::table('customer_addresses', function (Blueprint $table) {
                $table->integer('is_updated')->default(0);
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
        if(Schema::hasColumn('customer_addresses','is_updated')){
            Schema::table('customer_addresses', function (Blueprint $table) {
                $table->dropColumn('is_updated');
            });
        }
    }
}
