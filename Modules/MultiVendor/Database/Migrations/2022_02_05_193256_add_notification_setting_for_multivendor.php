<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\GeneralSetting\Entities\UserNotificationSetting;

class AddNotificationSettingForMultivendor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('notification_settings')){

            $exsist = DB::table('notification_settings')->where('event', 'Seller product approval')->first();
            if(!$exsist){
                $sql = [
                    ['event' => 'Seller product approval','type'=> 'system','message' => 'Product approved.', 'admin_msg' => 'A seller product approved.','user_access_status' => 0,'module'=>'MultiVendor','seller_access_status' => 1,'admin_access_status' => 1,'staff_access_status' => 1,'created_at' => now(),'updated_at' => now()],
                    ['event' => 'Seller product create','type'=> 'system','message' => 'Product created.','admin_msg' => 'A seller created product.','user_access_status' => 0,'module'=>'MultiVendor','seller_access_status' => 1,'admin_access_status' => 1,'staff_access_status' => 1,'created_at' => now(),'updated_at' => now()],
                    ['event' => 'Seller product update','type'=> 'system','message' => 'Product updated.','admin_msg' => 'A seller updated product.','user_access_status' => 0,'module'=>'MultiVendor','seller_access_status' => 1,'admin_access_status' => 1,'staff_access_status' => 1,'created_at' => now(),'updated_at' => now()],
                    ['event' => 'Seller payout','type'=> 'system','message' => 'Payout successfull.','admin_msg' => 'A seller request to payout.','user_access_status' => 0,'module'=>'MultiVendor','seller_access_status' => 1,'admin_access_status' => 1,'staff_access_status' => 1,'created_at' => now(),'updated_at' => now()],
                    ['event' => 'Seller suspended','type'=> 'system','message' => 'You are Suspended.', 'admin_msg' => 'A seller has been suspended.','user_access_status' => 0,'module'=>'MultiVendor','seller_access_status' => 1,'admin_access_status' => 1,'staff_access_status' => 1,'created_at' => now(),'updated_at' => now()],
                    ['event' => 'Seller approved','type'=> 'system','message' => 'You are approved.','admin_msg' => 'A seller has been approved.','user_access_status' => 0,'module'=>'MultiVendor','seller_access_status' => 1,'admin_access_status' => 1,'staff_access_status' => 1,'created_at' => now(),'updated_at' => now()],
                    ['event' => 'Seller Created','type'=> 'system','message' => 'Welcome as a seller.','admin_msg' => 'A seller has been created.','user_access_status' => 0,'module'=>'MultiVendor','seller_access_status' => 1,'admin_access_status' => 1,'staff_access_status' => 1,'created_at' => now(),'updated_at' => now()],
                    ['event' => 'Sub Seller Created','type'=> 'system','message' => 'Welcome as a sub seller.','admin_msg' => 'A sub seller has been created.','user_access_status' => 0,'module'=>'MultiVendor','seller_access_status' => 1,'admin_access_status' => 0,'staff_access_status' => 0,'created_at' => now(),'updated_at' => now()],
                ];
                NotificationSetting::insert($sql);

                $users = User::with('role')->get();
                $notifications = NotificationSetting::whereIn('event', ['Seller product approval','Seller product create','Seller product update','Seller payout','Seller suspended','Seller approved','Seller Created', 'Sub Seller Created'])->get();
                foreach($users as $user){
                    foreach($notifications as $notification){
                        if($user->role->type == 'customer' && $notification->user_access_status == 1){
                            UserNotificationSetting::create([
                                'user_id' => $user->id,
                                'notification_setting_id' => $notification->id,
                                'type' => $notification->type,
                            ]);
                        }elseif($user->role->type == 'seller' && $notification->seller_access_status == 1){
                            UserNotificationSetting::create([
                                'user_id' => $user->id,
                                'notification_setting_id' => $notification->id,
                                'type' => $notification->type,
                            ]);
                            
                        }elseif($user->role->type == 'staff' && $notification->staff_access_status == 1){
                            UserNotificationSetting::create([
                                'user_id' => $user->id,
                                'notification_setting_id' => $notification->id,
                                'type' => $notification->type,
                            ]);
                            
                        }
                        elseif($user->role->type == 'admin' && $notification->admin_access_status == 1){
                            UserNotificationSetting::create([
                                'user_id' => $user->id,
                                'notification_setting_id' => $notification->id,
                                'type' => $notification->type,
                            ]);
                        }elseif($user->role->type == 'superadmin'){
                            UserNotificationSetting::create([
                                'user_id' => $user->id,
                                'notification_setting_id' => $notification->id,
                                'type' => $notification->type,
                            ]);
                        }
                    }
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
        $notification_settings = NotificationSetting::whereIn('event', ['Seller product approval','Seller product create','Seller product update','Seller payout','Seller suspended','Seller approved','Seller Created','Sub Seller Created'])->pluck('id')->toArray();
        $user_notification_settings = UserNotificationSetting::whereIn('notification_setting_id',$notification_settings)->pluck('id')->toArray();
        NotificationSetting::destroy($notification_settings);
        UserNotificationSetting::destroy($user_notification_settings);
    }
}
