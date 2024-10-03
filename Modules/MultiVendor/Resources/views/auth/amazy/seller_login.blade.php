@extends('frontend.amazy.auth.layouts.app')

@section('content')
<div class="amazy_login_area">
    <div class="amazy_login_area_left d-flex align-items-center justify-content-center">
        <div class="amazy_login_form">
            <a href="{{url('/')}}" class="logo mb_50 d-block">
                <img src="{{showImage(app('general_setting')->logo)}}" alt="">
            </a>
            <h3 class="m-0">{{__('amazy.Sign In')}}</h3>
            <p class="support_text">{{__('auth.See your growth and get consulting support!')}}</p>
            @if(config('app.sync'))
                <div class="d-flex justify-content-center mt-20 grid_gap_5 flex-wrap">
                    @if ($seller_email)
                    <button class="amaz_primary_btn style2 radius_5px text-uppercase  text-center mb_25" id="seller" data-email="{{$seller_email}}">{{ __('common.seller') }}</button>
                    @endif
                </div>
            @endif
            <br>


            <form action="{{ route('seller.login_submit') }}" method="POST" name="login" id="login_form">
                @csrf

                @if(config('app.sync'))
                    <input type="hidden" id="auto_login" name="auto_login" value="true">
                @endif
                <div class="row">
                    <div class="col-12 mb_20">
                        <label class="primary_label2">{{ __('amazy.Email address or phone') }} <span>*</span> </label>
                        <input name="login" id="text" placeholder="{{ __('amazy.Email address or phone') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ __('amazy.Email address or phone') }}'" class="primary_input3 radius_5px" type="text">
                        <span class="text-danger" >{{ $errors->first('email') }}</span>
                        <span class="text-danger" >{{ $errors->first('username') }}</span>
                    </div>
                    <div class="col-12 mb_20">
                        <label class="primary_label2">{{ __('common.password') }} <span>*</span></label>
                        <input name="password" id="password" placeholder="{{__('amazy.Min. 8 Character')}}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{__('amazy.Min. 8 Character')}}'" class="primary_input3 radius_5px" type="password">
                        <span class="text-danger" >{{ $errors->first('password') }}</span>
                    </div>
                    @if(env('NOCAPTCHA_FOR_LOGIN') == "true")
                    <div class="col-12 mb_20">
                        @if(env('NOCAPTCHA_INVISIBLE') != "true")
                        <div class="g-recaptcha" data-callback="callback" data-sitekey="{{env('NOCAPTCHA_SITEKEY')}}"></div>
                        @endif
                        <span class="text-danger" >{{ $errors->first('g-recaptcha-response') }}</span>
                    </div>
                    @endif
                    <div class="col-12 mb_20">
                        <label class="primary_checkbox d-flex">
                            <input name="remember" id="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkmark mr_15"></span>
                            <span class="label_name f_w_400 ">{{ __('defaultTheme.remember_me') }}</span>
                        </label>
                    </div>
                    <div class="col-12">
                        @if(env('NOCAPTCHA_INVISIBLE') == "true")
                        <button type="button" class="g-recaptcha amaz_primary_btn style2 radius_5px  w-100 text-uppercase  text-center mb_25" data-sitekey="{{env('NOCAPTCHA_SITEKEY')}}" data-size="invisible" data-callback="onSubmit">{{__('auth.Sign In')}}</button>
                        @else
                        <button class="amaz_primary_btn style2 radius_5px  w-100 text-uppercase  text-center mb_25" id="sign_in_btn">{{__('auth.Sign In')}}</button>
                        @endif
                    </div>
                    <div class="col-12">
                        <p class="sign_up_text">{{__('amazy.Forgot Password?')}} <a href="{{url('/password/reset')}}">{{__('common.click_here')}}</a></p>
                    </div>
                    @if(app('general_setting')->disable_seller_plan==1)
                    <div class="col-12">
                        <p class="sign_up_text">{{__('amazy.Don’t have an Account?')}} <a href="{{url('/merchant-register-step-2/none')}}">{{__('amazy.Sign Up')}}</a></p>
                    </div>
                    @else
                    <div class="col-12">
                        <p class="sign_up_text">{{__('amazy.Don’t have an Account?')}} <a href="{{url('/merchant-register-step-1')}}">{{__('amazy.Sign Up')}}</a></p>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <div class="amazy_login_area_right d-flex align-items-center justify-content-center">
        <div class="amazy_login_area_right_inner d-flex align-items-center justify-content-center flex-column">
            <div class="thumb">
                <img class="img-fluid" src="{{ showImage($loginPageInfo->cover_img) }}" alt="">
            </div>
            <div class="login_text d-flex align-items-center justify-content-center flex-column text-center">
                <h4>{{ isset($loginPageInfo->title)? $loginPageInfo->title:'' }}.</h4>
                <p class="m-0">{{ isset($loginPageInfo->sub_title)? $loginPageInfo->sub_title:'' }}.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function onSubmit(token) {
        document.getElementById("login_form").submit();
    }
</script>
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                $('#submit_btn').removeAttr('disabled');
                $(document).on('submit', '#login_form', function(event){

                    $('#login_form > div > div:nth-child(1) > span:nth-child(3)').text('');
                    $('#login_form > div > div:nth-child(2) > span').text('');
                    $('#login_form > div > div:nth-child(1) > span:nth-child(4)').text('');

                    let email = $('#text').val();
                    let password = $('#password').val();

                    let val_check = 0;

                    if(email == ''){
                        $('#login_form > div > div:nth-child(1) > span:nth-child(3)').text('The email or phone field is required.');
                        val_check = 1;
                    }

                    if(password == ''){
                        $('#login_form > div > div:nth-child(2) > span').text('The password field is required.');
                        val_check = 1;
                    }

                    if(val_check == 1){
                        event.preventDefault();
                    }
                });

                @if(config('app.sync'))
                    $(document).on('click', '#seller', function(event){
                        let email = $(this).data('email');
                        $("#text").val('');
                        $("#password").val('');
                        if(email != ''){
                            $('#submit_btn').attr('disabled', true);
                            $("#text").val(email);
                            $("#password").val('12345678');
                            $('#login_form').submit();
                        }else{
                            toastr.error('Please Create a Seller First.', 'Error');
                        }
                    });
                    $(document).on('change', '#password', function(){
                        let value = $(this).val();
                        if($('#auto_login').length){
                            $('#auto_login').val(value == '12345678');
                        }
                    });
                @endif

            });
        })(jQuery);
    </script>
@endpush
