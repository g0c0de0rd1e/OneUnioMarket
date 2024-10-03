@extends('frontend.amazy.auth.layouts.app')

@push('styles')
    <style>
        .cursor_pointer{
            cursor: pointer!important;
        }

        .amaz_primary_btn.secondary{
            background: var(--text_color);
            border-color: var(--text_color);
        }
        .amaz_primary_btn.secondary:hover{
            background: var(--base_color);
            border-color: var(--base_color);
        }
    </style>
@endpush

@section('content')
<section class="pricing_part section_padding bg-white">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-6 col-md-10 mb_50">
                <div class="section__title">
                    <h3 class="mb_40">{{$content->pricingTitle}}</h3>
                    @php echo $content->pricingDescription; @endphp
                </div>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-lg-12 d-none">
                <div class="price_truggle d-flex">
                    <p>{{__('defaultTheme.monthly')}}</p>
                    <label class="switch-toggle outer">
                        <input id="pricingToggle" type="checkbox" />
                        <div></div>
                    </label>
                    <p class="pl-18">{{__('defaultTheme.yearly')}}</p>
                </div>
            </div> --}}

            @foreach($pricing_plans as $key => $item)
            <div class="col-lg-4 col-md-6">
                <div class="single_pricing_part {{$item->is_featured?'product_tricker':''}}">
                    @if($item->is_featured == 1)<span
                        class="product_tricker_text">{{__('defaultTheme.best value')}}</span> @endif
                    <div class="price_icon">
                        <!-- <i class="fas fa-star"></i> -->

                        <svg width="56" height="53" viewBox="0 0 56 53" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M26.0979 1.8541C26.6966 0.0114833 29.3034 0.0114799 29.9021 1.8541L34.9599 17.4205C35.2277 18.2445 35.9956 18.8024 36.862 18.8024H53.2295C55.1669 18.8024 55.9725 21.2817 54.4051 22.4205L41.1635 32.041C40.4625 32.5503 40.1692 33.453 40.437 34.2771L45.4948 49.8435C46.0935 51.6861 43.9845 53.2183 42.4171 52.0795L29.1756 42.459C28.4746 41.9497 27.5254 41.9497 26.8244 42.459L13.5829 52.0795C12.0155 53.2183 9.9065 51.6861 10.5052 49.8435L15.563 34.2771C15.8308 33.453 15.5375 32.5503 14.8365 32.041L1.59493 22.4205C0.0275064 21.2817 0.833055 18.8024 2.7705 18.8024H19.138C20.0044 18.8024 20.7723 18.2445 21.0401 17.4205L26.0979 1.8541Z" fill="currentColor"/>
                        </svg>

                    </div>
                    <div class="pricing_header">
                        <h5>{{$item->name}}</h5>
                        <div class="w-100">
                            <img src="{{ showImage($item->image) }}" alt="" class="img-fluid">
                        </div>
                        <div class="monthly_price_div">
                            <h2>{{single_price($item->monthly_cost)}}</h2>
                            <p>{{__('defaultTheme.per month')}}</p>
                        </div>
                        <div class="yearly_price_div d-none">
                            <h2>{{single_price($item->yearly_cost)}}</h2>
                            <p>{{__('defaultTheme.per year')}}</p>
                        </div>
                    </div>
                    <ul class="mb-5">
                        <li>
                            {{ __('defaultTheme.team_member') }}
                            : {{$item->team_size}}</li>
                        <li>{{__('defaultTheme.products')}} : {{$item->stock_limit}}</li>
                        <li>{{__('defaultTheme.categories')}} : {{$item->category_limit}}</li>
                        <li>{{__('defaultTheme.transaction_charge')}} : {{$item->transaction_fee}} % </li>
                    </ul>
                    <a class="amaz_primary_btn py-2 rounded-pill mb_20 text-center justify-content-center cursor_pointer select_btn_price" data-id='{{ $item->id }}'>{{__('defaultTheme.choose plan')}}</a>

                    <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                        <a class="amaz_primary_btn secondary cursor_pointer select_btn_price rounded-pill py-2">Edit</a>

                        <a class="amaz_primary_btn cursor_pointer select_btn_price rounded-pill py-2">Delete</a>
                    </div>
                </div>
            </div>
            @endforeach
            <form class="price_subscription_add d-none"
                action="{{ route('frontend.merchant-register-subscription-type') }}" method="get">

                <input type="hidden" id="id" name="id" value="">
                <input type="hidden" id="type" name="type" value="">
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    (function($){
        "use strict";
        $(document).ready(function(){
            $('#pricingToggle').on('change', function(){
                this.value = this.checked ? 1 : 0;
                if(this.value == 1){
                    $('#type').val('yearly');
                    $('.monthly_price_div').addClass('d-none');
                    $('.yearly_price_div').removeClass('d-none');
                }
                if(this.value == 0){
                    $('#type').val('monthly');
                    $('.yearly_price_div').addClass('d-none');
                    $('.monthly_price_div').removeClass('d-none');
                }
            });
            $(document).on('click','.select_btn_price', function(){
                event.preventDefault();
                $('#id').val($(this).attr("data-id"));
                $('.price_subscription_add').submit();
            });
        });
    })(jQuery);
</script>
@endpush
