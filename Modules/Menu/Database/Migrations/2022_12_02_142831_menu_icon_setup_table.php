<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MenuIconSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('menu_elements')){
            Schema::table('menu_elements', function (Blueprint $table) {
                $table->string('icon')->nullable()->after('title');
            });
        } 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_elements', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
}
