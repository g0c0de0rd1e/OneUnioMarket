<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
class CreateOneClickorderReceiveStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('one_clickorder_receive_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        DB::statement("INSERT INTO `one_clickorder_receive_statuses` (`id`, `status`, `created_at`, `updated_at`) VALUES
        (1, 0, '2023-04-07 05:41:58', NULL)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('one_clickorder_receive_statuses');
    }
}
