<?php

use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;

class MakeMultivendorModuleAsFree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $moduleManagerController = new ModuleManagerController();
        $free_module = [
            'MultiVendor',
        ];
        foreach($free_module as $module){
            $active = Module::find($module);
            $active->disable();
            if(!$active || $active->isDisabled()){
                $moduleManagerController->FreemoduleAddOnsEnable($module);
            }
        }

        DB::table('modules')->where('name','MultiVendor')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('');
    }
}
