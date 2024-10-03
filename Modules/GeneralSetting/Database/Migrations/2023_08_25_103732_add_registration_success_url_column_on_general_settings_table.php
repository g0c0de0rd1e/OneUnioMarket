<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegistrationSuccessUrlColumnOnGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('general_settings','registration_success_url')){
            Schema::table('general_settings', function (Blueprint $table) {
                $table->text('registration_success_url')->nullable();
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
        if(Schema::hasColumn('general_settings','registration_success_url')){
            Schema::table('general_settings', function (Blueprint $table) {
                $table->dropColumn('registration_success_url');
            });
        }
    }
}
