<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddTabbyPaymentGatewayModuleToModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('modules')){
            $module = Module::where('name', 'Tabby')->first();
            if(!$module){
                Module::create([
                    'name' => 'Tabby',
                    'status' => 1,
                    'order' => 19
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
            $module = Module::where('name', 'Tabby')->first();
            if($module){
                $module->delete();
            }
        }
    }
}
