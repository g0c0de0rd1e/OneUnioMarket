<?php

namespace Modules\GeneralSetting\Entities;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class NotificationSetting extends Model
{
    use HasTranslations;
    protected $guarded = [];
    protected $appends = [];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['event','message','admin_msg'];
            $this->appends = ['translateevent','Translatemessage','Translateadminmessage'];
        }
    }
    public function getTranslateeventAttribute(){
        return $this->attributes['event'];
    }
    public function getTranslatemessageAttribute(){
        return $this->attributes['message'];
    }
    public function getTranslateadminmessageAttribute(){
        return $this->attributes['admin_msg'];
    }
    public function getNotificationSettingByUserRoleType($userId)
    {
        $user = User::find($userId);
        $notificationSettings="";
        if($user->role->type == "customer"){
            $notificationSettings = NotificationSetting::where('user_access_status',1)->get();
        }elseif($user->role->type == "seller"){
            $notificationSettings = NotificationSetting::where('seller_access_status',1)->get();
        }elseif($user->role->type == "staff"){
            $notificationSettings = NotificationSetting::where('staff_access_status',1)->get();
        }elseif($user->role->type == "superadmin" || $user->role->type == "admin"){
            $notificationSettings = NotificationSetting::where('admin_access_status',1)->orWhere('seller_access_status',1)->get();
        }
        return $notificationSettings;
    }
}
