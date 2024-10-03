<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddIntshippingModuleToModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('modules')){
            $module = Module::where('name', 'INTShipping')->first();
            if(!$module){
                Module::create([
                    'name' => 'INTShipping',
                    'status' => 1,
                    'order' => 14
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
            $module = Module::where('name', 'INTShipping')->first();
            if($module){
                $module->delete();
            }
        }
    }
}
