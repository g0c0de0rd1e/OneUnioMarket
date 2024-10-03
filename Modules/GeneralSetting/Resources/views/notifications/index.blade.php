@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/generalsetting/css/style.css'))}}" />
@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.system') }} {{ __('common.notification') }} {{ __('common.setting') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="">
                            <table class="table Crm_table_active3">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('common.sl') }}</th>
                                        <th scope="col">{{ __('hr.event') }}</th>
                                        <th scope="col">{{ __('common.type') }}</th>
                                        <th scope="col">{{ __('common.message') }}</th>
                                        <th scope="col">{{ __('common.action')  }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- shortby  -->
                                    </td>
                                    </tr>
                                    @foreach($notificationSettings as $notificationSetting)
                                        @if(!$notificationSetting->module or isModuleActive($notificationSetting->module))
                                        <tr>
                                            <th>{{ getNumberTranslate($loop->index +1) }}</th>
                                            <td>{{ $notificationSetting->event }}</td>
                                            <td>
                                                <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                    <input disabled  name="status" id="status" value="1"
                                                    @if (Str::contains($notificationSetting->type,'email')) checked @endif
                                                    type="checkbox">
                                                    <span class="checkmark"></span> &nbsp;{{__('common.email')}}
                                                </label>
                                                <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                    <input disabled  name="status" id="status" value="1"
                                                    @if (Str::contains($notificationSetting->type,'mobile')) checked @endif
                                                    type="checkbox">
                                                    <span class="checkmark"></span> &nbsp;{{__('common.mobile')}}
                                                </label>
                                                <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                    <input disabled  name="status" id="status" value="1"
                                                    @if (Str::contains($notificationSetting->type,'sms')) checked @endif
                                                    type="checkbox">
                                                    <span class="checkmark"></span> &nbsp;{{__('common.sms')}}
                                                </label>
                                                <label data-id="bg_option" class="margin-type primary_checkbox d-flex mr-12">
                                                    <input disabled  name="status" id="status" value="1"
                                                    @if (Str::contains($notificationSetting->type,'system')) checked @endif
                                                    type="checkbox">
                                                    <span class="checkmark"></span> &nbsp;{{__('common.system')}}
                                                </label>
                                            </td>
                                            <td>{{ $notificationSetting->message }}</td>
                                            <td>
                                                @if(permissionCheck('notificationsetting.edit'))
                                                    <button data-value="{{$notificationSetting}}" class="primary-btn radius_30px mr-10 fix-gr-bg edit_notification" >{{ __('common.edit') }}</button>
                                                @endif
                                            </td>
                                        </tr>

                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('generalsetting::notifications.edit_modal')
</section>
@endsection
@push('scripts')
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('click', '.edit_notification', function(event){
                    let notification = $(this).data('value');
                    @if(isModuleActive('FrontendMultiLang'))
                    if (notification.event != null) {
                        $.each(notification.event, function( key, value ) {
                            $("#event_"+key).val(value);
                        });
                    }else{
                        $("#event_{{auth()->user()->lang_code}}").val(notification.translateevent);
                    }
                    if (notification.message != null) {
                        $.each(notification.message, function( key, value ) {
                            $("#message_"+key).val(value);
                        });
                    }else{
                        $("#message_{{auth()->user()->lang_code}}").val(notification.Translatemessage);
                    }
                    if (notification.admin_msg != null) {
                        $.each(notification.admin_msg, function( key, value ) {
                            $("#admin_msg_"+key).val(value);
                        });
                    }else{
                        $("#admin_msg_{{auth()->user()->lang_code}}").val(notification.Translateadminmessage);
                    }
                    @else
                    $('#event').val(notification.event);
                    $('#message').text(notification.message);
                    $('#admin_msg').text(notification.admin_msg);
                    @endif
                    $('#notificaion_id').val(notification.id);
                    if(notification.type.includes('email')){
                        $('#notification_email').attr('checked',true);
                    }else{
                        $('#notification_email').removeAttr('checked');
                    }
                    if(notification.type.includes('mobile')){
                        $('#notification_mobile').attr('checked',true);
                    }else{
                        $('#notification_mobile').removeAttr('checked');
                    }
                    if(notification.type.includes('system')){
                        $('#notification_system').attr('checked',true);
                    }else{
                        $('#notification_system').removeAttr('checked');
                    }
                    if(notification.type.includes('sms')){
                        $('#notification_sms').attr('checked',true);
                    }else{
                        $('#notification_sms').removeAttr('checked');
                    }
                    $('#edit_modal').modal('show');
                });
            $(document).on('submit', '#edit_form', function(event) {
                event.preventDefault();
                $("#pre-loader").removeClass('d-none');
                let id = $('#notificaion_id').val()
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                resetValidationErrors();
                $.ajax({
                    url: "{{ route('notificationsetting.update')}}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        window.location.reload();
                        toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                        $("#pre-loader").addClass('d-none');
                    },
                    error: function(response) {
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        showValidationErrors(response.responseJSON.errors);
                        $("#pre-loader").addClass('d-none');
                    }
                });
            });
            function showValidationErrors(errors) {
            @if(isModuleActive('FrontendMultiLang'))
                $('#error_event_{{auth()->user()->lang_code}}').text(errors['event.{{auth()->user()->lang_code}}']);
                $('#error_message_{{auth()->user()->lang_code}}').text(errors['message.{{auth()->user()->lang_code}}']);
                $('#error_admin_msg_{{auth()->user()->lang_code}}').text(errors['admin_msg.{{auth()->user()->lang_code}}']);
            @else
                $('#error_event').text(errors.event);
                $('#error_message').text(errors.message);
                $('#error_admin_msg').text(errors.admin_msg);
            @endif
                $('#error_type').text(errors.type);
            }
            function resetValidationErrors(){
                @if(isModuleActive('FrontendMultiLang'))
                $('#error_event_{{auth()->user()->lang_code}}').text('');
                $('#error_message_{{auth()->user()->lang_code}}').text('');
                $('#error_admin_msg_{{auth()->user()->lang_code}}').text('');
                @else
                $('#error_event').text('');
                $('#error_message').text('');
                $('#error_admin_msg').text('');
                @endif
                $('#error_type').text('');
            }
            });
        })(jQuery);
    </script>
@endpush
