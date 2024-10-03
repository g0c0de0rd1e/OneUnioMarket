<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddNewRowInSellerCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('seller_commissions')){
                DB::table('seller_commissions')->insert([
                    [
                        'name' => 'None',
                        'slug' => 'none',
                        'rate' => '0',
                        'status' => '1',
                        'description' => null
                    ]
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_commissions', function (Blueprint $table) {
            $table->dropIfExists();
        });
    }
}
