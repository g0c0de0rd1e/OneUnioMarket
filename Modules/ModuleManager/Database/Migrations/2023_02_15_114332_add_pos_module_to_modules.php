<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddPosModuleToModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('modules')){
            $module = Module::where('name', 'POS')->first();
            if(!$module){
                Module::create([
                    'name' => 'POS',
                    'status' => 1,
                    'order' => 17
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
        if(Schema::hasTable('modules')){
            $module = Module::where('name', 'POS')->first();
            if($module){
                $module->delete();
            }
        }
    }
}
