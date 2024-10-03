<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if(!Schema::hasColumn('customer_addresses','is_updated'))
        {
            Schema::table('customer_addresses',function($table){
                $table->integer('is_updated')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('customer_addresses','is_updated'))
        {
            Schema::table('customer_addresses',function($table){
                $table->dropColumn('is_updated');
            });
        }
    }
};
