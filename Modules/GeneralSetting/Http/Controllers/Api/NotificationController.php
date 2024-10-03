<?php

namespace Modules\GeneralSetting\Http\Controllers\Api;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use \Modules\GeneralSetting\Services\NotificationSettingService;
use Modules\GeneralSetting\Services\UserNotificationSettingService;
use Modules\OrderManage\Entities\CustomerNotification;
use Modules\UserActivityLog\Traits\LogActivity;
/**
* @group Notifications
*
* APIs for Notifications
*/
class NotificationController extends Controller
{

    protected $notificationSettingService;
    protected $customerNotificationSettingService;

    public function __construct(NotificationSettingService $notificationSettingService, UserNotificationSettingService $customerNotificationSettingService)
    {
        $this->notificationSettingService = $notificationSettingService;
        $this->customerNotificationSettingService = $customerNotificationSettingService;
    }


    /**
     * Notification Lists
     * @response{
     *      "notifications": {
     *           "current_page": 1,
     *           "data": [
     *               {
     *                   "id": 14,
     *                   "order_id": 11,
     *                   "customer_id": 4,
     *                   "seller_id": null,
     *                   "title": "Your order (order-1559-210824011647) status has changed",
     *                   "description": null,
     *                   "read_status": 0,
     *                   "super_admin_read_status": 1,
     *                   "created_at": "2021-08-24T01:48:47.000000Z",
     *                   "updated_at": "2021-09-08T01:24:40.000000Z",
     *                   "order": {
     *                       "id": 11,
     *                       "customer_id": 4,
     *                       "order_payment_id": null,
     *                       "order_type": null,
     *                       "order_number": "order-1559-210824011647",
     *                       "payment_type": 2,
     *                       "is_paid": 1,
     *                       "is_confirmed": 1,
     *                       "is_completed": 1,
     *                       "is_cancelled": 0,
     *                       "cancel_reason_id": null,
     *                       "customer_email": "customer@gmail.com",
     *                       "customer_phone": "2365659686569",
     *                       "customer_shipping_address": 1,
     *                       "customer_billing_address": 1,
     *                       "number_of_package": 1,
     *                       "grand_total": 179.5,
     *                       "sub_total": 130,
     *                       "discount_total": 0,
     *                       "shipping_total": 30,
     *                       "number_of_item": 1,
     *                       "order_status": 5,
     *                       "tax_amount": 19.5,
     *                       "created_at": "2021-08-24T01:16:47.000000Z",
     *                       "updated_at": "2021-08-25T03:38:24.000000Z"
     *                   }
     *               },
     *               {
     *                   "id": 16,
     *                   "order_id": 11,
     *                   "customer_id": 4,
     *                   "seller_id": null,
     *                   "title": "Your order (order-1559-210824011647) status has changed",
     *                   "description": null,
     *                   "read_status": 0,
     *                   "super_admin_read_status": 1,
     *                   "created_at": "2021-08-24T01:49:45.000000Z",
     *                   "updated_at": "2021-09-08T01:24:40.000000Z",
     *                   "order": {
     *                       "id": 11,
     *                       "customer_id": 4,
     *                       "order_payment_id": null,
     *                       "order_type": null,
     *                       "order_number": "order-1559-210824011647",
     *                       "payment_type": 2,
     *                       "is_paid": 1,
     *                       "is_confirmed": 1,
     *                       "is_completed": 1,
     *                       "is_cancelled": 0,
     *                       "cancel_reason_id": null,
     *                       "customer_email": "customer@gmail.com",
     *                       "customer_phone": "2365659686569",
     *                       "customer_shipping_address": 1,
     *                       "customer_billing_address": 1,
     *                       "number_of_package": 1,
     *                       "grand_total": 179.5,
     *                       "sub_total": 130,
     *                       "discount_total": 0,
     *                       "shipping_total": 30,
     *                       "number_of_item": 1,
     *                       "order_status": 5,
     *                       "tax_amount": 19.5,
     *                       "created_at": "2021-08-24T01:16:47.000000Z",
     *                       "updated_at": "2021-08-25T03:38:24.000000Z"
     *                   }
     *               }
     *           ],
     *           "first_page_url": "https://spn21.spondan.com/amazcart2/api/user-notifications?page=1",
     *           "from": 1,
     *           "last_page": 2,
     *           "last_page_url": "https://spn21.spondan.com/amazcart2/api/user-notifications?page=2",
     *           "links": [
     *               {
     *                   "url": null,
     *                   "label": "&laquo; Previous",
     *                   "active": false
     *               },
     *               {
     *                   "url": "https://spn21.spondan.com/amazcart2/api/user-notifications?page=1",
     *                   "label": "1",
     *                   "active": true
     *               },
     *               {
     *                   "url": "https://spn21.spondan.com/amazcart2/api/user-notifications?page=2",
     *                   "label": "2",
     *                   "active": false
     *               },
     *               {
     *                   "url": "https://spn21.spondan.com/amazcart2/api/user-notifications?page=2",
     *                   "label": "Next &raquo;",
     *                   "active": false
     *               }
     *           ],
     *           "next_page_url": "https://spn21.spondan.com/amazcart2/api/user-notifications?page=2",
     *           "path": "https://spn21.spondan.com/amazcart2/api/user-notifications",
     *           "per_page": 10,
     *           "prev_page_url": null,
     *           "to": 10,
     *           "total": 13
     *       }
     * }
     *
     */

