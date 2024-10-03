<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSellerCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_commissions')){
            Schema::create('seller_commissions', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->double('rate', 28,2)->default(0);
                $table->text('description')->nullable();
                $table->boolean('status')->default(1);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->timestamps();
            });
            DB::table('seller_commissions')->insert([
                [
                    'name' => 'Flat Rate',
                    'rate' => '0',
                    'status' => '1',
                    'description' => null
                ],
                [
                    'name' => 'Category Wise Commission',
                    'rate' => '0',
                    'status' => '1',
                    'description' => null
                ],
                [
                    'name' => 'Subscription',
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
        Schema::dropIfExists('seller_commissions');
    }
}
