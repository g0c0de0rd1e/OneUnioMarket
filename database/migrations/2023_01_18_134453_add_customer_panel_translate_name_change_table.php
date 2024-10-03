<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddCustomerPanelTranslateNameChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (
            Schema::hasColumn('backendmenus', 'name')) {
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.customer_panel' WHERE id=200");
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.my_purchase_orders' WHERE id=201");
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.my_giftcards' WHERE id=202");
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.my_digital_products' WHERE id=203");
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.my_wishlists' WHERE id=204");
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.my_refund_desputes' WHERE id=205");
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.my_coupons' WHERE id=206");
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.my_profiles' WHERE id=207");
            DB::statement("UPDATE `backendmenus` SET `name`='customer_panel.my_referral' WHERE id=208");
           
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
