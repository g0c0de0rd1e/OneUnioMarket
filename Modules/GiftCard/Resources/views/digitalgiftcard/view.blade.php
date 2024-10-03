@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/giftcard/css/style.css'))}}" />

@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.name') }}: {{$giftCards->name}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-8 student-details">
                <div class="white_box_50px box_shadow_white" id="printableArea">
                    <div class="row pb-30 border-bottom">
                        <div class="col-md-6 col-lg-6">
                            <div class="logo_div">
                                <img src="{{showImage(app('general_setting')->logo)}}" width="100px" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-30">
                        <div class="col-md-6 col-lg-6">
                            <table class="table-borderless clone_line_table">
                                <tr>
                                    <td><strong></strong></td>
                                </tr>
                                <tr>
                                    <td>{{__('common.name')}}</td>
                                    <td>: {{$giftCards->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.description')}}</td>
                                    <td>: {{$giftCards->description}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('gift_card.gift_card_value')}}</td>
                                    <td>: {{$giftCards->addGiftCard->pluck('gift_card_value')->implode(', ') ?? ''}}</td>
                                </tr>

                                <tr>
                                    <td>{{__('gift_card.number_of_gift_card')}}</td>
                                    <td>: {{$giftCards->addGiftCard->pluck('number_of_gift_card')->implode(', ') ?? ''}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('gift_card.selling_price')}}</td>
                                    <td>: {{$giftCards->addGiftCard->pluck('gift_selling_price')->implode(', ') ?? ''}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('gift_card.discount_type')}}</td>
                                    <td>: {{$giftCards->addGiftCard->pluck('gift_discount_type')->implode(', ') ?? ''}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('gift_card.gift_discount_amount')}}</td>
                                    <td>: {{$giftCards->addGiftCard->pluck('gift_discount_amount')->implode(', ') ?? ''}}</td>
                                </tr>
                                <tr>
                                    <td>{{__('common.end_date')}}</td>
                                    <td>: {{dateConvert($giftCards->addGiftCard->pluck('end_date')->implode(', ') ?? '')}}</td>
                                </tr>
                            </table>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>


    </script>
@endpush
