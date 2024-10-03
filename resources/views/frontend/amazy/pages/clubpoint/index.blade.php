@extends('frontend.amazy.layouts.app')
@push('styles')
    <style>
        .amaz_select3 {
            min-width: 220px;
        }
    </style>
@endpush
@section('content')
    <div class="amazy_dashboard_area dashboard_bg section_spacing6">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    @include('frontend.amazy.pages.profile.partials._menu')
                </div>
                
                <div class="col-xl-9 col-lg-8">
                    <div class="dashboard_white_box bg-white mb_25">
                        <h4 class="mb-4">{{__('clubpoint.my_points')}}</h4>
                        <div class="text-center">    
                            <h3>{{getNumberTranslate($wallet_point->wallet_point)}} {{__('clubpoint.point')}} = {{single_price(1)}} {{__('clubpoint.wallet_money')}}</h3>
                            <span>{{__('clubpoint.exchange_rate')}}</span>
                            <p>{{__('clubpoint.piint_convert_refund_date_over')}}</p>
                        </div>
                    </div>

                    <div class="dashboard_white_box bg-white mb_25 pt-0">                        
                        <div class="dashboard_white_box_body">
                            <div class="table-responsive mb_30">
                                <table class="table amazy_table2 mb-0">
                                    <thead>
                                        <tr>
                                            <th class="font_14 f_w_700 priamry_text text-nowrap" scope="col">{{__('common.sl')}}</th>
                                            <th class="font_14 f_w_700" scope="col">{{__('common.date')}}</th>
                                            <th class="font_14 f_w_700" scope="col">{{__('clubpoint.Order_code')}}</th>
                                            <th class="font_14 f_w_700 border-start-0 border-end-0" scope="col">{{__('clubpoint.point')}}</th>
                                            <th class="font_14 f_w_700 border-start-0 border-end-0" scope="col">{{__('common.action')}}</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @php
                                        $i = ($orders->perPage() * ($orders->currentPage() - 1)) + 1;
                                        @endphp 
                                            @foreach(@$orders as $key => $order)             
                                                <tr>
                                                    <td>{{getNumberTranslate($i++)}}</td>
                                                    <td><span class="font_14 f_w_500 mute_text">{{dateConvert($order->created_at)}} </span></td>
                                                    <td>
                                                        <h4>{{getNumberTranslate(@$order->order->order_number)}}</h4>
                                                    </td>
                                                    <td>
                                                    {{@getNumberTranslate($order->order->club_point ?? 0)}} {{__('clubpoint.pts')}}
                                                    </td>
                                                    <td>
                                                        @php
                                                        $refund_time = app('business_settings')->where('type', 'refund_times')->first();                                                      
                                                        $date_sum =\Carbon\Carbon::parse($order->order->updated_at)->addDays($refund_time->status);                                
                                                        @endphp       
                                                        @if ($date_sum->gte(\Carbon\Carbon::now()))
                                                            <h6><span class="table_badge_btn text-nowrap text-uppercase">{{__('common.pending')}}</span></h6>
                                                        @elseif($order->order->point_convert == 1)
                                                            <h6><span class="table_badge_btn style4 text-nowrap Converted_done">{{__('common.done')}}</span></h6>                                                                                                       
                                                        @else
                                                        <a href="{{route('clubpoint.point',$order->order_id)}}" class="amaz_primary_btn style3 text-uppercase Converted_btn">{{__('clubpoint.converted_now')}}</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                             @endforeach

                                    </tbody>
                                   
                                </table>
                            </div>
                            @if($orders->lastPage() > 1)
                                <x-pagination-component :items="$orders" type=""/>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_div"></div>
@endsection

