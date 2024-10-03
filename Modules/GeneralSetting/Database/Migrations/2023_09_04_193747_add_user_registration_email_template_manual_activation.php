<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\EmailTemplate;
use Modules\GeneralSetting\Entities\EmailTemplateType;

class AddUserRegistrationEmailTemplateManualActivation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $type = EmailTemplateType::where('type','new_user_registration_template')->first();

        if(!$type){
              $type = DB::table('email_template_types')->insert([
                "type" => 'new_user_registration_template',
                "module" => null
             ]);
             $last_id = DB::getPdo()->lastInsertId();
             $type = EmailTemplateType::where('id',$last_id)->first();
        }

        $hasTemplate = EmailTemplate::where('type_id',$type->id)->first();
            if(!$hasTemplate){
                DB::table('email_templates')->insert([
                "type_id" => $type->id,
                "subject" => "New user has been Registred",
                "value" => '<div style="font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); text-align: center; background-color: rgb(152, 62, 81); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-size: 36px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit;"><br><img src="https://shop.school.edu.sl/public/uploads/editor-image/1680716990.PNG" style="width: 25%;"></h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;"><p style="color: rgb(85, 85, 85);">Hello Admin<br>New customer has been Registered. Name: {CUSTOMER_NAME}. Email: {CUSTOMER_EMAIL}.</p><hr style="box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-top-color: rgb(238, 238, 238);"><p style="color: rgb(85, 85, 85);"><br></p><p style="color: rgb(85, 85, 85);">{EMAIL_SIGNATURE}</p><p style="color: rgb(85, 85, 85);"><br></p></div>
                    <div style="font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); text-align: center; background-color: rgb(152, 62, 81); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-size: 36px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit;"><br></h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;"></div>',
                "is_active" => 1,
                "relatable_type" => null,
                "relatable_type" => null,
                "reciepnt_type" => '["admin"]'

               ]);
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
