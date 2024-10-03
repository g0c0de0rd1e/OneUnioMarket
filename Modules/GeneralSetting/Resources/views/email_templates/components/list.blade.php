<table class="table Crm_table_active3">
    <thead>
        <tr>
            <th scope="col">{{__('common.sl')}}</th>
            <th scope="col">{{ __('general_settings.subject') }}</th>
            <th scope="col">{{ __('common.type') }}</th>
            <th scope="col">{{ __('general_settings.reciepent') }}</th>
            <th scope="col">{{ __('general_settings.activate') }}</th>
            <th scope="col">{{ __('common.action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($email_templates as $key => $email_template)
            @if(!$email_template->module or isModuleActive($email_template->module))
                <tr>
                    <td>{{ getNumberTranslate($key+1) }}</td>
                    <td>{{ $email_template->subject }}</td>
                    <td>
                        @php
                        switch ($email_template->email_template_type->type) {
                            case 'order_invoice_template':
                            echo __("template.order_invoice_template");
                            break;
                            case 'order_pending_template':
                            echo __("template.order_pending_template");
                            break;
                            case 'order_confirmed_template':
                            echo __("template.order_confirmed_template");
                            break;
                            case 'order_declined_template':
                            echo __("template.order_declined_template");
                            break;
                            case 'paid_payment_template':
                            echo __("template.paid_payment_template");
                            break;
                            case 'order_completed_template':
                            echo __("template.order_completed_template");
                            break;
                            case 'delivery_process_template':
                            echo __("template.delivery_process_template");
                            break;
                            case 'refund_pending_template':
                            echo __("template.refund_pending_template");
                            break;
                            case 'refund_confirmed_template':
                            echo __("template.refund_confirmed_template");
                            break;
                            case 'refund_declined_template':
                            echo __("template.refund_declined_template");
                            break;
                            case 'refund_money_paid_template':
                            echo __("template.refund_money_paid_template");
                            break;
                            case 'refund_completed_template':
                            echo __("template.refund_completed_template");
                            break;
                            case 'refund_process_template':
                            echo __("template.refund_process_template");
                            break;
                            case 'gift_card_template':
                            echo __("template.gift_card_template");
                            break;
                            case 'review_email_template':
                            echo __("template.review_email_template");
                            break;
                            case 'newsletter_email_template':
                            echo __("template.newsletter_email_template");
                            break;
                            case 'wallet_email_template':
                            echo __("template.wallet_email_template");
                            break;
                            case 'order_email_template':
                            echo __("template.order_email_template");
                            break;
                            case 'register_email_template':
                            echo __("template.register_email_template");
                            break;
                            case 'notification_email_template':
                            echo __("template.notification_email_template");
                            break;
                            case 'support_ticket_email_template':
                            echo __("template.support_ticket_email_template");
                            break;
                            case 'verification_email_template':
                            echo __("template.verification_email_template");
                            break;
                            case 'product_review_email_template':
                            echo __("template.product_review_email_template");
                            break;
                            case 'subscription_payment_email_template':
                            echo __("template.subscription_payment_email_template");
                            break;
                            case 'seller_approve_email_template':
                            echo __("template.seller_approve_email_template");
                            break;
                            case 'seller_suspended_email_template':
                            echo __("template.seller_suspended_email_template");
                            break;
                            case 'product_disable_email_template':
                            echo __("template.product_disable_email_template");
                            break;
                            case 'product_approve_email_template':
                            echo __("template.product_approve_email_template");
                            break;
                            case 'product_review_approve_email_template':
                            echo __("template.product_review_approve_email_template");
                            break;
                            case 'product_update_email_template':
                            echo __("template.product_update_email_template");
                            break;
                            case 'withdraw_request_email_template':
                            echo __("template.withdraw_request_email_template");
                            break;
                            case 'registration_otp_email_template':
                            echo __("template.registration_otp_email_template");
                            break;
                            case 'order_otp_email_template':
                            echo __("template.order_otp_email_template");
                            break;
                            case 'login_otp_email_template':
                            echo __("template.login_otp_email_template");
                            break;
                            case 'password_reset_otp_email_template':
                            echo __("template.password_reset_otp_email_template");
                            break;
                            case 'seller_create_email_template':
                            echo __("template.seller_create_email_template");
                            break;
                            case 'sub_seller_create_email_template':
                            echo __("template.sub_seller_create_email_template");
                            break;
                            case 'Password Reset':
                            echo __("template.Password Reset");
                            break;
                            case 'Subscription email verify':
                            echo __("template.Subscription email verify");
                            break;
                            case 'Send digital file':
                            echo __("template.Send digital file");
                            break;
                            case 'auction_bidder_template':
                            echo __("template.auction_bidder_template");
                            break;
                            case 'auction_seller_template':
                            echo __("template.auction_seller_template");
                            break;
                            case 'auction_order_cancel_template':
                            echo __("template.auction_order_cancel_template");
                            break;

                            case 'user_activation_template':
                            echo __("template.User Activation Template");
                            break;

                            case 'new_user_registration_template':
                            echo __("template.New Customer Registration Template");
                            break;
                        }
                        @endphp
                        @if ($email_template->relatable_type != null)
                            ({{ $email_template->relatable->name }})
                        @endif
                    </td>
                    <td>
                        @if ($email_template->reciepnt_type)
                            @foreach (json_decode($email_template->reciepnt_type) as $k => $reciepnt)
                               @if($reciepnt == "customer") {{__('general_settings.customer')}} @elseif($reciepnt == "admin") {{__('common.admin')}} @elseif($reciepnt == "seller") {{__('general_settings.seller')}}  @endif @if(!$loop->last) , @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <label class="switch_toggle" for="checkbox{{ $email_template->id }}">
                            <input type="checkbox" id="checkbox{{ $email_template->id }}" @if ($email_template->is_active == 1) checked @endif @if (permissionCheck('')) value="{{ $email_template->id }}" class="checkbox" @endif>
                            <div class="slider round"></div>
                        </label>
                    </td>
                    <td>
                        <a class="primary-btn radius_30px mr-10 fix-gr-bg a_btn" href="{{ route('email_templates.manage', $email_template->id) }}">{{ __('general_settings.manage') }}</a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
