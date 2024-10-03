<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Generalsetting\Entities\EmailTemplate;
use Modules\GeneralSetting\Entities\EmailTemplateType;
class AddUserEmailNotificationForAccountActiveEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $type = EmailTemplateType::where('type','user_activation_template')->first();
        if(empty($type))
        {
            $type = EmailTemplateType::create([
                "type" => 'user_activation_template',
                "module" => null
            ]);
        }

        $hasTemplate = EmailTemplate::where('type_id',$type->id)->first();
        if(empty($hasTemplate)){
            EmailTemplate::create([
                "type_id" => $type->id,
                "subject" => "Account has been Activated",
                "value" => '<div style="font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); text-align: center; background-color: rgb(152, 62, 81); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-size: 36px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit;"><br></h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;"><p style="color: rgb(85, 85, 85);">Hello {USER_FIRST_NAME},<br>Your account of {APP_NAME} has been activated. You can login now</p><hr style="box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-top-color: rgb(238, 238, 238);"><p style="color: rgb(85, 85, 85);"><br></p><p style="color: rgb(85, 85, 85);">{EMAIL_SIGNATURE}</p><p style="color: rgb(85, 85, 85);"><br></p></div>
                <div style="font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); text-align: center; background-color: rgb(152, 62, 81); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;"><h1 style="margin: 20px 0px 10px; font-size: 36px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit;"><br></h1></div><div style="color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;"></div>',
                "is_active" => 1,
                "relatable_type" => null,
                "relatable_type" => null,
                "reciepnt_type" => '["customer","seller"]'

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
        $type = EmailTemplateType::where('type','user_activation_template')->first();
        if($type){
            EmailTemplate::where('type_id',$type->id)->delete();
            $type->delete();
        }
    }
}
