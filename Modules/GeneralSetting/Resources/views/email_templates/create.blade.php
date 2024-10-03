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
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('general_settings.Email Template')}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="white_box_50px box_shadow_white">
                        <form action="{{route('email_templates.store')}}" method="post">
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
                                                        <input type="text" name="subject[{{$language->code}}]" class="primary_input_field" placeholder="{{__('general_settings.subject')}}" value="{{old('subject.'.$language->code)}}">
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
                                        <label class="primary_input_label" for="">{{__('general_settings.subject')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="subject" class="primary_input_field" placeholder="{{__('general_settings.subject')}}" {{old('subject')}}>
                                        <span class="text-danger">{{$errors->first('subject')}}</span>
                                    </div>
                                </div>
                             @endif
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('common.type')}} <span class="text-danger">*</span></label>
                                        <select class="primary_select mb-25" name="type_id" id="type_id">
                                            @foreach ($email_template_types as $key => $type)
                                                @if(!$type->module or isModuleActive($type->module))
                                                @php
                                                switch ($type->type) {
                                                    case 'order_invoice_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.order_invoice_template").'</option>';
                                                    break;
                                                    case 'order_pending_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.order_pending_template").'</option>';
                                                    break;
                                                    case 'order_confirmed_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.order_confirmed_template").'</option>';
                                                    break;
                                                    case 'order_declined_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.order_declined_template").'</option>';
                                                    break;
                                                    case 'paid_payment_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.paid_payment_template").'</option>';
                                                    break;
                                                    case 'order_completed_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.order_completed_template").'</option>';
                                                    break;
                                                    case 'delivery_process_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.delivery_process_template").'</option>';
                                                    break;
                                                    case 'refund_pending_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.refund_pending_template").'</option>';
                                                    break;
                                                    case 'refund_confirmed_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.refund_confirmed_template").'</option>';
                                                    break;
                                                    case 'refund_declined_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.refund_declined_template").'</option>';
                                                    break;
                                                    case 'refund_money_paid_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.refund_money_paid_template").'</option>';
                                                    break;
                                                    case 'refund_completed_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.refund_completed_template").'</option>';
                                                    break;
                                                    case 'refund_process_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.refund_process_template").'</option>';
                                                    break;
                                                    case 'gift_card_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.gift_card_template").'</option>';
                                                    break;
                                                    case 'review_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.review_email_template").'</option>';
                                                    break;
                                                    case 'newsletter_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.newsletter_email_template").'</option>';
                                                    break;
                                                    case 'wallet_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.wallet_email_template").'</option>';
                                                    break;
                                                    case 'order_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.order_email_template").'</option>';
                                                    break;
                                                    case 'register_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.register_email_template").'</option>';
                                                    break;
                                                    case 'notification_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.notification_email_template").'</option>';
                                                    break;
                                                    case 'support_ticket_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.support_ticket_email_template").'</option>';
                                                    break;
                                                    case 'verification_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.verification_email_template").'</option>';
                                                    break;
                                                    case 'product_review_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.product_review_email_template").'</option>';
                                                    break;
                                                    case 'subscription_payment_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.subscription_payment_email_template").'</option>';
                                                    break;
                                                    case 'seller_approve_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.seller_approve_email_template").'</option>';
                                                    break;
                                                    case 'seller_suspended_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.seller_suspended_email_template").'</option>';
                                                    break;
                                                    case 'product_disable_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.product_disable_email_template").'</option>';
                                                    break;
                                                    case 'product_approve_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.product_approve_email_template").'</option>';
                                                    break;
                                                    case 'product_review_approve_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.product_review_approve_email_template").'</option>';
                                                    break;
                                                    case 'product_update_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.product_update_email_template").'</option>';
                                                    break;
                                                    case 'withdraw_request_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.withdraw_request_email_template").'</option>';
                                                    break;
                                                    case 'registration_otp_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.registration_otp_email_template").'</option>';
                                                    break;
                                                    case 'order_otp_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.order_otp_email_template").'</option>';
                                                    break;
                                                    case 'login_otp_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.login_otp_email_template").'</option>';
                                                    break;
                                                    case 'password_reset_otp_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.password_reset_otp_email_template").'</option>';
                                                    break;
                                                    case 'seller_create_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.seller_create_email_template").'</option>';
                                                    break;
                                                    case 'sub_seller_create_email_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.sub_seller_create_email_template").'</option>';
                                                    break;
                                                    case 'Password Reset':
                                                    echo '<option value=" '.$type->id.'">'.__("template.Password Reset").'</option>';
                                                    break;
                                                    case 'Subscription email verify':
                                                    echo '<option value=" '.$type->id.'">'.__("template.Subscription email verify").'</option>';
                                                    break;
                                                    case 'Send digital file':
                                                    echo '<option value=" '.$type->id.'">'.__("template.Send digital file").'</option>';
                                                    break;
                                                    case 'auction_bidder_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.auction_bidder_template").'</option>';
                                                    break;
                                                    case 'auction_seller_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.auction_seller_template").'</option>';
                                                    break;
                                                    case 'auction_order_cancel_template':
                                                    echo '<option value=" '.$type->id.'">'.__("template.auction_order_cancel_template").'</option>';
                                                    break;
                                                }
                                                @endphp
                                                @endif
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('type_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-12 delivery_process_div d-none">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.set_for')}} <span class="text-danger">*</span></label>
                                        <select class="primary_select mb-25" name="delivery_process_id" id="delivery_process_id">
                                            @foreach ($delivery_processes as $key => $delivery_process)
                                                <option value="{{ $delivery_process->id }}">{{ $delivery_process->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('delivery_process_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-12 refund_process_div d-none">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.set_for')}}</label>
                                        <select class="primary_select mb-25" name="refund_process_id" id="refund_process_id">
                                            @foreach ($refund_processes as $key => $refund_process)
                                                <option value="{{ $refund_process->id }}">{{ $refund_process->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">{{$errors->first('refund_process_id')}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.reciepent')}}</label>
                                        <select class="primary_select mb-25" name="reciepnt_type[]" id="reciepnt_type" multiple>
                                            <option value="customer">{{__('general_settings.customer')}}</option>
                                            <option value="admin">{{__('common.admin')}}</option>
                                            @if(isModuleActive('MultiVendor'))
                                            <option value="seller">{{__('general_settings.seller')}}</option>
                                            @endif
                                        </select>
                                        <span class="text-danger">{{$errors->first('reciepnt_type')}}</span>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.short_code')}} <small>({{__('general_settings.use_these_to_get_your_neccessary_info')}})</small> </label>
                                        <label class="primary_input_label red_text" for="">{GIFT_CARD_NAME}, {SECRET_CODE}, {USER_FIRST_NAME}, {USER_EMAIL}, {EMAIL_SIGNATURE}, {ORDER_TRACKING_NUMBER}, {WEBSITE_NAME}, {RESET_LINK},{VERIFICATION_LINK}, {CUSTOM_MESSAGE}, {DIGITAL_FILE_LINK}</label>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{__('general_settings.template')}}</label>
                                        <textarea name="template" class="summernote" placeholder="" >{{ app('general_setting')->email_template }}</textarea>
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
                $(document).on('change', '#type_id', function(){
                    if (this.value == 7) {
                        $(".delivery_process_div").removeClass('d-none');
                        $(".refund_process_div").addClass('d-none');
                    }else if (this.value == 14) {
                        $(".refund_process_div").removeClass('d-none');
                        $(".delivery_process_div").addClass('d-none');
                    }else {
                        $(".delivery_process_div").addClass('d-none');
                        $(".refund_process_div").addClass('d-none');
                    }
                });
            });
        })(jQuery);
    </script>
@endpush
