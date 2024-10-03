<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SidbarmanagerTranslateNameChangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('backendmenus', 'name')) {
            DB::statement("UPDATE `backendmenus` SET `name`='seller.request_inactive_seller_list' WHERE id=171");
            DB::statement("UPDATE `backendmenus` SET `name`='seller.seller_setting' WHERE id=175");
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
