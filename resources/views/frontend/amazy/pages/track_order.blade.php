@extends('frontend.amazy.layouts.app')

@section('title')
    {{__('defaultTheme.track_order')}}
@endsection
<style>
    .order_tracking_area{
        padding: 50px 0px;
    }
</style>
@section('content')
    <div class="order_tracking_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-8 col-md-10">
                    <div class="tracking_form">

                        <h3 class="font_30 f_w_700 mb_5">{{__('defaultTheme.track_your_order')}}</h3>
                        <p class="mb-4">{{__('defaultTheme.enter_your_order_id_in_the_box_below_and_press_the_track_button')}}</p>

                        <form action="{{ route('frontend.order.track_find') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 mb_20">
                                    <label class="primary_label2 style2">{{ __('defaultTheme.order_tracking_number') }} <span>*</span></label>
                                    <input id="order_number" name="order_number"
                                    value="{{old('order_number')}}"
                                    placeholder="{{ __('defaultTheme.order_tracking_number') }}" value="{{old('order_number')}}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ __('defaultTheme.order_tracking_number') }}'" class="primary_input3 rounded-0 style2" type="text">
                                    @error('order_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @guest
                                    @if(app('general_setting')->track_order_by_secret_id)
                                        <div class="col-12 mb_20">
                                            <label class="primary_label2 style2">{{ __('defaultTheme.secret_id_only_for_guest_user') }} <span>*</span></label>
                                            <input id="guest_id" name="secret_id"
                                            placeholder="{{ __('defaultTheme.secret_id_only_for_guest_user') }}"
                                            value="{{old('secret_id')}}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{ __('defaultTheme.secret_id_only_for_guest_user') }}'" class="primary_input3 rounded-0 style2" required type="text">
                                            @error('secret_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                @endguest
                                <div class="col-12">
                                    <button class="amaz_primary_btn  rounded-0  w-100 text-uppercase  text-center">{{ __('defaultTheme.track_now') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
