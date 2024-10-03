<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckoutFieldVisibilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_field_visibility', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('field_name')->nullable();
            $table->integer('visibility')->default(1);
            $table->integer('required')->default(1);
            $table->timestamps();
        });

        DB::statement("INSERT INTO `checkout_field_visibility` (`id`, `user_id`, `field_name`, `visibility`, `required`, `created_at`, `updated_at`) VALUES
        (1, 1, 'address', 1, 1, '2023-04-07 05:41:58', NULL),
        (2, 1, 'city', 1, 1, '2023-04-07 05:41:58', NULL),
        (3, 1, 'state', 1, 1, '2023-04-07 05:41:58', NULL),
        (4, 1, 'country', 1, 1, '2023-04-07 05:41:58', NULL),
        (5, 1, 'postal', 1, 1, '2023-04-07 05:41:58', NULL)
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkout_field_visibility');
    }
}
