
@extends('frontend.amazy.layouts.app')
@section('title')
    {{ __('defaultTheme.checkout') }}
@endsection
@push('styles')
<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet"/>
    <style>
          @media (max-width: 400px){
            .shipping_address_div table td {
            width: 100px;
            }
          }

        .shipping_delivery_div {
            display: flex;
            /* grid-gap: 150px; */
        }
        .primary_bulet_checkbox{
            top: 4px;
        }

    </style>
@endpush
@section('content')
    <!-- checkout_v3_area::start  -->
    @php
        $postalCodeRequired = false;
        if(isModuleActive('ShipRocket')){
            $postalCodeRequired = true;
        }
    @endphp
    <div id="mainDiv">
        @include('frontend.amazy.partials._checkout_details')
    </div>
<!-- checkout_v3_area::end  -->
@endsection
@push('scripts')

@php
    $public_code = null;
    $payment = DB::table('payment_methods')->where('method','Tabby')->orWhere('slug','tabby')->where('active_status',1)->first();
    if($payment)
    {
        $tabby_gateway = getPaymentGatewayInfo($payment->id);
        if($tabby_gateway){
            $public_code = $tabby_gateway->perameter_1;
            $merchantCode = $tabby_gateway->perameter_5;
        }
    }

@endphp
@if(!empty( $public_code))
<script src="https://checkout.tabby.ai/tabby-promo.js"></script>
<script>
    let amount = $("#grand_total").html();
    let price = amount.replace(/[^0-9.]/g, '');
    new TabbyPromo({
        selector: '#TabbyPromo', // required, content of tabby Promo Snippet will be placed in element with that selector.
        currency: 'AED', // required, currency of your product. AED|SAR|KWD|BHD|QAR only supported, with no spaces or lowercase.
        price: price, // required, price or the product. 2 decimals max for AED|SAR|QAR and 3 decimals max for KWD|BHD.
        installmentsCount: 4, // Optional, for non-standard plans.
        lang: 'en', // Optional, language of snippet and popups, if the property is not set, then it is based on the attribute 'lang' of your html tag.
        source: 'product', // Optional, snippet placement; `product` for product page and `cart` for cart page.
        publicKey: '{{ $public_code }}', // required, store Public Key which identifies your account when communicating with tabby.
        merchantCode: '{{ $merchantCode }}'
    });
</script>
@endif



<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function onSubmit(token) {
        var response = checkShippingSelect();
        if(response == 1){
            return false;
        }
        document.getElementById("mainOrderForm").submit();
    }
    function checkShippingSelect(){
        var is_validate = 0;
        $("select[name*='intshipping_cartItem']").each(function () {
            var cartitem = $(this).data('id');
            var item =$('#uniqueCartId'+cartitem).val();
                if ($('#uniqueCartId'+cartitem).val() == null) {
                    $('#error_intship_cart_item_'+cartitem).text('Please Select Shipping Method');
                    is_validate = 1;
                }
        });
        return is_validate;
    }
</script>

