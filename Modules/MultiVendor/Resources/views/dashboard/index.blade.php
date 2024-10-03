@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/multivendor/css/style.css'))}}" />
@endsection
@section('mainContent')

<section class="mb-40">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 mb_10">
                <div class="main-title d-flex">
                    <h3 class="mb-0 mr-3 text-nowrap">{{ __('common.summary') }}</h3>
                    <ul class="d-flex">
                        @if (getParentSeller()->slug)
                        <li>
                            <a href="{{route('frontend.seller',getParentSeller()->slug)}}" target="_blank"
                                class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('dashboard.shop_link') }}
                            </a>
                        </li>
                        @else
                        <li>
                            <a href="{{route('frontend.seller',base64_encode(getParentSellerId()))}}"target="_blank"
                                class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('dashboard.shop_link') }}
                            </a>
                        </li>
                        @endif
                        @if(@$sellerAccount->seller_commission_id == 3 && $subscription)
                            @php
                                $current_date = strtotime(date("Y-m-d"));
                                $expiry_date = strtotime($subscription->expiry_date?$subscription->expiry_date:'1970-01-01');
                            @endphp
                            @if (isset($subscription) && @$sellerAccount->seller_commission_id == 3 &&
                            $subscription->is_paid == 0 || isset($subscription) && $sellerAccount->seller_commission_id == 3 &&
                            $subscription->is_paid == 1 && $expiry_date < $current_date)
                                @if(permissionCheck('seller.subscription_payment_select'))
                                <li><a href="{{route('seller.subscription_payment_select',encrypt($subscription->id))}}" target="_blank"
                                        class="primary-btn radius_30px mr-10 pay_for_subscription">{{ __('common.pay_first_for_subcription') }}</a>
                                </li>
                                @endif
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
            @if(permissionCheck('seller_widgets'))
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="float-md-right float-none pos_tab_btn justify-content-end">
                    <ul class="nav">
                        <li class="nav-item mb_5">
                            <a class="nav-link filtering active" data-type="today"
                                href="javascript:void(0)">{{ __('dashboard.today') }}</a>
                        </li>
                        <li class="nav-item mb_5">
                            <a class="nav-link filtering" data-type="week"
                                href="javascript:void(0)">{{ __('dashboard.this_week') }}</a>
                        </li>
                        <li class="nav-item mb_5">
                            <a class="nav-link filtering" data-type="month"
                                href="javascript:void(0)">{{ __('dashboard.this_month') }}</a>
                        </li>
                        <li class="nav-item mb_5">
                            <a class="nav-link filtering" data-type="year"
                                href="javascript:void(0)">{{ __('dashboard.this_year') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
        @if(permissionCheck('seller_widgets'))
        <div class="row mb_30">
            @if (app('dashboard_setup')->where('type', 'total_product_card')->first()->is_active &&
            permissionCheck('seller_widgets_total_product'))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery @if (app('dashboard_setup')->where('type', 'total_products')->first()->is_active == 1) active @elseif (app('dashboard_setup')->where('type', 'total_products')->first()->is_active == 2) bg_active @endif">
                    <a @if (Auth::user()->role->type == "seller")
                        href="{{ route('seller.product.index') }}"
                        @else
                        href="{{ route('product.index') }}"
                        @endif
                        target="_blank">
                        <div class="d-block mt-10">
                            <h3>{{ __('dashboard.total_product') }} </h3>
                            <img class="demo_wait d-none" height="60px"
                                src="{{showImage('backend/img/loader.gif')}}" alt="">
                            <h1 class="gradient-color2 total_products">{{ getNumberTranslate($total_products) }}</h1>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @if (app('dashboard_setup')->where('type', 'total_order_card')->first()->is_active &&
            permissionCheck('seller_widgets_total_order'))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery @if (app('dashboard_setup')->where('type', 'total_order')->first()->is_active == 1) active @elseif (app('dashboard_setup')->where('type', 'total_order')->first()->is_active == 2) bg_active  @endif">
                    <a @if (Auth::user()->role->type == "seller" && isModuleActive('MultiVendor'))
                        href="{{route('order_manage.my_sales_index')}}"
                        @else
                        href="{{route('order_manage.total_sales_index')}}"
                        @endif

                        target="_blank">
                        <div class="d-block mt-10">
                            <h3>{{ __('dashboard.total_order') }}</h3>
                            <img class="demo_wait d-none" height="60px"
                                src="{{showImage('backend/img/loader.gif')}}" alt="">
                            <h1 class="gradient-color2 total_orders">{{ getNumberTranslate($total_orders) }}</h1>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @if (app('dashboard_setup')->where('type', 'total_pending_order_card')->first()->is_active &&
            permissionCheck('seller_widgets_total_delivery_order'))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery @if (app('dashboard_setup')->where('type', 'pending_order')->first()->is_active == 1) active @elseif (app('dashboard_setup')->where('type', 'pending_order')->first()->is_active == 2) bg_active  @endif">
                    <a @if (Auth::user()->role->type == "seller" && isModuleActive('MultiVendor'))
                        href="{{route('order_manage.my_sales_index')}}"
                        @else
                        href="{{route('order_manage.total_sales_index')}}"
                        @endif

                        target="_blank">
                        <div class="d-block mt-10">
                            <h3>{{ __('dashboard.total_delivered_order') }}</h3>
                            <img class="demo_wait d-none" height="60px"
                                src="{{showImage('backend/img/loader.gif')}}" alt="">
                            <h1 class="gradient-color2 total_delivered_order">{{ getNumberTranslate($total_delivered_orders) }}</h1>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @if (app('dashboard_setup')->where('type', 'total_pending_order_card')->first()->is_active &&
            permissionCheck('seller_widgets_non_total_delivery_order'))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery @if (app('dashboard_setup')->where('type', 'pending_order')->first()->is_active == 1) active @elseif (app('dashboard_setup')->where('type', 'pending_order')->first()->is_active == 2) bg_active  @endif">
                    <a @if (Auth::user()->role->type == "seller")
                        href="{{route('order_manage.my_sales_index')}}"
                        @else
                        href="{{route('order_manage.total_sales_index')}}"
                        @endif

                        target="_blank">
                        <div class="d-block mt-10">
                            <h3>{{ __('dashboard.total_non_delivered_order') }}</h3>
                            <img class="demo_wait d-none" height="60px"
                                src="{{showImage('backend/img/loader.gif')}}" alt="">
                            <h1 class="gradient-color2 total_not_delivered_orders">{{ getNumberTranslate($total_not_delivered_orders) }}
                            </h1>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @if (app('dashboard_setup')->where('type', 'total_completed_order_card')->first()->is_active &&
            permissionCheck('seller_widgets_total_sale'))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery @if (app('dashboard_setup')->where('type', 'completed_order')->first()->is_active == 1) active @elseif (app('dashboard_setup')->where('type', 'completed_order')->first()->is_active == 2) bg_active  @endif">
                    <a @if (Auth::user()->role->type == "seller" && isModuleActive('MultiVendor'))
                        href="{{route('order_manage.my_sales_index')}}"
                        @else
                        href="{{route('order_manage.total_sales_index')}}"
                        @endif

                        target="_blank">
                        <div class="d-block mt-10">
                            <h3>{{ __('dashboard.total_sale') }}</h3>
                            <img class="demo_wait d-none" height="60px"
                                src="{{showImage('backend/img/loader.gif')}}" alt="">
                            <h1 class="gradient-color2 total_sale">{{ single_price($total_sale) }}</h1>
                        </div>
                    </a>
                </div>
            </div>
            @endif
            @if (app('dashboard_setup')->where('type', 'total_review_card')->first()->is_active &&
            permissionCheck('seller_widgets_shop_review'))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery @if (app('dashboard_setup')->where('type', 'total_review')->first()->is_active == 1) active @elseif (app('dashboard_setup')->where('type', 'total_sale')->first()->is_active == 2) bg_active  @endif">
                    <div class="d-block mt-10">
                        <h3>{{ __('dashboard.shop_review') }}</h3>
                        <img class="demo_wait d-none" height="60px"
                            src="{{showImage('backend/img/loader.gif')}}" alt="">
                        <h1 class="gradient-color2 shop_review">{{ getNumberTranslate($shop_review) }}</h1>
                    </div>
                </div>
            </div>
            @endif
            @if (app('dashboard_setup')->where('type', 'total_revenue_card')->first()->is_active &&
            permissionCheck('seller_widgets_total_product_refund'))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery @if (app('dashboard_setup')->where('type', 'total_revenue')->first()->is_active == 1) active @elseif (app('dashboard_setup')->where('type', 'total_sale')->first()->is_active == 2) bg_active  @endif">
                    <div class="d-block mt-10">
                        <h3>{{ __('dashboard.total_product_refund') }}</h3>
                        <img class="demo_wait d-none" height="60px"
                            src="{{showImage('backend/img/loader.gif')}}" alt="">
                        <h1 class="gradient-color2 total_refund">{{ single_price($total_refund) }}</h1>
                    </div>
                </div>
            </div>
            @endif
            @if (app('dashboard_setup')->where('type', 'total_revenue_card')->first()->is_active &&
            permissionCheck('seller_widgets_total_product_refund'))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery @if (app('dashboard_setup')->where('type', 'total_revenue')->first()->is_active == 1) active @elseif (app('dashboard_setup')->where('type', 'total_sale')->first()->is_active == 2) bg_active  @endif">
                    <div class="d-block mt-10">
                        <h3>{{ __('seller.total_commision') }}</h3>
                        <img class="demo_wait d-none" height="60px"
                            src="{{showImage('backend/img/loader.gif')}}" alt="">
                        <h1 class="gradient-color2 total_commision">{{ single_price($total_commision) }}</h1>
                    </div>
                </div>
            </div>
            @endif
            @if(app('general_setting')->seller_wise_payment)
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div
                    class="white-box single-summery ">
                    <a href="{{route('seller.order-commssion-for-admin')}}" class="d-block mt-10">
                        <h3>{{ __('Order Commission For Pay') }}</h3>
                        <img class="demo_wait d-none" height="60px"
                            src="{{showImage('backend/img/loader.gif')}}" alt="">
                        <h1 class="gradient-color2 total_commision">{{ single_price($order_commission_for_admin) }}</h1>
                    </a>
                </div>
            </div>
            @endif
        </div>

        @endif

        @if(permissionCheck('seller_graphs'))
        <div class="row mb_30 @if(permissionCheck('seller_widgets')) @else mt-30 @endif">
            @if(permissionCheck('seller_graphs_total_order_summary'))
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="white_box_30px mb_30 graph_dashboard">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.total_order_summary') }}</h3>
                        </div>
                    </div>
                    <div class="chart_pie_box">
                        <canvas height="150" id="traffic-chart_a"></canvas>
                        <div class="sales_value_legend" id="traffic-chart-legend_a"></div>
                    </div>
                </div>
            </div>
            @endif
            @if(permissionCheck('seller_graphs_total_sale_summary'))
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="white_box_30px mb_30 graph_dashboard">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.total_sale_summary') }}</h3>
                        </div>
                    </div>
                    <div class="chart_pie_box">
                        <canvas height="150" id="traffic-chart2"></canvas>
                    </div>
                    <div class="sales_value_legend" id="traffic-chart-legend2"></div>
                </div>
            </div>
            @endif
            @if(permissionCheck('seller_graphs_sales_vs_refund'))
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="white_box_30px mb_30 graph_dashboard">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.sale_vs_refund') }}</h3>
                        </div>
                    </div>
                    <div class="chart_pie_box">
                        <canvas height="150" id="traffic-chart3"></canvas>
                    </div>
                    <div class="sales_value_legend" id="traffic-chart-legend3"></div>
                </div>
            </div>
            @endif

        </div>
        @endif


        <div class="row mb_30">
            @if(permissionCheck('seller_top_sale_products'))
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="white_box_30px mb_30">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.top_sale_products') }}</h3>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active4">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{__('common.name')}}</th>
                                            <th scope="col">{{ __('common.brand') }}</th>
                                            <th scope="col">{{ __('dashboard.total_sale') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($top_sale_products as $key => $top_ten_product)
                                        <tr>
                                            <td><a href="{{singleProductURL($top_ten_product->seller->slug, $top_ten_product->slug)}}"
                                                    target="_blank">{{$top_ten_product->product->product_name}}</a></td>

                                            <td>{{$top_ten_product->product->brand->name}}</td>
                                            <td>{{ getNumberTranslate($top_ten_product->total_sale)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(permissionCheck('seller_latest_uploaded_products'))
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="white_box_30px mb_30">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.latest_uploaded_products') }}
                            </h3>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active4">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{__('common.name')}}</th>
                                            <th scope="col">{{ __('common.brand') }}</th>
                                            <th scope="col">{{ __('dashboard.total_sale') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($latest_uploaded_products as $key => $product)
                                        <tr>
                                            <td><a href="{{singleProductURL($product->seller->slug, $product->slug)}}"
                                                    target="_blank">{{$product->product->product_name}}</a>
                                            </td>
                                            <td>{{$product->product->brand->name}}</td>
                                            <td>{{ getNumberTranslate($product->total_sale)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(permissionCheck('seller_latest_orders'))
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="white_box_30px mb_30">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.latest_order') }}</h3>
                            <ul class="d-flex">
                                <li><a href="{{route('order_manage.my_sales_index')}}" target="_blank"
                                        class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('common.see_all') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active4">
                                    <thead>
                                        <tr>
                                            <th width="10%">{{__('common.date')}}</th>
                                            <th>{{__('common.order_id')}}</th>
                                            <th>{{__('order.order_state')}}</th>
                                            <th>{{__('common.total_amount')}}</th>
                                            <th>{{__('common.action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latest_orders as $key => $latest_order)
                                        <tr>
                                            <td class="nowrap">
                                                {{ dateConvert($latest_order->order->created_at) }}
                                            </td>
                                            <td>{{ getNumberTranslate(@$latest_order->order->order_number) }}</td>
                                            <td>
                                                @if ($latest_order->order->is_confirmed == 1)
                                                <h6><span class="badge_1">{{__('common.confirmed')}}</span></h6>
                                                @elseif ($latest_order->order->is_confirmed == 2)
                                                <h6><span class="badge_4">{{__('common.declined')}}</span></h6>
                                                @else
                                                <h6><span class="badge_4">{{__('common.pending')}}</span></h6>
                                                @endif
                                            </td>
                                            <td>
                                                {{single_price($latest_order->products->sum('total_price') + $latest_order->shipping_cost + $latest_order->tax_amount)}}
                                            </td>
                                            <td>
                                                <a href="@if(auth()->user()->role->type == 'seller') {{route('order_manage.show_details_mine',$latest_order->id)}} @else {{route('order_manage.show_details',$latest_order->id)}} @endif"
                                                    class="primary_btn_2" type="button" target="_blank"><i
                                                        class="ti-eye"></i>{{__('common.details')}}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(permissionCheck('seller_latest_refund_request'))
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="white_box_30px mb_30">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.latest_refund_request') }}
                            </h3>
                            <ul class="d-flex">
                                <li><a href="{{route('refund.my_refund_list')}}" target="_blank"
                                        class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('common.see_all') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active4">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.date') }}</th>
                                            <th>{{ __('common.order_id') }}</th>
                                            <th>{{ __('common.total_amount') }}</th>
                                            <th>{{ __('dashboard.request_status') }}</th>
                                            <th>{{ __('dashboard.is_refunded') }}</th>
                                            <th>{{ __('dashboard.refunded_action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latest_refund_requests as $key => $latest_refund)
                                        <tr>
                                            <td class="nowrap">
                                                {{ dateConvert($latest_refund->created_at) }}
                                            </td>
                                            <td>{{ getNumberTranslate(@$latest_refund->order->order_number) }}</td>
                                            <td>
                                                {{ single_price($latest_refund->total_return_amount) }}
                                            </td>
                                            <td>
                                                @if ($latest_refund->is_confirmed == 1)
                                                <h6><span class="badge_1">{{ __('common.confirmed') }}</span></h6>
                                                @elseif ($latest_refund->is_confirmed == 2)
                                                <h6><span class="badge_4">{{ __('common.declined') }}</span></h6>
                                                @else
                                                <h6><span class="badge_4">{{ __('common.pending') }}</span></h6>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($latest_refund->is_refunded == 1)
                                                <h6><span class="badge_1">{{ __('common.refunded') }}</span></h6>
                                                @else
                                                <h6><span class="badge_4">{{ __('common.pending') }}</span></h6>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('refund.refund_show_details',$latest_refund->id)}}"
                                                    class="primary_btn_2" type="button" target="_blank"><i
                                                        class="ti-eye"></i>{{__('common.details')}}</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if (isset($subscription) && permissionCheck('seller_subscription_payments'))
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="white_box_30px mb_30">
                    <div class="box_header common_table_header ">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('dashboard.subscription_payments') }}
                            </h3>

                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active4">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.date') }}</th>
                                            <th>{{ __('common.name') }}</th>
                                            <th>{{ __('common.total_amount') }}</th>
                                            <th>{{ __('common.payment_type') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($subscription_payment as $key => $payment)
                                        <tr>
                                            <td class="nowrap">
                                                {{ dateConvert($payment->created_at) }}
                                            </td>
                                            <td>{{ @$payment->subscription_payment->commission_type }}</td>
                                            <td>
                                                {{ single_price($payment->amount) }}
                                            </td>
                                            <td>
                                                {{ @$payment->subscription_payment->subscription_type }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <input type="hidden" id="graph_total_orders" value="{{ $graph_total_orders }}">
        <input type="hidden" id="graph_total_delivered_orders" value="{{ $graph_total_delivered_orders }}">
        <input type="hidden" id="graph_total_not_delivered_orders" value="{{ $graph_total_not_delivered_orders }}">
        <input type="hidden" id="graph_total_shipping" value="{{ $graph_total_shipping }}">
        <input type="hidden" id="graph_total_tax" value="{{ $graph_total_tax }}">
        <input type="hidden" id="graph_total_net_sale" value="{{ $graph_total_net_sale }}">
        <input type="hidden" id="graph_total_sale" value="{{ $graph_total_sale }}">
        <input type="hidden" id="graph_total_refund" value="{{ $graph_total_refund }}">
</section>
@endsection
@push('scripts')
<script type="text/javascript">
    (function($) {
          "use strict";
          $(document).on('click', '.filtering', function () {
              $('.filtering').removeClass('active');
              $(this).addClass('active');
              let type = $(this).data('type');
              $('.gradient-color2').hide();
              $('.demo_wait').removeClass('d-none');
              $.ajax({
                  method: "get",
                  url: "{{url('seller/seller-dashboard-cards-info')}}" + "/" + type,
                  success: function (data) {
                      $('.total_sale').text(data.total_sale);
                      $('.total_orders').text(data.total_orders);
                      $('.total_delivered_order').text(data.total_delivered_orders);
                      $('.total_not_delivered_orders').text(data.total_not_delivered_orders);
                      $('.shop_review').text(data.shop_review);
                      $('.total_refund').text(data.total_refund);
                      $('.total_commision').text(data.total_commision);
                      $('.gradient-color2').show();
                      $('.demo_wait').addClass('d-none');
                  }
              })
          });
          $(function() {
            Chart.defaults.global.legend.labels.usePointStyle = true;
            if (document.getElementById('traffic-chart_a') != null) {
                var ctx = document.getElementById('traffic-chart_a').getContext("2d");
                if ($("#traffic-chart_a").length) {

                  var trafficChartData = {
                    datasets: [{
                      data: [$('#graph_total_orders').val(), $('#graph_total_delivered_orders').val(), $('#graph_total_not_delivered_orders').val()],
                      backgroundColor: [
                        "#d5d1fc",
                        "#b044cf",
                        "#c7eaee"
                      ],
                      hoverBackgroundColor: [
                          "#d5d1fc",
                          "#b044cf",
                          "#c7eaee"
                      ],
                      borderColor: [
                        "transparent",
                        "transparent",
                        "transparent"
                      ],
                      legendColor: [
                        "#d5d1fc",
                        "#b044cf",
                        "#c7eaee"
                      ]
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                      'Total',
                      'Delivered',
                      'Not Delivered',
                    ]
                  };

                  var trafficChartOptions = {
                    responsive: true,
                    cutoutPercentage: 65,
                    animation: {
                      animateScale: true,
                      animateRotate: true
                    },
                    legend: false,
                    legendCallback: function(chart) {
                      var text = [];
                      text.push('<ul>');
                      for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) {
                          text.push('<li><span class="legend-dots" style="background:' +
                          trafficChartData.datasets[0].legendColor[i] +
                                      '"></span><div class="legend_name"><span>');
                          if (trafficChartData.labels[i]) {
                              text.push(trafficChartData.labels[i]);
                          }
                          text.push('</span><span class="value_legend">'+trafficChartData.datasets[0].data[i]+'</span>')
                          text.push('</div></li>');
                      }
                      text.push('</ul>');
                      return text.join('');
                    }
                  };
                  var trafficChartCanvas = $("#traffic-chart_a").get(0).getContext("2d");
                  var trafficChart = new Chart(trafficChartCanvas, {
                    type: 'doughnut',
                    data: trafficChartData,
                    options: trafficChartOptions
                  });
                  $("#traffic-chart-legend_a").html(trafficChart.generateLegend());
                }
            }
            if (document.getElementById('traffic-chart2') != null) {
                Chart.defaults.global.legend.labels.usePointStyle = true;
                var ctx = document.getElementById('traffic-chart2').getContext("2d");
                if ($("#traffic-chart2").length) {

                  var trafficChartData = {
                    datasets: [{
                      data: [$('#graph_total_net_sale').val(), $('#graph_total_tax').val(), $('#graph_total_shipping').val()],
                      backgroundColor: [
                        "#d5d1fc",
                        "#c7eaee",
                        "#b044cf",
                      ],
                      hoverBackgroundColor: [
                        "#d5d1fc",
                        "#c7eaee",
                        "#b044cf",
                      ],
                      borderColor: [
                        "transparent",
                        "transparent",
                        "transparent",
                      ],
                      legendColor: [
                        "#d5d1fc",
                        "#c7eaee",
                        "#b044cf",
                      ]
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                      'Net Sale',
                      'Tax',
                      'Shipping',
                    ]
                  };

                  var trafficChartOptions = {
                    responsive: true,
                    cutoutPercentage: 65,
                    animation: {
                      animateScale: true,
                      animateRotate: true
                    },
                    legend: false,
                    legendCallback: function(chart) {
                      var text = [];
                      text.push('<ul>');
                      for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) {
                          text.push('<li><span class="legend-dots" style="background:' +
                          trafficChartData.datasets[0].legendColor[i] +
                                      '"></span><div class="legend_name"><span>');
                          if (trafficChartData.labels[i]) {
                              text.push(trafficChartData.labels[i]);
                          }
                          text.push('</span><span class="value_legend">'+"$"+trafficChartData.datasets[0].data[i]+'</span>')
                          text.push('</div></li>');
                      }
                      text.push('</ul>');
                      return text.join('');
                    }
                  };
                  var trafficChartCanvas = $("#traffic-chart2").get(0).getContext("2d");
                  var trafficChart = new Chart(trafficChartCanvas, {
                    type: 'doughnut',
                    data: trafficChartData,
                    options: trafficChartOptions
                  });
                  $("#traffic-chart-legend2").html(trafficChart.generateLegend());
                }
            }
            if (document.getElementById('traffic-chart3') != null) {
                Chart.defaults.global.legend.labels.usePointStyle = true;
                var ctx = document.getElementById('traffic-chart3').getContext("2d");
                if ($("#traffic-chart3").length) {

                  var trafficChartData = {
                    datasets: [{
                      data: [$('#graph_total_sale').val(), $('#graph_total_refund').val()],
                      backgroundColor: [
                        "#d5d1fc",
                        "#c7eaee",
                      ],
                      hoverBackgroundColor: [
                        "#d5d1fc",
                        "#c7eaee",
                      ],
                      borderColor: [
                        "transparent",
                        "transparent",
                      ],
                      legendColor: [
                        "#d5d1fc",
                        "#c7eaee",
                      ]
                    }],

                    // These labels appear in the legend and in the tooltips when hovering different arcs
                    labels: [
                      'Sale Amount',
                      'Refund Amount',
                    ]
                  };

                  var trafficChartOptions = {
                    responsive: true,
                    cutoutPercentage: 65,
                    animation: {
                      animateScale: true,
                      animateRotate: true
                    },
                    legend: false,
                    legendCallback: function(chart) {
                      var text = [];
                      text.push('<ul>');
                      for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) {
                          text.push('<li><span class="legend-dots" style="background:' +
                          trafficChartData.datasets[0].legendColor[i] +
                                      '"></span><div class="legend_name"><span>');
                          if (trafficChartData.labels[i]) {
                              text.push(trafficChartData.labels[i]);
                          }
                          text.push('</span><span class="value_legend">'+"$"+trafficChartData.datasets[0].data[i]+'</span>')
                          text.push('</div></li>');
                      }
                      text.push('</ul>');
                      return text.join('');
                    }
                  };
                  var trafficChartCanvas = $("#traffic-chart3").get(0).getContext("2d");
                  var trafficChart = new Chart(trafficChartCanvas, {
                    type: 'doughnut',
                    data: trafficChartData,
                    options: trafficChartOptions
                  });
                  $("#traffic-chart-legend3").html(trafficChart.generateLegend());
                }
            }
          });
        })(jQuery);

</script>
@endpush
