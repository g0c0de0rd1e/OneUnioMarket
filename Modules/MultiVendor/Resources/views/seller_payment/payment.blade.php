@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/multivendor/css/payment.css'))}}" />

@endsection
@section('mainContent')
@php
    $currency_code = getCurrencyCode();
@endphp
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('wallet.choose_payment_gateway') }}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-25 text-center">
                        <h4>{{ __('payment_gatways.payment_amount') }}: {{ single_price($recharge_amount) }}</h4>
                    </div>
                    <div class="col-12">
                        <div class="deposit_lists_wrapper mb-50">
                            @if (@$payment_gateways->where('method','Stripe')->first()->active_status == 1)

                            <div class="single_deposite">
                                <form action="{{route('seller.subscription_payment')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="method" value="Stripe">
                                    <input type="hidden" name="amount" value="{{ $recharge_amount }}">

                                    <!-- single_deposite_item  -->
                                    <button type="submit">
                                        <img src="{{showImage($gateway_activations->where('method', 'Stripe')->first()->logo)}}"
                                            alt="">
                                    </button>
                                    @csrf
                                    @php
                                        $stripe_credential = getPaymentInfoViaSellerId(1, 4);
                                    @endphp
                                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="{{ @$stripe_credential->perameter_1 }}" data-name="Stripe Payment"
                                        data-image="{{showImage(app('general_setting')->favicon)}}"
                                        data-locale="auto" data-currency="{{$currency_code}}">
                                    </script>
                                </form>
                            </div>
                            @endif

                            @if(isModuleActive('Bkash') && @$payment_gateways->where('method','Bkash')->first()->active_status == 1)
                                <div class="single_deposite">
                                        <form action="{{route('seller.subscription_payment')}}" method="post" id="bkash_form" class="bkash_form">
                                        @csrf
                                            <script src="https://code.jquery.com/jquery-3.4.1.min.js"
                                                    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
                                        @php
                                            $bkash_credential = getPaymentInfoViaSellerId(1, 15);
                                        @endphp
                                        @if(@$bkash_credential->perameter_1 === "1")
                                            <script id="myScript"
                                                    src="https://scripts.sandbox.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout-sandbox.js"></script>
                                        @else
                                            <script id="myScript"
                                                    src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>
                                        @endif

                                        <input type="hidden" name="method" value="Bkash">
                                        <input type="hidden" name="type" value="subscription_payment">
                                        <input type="hidden" name="amount" value="{{$recharge_amount}}">
                                        <input type="hidden" name="trxID" id="trxID" value="">
                                        <button type="button"  class="Payment_btn" id="bKash_button" onclick="BkashPayment()">
                                            <img src="{{showImage($gateway_activations->where('method', 'Bkash')->first()->logo)}}" alt="">
                                        </button>
                                        @php
                                            $type = 'subscription_payment';
                                            $amount = $recharge_amount;
                                        @endphp
                                        @include('bkash::bkash-script',compact('type','amount'))

                                    </form>
                                 </div>
                            @endif


                            @if(isModuleActive('SslCommerz') && @$payment_gateways->where('method','SslCommerz')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <form action="{{route('seller.subscription_payment')}}" method="post" id="ssl_commerz_form">
                                        @csrf
                                        <input type="hidden" name="method" value="SslCommerz">
                                        <input type="hidden" name="type" value="subscription_payment">
                                        <input type="hidden" name="amount" value="{{$recharge_amount}}">
                                        <button type="submit" class="your-button-class" id="sslczPayBtn">
                                            <img src="{{showImage($gateway_activations->where('method', 'SslCommerz')->first()->logo)}}" alt="">
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if (isModuleActive('MercadoPago') && @$payment_gateways->where('method','Mercado Pago')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <a href="#" data-toggle="modal" data-target="#MercadoPagoModal">
                                        <img src="{{showImage($gateway_activations->where('method', 'Mercado Pago')->first()->logo)}}" alt="">
                                    </a>
                                </div>
                            @endif
                            @if (isModuleActive('Tabby') && @$payment_gateways->where('method','Tabby')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <form action="{{route('seller.subscription_payment')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="method" value="Tabby">
                                        <input type="hidden" name="purpose" value="SubscriptionPayment">
                                        <input type="hidden" name="amount" value="{{ $recharge_amount }}">
                                        <button type="submit">
                                            <img src="{{showImage($gateway_activations->where('method', 'Tabby')->first()->logo)}}" alt="">
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if (@$payment_gateways->where('method','RazorPay')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <form action="{{ route('seller.subscription_payment') }}" method="POST">
                                        <input type="hidden" name="method" value="RazorPay">
                                        <input type="hidden" name="amount" value="{{ $recharge_amount * 100 }}">

                                        <button type="submit">
                                            <img src="{{showImage($gateway_activations->where('method', 'RazorPay')->first()->logo)}}"
                                                alt="">
                                        </button>
                                        @csrf
                                        @php
                                            $razor_credential = getPaymentInfoViaSellerId(1, 6);
                                        @endphp
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ @$razor_credential->perameter_1 }}" data-amount="{{ $recharge_amount * 100 }}"
                                            data-name="{{str_replace('_', ' ',app('general_setting')->company_name ) }}"
                                            data-description="SubscriptionPayment"
                                            data-image="{{showImage(app('general_setting')->favicon)}}"
                                            data-prefill.name="{{ auth()->user()->username }}"
                                            data-prefill.email="{{ auth()->user()->email }}" data-theme.color="#ff7529">
                                        </script>
                                    </form>
                                </div>
                            @endif

                            @if (@$payment_gateways->where('method','PayPal')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <form action="{{route('seller.subscription_payment')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="method" value="Paypal">
                                        <input type="hidden" name="purpose" value="SubscriptionPayment">
                                        <input type="hidden" name="amount" value="{{ $recharge_amount }}">

                                        <button type="submit">
                                            <img src="{{showImage($gateway_activations->where('method', 'PayPal')->first()->logo)}}"
                                                alt="">
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if (@$payment_gateways->where('method','PayStack')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <form action="{{ route('seller.subscription_payment') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ @Auth::user()->email}}">
                                        {{-- required --}}
                                        <input type="hidden" name="orderID" value="{{md5(uniqid(rand(), true))}}">
                                        <input type="hidden" name="amount" value="{{ $recharge_amount*100}}">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="currency" value="{{$currency_code}}">
                                        {{-- <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> --}}
                                        {{-- required --}}

                                        <input type="hidden" name="method" value="Paystack">

                                        <button type="submit">
                                            <img
                                                src="{{showImage($gateway_activations->where('method', 'PayStack')->first()->logo)}}">
                                        </button>

                                    </form>
                                </div>
                            @endif

                            @if (@$payment_gateways->where('method','Bank Payment')->first()->active_status == 1)

                                <div class="single_deposite">
                                    <a href="#" data-toggle="modal" data-target="#exampleModal">
                                        <img src="{{showImage($gateway_activations->where('method', 'Bank Payment')->first()->logo)}}"
                                            alt="">
                                    </a>
                                </div>

                            @endif

                            @if (@$payment_gateways->where('method','PayTM')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <a href="#" data-toggle="modal" data-target="#PayTMModal">
                                        <img src="{{showImage($gateway_activations->where('method', 'PayTM')->first()->logo)}}"
                                            alt="">
                                    </a>
                                </div>
                            @endif
                            @if (@$payment_gateways->where('method','Instamojo')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <a href="#" data-toggle="modal" data-target="#InstamojoModal">
                                        <img src="{{showImage($gateway_activations->where('method', 'Instamojo')->first()->logo)}}"
                                            alt="">
                                    </a>
                                </div>
                            @endif
                            @if (@$payment_gateways->where('method','Midtrans')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <form action="{{ route('seller.subscription_payment') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="method" value="Midtrans">
                                        <input type="hidden" name="amount" value="{{ $recharge_amount * 100 }}">
                                        <input type="hidden" name="ref_no"
                                            value="{{ rand(1111,99999).'-'.date('y-m-d').'-'.auth()->user()->id }}">
                                        <button type="submit">
                                            <img src="{{showImage($gateway_activations->where('method', 'Midtrans')->first()->logo)}}"
                                                alt="">
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if (@$payment_gateways->where('method','PayUMoney')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <a href="#" data-toggle="modal" data-target="#PayUMoneyModal">
                                        <img src="{{showImage($gateway_activations->where('method', 'PayUMoney')->first()->logo)}}"
                                            alt="">
                                    </a>
                                </div>
                            @endif
                            @if (@$payment_gateways->where('method','JazzCash')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <a href="#" data-toggle="modal" data-target="#JazzCashModal">
                                        <img src="{{showImage($gateway_activations->where('method', 'JazzCash')->first()->logo)}}"
                                            alt="">
                                    </a>
                                </div>
                            @endif
                            @if (@$payment_gateways->where('method','Google Pay')->first()->active_status == 1)
                                <div class="single_deposite" id="gPayBtn">
                                    <a id="buyButton">
                                        <img src="{{showImage($gateway_activations->where('method', 'Google Pay')->first()->logo)}}"
                                            alt="">
                                    </a>
                                </div>
                            @endif
                            @if (@$payment_gateways->where('method','FlutterWave')->first()->active_status == 1)
                                <div class="single_deposite">
                                    <a href="#" data-toggle="modal" data-target="#FlutterWaveModal">
                                        <img src="{{showImage($gateway_activations->where('method', 'FlutterWave')->first()->logo)}}"
                                            alt="">
                                    </a>
                                </div>
                            @endif

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

@include('multivendor::seller_payment.components._bank_payment_modal')
@include('multivendor::seller_payment.components._paytm_payment_modal')
@include('multivendor::seller_payment.components._instammojo_payment_modal')
@include('multivendor::seller_payment.components._payumoney_payment_modal')
@include('multivendor::seller_payment.components._jazzcash_payment_modal')
@include('multivendor::seller_payment.components._google_pay_script')
@include('multivendor::seller_payment.components._flutter_wave_payment_modal')
@if (isModuleActive('MercadoPago') && @$payment_gateways->where('method','Mercado Pago')->first()->active_status == 1)
    @include('multivendor::seller_payment.components._mercado_pago_modal')
@endif
@endsection
@push('scripts')
<script type="text/javascript">
    (function($){
            "use strict";
            $(document).ready(function() {
                $(".stripe-button-el").remove();
                $(".razorpay-payment-button").hide();
            });
            
        })(jQuery);
</script>
@endpush
