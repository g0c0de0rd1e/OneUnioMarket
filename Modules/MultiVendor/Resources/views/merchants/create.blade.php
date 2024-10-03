@extends('backEnd.master')
@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">

    <div class="container-fluid p-0">
        <div class="row justify-content-center mb-40">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex justify-content-between w-100">
                        <h3 class="mb-0 mr-30">{{__('seller.create_a_seller')}}</h3>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="white_box_50px box_shadow_white">
                    <form action="{{ route('admin.merchants_store') }}" method="POST" id="staff_addForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="main-title d-flex">
                                    <h3 class="mb-0 mr-30">{{ __('seller.basic_info') }}</h3>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('seller.subscription_type') }} <span class="text-danger">*</span></label>
                                    <select class="primary_select commission_id" name="commission_id" id="commission_id">
                                        <option disabled selected>{{ __('common.select_one') }}</option>
                                        @foreach ($commissions as $key => $commission)
                                            <option value="{{ $commission->id }}" data-rate="{{ $commission->rate }}"@if(old('commission_id') && old('commission_id') == $commission->id) selected @endif >{{ $commission->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{$errors->first('commission_id')}}</span>
                                </div>
                            </div>
                            <div class="col-md-4" id="commission_rate_div">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.commission_rate') }} <span class="text-danger">*</span></label>
                                    <input type="number" class="primary_input_field commission_rate" name="commission_rate" value="{{old('commission_rate')}}">
                                    <span class="text-danger">{{$errors->first('commission_rate')}}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="primary_input_field" placeholder="{{ __('common.name') }}" name="name" value="{{old('name')}}">
                                    <span class="text-danger">{{$errors->first('name')}}</span>
                                </div>
                            </div>

                            <div class="col-md-4 pricing_div d-none">

                            </div>

                            <div class="col-md-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('seller.shop_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="primary_input_field" placeholder="{{ __('seller.shop_name') }}" name="shop_name" value="{{old('shop_name')}}">
                                    <span class="text-danger">{{$errors->first('shop_name')}}</span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="email">{{ __('common.email') }} <span class="text-danger">*</span></label>
                                    <input name="email" class="primary_input_field" placeholder="{{ __('common.email') }}" type="email" value="{{old('email')}}">
                                    <span class="text-danger">{{$errors->first('email')}}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="email">{{ __('common.phone_number') }} <span class="text-danger">*</span></label>
                                    <input name="phone_number" class="primary_input_field" placeholder="{{ __('common.phone_number') }}" type="text" value="{{old('phone_number')}}">
                                    <span class="text-danger">{{$errors->first('phone_number')}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="password">{{__('common.password')}} <span class="text-danger">*</span></label>
                                    <input type="password" id="password" class="primary_input_field" name="password" value="{{old('password')}}" placeholder="{{__('common.password')}} ">
                                    <span class="text-danger">{{$errors->first('password')}}</span>
                                </div>
                            </div>
                            <input type="hidden" name="admin_creation" value="1">
                            <div class="col-md-6">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="re_password">{{__('common.confirm_password')}} <span class="text-danger">*</span></label>
                                    <input type="password" id="re_password" class="primary_input_field" name="password_confirmation" placeholder="{{__('common.confirm_password')}} " value="{{old('password_confirmation')}}">
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
<input type="hidden" id="get_pricing_url" name="get_pricing_url" value="{{ route('admin.pricing.get_pricing_url') }}">
</section>


@endsection

@push('scripts')
<script type="text/javascript">
(function($){
    "use strict";
    $(document).ready(function(){
        $(document).on('change', '.commission_id', function(){
            var subscription_type = this.value;
            $('.commission_rate').val($('select.commission_id').find(':selected').data('rate'));

            if (subscription_type == 3) {
                $('#pre-loader').removeClass('d-none');
                var get_pricing_url = $('#get_pricing_url').val();
                $.ajax({
                    url: get_pricing_url,
                    type: "GET",
                    dataType: "JSON",
                    success: function (response) {
                        $(".pricing_div").removeClass('d-none');
                        $(".pricing_div").append(response);
                        $('select').niceSelect();
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function (error) {
                        $('#pre-loader').addClass('d-none');
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                    }
                });
            }else {
                $(".pricing_div").addClass('d-none');
            }
            if (subscription_type == 1) {
                $("#commission_rate_div").show();
            }else{
                $("#commission_rate_div").hide();

            }
        });
        checkSelectedCommission();

        function checkSelectedCommission(){
            let type = "{{old('commission_id')}}";
            if(type != '' && type != 1){
                $("#commission_rate_div").hide();
            }
        }
    });
})(jQuery);
</script>
@endpush
