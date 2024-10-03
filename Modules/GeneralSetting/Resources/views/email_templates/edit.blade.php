@extends('backEnd.master')
@section('mainContent')
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('general_settings.Email Template')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="white_box_50px box_shadow_white">
                    <form action="{{route('email_templates.update', $email_template->id)}}" method="post">
                        @csrf
                        <!-- content  -->
                        <div class="row">
                            @if(isModuleActive('FrontendMultiLang'))
                                <div class="col-lg-12">
                                    <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                        @foreach ($LanguageList as $key => $language)
                                            <li class="nav-item">
                                                <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($LanguageList as $key => $language)
                                            <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="">{{__('general_settings.subject')}} <span class="text-danger">*</span></label>
                                                        <input type="text" name="subject[{{$language->code}}]" class="primary_input_field" placeholder="{{__('general_settings.subject')}}" value="{{isset($email_template)?$email_template->getTranslation('subject',$language->code):old('subject.'.$language->code)}}">
                                                        <span class="text-danger">{{$errors->first('subject')}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.subject')}}</label>
                                        <input type="text" name="subject" class="primary_input_field" placeholder="{{__('general_settings.subject')}}" value="{{ $email_template->subject }}">
                                        <span class="text-danger">{{$errors->first('subject')}}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('common.type')}} <span class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="primary_input_field" placeholder="{{__('common.type')}}" value=" @php
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
                                    @endphp {{ ($email_template->relatable_type != null) ? '( '.$email_template->relatable->name.' )' : '' }}" disabled>
                                    <span class="text-danger">{{$errors->first('type_id')}}</span>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('general_settings.reciepent')}}</label>
                                    <select class="primary_select mb-25" name="reciepnt_type[]" id="reciepnt_type" multiple>
                                        <option value="customer" @if (in_array("customer", json_decode($email_template->reciepnt_type))) selected @endif>{{__('general_settings.customer')}}</option>
                                        <option value="admin" @if (in_array("admin", json_decode($email_template->reciepnt_type))) selected @endif>{{__('common.admin')}}</option>
                                        @if(isModuleActive('MultiVendor'))
                                          <option value="seller" @if (in_array("seller", json_decode($email_template->reciepnt_type))) selected @endif>{{__('general_settings.seller')}}</option>
                                        @endif
                                    </select>
                                    <span class="text-danger">{{$errors->first('reciepnt_type')}}</span>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('general_settings.short_code')}} <small>({{__('general_settings.use_these_to_get_your_neccessary_info')}})</small> </label>
                                    <label class="primary_input_label red_text" for="">{{ $email_template->short_codes }}</label>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('general_settings.template')}}</label>
                                    <textarea name="template" class="summernote" placeholder="" >{{ $email_template->value }}</textarea>
                                    <span class="text-danger">{{$errors->first('template')}}</span>
                                </div>
                            </div>

                        </div>
                        <div class="submit_btn text-center mb-100 pt_15">
                            <button class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.save') }}</button>
                        </div>
                        <!-- content  -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function() {
                $('.summernote').summernote({
                    placeholder: '',
                    tabsize: 5,
                    minHeight: 600,
                    maxHeight: 800,
                    codeviewFilter: true,
			        codeviewIframeFilter: true,
                    callbacks: {
                        onImageUpload: function (files) {
                            sendFile(files, '.summernote')
                        }
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
