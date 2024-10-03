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
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('general_settings.sms_template')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="white_box_50px box_shadow_white">
                    <form action="{{route('sms_templates.store')}}" method="post">
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
                                        <input type="text" name="subject" class="primary_input_field" placeholder="{{__('general_settings.subject')}}">
                                        <span class="text-danger">{{$errors->first('subject')}}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('general_settings.Type')}} <span class="text-danger">*</span></label>
                                    <select class="primary_select mb-25" name="type_id" id="type_id">
                                        @foreach ($sms_template_types as $key => $type)
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
                                                        case 'refund_money_pending_template':
                                                        echo '<option value=" '.$type->id.'">'.__("template.refund_money_pending_template").'</option>';
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
                                                        case 'review_sms_template':
                                                        echo '<option value=" '.$type->id.'">'.__("template.review_sms_template").'</option>';
                                                        break;
                                                        case 'bulk_sms_template':
                                                        echo '<option value=" '.$type->id.'">'.__("template.bulk_sms_template").'</option>';
                                                        break;
                                                        case 'order_sms_template':
                                                        echo '<option value=" '.$type->id.'">'.__("template.order_sms_template").'</option>';
                                                        break;
                                                        case 'register_sms_template':
                                                        echo '<option value=" '.$type->id.'">'.__("template.register_sms_template").'</option>';
                                                        break;
                                                        case 'notification_sms_template':
                                                        echo '<option value=" '.$type->id.'">'.__("template.notification_sms_template").'</option>';
                                                        break;
                                                        case 'support_ticket_sms_template':
                                                        echo '<option value=" '.$type->id.'">'.__("template.support_ticket_sms_template").'</option>';
                                                        break;
                                                        case 'wallet_offline_recharge':
                                                        echo '<option value=" '.$type->id.'">'.__("template.wallet_offline_recharge").'</option>';
                                                        break;
                                                        case 'wallet_online_recharge':
                                                        echo '<option value=" '.$type->id.'">'.__("template.wallet_online_recharge").'</option>';
                                                        break;
                                                        case 'withdraw_request_approve':
                                                        echo '<option value=" '.$type->id.'">'.__("template.withdraw_request_approve").'</option>';
                                                        break;
                                                        case 'withdraw_request_declined':
                                                        echo '<option value=" '.$type->id.'">'.__("template.withdraw_request_declined").'</option>';
                                                        break;
                                                        case 'Product disable':
                                                        echo '<option value=" '.$type->id.'">'.__("template.Product disable").'</option>';
                                                        break;
                                                        case 'Seller product approval':
                                                        echo '<option value=" '.$type->id.'">'.__("template.Seller product approval").'</option>';
                                                        break;
                                                        case 'Seller product update':
                                                        echo '<option value=" '.$type->id.'">'.__("template.Seller product update").'</option>';
                                                        break;
                                                        case 'Seller payout':
                                                        echo '<option value=" '.$type->id.'">'.__("template.Seller payout").'</option>';
                                                        break;
                                                        case 'Seller payout request':
                                                        echo '<option value=" '.$type->id.'">'.__("template.Seller payout request").'</option>';
                                                        break;
                                                        case 'Seller approved':
                                                        echo '<option value=" '.$type->id.'">'.__("template.Seller approved").'</option>';
                                                        break;
                                                        case 'Seller suspended':
                                                        echo '<option value=" '.$type->id.'">'.__("template.Seller suspended").'</option>';
                                                        break;
                                                        case 'registration_templete':
                                                        echo '<option value=" '.$type->id.'">'.__("template.registration_templete").'</option>';
                                                        break;
                                                        case 'order_confirmation_templete':
                                                        echo '<option value=" '.$type->id.'">'.__("template.order_confirmation_templete").'</option>';
                                                        break;
                                                        case 'login_otp_templete':
                                                        echo '<option value=" '.$type->id.'">'.__("template.login_otp_templete").'</option>';
                                                        break;
                                                        case 'Password_reset_otp_templete':
                                                        echo '<option value=" '.$type->id.'">'.__("template.Password_reset_otp_templete").'</option>';
                                                        break;
                                                        case 'order_processing_templete':
                                                        echo '<option value=" '.$type->id.'">'.__("template.order_processing_templete").'</option>';
                                                        break;
                                                        case 'order_shipped_templete':
                                                        echo '<option value=" '.$type->id.'">'.__("template.order_shipped_templete").'</option>';
                                                        break;
                                                        case 'order_recieved_templete':
                                                        echo '<option value=" '.$type->id.'">'.__("template.order_recieved_templete").'</option>';
                                                        break;
                                                    }
                                                @endphp
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{$errors->first('type_id')}}</span>
                                </div>
                            </div>
                            <div class="col-xl-6 delivery_process_div d-none">
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
                            <div class="col-xl-6 refund_process_div d-none">
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
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('general_settings.reciepent')}}</label>
                                    <select class="primary_select mb-25" name="reciepnt_type[]" id="reciepnt_type" multiple>
                                        <option value="customer">{{__('general_settings.customer')}}</option>
                                        @if(isModuleActive('MultiVendor'))
                                        <option value="seller">{{__('general_settings.seller')}}</option>
                                        @endif
                                    </select>
                                    <span class="text-danger">{{$errors->first('reciepnt_type')}}</span>
                                </div>
                            </div>
                            
                            <div class="col-xl-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('general_settings.short_code')}} <small>({{__('general_settings.use_these_to_get_your_neccessary_info')}})</small> </label>
                                    <label class="primary_input_label red_text" for="">{GIFT_CARD_NAME}, {SECRET_CODE}, {USER_FIRST_NAME}, {USER_EMAIL}, {ORDER_TRACKING_NUMBER}, {WEBSITE_NAME}</label>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{__('general_settings.template')}}</label>
                                    <textarea name="template" class="form-control primary_input_field" rows="10" placeholder="" >hello</textarea>
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
