<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SellerReviewReviewChangeNullableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('seller_reviews', 'review')) {
            DB::statement("ALTER TABLE `seller_reviews` CHANGE `review` `review` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_reviews', function (Blueprint $table) {
            $table->dropColumn('review');
        });
    }
}
