@extends('frontend.amazy.layouts.app')
@push('styles')
<link rel="stylesheet" href="{{asset(asset_path('frontend/amazy/css/page_css/otp.css'))}}" />
@endpush
@section('title')
{{__('otp.otp')}}
@endsection
@section('content')
<section class="login_area register_part py-5">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-xl-4">
                <div class="register_form_iner">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-center">{{__('otp.otp_is_sent') }} </p>
                    <form method="POST" class="register_form" action="{{ route('order_otp_check') }}">
                        @csrf
                        <div class="row align-items-end mb-3">
                            <div class="col-6">
                                <label for="email">{{ __('otp.otp') }}</label>
                            </div>
                            <div class="col-6">
                                <div class="float-end">
                                    <div id="app"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" id="otp" name="otp" placeholder="{{ __('otp.enter_otp') }}" required value="{{ old('otp') }}" class="@error('otp') is-invalid @enderror primary_input3 radius_5px"
                                    onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = ''">

                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <input type="hidden" id="code_validation_time" name="code_validation_time" value="">
                            <div class="col-md-12 text-center d-flex align-items-center justify-content-between mt-4">
                                <div class="register_area">
                                    <button type="submit" id="btnSubmit" class="amaz_primary_btn style2 radius_5px text-uppercase px-5">{{ __('common.submit') }}</button>
                                </div>
                                <div>
                                    <p> <a href="{{route('order_resend_otp')}}">{{ __('otp.resend_otp') }}</a></p>
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
@include('frontend.default.partials._otp_script')
