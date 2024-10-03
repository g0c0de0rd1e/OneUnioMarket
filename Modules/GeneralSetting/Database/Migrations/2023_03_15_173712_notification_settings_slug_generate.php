<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\GeneralSetting\Entities\NotificationSetting;
use App\Traits\GenerateSlug;

class NotificationSettingsSlugGenerate extends Migration
{
    use GenerateSlug;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('notification_settings')){
            Schema::table('notification_settings', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('event');
            });

            $settings = NotificationSetting::all();
            foreach($settings as $setting){
               $notification = NotificationSetting::find($setting->id);
               $notification->update([
                'slug' => $this->productSlug($notification->event)
               ]);
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
        Schema::table('notification_settings', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