    public function userNotifications(Request $request)
    {

        $user_id = $request->user()->id;
        $notifications = $this->notificationSettingService->userNotifications($user_id);

        if($notifications){
            return response()->json([
                'notifications' => $notifications
            ],200);
        }else{
            return response()->json([
                'message' => 'not found'
            ],404);
        }

    }
    /**
     * Notification setting
     * @response{
     *   "notifications": [
     *       {
     *           "id": 40,
     *           "user_id": 4,
     *           "notification_setting_id": 2,
     *           "type": "email,system",
     *           "created_at": "2021-09-12T04:47:19.000000Z",
     *           "updated_at": "2021-09-30T07:01:43.000000Z",
     *           "notification_setting": {
     *               "id": 2,
     *               "event": "Offline recharge",
     *               "delivery_process_id": null,
     *               "type": "email,system,",
     *               "message": "Offline recharge successful",
     *               "user_access_status": 1,
     *               "seller_access_status": 1,
     *               "admin_access_status": 1,
     *               "staff_access_status": 1,
     *               "created_at": "2021-09-12T04:45:20.000000Z",
     *               "updated_at": "2021-09-30T06:27:18.000000Z"
     *           }
     *       },
     *       {
     *           "id": 41,
     *           "user_id": 4,
     *           "notification_setting_id": 3,
     *           "type": "system",
     *           "created_at": "2021-09-12T04:47:19.000000Z",
     *           "updated_at": "2021-09-12T04:47:19.000000Z",
     *           "notification_setting": {
     *               "id": 3,
     *               "event": "Withdraw request declined",
     *               "delivery_process_id": null,
     *               "type": "system",
     *               "message": "Your withdraw request declined",
     *               "user_access_status": 1,
     *               "seller_access_status": 1,
     *               "admin_access_status": 1,
     *               "staff_access_status": 1,
     *               "created_at": "2021-09-12T04:45:20.000000Z",
     *               "updated_at": "2021-09-12T04:45:20.000000Z"
     *           }
     *       }
     *
     *   ],
     *   "msg": "success"
     * }
     */

    public function notificationSetting(Request $request){
        $userNotificationSettings = $this->customerNotificationSettingService->getByAuthUser($request->user()->id);
        return response()->json([
            'notifications' => $userNotificationSettings,
            'msg' => 'success'
        ]);
    }

    /**
     * Setting Update
     * @bodyParam id integer required Notification id
     * @bodyParam type string required example: system,email,mobile,sms
     * @response{
     *      "msg": "updated successfully"
     * }
     */

    public function notificationSettingUpdate(Request $request){
        $request->validate([
            'id' => 'required',
            'type' => 'required'
        ]);

       $update = $this->customerNotificationSettingService->updateSettingForAPI($request);
       if($update){
            return response()->json([
                'msg' => 'updated successfully'
            ],202);

       }else{
           return response()->json([
                'msg' => 'Not updated'
            ],501);
       }
    }

    /**
     * Mark As read
     * @response{
     *      "msg": "success"
     * }
     */

    public function ReadALLNotifications(Request $request){
        try{
            CustomerNotification::where('customer_id', $request->user()->id)->update(['read_status' => 1]);
            return response()->json([
                'msg' => 'success'
            ],201);
        }catch(Exception $e){
            LogActivity::errorLog($e->getMessage());
        }
    }

}
