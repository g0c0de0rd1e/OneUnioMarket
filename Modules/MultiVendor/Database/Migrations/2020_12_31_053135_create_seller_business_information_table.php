<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\MultiVendor\Entities\SellerBusinessInformation;
use App\Models\User;

class CreateSellerBusinessInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_business_information')){
            Schema::create('seller_business_information', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('business_owner_name')->nullable();
                $table->string('business_address1')->nullable();
                $table->string('business_address2')->nullable();
                $table->string('business_country')->nullable();
                $table->string('business_state')->nullable();
                $table->string('business_city')->nullable();
                $table->string('business_postcode')->nullable();
                $table->string('business_person_in_charge_name')->nullable();
                $table->string('business_registration_number')->nullable();
                $table->string('business_document')->nullable();
                $table->string('business_seller_tin')->nullable();
                $table->boolean('claim_gst')->default(0);
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
        Schema::dropIfExists('seller_business_information');
    }
}
