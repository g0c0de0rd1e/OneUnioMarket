<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\Account\Entities\ChartOfAccount;

class AddSellerCommisionChartOfAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('chart_of_accounts')){
            $seller_commision = ChartOfAccount::where('default_for', 'Seller Commision')->first();
            if(!$seller_commision){
                DB::table('chart_of_accounts')->insert([
                    'code' => 'income-4',
                    'type' => 'Income',
                    'default_for' => 'Seller Commision',
                    'name' => 'Seller Commision',
                    'opening_balance' => 0,
                    'level' => 0
                ]);
            }


        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
