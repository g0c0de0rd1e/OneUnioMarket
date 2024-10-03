<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\EmailTemplate;
class UpdateShortCodesOnEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $short_codes =   [
            ['id' => 1,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 2,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 3,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 4,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 5,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 6,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 7,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 8,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 9,  'code' => '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 10, 'code' =>  '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 11, 'code' =>  '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 12, 'code' =>  '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 13, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 14, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 15, 'code' =>  '{USER_FIRST_NAME},{ORDER_TRACKING_NUMBER},{EMAIL_SIGNATURE}'],
            ['id' => 16, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}, {CUSTOM_MESSAGE}'],
            ['id' => 17, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 18, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 19, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 20, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 24, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 25, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 26, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 27, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 28, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 29, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 30, 'code' =>  '{USER_FIRST_NAME},{RESET_LINK},{EMAIL_SIGNATURE}'],
            ['id' => 31, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 32, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 33, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 34, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 35, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 36, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 37, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 38, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 39, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 40, 'code' =>  '{USER_FIRST_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 41, 'code' =>  '{USER_FIRST_NAME},{VERIFICATION_LINK},{EMAIL_SIGNATURE}'],
            ['id' => 42, 'code' =>  '{USER_FIRST_NAME}, {DIGITAL_FILE_LINK},{EMAIL_SIGNATURE}'],
            ['id' => 43, 'code' =>  '{USER_FIRST_NAME},{VERIFICATION_LINK},{EMAIL_SIGNATURE}'],
            ['id' => 44, 'code' =>  '{USER_FIRST_NAME},{VERIFICATION_LINK},{EMAIL_SIGNATURE}'],
            ['id' => 45, 'code' =>  '{USER_FIRST_NAME}, {CUSTOMER_NAME},{BIDDING_AMOUNT},{VERIFICATION_LINK},{EMAIL_SIGNATURE}'],
            ['id' => 46, 'code' =>  '{USER_FIRST_NAME}, {APP_NAME},{EMAIL_SIGNATURE}'],
            ['id' => 47, 'code' =>  '{CUSTOMER_NAME},{CUSTOMER_EMAIL},{EMAIL_SIGNATURE}'],
    ];

        foreach($short_codes as $code){
           $id = isset($code['id']) ? $code['id']:'';
           $shortcode = isset($code['code']) ? $code['code']:null;
            if($id != null)
            {
                $template = EmailTemplate::where('id',$id)->first();
                if(!empty($template)){
                    $template->update([
                        "short_codes" => $shortcode
                    ]);
                }
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

    }
}
