@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<div class="modal fade admin-query" id="edit_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.edit') }}</h4>
                <button type="button" class="close " data-dismiss="modal"> <i class="ti-close "></i> </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="edit_form">
                    @csrf
                    <input type="hidden" name="id" id="notificaion_id">
                    <div class="row">
                        @if(isModuleActive('FrontendMultiLang'))
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                    @foreach ($LanguageList as $key => $language)
                                        <li class="nav-item lang_code" data-id="{{$language->code}}">
                                            <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($LanguageList as $key => $language)
                                        <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="event">{{ __('common.notification') }}{{ __('hr.event') }} <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" type="text" id="event_{{$language->code}}" class="form-control" name="event[{{$language->code}}]" autocomplete="off" value="">
                                                        <span class="text-danger" id="error_event_{{$language->code}}"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="message"> {{__('general_settings.message_for_particular_user')}} <span class="text-danger">*</span></label>
                                                        <textarea name="message[{{$language->code}}]" id="message_{{$language->code}}" cols="30" class="form-control primary_input_field" placeholder="Message" rows="5"></textarea>
                                                        <span class="text-danger" id="error_message_{{$language->code}}"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="message"> {{__('general_settings.message_for_admin_site')}}<span class="text-danger">*</span></label>
                                                        <textarea name="admin_msg[{{$language->code}}]" id="admin_msg_{{$language->code}}" cols="30" class="form-control primary_input_field" placeholder="Message" rows="5"></textarea>
                                                        <span class="text-danger" id="error_admin_msg_{{$language->code}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="event">{{ __('common.notification') }}{{ __('hr.event') }} <span class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="event" class="form-control" name="event" autocomplete="off" value="">
                                    <span class="text-danger" id="error_event"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="message"> {{__('general_settings.message_for_particular_user')}} <span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" cols="30" class="form-control primary_input_field" placeholder="Message" rows="5"></textarea>
                                    <span class="text-danger" id="error_message"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="message"> {{__('general_settings.message_for_admin_site')}}<span class="text-danger">*</span></label>
                                    <textarea name="admin_msg" id="admin_msg" cols="30" class="form-control primary_input_field" placeholder="Message" rows="5"></textarea>
                                    <span class="text-danger" id="error_admin_msg"></span>
                                </div>
                            </div>  
                        @endif
                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="type">{{ __('common.notification') }} {{ __('common.type') }}<span class="text-danger">*</span></label>
                                    <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                        <input name="type[]" value="email" class="notification-type" type="checkbox" id="notification_email">
                                        <span class="checkmark"></span>  &nbsp;{{__('common.email')}}
                                    </label>
                                    <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                        <input name="type[]" value="mobile" class="notification-type" type="checkbox" id="notification_mobile">
                                        <span class="checkmark"></span>  &nbsp;{{__('common.mobile')}}
                                    </label>
                                    <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                        <input name="type[]" value="system" class="notification-type" type="checkbox" id="notification_system">
                                        <span class="checkmark"></span>  &nbsp;{{__('common.system')}}
                                    </label>
                                    <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                        <input name="type[]" value="sms" class="notification-type" type="checkbox" id="notification_sms">
                                        <span class="checkmark"></span>  &nbsp;{{__('common.sms')}}
                                    </label>
                                    <span class="text-danger" id="error_type"></span>   
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="primary_input">
                            <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
