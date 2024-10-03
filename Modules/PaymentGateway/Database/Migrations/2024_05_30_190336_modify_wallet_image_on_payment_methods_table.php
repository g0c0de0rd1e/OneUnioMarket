<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyWalletImageOnPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $gateway = DB::table('payment_methods')->where('slug','wallet')->first();
        if($gateway)
        {
            DB::table('payment_methods')->where('id',$gateway->id)->update([
                "logo" => 'payment_gateway/wallet.jpg'
            ]);
        }

        DB::table('infix_module_managers')->where('name','MultiVendor')->update([
            "purchase_code" => time()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $gateway = DB::table('payment_methods')->where('slug','wallet')->first();
        if($gateway)
        {
            DB::table('payment_methods')->where('id',$gateway->id)->update([
                "logo" => 'payment_gateway/cod.jpg'
            ]);
        }
    }
}
