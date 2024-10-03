@extends('frontend.amazy.layouts.app')
@section('title')
    {{ __('defaultTheme.select_payment') }}
@endsection
@section('content')
    <!-- checkout_v3_area::start  -->
    <div id="mainDiv">
        @include('frontend.amazy.partials._payment_step_details')
    </div>
    <!-- checkout_v3_area::end  -->
@endsection

@push('scripts')
@php
    $public_code = null;
    $payment = DB::table('payment_methods')->where('method','Tabby')->where('active_status',1)->first();
    if($payment)
    {
        $tabby_gateway = getPaymentGatewayInfo($payment->id);
        if($tabby_gateway){
            $public_code = $tabby_gateway->perameter_1;
        }
    }

@endphp
@if(!empty($public_code))
    <script src="https://checkout.tabby.ai/tabby-card.js"></script>
    <script>
            let amount = $("#total_amount").attr('data-amount');
            new TabbyCard({
                selector: '#tabbyCard', // empty div for TabbyCard.
                currency: 'AED', // required, currency of your product. AED|SAR|KWD|BHD|QAR only supported, with no spaces or lowercase.
                lang: 'en', // Optional, language of snippet and popups.
                price: amount, // required, total price or the cart. 2 decimals max for AED|SAR|QAR and 3 decimals max for KWD|BHD.
                size: 'wide', // required, can be also 'wide', depending on the width.
                theme: '#18171c', // required, can be also 'default'.
                header: true // if a Payment method name present already.
            });
    </script>
