<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class GeneralSettingsModuleManagerNameUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('backendmenus', 'name')) {
            DB::statement("UPDATE `backendmenus` SET `name`='general_settings.module_manager' WHERE id=148");
        }
        if (Schema::hasColumn('backendmenus', 'name')) {
            DB::statement("UPDATE `backendmenus` SET `name`='refund.my_refund_requests' WHERE id=190");
           
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
