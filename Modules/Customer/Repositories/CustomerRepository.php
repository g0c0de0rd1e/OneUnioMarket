<?php

namespace Modules\Customer\Repositories;
use App\Traits\ImageStore;
use App\Models\Order;
use Modules\Customer\Entities\CustomerAddress;
use App\Models\User;
use App\Traits\Notification;
use App\Traits\SendMail;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Customer\Imports\CustomerImport;
use Modules\GeneralSetting\Entities\EmailTemplateType;
use Modules\GeneralSetting\Entities\NotificationSetting;
use Modules\GeneralSetting\Entities\UserNotificationSetting;
use Modules\Marketing\Entities\ReferralCode;
use Modules\Marketing\Entities\ReferralCodeSetup;
use Modules\Marketing\Entities\ReferralUse;
use Modules\OrderManage\Entities\CustomerNotification;
use Modules\Wallet\Entities\WalletBalance;

class CustomerRepository
{
    use Notification, SendMail, ImageStore;
    public function getAll()
    {
        return User::with('wallet_balances', 'orders')->whereHas('role', function($query){
            return $query->where('type', 'customer');
        })->latest();
    }

    public function find($id)
    {
        return User::with('wallet_balances', 'orders', 'customerAddresses')->findOrFail($id);
    }

    public function store($data){
        $field = $data['email'];
        if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            $email = $data['email'];
        }else{
            $phone = $data['email'];
        } 
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => isset($phone) ? $phone : NULL,
            'email' => isset($email) ? $email : NULL,
            'verify_code' => sha1(time()),
            'password' => Hash::make($data['password']),
            'role_id' => 4,
            'phone' => isset($phone) ? $phone : NULL,
            'is_verified' => 1,
            'is_active' => $data['status'],
            'currency_id' => app('general_setting')->currency,
            'lang_code' => app('general_setting')->language_code,
            'currency_code' => app('general_setting')->currency_code,
        ]);

        // User Notification Setting Create
        (new UserNotificationSetting)->createForRegisterUser($user->id);
        $this->typeId = EmailTemplateType::where('type', 'register_email_template')->first()->id; //register email templete typeid
        $notification = NotificationSetting::where('slug','register')->first();
        if ($notification) {
            $this->notificationSend($notification->id, $user->id);
        }
        if (isset($data['referral_code'])) {
            $referralData = ReferralCodeSetup::first();
            $referralExist = ReferralCode::where('referral_code', $data['referral_code'])->first();
            if ($referralExist) {
                $referralExist->update(['total_used' => $referralExist->total_used + 1]);
                ReferralUse::create([
                    'user_id' => $user->id,
                    'referral_code' => $data['referral_code'],
                    'discount_amount' => $referralData->amount
                ]);
            }
        }
        return $user;

    }

    public function update($data, $id){
        $field = $data['email'];
        if (is_numeric($field)) {
            $phone = $data['email'];
        } elseif (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            $email = $data['email'];
        }
        $user = User::find($id);
        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => isset($phone) ? $phone : NULL,
            'email' => isset($email) ? $email : NULL,
            'password' => ($data['password'] != null)?Hash::make($data['password']):$user->password,
            'is_active' => $data['status']
        ]);
        return $user;

    }

    public function destroy($id){
        $customer = User::find($id);
        $customer_orders  = Order::where('customer_id',$id)->pluck('id');
        $wallet = WalletBalance::where('user_id', $id)->pluck('id');
        if($customer_orders->count() || $wallet->count()){
            return false;
        }
        $addresses = $customer->customerAddresses->pluck('id');
        CustomerAddress::destroy($addresses);
        $notifications = CustomerNotification::where('customer_id', $id)->pluck('id');
        CustomerNotification::destroy($notifications);
        $notification_settings = UserNotificationSetting::where('user_id', $id)->pluck('id');
        UserNotificationSetting::destroy($notification_settings);
        $customer->delete();
        return true;
    }
    public function imageDelete($data){
        $customer = User::find(auth()->user()->id);
        if (showImage($customer->avatar ) == $data['image']) {
            $this->deleteImage($customer->avatar);
        }
        $customer->update([
            'avatar' => ''
        ]);
        return true;
    }
    public function BulkUploadStore($data){
        Excel::import(new CustomerImport, $data['file']->store('temp'));
    }

    public function posCustomer()
    {
        return User::with('customerAddresses')->whereHas('role', function($query){
            return $query->where(['type' => 'customer', 'is_active' => 1]);
        })->orderBy('id','DESC')->get();
    }

    public function getCustomersByAjax($search){
        if($search == ''){
            $customer = User::select('id','first_name', 'last_name')->whereHas('role', function($query){
                return $query->where(['type' => 'customer', 'is_active' => 1]);
            })->orderBy('id', 'DESC')->paginate(10);
        }else{
            $customer = User::select('id','first_name', 'last_name')
                ->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")->whereHas('role', function($query){
                    return $query->where(['type' => 'customer', 'is_active' => 1]);
                })->orderBy('id', 'DESC')
                ->paginate(10);
        }
        $response = [];
        foreach($customer as $customers){
            $response[]  =[
                'id'    =>'customer-'.$customers->id,
                'text'  =>$customers->first_name.' '.$customers->last_name
            ];
        }
        return  $response;
    }

}