<?php if (config('app.map_api_status') == "true") { ?>
    <script src="https://maps.googleapis.com/maps/api/js?key={{config('app.map_api_key')}}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
    <script>

        let autocomplete;
        let address1Field;
        let postalField;
        function initAutocomplete(){
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
                    let url = base_url + '/get-state?country_id=' + countryId;

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
                let url = base_url + '/get-city?state_id=' +stateId;

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
(function($) {
    "use strict";
    $(document).ready(function() {

        $(document).on('click', '.link_btn_design', function(event){
            shippingAddressDiv();
            let intshiping = '{{isModuleActive("INTShipping")}}';
            let multivendor = '{{isModuleActive("MultiVendor")}}';
            if(intshiping == 1 && multivendor == 1){
                $('#address_btn').html(`
                    <a href="javascript:void(0)" class="amaz_badge_btn3 text-uppercase text-nowrap saveAddress">{{__('common.save')}}</a>
                `);
            }
        });

        function shippingAddressDiv(){
            let shipping_address_div = $('.shipping_address_div');
            let shipping_address_edit_div = $('.shipping_address_edit_div');
            shipping_address_div.toggleClass('d-none');
            shipping_address_edit_div.toggleClass('d-none');
        }

        $(document).on('click', '.saveAddress', function(e){
            e.preventDefault();

            let is_submit = 0;
            let postalCodeRequired = "{{$postalCodeRequired}}"

            $('#error_term_check').text('');
            $('#error_name').text('');
            $('#error_address').text('');
            $('#error_email').text('');
            $('#error_phone').text('');
            $('#error_country').text('');
            $('#error_state').text('');
            $('#error_city').text('');
            $('#error_postal_code').text('');
            $('#error_pickup_location').text('');

            if(!$('#term_check').is(":checked")){
                is_submit = 1;
                $('#error_term_check').text('{{__("validation.please_agree_with_terms")}}');
            }

            if($('#name').val() == ''){
                is_submit = 1;
                $('#error_name').text('{{__("validation.this_field_is_required")}}');
            }

            if(postalCodeRequired == 1 && $('#postal_code').val() == ''){
                is_submit = 1;
                $('#error_postal_code').text('{{__("validation.this_field_is_required")}}');
            }

            if($('#address').val() == ''){
                is_submit = 1;
                $('#error_address').text('{{__("validation.this_field_is_required")}}');
            }

            if($('#email').val() == ''){
                is_submit = 1;
                $('#error_email').text('{{__("validation.this_field_is_required")}}');
            }

            if($('#phone').val() == ''){
                is_submit = 1;
                $('#error_phone').text('{{__("validation.this_field_is_required")}}');
            }

            let phone_digit = $("#phone").val();
            let phone_max = $("#phone").attr('data-max');
            let phone_min = $("#phone").attr('data-min');
            if(phone_digit.length < phone_min || phone_digit.length > phone_max){
              is_submit = 1;
              $("#error_phone").text('Invalid phone number, number have to Minimum  '+phone_min+' and Maximum '+phone_max+') digits');
            }



            if($('#country').val() == ''){
                is_submit = 1;
                $('#error_country').text('{{__("validation.this_field_is_required")}}');
            }

            if($('#state').val() == ''){
                is_submit = 1;
                $('#error_state').text('{{__("validation.this_field_is_required")}}');
            }

            if($('#city').val() == ''){
                is_submit = 1;
                $('#error_city').text('{{__("validation.this_field_is_required")}}');
            }

            if($('input[name=delivery_type]').length && $('input[name=delivery_type]:checked').val() == 'pickup_location' && $('#pickup_location').val() == ''){
                is_submit = 1;
                $('#error_pickup_location').text('{{__("validation.this_field_is_required")}}');
            }

            if(is_submit === 1){
                return false;
            }

            let data = {
                address_id : $('#address_id').val(),
                name : $('#name').val(),
                address : $('#address').val(),
                email : $('#email').val(),
                phone : $('#phone').val(),
                country : $('#country').val(),
                state : $('#state').val(),
                city : $('#city').val(),
                postal_code : $('#postal_code').val(),
                _token: "{{csrf_token()}}"
            }

            $('#pre-loader').show();

            $.post('{{route("frontend.checkout.shipping.address.store")}}', data, function(response){
                if(response.msg == 'success'){
                    toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                    location.reload();
                }else{
                    toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    location.reload();
                }
            });


        });

        $(document).on('change', 'input[name=delivery_type]', function(){
            $('.pick_location_list_div').toggleClass('d-none');
            var delivery_type = $(this).val();
            if(delivery_type == 'pickup_location'){
                $('#next_step_btn_div').html(
                    `
                    <input type="hidden" name="step" value="select_payment">
                    <input type="hidden" name="shipping_method" value="{{encrypt($free_shipping_for_pickup_location->id)}}">
                    <button type="submit" class="amaz_primary_btn style2  min_200 text-center text-uppercase ">{{__('defaultTheme.continue_to_payment')}}</button>
                    `
                );
                $('.address_title').text("{{__('common.billing_address')}}");

            }else if(delivery_type == 'home_delivery'){
                $('#next_step_btn_div').html(
                    `
                    <input type="hidden" name="step" value="select_shipping">
                    <button type="submit" class="amaz_primary_btn style2  min_200 text-center text-uppercase ">{{__('defaultTheme.continue_to_shipping')}}</button>
                    `
                );
                $('.address_title').text("{{__('shipping.shipping_address')}}");
            }
        });

        $(document).on('click', '#shipping_methods', function(event){
            let id = $(this).data('target');
            $('#'+id).modal('show');
        });

        $(document).on('change', '.shipping_method_select', function(event){
            $('#pre-loader').show();
            let id = $(this).data('package');
            let shipping_method = $(this).val();
            let url = "{{route('frontend.change_shipping_method')}}";
            let data = {
                _token:"{{csrf_token()}}",
                seller:id,
                shipping_method:shipping_method,
            }
            $('#shipping_methods_'+id).modal('hide');
            $.post(url,data, function(res){
                $('#mainDiv').html(res);
                $('select').niceSelect();
                $('#pre-loader').hide();
            });
        });

        $(document).on('submit', '#mainOrderForm', function(event){

            let captcha_type = "{{config('app.recaptcha_version')}}";
            let captcha_visibility = "{{config('app.recaptcha_invisible')}}";
            let captcha_checkout = "{{config('app.recaptcha_for_checkout')}}";
            let captcha =  $("[name='g-recaptcha-response']").val();
            if(captcha_type == 2 && captcha_visibility != 'true' && captcha_checkout == 1){
                $('#captcha_response').text('');
                if(captcha == ''){
                    $('#captcha_response').text('Recaptcha is required.');
                    return false;
                }
            }
            let is_submit = 0;
            let postalCodeRequired = "{{$postalCodeRequired}}"
            $('#error_term_check').text('');
            $('#error_name').text('');
            $('#error_address').text('');
            $('#error_email').text('');
            $('#error_phone').text('');
            $('#error_country').text('');
            $('#error_state').text('');
            $('#error_city').text('');
            $('#error_postal_code').text('');
            $('#error_pickup_location').text('');
            if(!$('#term_check').is(":checked")){
                is_submit = 1;
                $('#error_term_check').text('{{__("validation.please_agree_with_terms")}}');
            }
            if($('#name').val() == ''){
                is_submit = 1;
                $('#error_name').text('{{__("validation.this_field_is_required")}}');
            }
            @if($checkoutField[4]->field_name=='postal' && $checkoutField[4]->visibility==1 && $checkoutField[4]->required==1)
            if(postalCodeRequired == 1 && $('#postal_code').val() == ''){
                is_submit = 1;
                $('#error_postal_code').text('{{__("validation.this_field_is_required")}}');
            }
            @endif
            @if($checkoutField[0]->field_name=='address' && $checkoutField[0]->visibility==1 && $checkoutField[0]->required==1)
            if($('#address').val() == ''){
                is_submit = 1;
                $('#error_address').text('{{__("validation.this_field_is_required")}}');
            }
            @endif
            if($('#email').val() == ''){
                is_submit = 1;
                $('#error_email').text('{{__("validation.this_field_is_required")}}');
            }
            if($('#phone').val() == ''){
                is_submit = 1;
                $('#error_phone').text('{{__("validation.this_field_is_required")}}');
            }

            let phone_digit = $("#phone").val();
            let phone_max = $("#phone").attr('data-max');
            let phone_min = $("#phone").attr('data-min');
            if(phone_digit.length < phone_min || phone_digit.length > phone_max){
              is_submit = 1;
              $("#error_phone").text('Invalid phone number, number have to Minimum  '+phone_min+' and Maximum '+phone_max+') digits');
            }

            @if($checkoutField[3]->field_name=='country' && $checkoutField[3]->visibility==1 && $checkoutField[3]->required==1)
            if($('#country').val() == ''){
                is_submit = 1;
                $('#error_country').text('{{__("validation.this_field_is_required")}}');
            }
            @endif
            @if($checkoutField[2]->field_name=='state' && $checkoutField[2]->visibility==1 && $checkoutField[2]->required==1)
            if($('#state').val() == ''){
                is_submit = 1;
                $('#error_state').text('{{__("validation.this_field_is_required")}}');
            }
            @endif
            @if($checkoutField[1]->field_name=='city' && $checkoutField[1]->visibility==1 && $checkoutField[1]->required==1)

            if($('#city').val() == ''){
                is_submit = 1;
                $('#error_city').text('{{__("validation.this_field_is_required")}}');
            }

            @endif
            if($('input[name=delivery_type]').length && $('input[name=delivery_type]:checked').val() == 'pickup_location' && $('#pickup_location').val() == ''){
                is_submit = 1;
                $('#error_pickup_location').text('{{__("validation.this_field_is_required")}}');
            }

            let intShippingCheck = "{{isModuleActive('INTShipping')}}";
            if(intShippingCheck == 1){
                is_submit = checkShippingSelect();
            }

            if(is_submit === 1){
                event.preventDefault();
            }

        });

        $(document).on('change', '#address_id', function(event) {
            let data = {
                _token:"{{csrf_token()}}",
                id: $(this).val()
            }
            $('#pre-loader').show();
            $.post("{{route('frontend.checkout.address.shipping')}}",data, function(res){
                // $('#mainDiv').html(res.MainCheckout);
                location.reload();
                $('select').niceSelect();
                // $('#pre-loader').hide();
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

        $(document).on('change', '#country', function(event) {
            let country = $('#country').val();
            $('#pre-loader').show();
            if (country) {
                let base_url = $('#url').val();
                let url = base_url + '/get-state?country_id=' + country;

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
                let url = base_url + '/get-city?state_id=' +state;


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

        let shipping_amount = 0 ;
        let total = $('#total').val();
        let format_total = parseFloat(total) + parseFloat(shipping_amount);
        grand_total(format_total);

        function shipping_cost(cost = 0){
            $('#shipping_cost').text(numbertrans(currency_format(cost)));
        }

        function grand_total(total){
            $('#grand_total').text(numbertrans(currency_format(total)));
        }

        const unique = (value, index, self) => {
            return self.indexOf(value) === index
        }
        const cartId = [];

        $(document).on('change', '.intshiping', function(){
            const cartitem = $(this).data('id');
            cartId.push(cartitem);
            const uniqueCartId = cartId.filter(unique);
            var cartCost = 0;
            const ratrId = [];
            for (let i = 0; i < uniqueCartId.length; i++) {
                var itemvalue = $('#uniqueCartId'+uniqueCartId[i]).val();
                const myArray = itemvalue.split(" ");
                ratrId.push(myArray[1]);
                cartCost += parseFloat(myArray[0]);
                $('#error_intship_cart_item_'+uniqueCartId[i]).text('');
            }
            const cost = parseFloat(cartCost);
            shipping_cost(cost);
            grand_total(parseFloat(total) + parseFloat(cost));
        });

    });

})(jQuery);

 </script>
@endpush
