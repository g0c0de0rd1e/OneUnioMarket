<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftCardXtraColumn extends Migration
{
    public function up()
    {
        if (Schema::hasTable('gift_cards')) {
            Schema::table('gift_cards', function (Blueprint $table) {
                if (!Schema::hasColumn('gift_cards', 'type')) {
                    $table->string('type')->nullable();
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('gift_cards')) {
            Schema::table('gift_cards', function (Blueprint $table) {
                if (Schema::hasColumn('gift_cards', 'type')) {
                    $table->dropColumn('type');
                }
            });
        }
    }
}
