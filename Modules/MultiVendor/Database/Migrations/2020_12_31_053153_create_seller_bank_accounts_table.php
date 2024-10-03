<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\MultiVendor\Entities\SellerBankAccount;
use App\Models\User;

class CreateSellerBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_bank_accounts')){
            Schema::create('seller_bank_accounts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');

                $table->unsignedInteger('payment')->default(0);
                $table->string('bank_title')->nullable();
                $table->string('bank_account_number')->nullable();
                $table->string('bank_name')->nullable();
                $table->string('bank_branch_name')->nullable();
                $table->string('bank_routing_number')->nullable();
                $table->string('bank_ibn')->nullable();
                $table->string('bank_cheque')->nullable();

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
        Schema::dropIfExists('seller_bank_accounts');
    }
}
