@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/seller/css/sub_seller.css'))}}" />

@endsection
@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">

    <div class="container-fluid p-0">
        <div class="row justify-content-center mb-40">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex justify-content-between w-100">
                        <h3 class="mb-0 mr-30">{{__('seller.update_staff_info')}}</h3>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <form action="{{ route('seller.sub_seller.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30">{{ __('seller.basic_info') }}</h3>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.first_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="primary_input_field" placeholder="{{ __('common.first_name') }}" name="first_name" value="{{old('first_name')?old('first_name'):$user->first_name}}">
                                    <span class="text-danger">{{$errors->first('first_name')}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.last_name') }}</label>
                                    <input type="text" class="primary_input_field" placeholder="{{ __('common.last_name') }}" name="last_name" value="{{old('last_name')?old('last_name'):$user->last_name}}">
                                    <span class="text-danger">{{$errors->first('last_name')}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="email">{{ __('common.email') }} <span class="text-danger">*</span></label>
                                    <input name="email" class="primary_input_field" placeholder="{{ __('common.email') }}" type="email" value="{{$user->email}}">
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="password">{{__('common.password')}} <span class="text-danger"></span></label>
                                    <input type="password" id="password" class="primary_input_field" name="password" value="{{old('password')}}" placeholder="{{__('common.password')}}">
                                    <span class="text-danger">{{$errors->first('password')}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="re_password">{{__('common.confirm_password')}} <span class="text-danger"></span></label>
                                    <input type="password" id="re_password" class="primary_input_field" name="password_confirmation" placeholder="{{__('common.confirm_password')}}" value="{{old('password_confirmation')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="phone">{{__('common.phone')}} <span class="text-danger"></span></label>
                                    <input type="text" id="phone" class="primary_input_field" name="phone" value="{{old('phone')?old('phone'):$user->sub_seller->phone}}" placeholder="018XXXXXXX">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="address">{{__('common.address')}} <span class="text-danger"></span></label>
                                    <input type="text" id="address" class="primary_input_field" name="address" value="{{old('address')?old('address'):$user->sub_seller->address}}" placeholder="{{__('common.address')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="address">{{__('common.avatar')}} (165x165)PX <span class="text-danger"></span></label>
                                    <div class="primary_file_uploader">
                                      <input class="primary-input" type="text" id="photo" placeholder="{{__('common.browse_image_file')}}" readonly="">
                                      <button class="" type="button">
                                          <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.avatar")}} </label>
                                          <input type="file" class="d-none" name="photo" id="document_file_1">
                                      </button>
                                   </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="avatar_div">
                                    <img id="logoImg" src="{{ ($user->avatar) ? showImage($user->avatar) : showImage('backend/img/default.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i class="ti-check"></i>{{ __('common.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
                $(document).on('change', '#document_file_1', function(){
                    getFileName($(this).val(),'#photo');
                    imageChangeWithFile($(this)[0],'#logoImg');
                });
            });
        })(jQuery);
    </script>
@endpush
