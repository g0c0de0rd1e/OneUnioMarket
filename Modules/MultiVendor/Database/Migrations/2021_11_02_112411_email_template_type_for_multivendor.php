<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class EmailTemplateTypeForMultivendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('email_template_types')){

            $exsist = DB::table('email_template_types')->where('id', 25)->first();
            if(!$exsist){
                DB::statement("INSERT INTO `email_template_types` (`id`, `type`, `module` , `created_at`, `updated_at`) VALUES
                    (25, 'subscription_payment_email_template', 'MultiVendor' , NULL, '2021-01-20 12:40:47'),
                    (26, 'seller_approve_email_template', 'MultiVendor' , NULL, '2021-01-20 12:40:47'),
                    (27, 'seller_suspended_email_template', 'MultiVendor' , NULL, '2021-01-20 12:40:47'),
                    (29, 'product_approve_email_template', 'MultiVendor' , NULL, '2021-01-20 12:40:47'),
                    (39, 'seller_create_email_template', 'MultiVendor' , NULL, '2021-01-20 12:40:47'),
                    (40, 'sub_seller_create_email_template', 'MultiVendor' , NULL, '2021-01-20 12:40:47')
                ");
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
