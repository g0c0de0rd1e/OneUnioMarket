<?php

namespace Modules\GeneralSetting\Repositories;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\OrderManage\Entities\CustomerNotification;

class NotificationSettingRepository
{
    public function all()
    {
        return NotificationSetting::all();
    }
    public function single($id)
    {
        return NotificationSetting::findOrFail($id);
    }
    public function update($request)
    {
        $notificationSetting = NotificationSetting::findOrFail($request->id);
        $notificationSetting->event = $request->event;
        $notificationSetting->message = $request->message;
        $notificationSetting->admin_msg = $request->admin_msg;
        $notificationtype="";
        foreach($request->type as $type){
            $notificationtype .= $type.",";
        }
        $notificationSetting->type = $notificationtype;
        $notificationSetting->save();
        return true;
    }
    public function userNotifications($user_id)
    {
        return CustomerNotification::with('order')->where('customer_id',$user_id)->paginate(10);
    }
}
