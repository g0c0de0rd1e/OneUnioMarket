@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{asset(asset_path('modules/paymentgateway/css/style.css'))}}" />
    <style>
        #logo_preview{
            width: 80px;
            height: 70px;
        }
    </style>
@endsection
@section('mainContent')
    <div class="row">
        @php
            $activeAutomaticCarrier = $carriers->where('type','Automatic')->where('status',1)->count();
        @endphp
        <div class="{{$activeAutomaticCarrier > 0 ? 'col-md-5 col-sm-6 col-xs-12': "col-md-12 col-sm-12 col-xs-12"}}">
            <div class="main-title mb-25 d-md-flex">
                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('shipping.carriers') }}</h3>
                <ul class="d-flex">
                    @if(permissionCheck('shipping.carriers.store'))
                        <li>
                            <a  data-toggle="modal" data-target="#add_carrier_modal" class="primary-btn radius_30px mr-10 fix-gr-bg" href="#">
                                <i class="ti-plus"></i> {{ __('common.add_new') }}
                            </a>
                        </li>
                    @endif

                </ul>
            </div>
            <div class="common_QA_section QA_section_heading_custom">
                <div class="QA_table ">
                    <!-- table-responsive -->
                    <div id="carrier_list">
                        @include('shipping::carriers.list')
                    </div>
                </div>
            </div>
        </div>
        @if($activeAutomaticCarrier > 0)
        <div class="col-md-7 col-sm-6 col-xs-12">
            <section class="admin-visitor-area up_st_admin_visitor">
                <div class="container-fluid p-0">
                    <div class="row config_list" id="form_list_div">
                        @include('shipping::carriers.components._config', [$carriers])
                    </div>
                </div>
            </section>
        </div>
        @endif
    </div>
    <div id="append_html"></div>
    @include('shipping::carriers.create')
    @include('backEnd.partials._deleteModalForAjax',['item_name' => __('shipping.carrier'),'form_id' =>'carrier_delete_form','modal_id' => 'carrier_delete_modal', 'delete_item_id' => 'carrier_delete_id'])
    <input type="hidden" value="{{route('shipping.carriers.store')}}" id="carrier_store_url">
    <input type="hidden" value="{{route('shipping.carriers.edit',':id')}}" id="carrier_edit_url">
    <input type="hidden" value="{{route('shipping.carriers.update',':id')}}" id="carrier_update_url">
    <input type="hidden" value="{{route('shipping.carriers.destroy')}}" id="carrier_delete_url">
