<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $max_id =  DB::table('permissions')->orderBy('id','DESC')->first();
        DB::table('permissions')->insert([
            "id" => $max_id->id + 1,
            "module_id" => 38,
            "parent_id" => 631,
            "name" => "Convert Image",
            "route" => 'utilities.convert_images',
            "type" => 2,
            "created_by" => 1,
            "updated_by" => 1,
            "status" => 1
        ]);

        if(!Schema::hasColumn('general_settings','image_convert')){
            Schema::table('general_settings',function($table){
                $table->integer('image_convert')->default(0);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permissions')->where('route','utilities.convert_images')->delete();
        if(Schema::hasColumn('general_settings','image_convert')){
            Schema::table('general_settings',function($table){
                $table->dropColumn('image_convert');
            });
        }
    }
};
