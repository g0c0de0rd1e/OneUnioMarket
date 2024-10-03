<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\ModuleManager\Entities\Module;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $max_order  = Module::max('order');
        $hasOne = Module::where('name','Torod')->first();
        if(!$hasOne)
        {
            Module::create([
                "name" => "Torod",
                'status' => 0,
                "order" => $max_order + 1
            ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
