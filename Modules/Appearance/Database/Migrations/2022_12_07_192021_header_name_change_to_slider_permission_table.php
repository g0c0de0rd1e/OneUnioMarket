<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class HeaderNameChangeToSliderPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('permissions', 'name','route')) {
            DB::statement("UPDATE `permissions` SET `name`='Slider',`route`='appearance.slider.index' WHERE id=79");
        }
        if (Schema::hasColumn('permissions','route')) {
            DB::statement("UPDATE `permissions` SET `route`='appearance.slider.update_status' WHERE id=80");
        }
        if (Schema::hasColumn('permissions','route')) {
            DB::statement("UPDATE `permissions` SET `route`='appearance.slider.setup' WHERE id=81");
        }
        if (Schema::hasColumn('backendmenus', 'name','route')) {
            DB::statement("UPDATE `backendmenus` SET `name`='appearance.slider',`route`='appearance.slider.index' WHERE id=32");
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
