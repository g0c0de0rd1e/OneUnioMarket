<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\ModuleManager\Entities\Module;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $max_order  = Module::max('order');
        $hasOne = Module::where('name','Clickpay')->first();
        if(!$hasOne)
        {
            Module::create([
                "name" => "Clickpay",
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
