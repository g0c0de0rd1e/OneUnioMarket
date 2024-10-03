<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShortCodesColumnOnEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('email_templates','short_codes')){
            Schema::table('email_templates', function (Blueprint $table) {
                $table->text('short_codes')->nullable();
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
        if(Schema::hasColumn('email_templates','short_codes')){
            Schema::table('email_templates', function (Blueprint $table) {
                $table->dropColumn('short_codes');
            });
        }
    }
}