@endsection
@push('scripts')
<script type="text/javascript">
(function($) {
    "use strict";
    let _token = $('meta[name=_token]').attr('content') ;
    $(document).ready(function(){
        $(document).on('click','.disable_shiprocket',function (){
                toastr.info('Please Configure Shiprocket First');
            })
            $(document).on('change','.carrier_activate', function(){
                let carrier_id = $(this).data('carrier');
                if(this.checked){
                    var status = 1;
                }
                else{
                    var status = 0;
                }
                $('#pre-loader').removeClass('d-none');
                $.post('{{ route('shipping.carriers.status') }}', {_token:'{{ csrf_token() }}', id:this.value, status:status,carrier_id:carrier_id }, function(data){
                    if(data.status === 1){
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        $('#form_list_div').html(data.list);
                        $('#pre-loader').addClass('d-none');
                    }else if(data.status == 'shipping method exsist'){
                        toastr.info("{{__('shipping.Delete Not possible because of shipping rate exist. Change carrier from shipping rate first.')}}", "{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                    else{
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                    location.reload(true);
                }).fail(function(response) {
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        location.reload(true);
                        return false;
                    }
                });
            });
        $(document).on('change', '#shiprocket_logo', function(){
            getFileName($(this).val(),'#shiprocket_image_file');
            imageChangeWithFile($(this)[0],'#ShiprocketImgDiv');
        });
        $('[data-toggle="tooltip"]').tooltip();
        $(document).on('change', '#logo', function(event){
            getFileName($(this).val(),'#logo_name');
            imageChangeWithFile($(this)[0],'#logo_preview');
        });
        $(document).on('submit', '#create_form', function(event){
            event.preventDefault();
            $('#pre-loader').removeClass('d-none');
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name,element.value);
            });
            let logo = $('#logo')[0].files[0];
            if(logo){
                formData.append('logo',logo);
            }
            formData.append('_token',_token);
            let url = $('#carrier_store_url').val();
            resetValidationError();
            $.ajax({
                url: url,
                type:"POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success:function(response){
                    resetAfterChange(response.carrier_list,response.config);
                    create_form_reset();
                    $('#add_carrier_modal').modal('hide');
                    toastr.success("Carrier Add Successfully");
                    $('#pre-loader').addClass('d-none');

                },
                error:function(response) {
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"Error");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                    showValidationErrors('#create_form',response.responseJSON.errors);
                    $('#pre-loader').addClass('d-none');
                }
            });
        });
        $(document).on('click', '.edit_carrier', function(event){
            event.preventDefault();
            $('#pre-loader').removeClass('d-none');
            let id = $(this).data('id');
            let url =  $('#carrier_edit_url').val();
            url = url.replace(':id',id);
            $.get(url, function(response){
                if(response.msg_type == 'Manual'){
                    $('#append_html').html(response.view);
                    $('#edit_carrier_modal').modal('show');
                    $('[data-toggle="tooltip"]').tooltip();
                }else{
                    toastr.error('Automatic Carriers Is Not Editable.');
                }
                $('#pre-loader').addClass('d-none');
            });
        });

        $(document).on('submit', '#update_form', function(event){
            event.preventDefault();
            $('#pre-loader').removeClass('d-none');
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name,element.value);
            });
            let logo = $('#logo')[0].files[0];
            if(logo){
                formData.append('logo',logo);
            }
            formData.append('_token',_token);
            let id = $('#rowId').val();
            let url = $('#carrier_update_url').val();
            url = url.replace(':id',id);
            resetValidationError();
            $.ajax({
                url: url,
                type:"POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success:function(response){
                    resetAfterChange(response.carrier_list,response.config);
                    $('#edit_carrier_modal').modal('hide');
                    $('#pre-loader').addClass('d-none');
                    toastr.success("Carrier Update Successfully");
                },
                error:function(response) {
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"Error");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                    showValidationErrors('#update_form',response.responseJSON.errors);
                    $('#pre-loader').addClass('d-none');
                }
            });
        });
        $(document).on("click", ".delete_carrier", function (event) {
            event.preventDefault();
            let id = $(this).data("id");
            $('#carrier_delete_id').val(id);
            $('#carrier_delete_modal').modal('show');
        });
        $(document).on('submit', '#carrier_delete_form', function(event) {
            event.preventDefault();
            $('#pre-loader').removeClass('d-none');
            $('#carrier_delete_modal').modal('hide');
            var formData = new FormData();
            formData.append('_token', _token);
            formData.append('id', $('#carrier_delete_id').val());
            let url = $('#carrier_delete_url').val();
            $.ajax({
                url: url,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    if(response.msg_type == 'Automatic'){
                        toastr.error('Automatic carrirers delete not possible.');
                    }
                    else if(response.msg_type == 'last_item'){
                        toastr.error('Last carrirer delete not possible.');
                    }
                    else if(response.msg_type == 'has_shipping_method'){
                        toastr.error('This carrier added on Shipping Rate.');
                    }
                    else{
                        toastr.success("Deleted Successfully","Success")
                    }
                    resetAfterChange(response.carrier_list,response.config);
                    $("#pre-loader").addClass('d-none');
                },
                error: function(response) {
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"Error");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                    toastr.error("Error Message","Error");
                }
            });
        });
        function resetAfterChange(list,config){
            $('#carrier_list').html(list);
            $('.config_list').html(config);
            CRMTableTwoReactive();
        }
        function create_form_reset(){
            $('#create_form')[0].reset();
        }
        function showValidationErrors(formType, errors){
            @if(isModuleActive('FrontendMultiLang'))
                $(formType +' #error_name_{{auth()->user()->lang_code}}').text(errors['name.{{auth()->user()->lang_code}}']);
            @else
                $(formType +' #error_name').text(errors.name);
            @endif
            $(formType +' #error_tracking_url').text(errors.tracking_url);
            $(formType +' #error_logo').text(errors.logo);
        }
        function resetValidationError(){
            @if(isModuleActive('FrontendMultiLang'))
            $('#error_name_{{auth()->user()->lang_code}}').text('');
            @else
            $('#error_name').text('');
            @endif
            $('#error_tracking_url').html('');
            $('#error_logo').html('');
        }
    });
})(jQuery);
</script>
@endpush
