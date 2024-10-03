<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserManualActivationFieldOnGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('general_settings', 'user_manual_activation')) {
            Schema::table('general_settings', function (Blueprint $table) {
                $table->integer('user_manual_activation')->default(1);
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
        if (Schema::hasColumn('general_settings', 'user_manual_activation')) {
            Schema::table('general_settings', function (Blueprint $table) {
                $table->dropColumn('user_manual_activation');
            });
        }
    }
}
