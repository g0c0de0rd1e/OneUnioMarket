<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMarcadopagoColumnOnGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('general_settings','MercadoPago'))
        {
            Schema::table('general_settings', function (Blueprint $table) {
                $table->integer('MercadoPago')->nullable();
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
        if(Schema::hasColumn('general_settings','MercadoPago'))
        {
            Schema::table('general_settings', function (Blueprint $table) {
                $table->dropColumn('MercadoPago');
            });
        }
    }
}
