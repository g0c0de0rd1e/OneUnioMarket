<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\MultiVendor\Entities\SellerAccount;
use App\Models\User;

class CreateSellerAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_accounts')){
            Schema::create('seller_accounts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->tinyInteger('seller_commission_id')->default(0);
                $table->double('commission_rate',16,2)->nullable();
                $table->string('seller_id')->unique();
                $table->string('banner')->nullable();
                $table->string('subscription_type')->nullable();
                $table->string('seller_phone')->nullable();
                $table->string('seller_shop_display_name')->nullable()->unique();
                $table->boolean('holiday_mode')->default(0);
                $table->unsignedInteger('holiday_type')->nullable();
                $table->date('holiday_date')->nullable();
                $table->date('holiday_date_start')->nullable();
                $table->date('holiday_date_end')->nullable();
                $table->boolean('is_trusted')->default(0);
                $table->unsignedInteger('total_sale_qty')->default(0);
                $table->longText('about_seller')->nullable();
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
        Schema::dropIfExists('seller_accounts');
    }
}