@endif



    @if(isModuleActive('Bkash'))
        @php
            if(session()->has('order_payment') && app('general_setting')->seller_wise_payment && session()->has('seller_for_checkout')){
                $credential = getPaymentInfoViaSellerId(session()->get('seller_for_checkout'), 15);
            }else{
                $credential = getPaymentInfoViaSellerId(1, 15);
            }
        @endphp
        @include('bkash::partials._bkash_data', ['credential' => $credential])
    @endif

    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $(document).on('change', 'input[type=radio][name=payment_method]', function(){
                    let method = $(this).data('name');
                    console.log(method);
                    $('#order_payment_method').val($(this).val());
                    let payment_id = $('#off_payment_id').val();
                    let gateway_id = $(this).data('id');
                    let baseUrl = $('#url').val();
                    let id = $(this).val();
                    if(method === 'Cash On Delivery'){
                        var url = baseUrl + '/checkout?gateway_id='+gateway_id+'&payment_id='+payment_id+'&step=complete_order';
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="CashOnDelivery" data-url="`+url+`" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.order_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    if(method === 'Wallet'){
                        var url = baseUrl + '/checkout?gateway_id='+gateway_id+'&payment_id='+payment_id+'&step=complete_order';
                        $('#btn_div').html(`<a href="javascript:void(0)" data-url="`+url+`" id="payment_btn_trigger" data-type="Wallet" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }

                    if(method === 'Stripe'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Stripe" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'Bkash'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Bkash" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'SslCommerz'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="SslCommerz" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'Mercado Pago'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Mercado Pago" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }
                    else if(method === 'Tabby'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Tabby" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }
                    else if(method === 'CCAvenue'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="CCAvenue" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }
                    else if(method === 'PayPal'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="PayPal" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'PayStack'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="PayStack" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'RazorPay'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="RazorPay" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'Instamojo'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Instamojo" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }
                    else if(method === 'PayTM'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="PayTM" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }
                    else if(method === 'Midtrans'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Midtrans" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'PayUMoney'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="PayUMoney" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }
                    else if(method === 'JazzCash'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="JazzCash" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'Google Pay'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Google Pay" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                        $('#acc_'+id).addClass('d-none');
                    }
                    else if(method === 'FlutterWave'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="FlutterWave" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }
                    else if(method === 'Bank Payment'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Bank Payment" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }else if(method == 'Clickpay'){
                        $('#btn_div').html(`<a href="javascript:void(0)" id="payment_btn_trigger" data-type="Clickpay" class="amaz_primary_btn style2  min_200 text-center text-uppercase">{{__("hr.pay_now")}}</a>`);
                    }

                });

                $(document).on('click', '#payment_btn_trigger', function(event){
                    let method = $(this).data('type');
                    let is_same_billing = $('input[type=radio][name=is_same_billing]:checked').val();
                    $('#error_name').text('');
                    $('#error_email').text('');
                    $('#error_phone').text('');
                    $('#error_address').text('');
                    $('#error_country').text('');
                    $('#error_state').text('');
                    $('#error_city').text('');
                    let is_true = 0;
                    if(is_same_billing == 0){
                        if($('#name').val() == ''){
                            $('#error_name').text('{{__("validation.this_field_is_required")}}');
                            is_true = 1;
                        }
                        if($('#email').val() == ''){
                            $('#error_email').text('{{__("validation.this_field_is_required")}}');
                            is_true = 1;
                        }
                        if($('#phone').val() == ''){
                            $('#error_phone').text('{{__("validation.this_field_is_required")}}');
                            is_true = 1;
                        }
                        if($('#address').val() == ''){
                            $('#error_address').text('{{__("validation.this_field_is_required")}}');
                            is_true = 1;
                        }
                        if($('#country').val() == ''){
                            $('#error_country').text('{{__("validation.this_field_is_required")}}');
                            is_true = 1;
                        }
                        if($('#state').val() == ''){
                            $('#error_state').text('{{__("validation.this_field_is_required")}}');
                            is_true = 1;
                        }
                        if($('#city').val() == ''){
                            $('#error_city').text('{{__("validation.this_field_is_required")}}');
                            is_true = 1;
                        }
                        if('{{isModuleActive('ShipRocket')}}'){
                            $('#error_postal_code').text('{{__("validation.this_field_is_required")}}');
                            is_true = 1;
                        }
                        if(is_true === 1){
                            return false;
                        }
                        let data = {
                            address_id: $('#address_id').val(),
                            name: $('#name').val(),
                            email: $('#email').val(),
                            address: $('#address').val(),
                            phone: $('#phone').val(),
                            country: $('#country').val(),
                            state: $('#state').val(),
                            city: $('#city').val(),
                            postal_code: $('#postal_code').val(),
                            _token: $('#token').val()
                        }
                        $('#pre-loader').show();
                        $.post("{{route('frontend.checkout.billing.address.store')}}",data, function(response){
                            if("{{isModuleActive('GoldPrice')}}" == 1){
                                $.post("{{route('frontend.checkout.check-cart-price-update')}}", {_token:"{{csrf_token()}}"}, function(response){
                                    if(response.count > 0){
                                        toastr.info('Cart Price Updated. Try again with updated price', 'Info');
                                        location.reload();
                                    }else{
                                        paymentAction(method);
                                    }
                                    $('#pre-loader').hide();
                                });
                            }else{
                                paymentAction(method);
                                $('#pre-loader').hide();
                            }
                        }).fail(function(response) {
                            $('#error_name').text(response.responseJSON.errors.name);
                            $('#error_address').text(response.responseJSON.errors.address);
                            $('#error_email').text(response.responseJSON.errors.email);
                            $('#error_phone').text(response.responseJSON.errors.phone);
                            $('#error_country').text(response.responseJSON.errors.country);
                            $('#error_state').text(response.responseJSON.errors.state);
                            $('#error_city').text(response.responseJSON.errors.city);
                            return false;
                        });

                    }else{
                        if("{{isModuleActive('GoldPrice')}}" == 1){
                            $('#pre-loader').show();
                            $.post("{{route('frontend.checkout.check-cart-price-update')}}", {_token:"{{csrf_token()}}"}, function(response){
                                if(response.count > 0){
                                    toastr.info('Cart Price Updated. Try again with updated price', 'Info');
                                    location.reload();
                                }else{
                                    paymentAction(method);
                                }
                                $('#pre-loader').hide();
                            });
                        }else{
                            paymentAction(method);
                        }
                    }

                });
                function paymentAction(method){
                    if(method == 'CashOnDelivery' || method == 'Wallet'){
                        var dataUrl = $('#payment_btn_trigger').data('url');
                        location.href = dataUrl;
                    }
                    else if(method == 'Stripe'){
                        $('#stribe_submit_btn').click();
                        $('#pre-loader').show();
                    }
                    else if(method == 'PayPal'){
                        $('.paypal_btn').click();
                    }
                    else if(method == 'PayStack'){
                        $('#paystack_btn').click();
                    }
                    else if(method == 'RazorPay'){
                        $('#razorpay_btn').click();
                    }
                    else if(method == 'Instamojo'){
                        $("#instamojo_btn").click();
                    }
                    else if(method == 'PayTM'){
                        $("#paytm_btn").click();
                    }
                    else if(method == 'Midtrans'){
                        $("#midtrans_btn").click();
                    }
                    else if(method == 'PayUMoney'){
                        $("#payumoney_btn").click();
                    }
                    else if(method == 'JazzCash'){
                        $("#jazzcash_btn").click();
                    }
                    else if(method == 'Google Pay'){
                        $("#buyButton").click();
                    }
                    else if(method == 'FlutterWave'){
                        $("#flutterwave_btn").click();
                    }
                    else if(method == 'Bank Payment'){
                        $("#bank_btn").click();
                    }
                    else if(method == 'Bkash'){
                        $("#bKash_button").click();
                    }

                    else if(method == 'SslCommerz'){
                        $("#ssl_commerz_form").submit();
                    }
                    else if(method == 'Mercado Pago'){
                        mercado_field_validate();
                        $("#form-checkout__submit").click();
                    }
                    else if(method == 'Tabby'){
                        $("#tabby_btn").click();
                    }
                    else if(method == 'CCAvenue'){
                        $("#ccavenue_btn").click();
                    }else if(method == 'Clickpay'){
                        $("#Clickpay_form").submit();
                    }
                }

                function mercado_field_validate() {

                    let cardholderName = $('#form-checkout__cardholderName').val();
                    let cardholderEmail = $('#form-checkout__cardholderEmail').val();
                    let cardNumber = $('#form-checkout__cardNumber').val();
                    let cardExpirationDate = $('#form-checkout__cardExpirationDate').val();
                    let securityCode = $('#form-checkout__securityCode').val();
                    let installments = $('#form-checkout__installments').val();
                    let identificationType = $('#form-checkout__identificationType').val();
                    let identificationNumber = $('#form-checkout__identificationNumber').val();
                    let issuer = $('#form-checkout__issuer').val();

                    if (cardholderName == null) {
                        toastr.error('Cardholder name required');
                        return false;
                    }

                    if (cardholderEmail == null) {
                        toastr.error('Email required');
                        return false;
                    }

                    if (cardNumber == null) {
                        toastr.error('CardNumber required');
                        return false;
                    }

                    if (cardExpirationDate == null) {
                        toastr.error('Card Expiration Date required');
                        return false;
                    }

                    if (securityCode == null) {
                        toastr.error('Security Code required');
                        return false;
                    }

                    if (installments == null) {
                        toastr.error('Installments required');
                        return false;
                    }

                    if (identificationType == null) {
                        toastr.error('Identification Type required');
                        return false;
                    }

                    if (identificationNumber == null) {
                        toastr.error('Identification Number required');
                        return false;
                    }

                    if (issuer == null) {
                        toastr.error('issuer required');
                        return false;
                    }
                }

                $(document).on('change', '#address_id', function(event) {
                    let data = {
                        _token:"{{csrf_token()}}",
                        id: $(this).val()
                    }
                    $('#pre-loader').show();
                    $.post("{{route('frontend.checkout.address.billing')}}",data, function(res){
                        $('#pre-loader').hide();
                        let address = res.address;
                        let states = res.states;
                        let cities = res.cities;
                        $('#name').val(address.name);
                        $('#address').val(address.address);
                        $('#email').val(address.email);
                        $('#phone').val(address.phone);
                        $('#postal_code').val(address.postal_code);
                        $('#country').val(address.country);

                        $('#state').empty();
                        $('#state').append(
                            `<option value="">{{__("common.select_from_options")}}</option>`
                        );
                        $.each(states, function(index, stateObj) {
                            $('#state').append('<option value="' + stateObj
                                .id + '">' + stateObj.name + '</option>');
                        });
                        $('#state').val(address.state);

                        $('#city').empty();
                        $('#city').append(
                            `<option value="">{{__("common.select_from_options")}}</option>`
                        );
                        $.each(cities, function(index, cityObj) {
                            $('#city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                        });
                        $('#city').val(address.city);
                        $('select').niceSelect('update');

                    });
                });

                $(document).on('change', '#country', function(event) {
                    let country = $('#country').val();
                    $('#pre-loader').show();
                    if (country) {
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-state?country_id=' + country;

                        $('#state').empty();

                        $('#state').append(
                            `<option value="">{{__("common.select_from_options")}}</option>`
                        );
                        $('#state').niceSelect('update');
                        $('#city').empty();
                        $('#city').append(
                            `<option value="">{{__("common.select_from_options")}}</option>`
                        );
                        $('#city').niceSelect('update');
                        $.get(url, function(data) {

                            $.each(data, function(index, stateObj) {
                                $('#state').append('<option value="' + stateObj
                                    .id + '">' + stateObj.name + '</option>');
                            });

                            $('#state').niceSelect('update');
                            $('#pre-loader').hide();
                        });
                    }
                });

                $(document).on('change', '#state', function(event){
                    let state = $('#state').val();
                    $('#pre-loader').show();
                    if(state){
                        let base_url = $('#url').val();
                        let url = base_url + '/seller/profile/get-city?state_id=' +state;


                        $('#city').empty();
                        $('#city').append(
                            `<option value="">{{__("common.select_from_options")}}</option>`
                        );
                        $.get(url, function(data){

                            $.each(data, function(index, cityObj) {
                                $('#city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                            });

                            $('#city').niceSelect('update');
                            $('#pre-loader').hide();
                        });
                    }
                });

            });

            $(document).on('click', '.coupon_apply_btn', function(event){
                    event.preventDefault();
                    let total = $(this).data('total');
                    couponApply(total);
                });

                function couponApply(total){
                    let coupon_code = $('#coupon_code').val();
                    if(coupon_code){
                        $('#pre-loader').show();

                        let formData = new FormData();
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('coupon_code', coupon_code);
                        formData.append('shopping_amount', total);
                        $.ajax({
                            url: '{{route('frontend.checkout.coupon-apply')}}',
                            type: "POST",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            success: function (response) {
                                if(response.error){
                                    toastr.error(response.error,'Error');
                                    $('#pre-loader').hide();
                                }else{
                                    $('#mainDiv').html(response.MainCheckout);
                                    toastr.success("{{__('defaultTheme.coupon_applied_successfully')}}","{{__('common.success')}}");
                                    $('#pre-loader').hide();
                                }
                            },
                            error: function (response) {
                                toastr.error(response.responseJSON.errors.coupon_code)
                                $('#pre-loader').hide();
                            }
                        });
                    }else{
                        toastr.error("{{__('defaultTheme.coupon_field_is_required')}}","{{__('common.error')}}");
                    }
                }
                $(document).on('click', '#coupon_delete', function(event){
                    event.preventDefault();
                    couponDelete();
                });

                function couponDelete(){
                    $('#pre-loader').show();
                    let base_url = $('#url').val();
                    let url = base_url + '/checkout/coupon-delete';
                    $.get(url, function(response) {
                        $('#mainDiv').html(response.MainCheckout);
                        $('#pre-loader').hide();
                        toastr.success("{{__('defaultTheme.coupon_deleted_successfully')}}","{{__('common.success')}}");
                    });
                }

        })(jQuery);

        function updateTabbyTotalAmount()
        {
            let amount = $("#total_amount").attr('data-amount');
            @if(!empty($public_code))
                new TabbyCard({
                    selector: '#tabbyCard', // empty div for TabbyCard.
                    currency: 'AED', // required, currency of your product. AED|SAR|KWD|BHD|QAR only supported, with no spaces or lowercase.
                    lang: 'en', // Optional, language of snippet and popups.
                    price: amount, // required, total price or the cart. 2 decimals max for AED|SAR|QAR and 3 decimals max for KWD|BHD.
                    size: 'wide', // required, can be also 'wide', depending on the width.
                    theme: '#18171c', // required, can be also 'default'.
                    header: true // if a Payment method name present already.
                });
            @endif
        }
    </script>

<?php if (config('app.map_api_status') == "true") { ?>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
    <script>

        let autocomplete;
        let address1Field;
        let postalField;
        function initAutocomplete() {
            address1Field = document.querySelector("#address");
            postalField = document.querySelector("#postal_code");
            autocomplete = new google.maps.places.Autocomplete(address1Field, {
                componentRestrictions: { country: [@if(config('app.map_api_country_1') != "" ) "{{config('app.map_api_country_1')}}" @endif @if(config('app.map_api_country_2') != "" ) ,"{{config('app.map_api_country_2')}}" @endif @if(config('app.map_api_country_3') != "" ) ,"{{config('app.map_api_country_3')}}" @endif @if(config('app.map_api_country_4') != "" ) ,"{{config('app.map_api_country_4')}}" @endif @if(config('app.map_api_country_5') != "" ) ,"{{config('app.map_api_country_5')}}" @endif] },
                fields: ["address_components", "geometry"],
                types: ["address"],
            });
            address1Field.focus();
            autocomplete.addListener("place_changed", fillInAddress);
        }
        function fillInAddress() {
            const place = autocomplete.getPlace();
            let address1 = "";
            let postal_code = "";
            let countryId = "";
            let state_list = [];
            let city_list = [];
            postalField.value = postal_code;

            for (const component of place.address_components) {
                const componentType = component.types[0];

                if ( componentType == 'country') {
                    const country = component.long_name;
                    $("#country option").each(function(i,e)
                    {
                        if (country == e.innerHTML ) {
                            countryId = e.value;
                            $(this).attr('selected', true);
                        }else{
                            $(this).attr('selected', false);
                        }

                    })
                    $('#country').niceSelect('update');
                    $('#pre-loader').show();
                    //change country
                    let base_url = $('#url').val();
                    let url = base_url + '/seller/profile/get-state?country_id=' + countryId;

                    $('#state').empty();

                    $('#state').append(
                        `<option value="">{{__("common.select_from_options")}}</option>`
                    );
                    $('#state').niceSelect('update');
                    $('#city').empty();
                    $('#city').append(
                        `<option value="">{{__("common.select_from_options")}}</option>`
                    );
                    $('#city').niceSelect('update');
                    $.get(url, function(data) {

                        $.each(data, function(index, stateObj) {
                            $('#state').append('<option value="' + stateObj
                                .id + '">' + stateObj.name + '</option>');
                            state_list.push(stateObj.name);
                        });
                        $('#state').niceSelect('update');
                        $('#pre-loader').hide();
                        for (const component of place.address_components) {
                            const componentType = component.types[0];
                            if ( componentType == 'locality' && state_list.includes(component.long_name)) {
                                state = component.long_name
                                $("#state option").each(function(i,e)
                                {
                                    if (state == e.innerHTML ) {
                                        stateId = e.value;
                                        $(this).attr('selected', true);
                                    }else{
                                        $(this).attr('selected', false);
                                    }
                                })
                                $('#state').niceSelect('update');

                                getAndSelectCity(stateId);

                            }
                            else if ( componentType == 'administrative_area_level_2' && state_list.includes(component.long_name)) {
                                state = component.long_name
                                $("#state option").each(function(i,e)
                                {
                                    if (state == e.innerHTML ) {
                                        stateId = e.value;
                                        $(this).attr('selected', true);
                                    }else{
                                        $(this).attr('selected', false);
                                    }
                                })
                                $('#state').niceSelect('update');

                                // get city list
                                getAndSelectCity(stateId);
                            }
                            else if ( componentType == 'administrative_area_level_1' && state_list.includes(component.long_name)) {
                                state = component.long_name
                                $("#state option").each(function(i,e)
                                {
                                    if (state == e.innerHTML ) {
                                        stateId = e.value;
                                        $(this).attr('selected', true);
                                    }else{
                                        $(this).attr('selected', false);
                                    }
                                })
                                $('#state').niceSelect('update');

                                // get city list
                                getAndSelectCity(stateId);
                            }
                        }
                    });
                }
                if(componentType == 'postal_code'){
                    postalField.value = component.long_name;
                }


            }

            function getAndSelectCity(stateId){
                // get city list
                let base_url = $('#url').val();
                let url = base_url + '/seller/profile/get-city?state_id=' +stateId;

                $('#city').empty();
                $('#city').append(
                    `<option value="">{{__("common.select_from_options")}}</option>`
                );
                $('#pre-loader').show();
                $.get(url, function(data){

                    $.each(data, function(index, cityObj) {
                        $('#city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                        city_list.push(cityObj.name);
                    });

                    $('#city').niceSelect('update');
                    $('#pre-loader').hide();

                    for (const component of place.address_components) {
                        const componentType = component.types[0];
                        if ( componentType == 'sublocality_level_2' && city_list.includes(component.long_name)) {
                            city = component.long_name
                            $("#city option").each(function(i,e)
                            {
                                if (city == e.innerHTML ) {
                                    cityId = e.value;
                                    $(this).attr('selected', true);
                                }else{
                                    $(this).attr('selected', false);
                                }
                            })
                            $('#city').niceSelect('update');
                        }
                        else if ( componentType == 'sublocality_level_1' && city_list.includes(component.long_name)) {
                            city = component.long_name
                            $("#city option").each(function(i,e)
                            {
                                if (city == e.innerHTML ) {
                                    cityId = e.value;
                                    $(this).attr('selected', true);
                                }else{
                                    $(this).attr('selected', false);
                                }
                            })
                            $('#city').niceSelect('update');
                        }
                        else if ( componentType == 'locality' && city_list.includes(component.long_name)) {
                            city = component.long_name
                            $("#city option").each(function(i,e)
                            {
                                if (city == e.innerHTML ) {
                                    cityId = e.value;
                                    $(this).attr('selected', true);
                                }else{
                                    $(this).attr('selected', false);
                                }
                            })
                            $('#city').niceSelect('update');
                        }
                        else if ( componentType == 'locality' && city_list.includes(component.long_name)) {
                            city = component.long_name
                            $("#city option").each(function(i,e)
                            {
                                if (city == e.innerHTML ) {
                                    cityId = e.value;
                                    $(this).attr('selected', true);
                                }else{
                                    $(this).attr('selected', false);
                                }
                            })
                            $('#city').niceSelect('update');
                        }
                        else if ( componentType == 'administrative_area_level_2' && city_list.includes(component.long_name)) {
                            city = component.long_name
                            $("#city option").each(function(i,e)
                            {
                                if (city == e.innerHTML ) {
                                    cityId = e.value;
                                    $(this).attr('selected', true);
                                }else{
                                    $(this).attr('selected', false);
                                }
                            })
                            $('#city').niceSelect('update');
                        }
                        else if ( componentType == 'administrative_area_level_1' && city_list.includes(component.long_name)) {
                            city = component.long_name
                            $("#city option").each(function(i,e)
                            {
                                if (city == e.innerHTML ) {
                                    cityId = e.value;
                                    $(this).attr('selected', true);
                                }else{
                                    $(this).attr('selected', false);
                                }
                            })
                            $('#city').niceSelect('update');
                        }

                    }
                });
            }
        }
        window.initAutocomplete = initAutocomplete;


    </script>
<?php } ?>
    <script>
        $(document).on('change','input[name="payment_method"]',function(){
            generateTabbyFee();
            updateTabbyTotalAmount();
        });

        $(document).ready(function(){
            generateTabbyFee();
        });

        function generateTabbyFee(){
            let currency_code = $("#tabby_fee").attr('data-currency');
            let product_price = parseFloat( $("#tabby_fee").attr('data-product-total'));
            let fee_percentage = parseFloat($("#tabby_fee").attr('data-tabby-fee'));
            let total_amount = parseFloat($("#tabby_fee").attr('data-total-amount'));
            let percentageAmount = (fee_percentage * product_price) / 100;
            let sub_total = total_amount + percentageAmount;

            if($('input[name="payment_method"]:checked').attr('data-name') == 'Tabby')
            {
                percentageAmount = percentageAmount.toFixed(2);
                sub_total = sub_total.toFixed(2);
                $("#tobbyFeeDiv").removeClass('d-none');
                $("#tabby_fee").html("+ "+currency_code+" "+percentageAmount);
                $("#total_amount").html(currency_code+" "+sub_total);
                $("#total_amount").attr('data-amount',sub_total);
            }else{
                $("#tobbyFeeDiv").addClass('d-none');
                $("#total_amount").html(currency_code+" "+total_amount);
                $("#total_amount").attr('data-amount',sub_total);
            }


        }
    </script>
@endpush
