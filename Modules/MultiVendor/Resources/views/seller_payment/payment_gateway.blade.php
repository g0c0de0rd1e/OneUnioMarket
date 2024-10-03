@extends('frontend.amazy.layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset(asset_path('frontend/amazy/css/page_css/product_details.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/lightbox.css'))}}" />
    @if(isRtl())
        <style>
            .zoomWindowContainer div {
                left: 0!important;
                right: 510px;
            }
            .product_details_part .cs_color_btn .radio input[type="radio"] + .radio-label:before {
                left: -1px !important;
            }
            @media (max-width: 970px) {
                .zoomWindowContainer div {
                    right: inherit!important;
                }
            }
        </style>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@php
    $discount = 0;
    $dis_percent = !empty($seller_subscription->pricing) ? $seller_subscription->pricing->discount:0;
    if(!empty($seller_subscription->pricing) && $seller_subscription->pricing->discount_type == 1){
         $discount = ($seller_subscription->pricing->plan_price * $seller_subscription->pricing->discount) / 100;
    }else{
         $discount = $seller_subscription->pricing->discount;
    }
    $sub_total = $seller_subscription->pricing->plan_price - $discount;


    if(session()->has('coupon_discount')){
         $final_discounted_price = $sub_total - session()->get('coupon_discount');
    }else{
        $final_discounted_price = $sub_total;
    }
    $tax = !empty($seller_subscription->pricing) && !empty($seller_subscription->pricing->vat) ? $seller_subscription->pricing->vat->tax_percentage:0;
    $vat = ($final_discounted_price * $tax) / 100;

    $total_pay = $final_discounted_price + $vat;
@endphp


@section('content')
<div class="product_details_wrapper">
    <div class="container">
        <div class="row mb-5">
            <div class="col-xl-6">
                @if(count($gateway_activations->where('method','!=','Cash on Delivery')) > 0)
                <form action="{{route('seller.subscription_payment')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb_10">
                            <h3 class="check_v3_title2">{{__('common.payment')}}</h3>
                            <h6 class="shekout_subTitle_text">{{__('defaultTheme.all_transactions_are_secure_and_encrypted')}}.</h6>
                        </div>
                        <div class="col-12">
                            <div class="accordion checkout_acc_style mb_30" id="accordionExample">

                                @foreach($gateway_activations->where('method','!=','Cash On Delivery') as $key => $payment)
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="headingOne">
                                            <span class="accordion-button shadow-none" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}"  aria-controls="collapse{{$key}}">
                                                <span class="w-100">
                                                    <label class="primary_checkbox d-inline-flex style4 gap_10 w-100" >
                                                        <input type="radio" name="method" class="payment_method" data-name="{{$payment->method}}" value="{{$payment->method}}" {{$key == 0?'checked':''}}>
                                                        <span class="checkmark mr_10"></span>
                                                        <span class="label_name f_w_500 ">
                                                            @php
                                                                switch ($payment->method) {
                                                                    case 'Cash On Delivery':
                                                                    echo __("payment_gatways.cash_on_delivery");
                                                                    break;
                                                                    case 'Wallet':
                                                                    echo __("payment_gatways.wallet");
                                                                    break;
                                                                    case 'PayPal':
                                                                    echo __("payment_gatways.paypal");
                                                                    break;
                                                                    case 'Stripe':
                                                                    echo __("payment_gatways.stripe");
                                                                    break;
                                                                    case 'PayStack':
                                                                    echo __("payment_gatways.paystack");
                                                                    break;
                                                                    case 'RazorPay':
                                                                    echo __("payment_gatways.razorpay");
                                                                    break;
                                                                    case 'PayTM':
                                                                    echo __("payment_gatways.paytm");
                                                                    break;
                                                                    case 'Instamojo':
                                                                    echo __("payment_gatways.instamojo");
                                                                    break;
                                                                    case 'Midtrans':
                                                                    echo __("payment_gatways.midtrans");
                                                                    break;
                                                                    case 'PayUMoney':
                                                                    echo __("payment_gatways.payumoney");
                                                                    break;
                                                                    case 'JazzCash':
                                                                    echo __("payment_gatways.jazzcash");
                                                                    break;
                                                                    case 'Google Pay':
                                                                    echo __("payment_gatways.google_pay");
                                                                    break;
                                                                    case 'FlutterWave':
                                                                    echo __("payment_gatways.flutter_wave_payment");
                                                                    break;
                                                                    case 'Bank Payment':
                                                                    echo __("payment_gatways.bank_payment");
                                                                    break;
                                                                    case 'Bkash':
                                                                    echo __("payment_gatways.bkash");
                                                                    break;
                                                                    case 'SslCommerz':
                                                                    echo __("payment_gatways.ssl_commerz");
                                                                    break;
                                                                    case 'Mercado Pago':
                                                                    echo __("payment_gatways.mercado_pago");
                                                                    break;
                                                                    case 'Tabby':

                                                                    echo trans('payment_gatways.4 intereset-free Payments');
                                                                    echo '<span style="position: absolute; right:0"><img height="20" src="'.asset('public/'.$payment->logo).'"></span>';

                                                                    break;
                                                                    case 'CCAvenue':
                                                                    echo __("payment_gatways.ccavenue");
                                                                    break;

                                                                    case 'Clickpay':
                                                                    echo __("payment_gatways.Clickpay");
                                                                    break;
                                                                }
                                                                @endphp
                                                        </span>
                                                    </label>
                                                </span>
                                            </span>
                                        </div>
                                        <div id="collapse{{$key}}" class="accordion-collapse collapse {{$key == 0?'show':''}}" aria-labelledby="heading{{$key}}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body" id="acc_{{$payment->id}}">
                                                <!-- content ::start  -->
                                                <div class="row">

                                                    @if($payment->method == 'Cash On Delivery')

                                                    @elseif($payment->method == 'Wallet')
                                                        <div class="col-lg-12 text-center mb_20">
                                                            <strong>{{__('common.balance')}}: {{single_price(auth()->user()->CustomerCurrentWalletAmounts)}}</strong>
                                                        </div>
                                                    @elseif($payment->method == 'Stripe')

                                                    @elseif($payment->method == 'PayPal')

                                                    @elseif($payment->method == 'PayStack')
                                                    <input type="hidden" name="email" value="{{ @Auth::user()->email}}">
                                                    {{-- required --}}
                                                    <input type="hidden" name="orderID" value="{{md5(uniqid(rand(), true))}}">
                                                    <input type="hidden" name="pay_amount" value="{{ $total_pay*100}}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <input type="hidden" name="currency" value="{{$currency_code}}">

                                                    @elseif($payment->method == 'RazorPay')

                                                    @elseif($payment->method == 'Instamojo')

                                                    @elseif($payment->method == 'PayTM')

                                                    @elseif($payment->method == 'Midtrans')

                                                    <input type="hidden" name="ref_no"
                                                        value="{{ rand(1111,99999).'-'.date('y-m-d').'-'.auth()->user()->id }}">
                                                    @elseif($payment->method == 'PayUMoney')

                                                    @elseif($payment->method == 'JazzCash')

                                                    @elseif($payment->method == 'Google Pay')

                                                    @elseif($payment->method == 'FlutterWave')

                                                    @elseif($payment->method == 'Bank Payment')
                                                    @php
                                                        $bank = $payment->where('method','Bank Payment')->first();
                                                    @endphp
                                                    @include('multivendor::seller_payment.components._bank_payment_modal',compact('bank','total_pay'))
                                                    @elseif(isModuleActive('Bkash') && $payment->method=="Bkash")

                                                    @elseif(isModuleActive('MercadoPago') && $payment->method=="Mercado Pago")

                                                    @elseif(isModuleActive('Tabby') && $payment->method=="Tabby")
                                                        @php
                                                            $tabby_gateway = getPaymentGatewayInfo($payment->id);
                                                            if($tabby_gateway){
                                                                $tabby_fee = $tabby_gateway->perameter_3;
                                                                $place_holder =$tabby_gateway->perameter_4;
                                                            }
                                                        @endphp

                                                    @elseif(isModuleActive('CCAvenue') && $payment->method=="CCAvenue")

                                                    @elseif(isModuleActive('SslCommerz') && $payment->method=="SslCommerz")

                                                    @elseif(isModuleActive('Clickpay') && $payment->method=="Clickpay")

                                                        <input type="hidden" name="purpose" value="SubscriptionPayment">
                                                        <input type="hidden" name="amount" value="{{ $total_pay }}">
                                                        @php
                                                            $address = !empty(auth()->user()->SellerBusinessInformation) ? auth()->user()->SellerBusinessInformation:null;
                                                        @endphp
                                                        <input type="hidden" name="customer_name" value="{{ auth()->user()->first_name.' '.auth()->user()->last_name }}">
                                                        <input type="hidden" name="customer_phone" value="{{ auth()->user()->phone }}">
                                                        <input type="hidden" name="customer_email" value="{{ auth()->user()->email }}">
                                                        <input type="hidden" name="customer_address" value="{{ !empty($address) ? $address->business_address1:'' }}">
                                                        <input type="hidden" name="customer_state" value="{{ !empty($address) ? $address->business_state:'' }}">
                                                        <input type="hidden" name="customer_city" value="{{ !empty($address) ? $address->business_city:'' }}">
                                                        <input type="hidden" name="customer_country" value="{{ !empty($address) ? $address->business_country:'' }}">
                                                        <input type="hidden" name="customer_postal_code" value="{{ !empty($address) ? $address->business_postcode:'' }}">
                                                    @endif

                                                </div>
                                                <!-- content ::end  -->
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb_25" bis_skin_checked="1">
                            <label class="primary_checkbox d-flex">
                                <input value="1" id="term_check" checked="" type="checkbox" required>
                                <span class="checkmark mr_15"></span>
                                <span class="label_name f_w_400 ">{{ __("common.i_agree_terms") }}</span>
                                <span id="error_term_check" class="text-danger"></span>
                            </label>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="amaz_primary_btn style2  min_200 text-center text-uppercase">
                               {{ __("common.pay_now") }}
                            </button>
                        </div>
                    </div>
                </form>
                @else
                <div class="alert alert-danger">
                    {{ __('payment_gatways.gateway_not_active') }}
                </div>
                @endif
            </div>
            <div class="col-lg-6">
                    <div class="order_sumery_box flex-fill">
                        <h3 class="check_v3_title mb_25">{{ __("common.payment_summery") }}</h3>
                        <div class="subtotal_lists">
                                <div class="single_total_list d-flex align-items-center">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text">{{ __("marketing.Plan Price") }}</span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text">{{ single_price($seller_subscription->pricing->plan_price) }}</span>
                                    </div>
                                </div>



                                <div class="single_total_list d-flex align-items-center">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text">{{ __("common.discount") }}  {{$seller_subscription->pricing->discount_type == 1 ?  "(".$seller_subscription->pricing->discount.'%'.")" :''}}</span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text"  > {{ single_price($discount) }} </span>
                                    </div>
                                </div>

                                @if(session()->has('coupon_discount'))
                                    <div class="single_total_list d-flex align-items-center">
                                        <div class="single_total_left flex-fill">
                                            <span class="total_text">{{ __("common.coupon_discount") }} {{session()->get('coupon_type') == 0 ? "(".session()->get('coupon_amount').'%'.")":'' }} </span>
                                        </div>
                                        <div class="single_total_right">
                                            <span class="total_text"  > {{ single_price(session()->get('coupon_discount')) }} </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="single_total_list d-flex align-items-center">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text">{{ __("common.subtotal") }}</span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text"  > {{ single_price($final_discounted_price) }} </span>
                                    </div>
                                </div>





                                <div class="single_total_list d-flex align-items-center">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text"> {{__('common.vat/tax/gst')}}  ({{$tax}} %) </span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text"  > {{ single_price($vat) }} </span>
                                    </div>
                                </div>



                                <div class="total_amount d-flex align-items-center flex-wrap pb_25">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text">{{ __("common.total") }}</span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text"  > {{ single_price($vat + $final_discounted_price) }} </span>
                                    </div>
                                </div>


                                @if(!session()->has('coupon_discount'))
                                <div class="coupon_wrapper  couponCodeDiv">

                                        <input data-url='{{ route('seller.plan.apply_coupon',$seller_subscription->pricing->id) }}' placeholder="{{ __("marketing.coupon_code") }}" id="coupon_code" class="primary_input5 "  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Coupon Code'" type="text">
                                        <button type="button" class="amaz_primary_btn style4 min_100 text-uppercase text-center coupon_apply_btn" data-total="19">{{ __("common.apply") }}</button>

                                </div>
                                @endif

                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        $(document).on('click','.coupon_apply_btn',function(){
            let coupon = $("#coupon_code").val();
            let url = $("#coupon_code").attr('data-url');

            $.ajax({
                url:url,
                method:"post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    coupon: coupon,
                },
            }).done(function(response){
                if(response.status == 1)
                {
                    toastr.success(response.msg,'Successs');
                    window.location.reload();
                }else{
                    toastr.error(response.msg,'Successs');
                }
            });
        });
    </script>


    @if ($errors->any())
        @foreach($errors->all() as $error)
        <script>
            toastr.error("{{$error}}",'Error');
        </script>
        @endforeach
    @endif

@endpush
