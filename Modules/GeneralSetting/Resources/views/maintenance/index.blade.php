@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/generalsetting/css/style.css'))}}" />
@endsection
<style>
    .removeUpImage{
        position: absolute !important;
        top: -10px;
        left: -10px;
        padding: 0 !important;
        width: 30px;
        height: 30px;
        display: flex !important;
        align-items: center;
        justify-content: center;
        border-radius: 100% !important;        
    }
    .removeUpImage i{
        margin: 0 !important;
    }
   

</style>
@section('mainContent')
    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row pt-20">
                        <div class="main-title pl-3 pt-10">
                            <h3 class="mb-30">{{__('general_settings.maintenance')}} {{__('common.setting')}}</h3>
                        </div>
                    </div>
                    <form class="form-horizontal" action="{{ route('maintenance.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="white-box">
                            <div class="col-md-12 p-0">
                                <div class="row mb-30">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('common.title') }}</label>
                                                    <input class="primary_input_field" placeholder="-" type="text"
                                                           name="title"
                                                           value="{{$setting->maintenance_title}}">
                                                    @error('title')
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                           for="">{{ __('common.sub_title') }}  </label>
                                                    <input class="primary_input_field" placeholder="-" type="text"
                                                           name="subtitle"
                                                           value="{{$setting->maintenance_subtitle}}">
                                                    @error('subtitle')
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="primary_input mb-25">
                                                    <div class="banner_img_div position-relative d-block">
                                                        <div class="removeUpImage primary-btn fix-gr-bg {{$setting->maintenance_banner ? "" : ""}}">
                                                            <i class="fas fa-times"></i>
                                                        </div>
                                                        <img class="imagePreview1 removeUpImage w-100 h-100"
                                                            src="{{showImage($setting->maintenance_banner)}}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="">{{ __('general_settings.maintenance_page_banner') }} ({{getNumberTranslate(1300)}}x{{getNumberTranslate(920)}}) {{__('common.px')}}
                                                    </label>
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary-input  filePlaceholder"
                                                            type="text" id="filePlaceholder"
                                                            placeholder="Browse file"
                                                            readonly="" {{ $errors->has('course_page_banner') ? ' autofocus' : '' }}>
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                   for="file1">{{ __('common.browse') }}</label>
                                                            <input type="file" class="d-none fileUpload imgInput1"
                                                                   name="banner" id="file1">
                                                        </button>
                                                    </div>
                                                    @error('banner')
                                                        <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-xl-6 dripCheck">
                                                <div class="primary_input mb-25">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label class="primary_input_label"
                                                                   for=""> {{__('general_settings.maintenance')}} {{__('general_settings.mode')}}</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <input type="radio"
                                                                           class="common-radio "
                                                                           id="yes"
                                                                           name="status"
                                                                           {{$setting->maintenance_status==1?'checked':''}}
                                                                           value="1">
                                                                    <label
                                                                        for="yes">{{__('common.yes')}}</label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="radio"
                                                                           class="common-radio "
                                                                           id="no"
                                                                           name="status"
                                                                           value="0" {{$setting->maintenance_status==0?'checked':''}}>
                                                                    <label
                                                                        for="no">{{__('common.no')}}</label>
                                                                </div>
                                                            </div>
                                                            @error('status')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row justify-content-center">
                                            @if(session()->has('message-success'))
                                                <p class=" text-success">
                                                    {{ session()->get('message-success') }}
                                                </p>
                                            @elseif(session()->has('message-danger'))
                                                <p class=" text-danger">
                                                    {{ session()->get('message-danger') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(permissionCheck('maintenance.update'))
                            <div class="row mt-40">
                                <div class="col-lg-12 text-center">
                                    <button class="primary-btn fix-gr-bg" data-toggle="tooltip">
                                        <span class="ti-check"></span>
                                        {{__('common.update')}}
                                    </button>
                                </div>
                            </div>
                            @else
                            <span class="text-danger">{{__('common.no_action_permitted')}}</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('change', '#file1', function(event){
                    getFileName($(this).val(),'#filePlaceholder');
                    imageChangeWithFile($(this)[0],'.imagePreview1');
                });
            });
        })(jQuery);
    </script>
     <script>
        $(document).on('change', '.imgInput1', function(event){
            let name = $(this).data('name');
            let view = $(this).data('view');
            getFileName($(this).val(),name);
            imageChangeWithFile($(this)[0], view);
            $('.removeUpImage').removeClass('d-none');
        });

        $(".removeUpImage").click(function(){
            var img_src = $('#uploadImgShow').attr('src');
            if (img_src == '') {
                return false;
            }
            $('#pre-loader').show();
            $('#linkImageClickId').attr('placeholder', '{{__('common.browse_image_file')}}');
            $('.removeUpImage').addClass('d-none');
            $('#uploadImgShow').attr("src","{{ showImage('frontend/default/img/avatar.jpg') }}");
            $('#customerMiniImage').attr("src","{{ showImage('frontend/default/img/avatar.jpg') }}");
            var formData = new FormData();
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('image',img_src);
            $.ajax({
                    url: "{{ route('customer.profile.image.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                            toastr.success("{{__('common.deleted_successfully')}}");
                            $('#pre-loader').hide();
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').hide();
                            return false;
                        }
                        toastr.error("{{__('common.address_already_used')}}", "{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                });
        });
    </script>
@endpush
