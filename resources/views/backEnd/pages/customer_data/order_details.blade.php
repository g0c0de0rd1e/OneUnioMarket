@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/ordermanage/css/sale_details.css'))}}" />
<style>
    .dashboard_white_box.style3 {
        padding: 30px 30px 36px 30px;
    }
    .bg-white {
        background-color: #fff!important;
    }
    .rounded-0 {
        border-radius: 0!important;
    }
    .mb_20 {
        margin-bottom: 20px;
    }
    .f_w_700 {
        font-weight: 700 !important;
    }
    .font_20 {
        font-size: 20px;
    }
    .f_w_400 {
        font-weight: 400 !important;
    }
    .font_14 {
        font-size: 14px !important;
    }
</style>
@endsection
@section('mainContent')
    <div id="add_product">
        <section class="admin-visitor-area up_st_admin_visitor">
            <div class="container-fluid p-0">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="box_header common_table_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ $order->order_number }} </h3>
                                <ul class="d-flex float-right">
                                    <li><a href="{{ route('order_manage.print_order_details', $order->id) }}" target="_blank" class="primary-btn fix-gr-bg radius_30px mr-10">{{ __('order.print') }}</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 student-details">
                        <div class="white_box_50px box_shadow_white" id="printableArea">
                            <div class="row pb-30 border-bottom">
                                <div class="col-md-6 col-lg-6">
                                    <div class="logo_div">
                                        <img src="{{ showImage(app('general_setting')->logo) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 text-right">
                                    <h4>{{ $order->order_number }}</h4>
                                </div>
                            </div>
                            <div class="row mt-30">
                                @if ($order->customer_id)
                                    <div class="col-md-6 col-lg-6">
                                        <table class="table-borderless clone_line_table">
                                            <tr>
                                                <td><strong>{{__('defaultTheme.billing_info')}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.name')}}</td>
                                                <td>: {{ @$order->address->billing_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.email')}}</td>
                                                <td><a class="link_color" href="mailto:{{ @$order->address->billing_email }}">: {{ @$order->address->billing_email }}</a></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.phone')}}</td>
                                                <td>: {{ @$order->address->billing_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.address')}}</td>
                                                <td>: {{ @$order->address->billing_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.city')}}</td>
                                                <td>: {{ @$order->address->getBillingCity->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.state')}}</td>
                                                <td>: {{ @$order->address->getBillingState->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.country')}}</td>
                                                <td>: {{ @$order->address->getBillingCity->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.postcode')}}</td>
                                                <td>: {{ @$order->address->billing_postcode }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @else
                                    <div class="col-md-6 col-lg-6">
                                        <table class="table-borderless clone_line_table">
                                            <tr>
                                                <td><strong>{{__('defaultTheme.billing_info')}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.name')}}</td>
                                                <td>: {{$order->guest_info->billing_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.email')}}</td>
                                                <td><a class="link_color" href="mailto:{{$order->guest_info->billing_email}}">: {{$order->guest_info->billing_email}}</a></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.phone')}}</td>
                                                <td>: {{$order->guest_info->billing_phone}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.address')}}</td>
                                                <td>: {{$order->guest_info->billing_address}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.city')}}</td>
                                                <td>: {{@$order->guest_info->getBillingCity->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.state')}}</td>
                                                <td>: {{@$order->guest_info->getBillingState->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.country')}}</td>
                                                <td>: {{@$order->guest_info->getBillingCountry->name}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                                <div class="col-md-6 col-lg-6">
                                    @if ($order->customer_id)
                                        <table class="table-borderless clone_line_table">
                                            <tr>
                                                <td><strong>{{__('defaultTheme.shipping_info')}} @if($order->delivery_type == 'pickup_location')(Collect from Pickup location) @endif</strong></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.name')}}</td>
                                                <td>: {{ @$order->address->shipping_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.email')}}</td>
                                                <td><a class="link_color" href="mailto:{{ @$order->address->shipping_email }}">: {{ @$order->address->shipping_email }}</a></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.phone')}}</td>
                                                <td>: {{ @$order->address->shipping_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.address')}}</td>
                                                <td>: {{ @$order->address->shipping_address }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.city')}}</td>
                                                <td>: {{ @$order->address->getShippingCity->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.state')}}</td>
                                                <td>: {{ @$order->address->getShippingState->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.country')}}</td>
                                                <td>: {{ @$order->address->getShippingCountry->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.postcode')}}</td>
                                                <td>: {{ @$order->address->shipping_postcode }}</td>
                                            </tr>
                                        </table>
                                    @else
                                        <table class="table-borderless clone_line_table">
                                            <tr>
                                                <td><strong>{{__('defaultTheme.shipping_info')}} @if($order->delivery_type == 'pickup_location')(Collect from Pickup location) @endif</strong></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.secret_id')}}</td>
                                                <td>: {{$order->guest_info->guest_id}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.name')}}</td>
                                                <td>: {{$order->guest_info->shipping_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.email')}}</td>
                                                <td><a class="link_color" href="mailto:{{$order->guest_info->shipping_email}}">: {{$order->guest_info->shipping_email}}</a></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.phone')}}</td>
                                                <td>: {{$order->guest_info->shipping_phone}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.address')}}</td>
                                                <td>: {{$order->guest_info->shipping_address}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.city')}}</td>
                                                <td>: {{@$order->guest_info->getShippingCity->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.state')}}</td>
                                                <td>: {{@$order->guest_info->getShippingState->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.country')}}</td>
                                                <td>: {{@$order->guest_info->getShippingCountry->name}}</td>
                                            </tr>
                                        </table>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-30">

                                <div class="col-md-6 col-lg-6">
                                    <table class="table-borderless clone_line_table">
                                        <tr>
                                            <td><strong>{{__('defaultTheme.payment_info')}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.payment_method')}}</td>
                                            <td>: {{ $order->GatewayName }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.amount')}}</td>
                                            <td>: {{ single_price(@$order->order_payment->amount) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('order.txn_id')}}</td>
                                            <td>: {{ @$order->order_payment->txn_id }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.date')}}</td>
                                            <td>:
                                                {{ date(app('general_setting')->dateFormat->format, strtotime(@$order->order_payment->created_at)) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{__('defaultTheme.payment_status')}}</td>
                                            <td>:
                                                @if ($order->is_paid == 1)
                                                    <span>{{__('common.paid')}}</span>
                                                @else
                                                    <span>{{__('common.pending')}}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                @if(isModuleActive('Affiliate'))
                                    @if($order->affiliateUser)
                                    <div class="col-md-6 col-lg-6">
                                        <table class="table-borderless clone_line_table">
                                            <tr>
                                                <td><strong>{{__('affiliate.affiliate_user')}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.name')}}</td>
                                                <td>: <a target="_blank" class="link_color" href="{{route('affiliate.user.show',$order->affiliateUser->payment_to)}}">{{ @$order->affiliateUser->user->first_name }}</a></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.email')}}</td>
                                                <td>: {{ @$order->affiliateUser->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.phone')}}</td>
                                                <td>: {{ @$order->affiliateUser->user->phone }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    @endif
                                @endif
                            </div>
                            <div class="row mt-30">
                                @foreach ($order->packages as $key => $order_package)
                                    <div class="col-12 mt-30">
                                        @if ($order_package->is_cancelled == 1)
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label red"> {{__('defaultTheme.order_cancelled')}} - ({{ $order_package->package_code }}) </label>
                                            </div>
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label sub-title"> {{ @$order_package->cancel_reason->name }}</label>
                                            </div>
                                        @endif
                                        <div class="box_header common_table_header">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.package')}}:
                                                {{ $order_package->package_code }} @if ($order_package->delivery_process)
                                                    <small>({{ @$order_package->delivery_process->name }})</small>
                                                @endif
                                            </h3>
                                            @if(isModuleActive('MultiVendor'))
                                            <ul class="d-flex float-right">
                                                <li>
                                                    <strong>
                                                        @if($order_package->seller->role->type == 'seller')
                                                            {{ @$order_package->seller->SellerAccount->seller_shop_display_name ? @$order_package->seller->SellerAccount->seller_shop_display_name : @$order_package->seller->first_name }}
                                                        @else
                                                            {{ app('general_setting')->company_name }}
                                                        @endif
                                                    </strong>
                                                </li>
                                            </ul>
                                            @endif
                                        </div>
                                        <div class="box_header common_table_header justify-content-lg-end">
                                            <ul class="d-flex float-right">
                                                <li> <strong>{{__('shipping.shipping_method')}} : {{ $order_package->shipping->method_name }}</strong></li>
                                            </ul>
                                        </div>
                                        <div class="QA_section QA_section_heading_custom check_box_table">
                                            <div class="QA_table ">
                                                <!-- table-responsive -->
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th scope="col">{{__('common.sl')}}</th>
                                                            <th scope="col">{{__('common.image')}}</th>
                                                            <th scope="col">{{__('common.name')}}</th>
                                                            <th scope="col">{{__('common.details')}}</th>
                                                            <th scope="col">{{__('common.price')}}</th>
                                                            <th scope="col">{{__('common.tax')}}/{{__('gst.gst')}}</th>
                                                            <th scope="col">{{__('common.total')}}</th>
                                                        </tr>
                                                        @foreach ($order_package->products as $key => $package_product)
                                                            <tr>
                                                                <td>{{ getNumberTranslate($key + 1)}}</td>
                                                                <td>
                                                                    <div class="product_img_div">
                                                                        @if ($package_product->type == "gift_card")
                                                                            <img src="{{showImage(@$package_product->giftCard->thumbnail_image)}}" alt="#">
                                                                        @else
                                                                            @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                                <img src="{{showImage(@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}"
                                                                                     alt="#">
                                                                            @else
                                                                                <img src="{{showImage(@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->product->thum_img??@$package_product->seller_product_sku->product->product->thumbnail_image_source)}}"
                                                                                     alt="#">
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    @if ($package_product->type == "gift_card")
                                                                    <span class="text-nowrap">{{substr(@$package_product->giftCard->name,0,22)}} @if(strlen(@$package_product->giftCard->name) > 22)... @endif</span>
                                                                    @else
                                                                        <span class="text-nowrap">{{substr(@$package_product->seller_product_sku->sku->product->product_name,0,22)}} @if(strlen(@$package_product->seller_product_sku->sku->product->product_name) > 22)... @endif</span>
                                                                    @endif
                                                                </td>
                                                                @if ($package_product->type == "gift_card")
                                                                    <td class="text-nowrap">{{__('common.qty')}}: {{ getNumberTranslate($package_product->qty) }}</td>
                                                                @else
                                                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 2)
                                                                        <td class="text-nowrap">
                                                                            {{__('common.qty')}}: {{getNumberTranslate( $package_product->qty)}}
                                                                            <br>
                                                                            @php
                                                                                $countCombinatiion = count(@$package_product->seller_product_sku->product_variations);
                                                                            @endphp
                                                                            @foreach (@$package_product->seller_product_sku->product_variations as $key => $combination)
                                                                                @if ($combination->attribute->id == 1)
                                                                                    <div class="box_grid ">
                                                                                        <span>{{ $combination->attribute->name }}:</span><span class='box variant_color' style="background-color:{{ $combination->attribute_value->value }}"></span>
                                                                                    </div>
                                                                                @else
                                                                                    {{ $combination->attribute->name }}:
                                                                                    {{ $combination->attribute_value->value }}
                                                                                @endif
                                                                                @if (getNumberTranslate($countCombinatiion > $key + 1))
                                                                                    <br>
                                                                                @endif
                                                                            @endforeach
                                                                        </td>
                                                                    @else
                                                                        <td class="text-nowrap">{{__('common.qty')}}: {{ getNumberTranslate($package_product->qty) }}</td>
                                                                    @endif
                                                                @endif

                                                                <td class="text-nowrap">{{ single_price($package_product->price) }}</td>
                                                                <td class="text-nowrap">{{ single_price($package_product->tax_amount) }}</td>
                                                                <td class="text-nowrap">{{ single_price($package_product->price * $package_product->qty + $package_product->tax_amount) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row mt-30">
                                <div class="col-md-12 col-lg-12">
                                    <table class="table-borderless clone_line_table w-100">
                                        <tr>
                                            <td><strong>{{__('order.order_info')}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>{{__('order.is_paid')}}</td>
                                            <td class="pl-25 text-nowrap">: {{ $order->is_paid == 1 ? __('common.yes') : __('common.no') }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('order.subtotal')}}</td>
                                            <td class="pl-25 text-nowrap">: {{ single_price($order->sub_total) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.discount')}}</td>
                                            <td class="pl-25 text-nowrap">: - {{ single_price($order->discount_total) }}</td>
                                        </tr>
                                        @if($order->coupon)
                                        <tr>
                                            <td>{{__('common.coupon')}} {{__('common.discount')}}</td>
                                            <td class="pl-25 text-nowrap">: - {{single_price($order->coupon->discount_amount)}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>{{__('common.shipping_charge')}}</td>
                                            <td class="pl-25 text-nowrap">: + {{ single_price($order->shipping_total) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('common.tax')}}/{{__('gst.gst')}}</td>
                                            <td class="pl-25 text-nowrap">: + {{ single_price($order->tax_amount) }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('order.grand_total')}}</td>
                                            <td class="pl-25 text-nowrap">: {{ single_price($order->grand_total) }}</td>
                                        </tr>
                                    </table>
                                </div>
                                @if (@$order->order_payment->payment_method == 7)
                                    <div class="col-md-6 col-lg-6">
                                        <table class="table-borderless clone_line_table">
                                            <tr>
                                                <td><strong>{{__('order.bank_details')}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('common.bank_name') }}</td>
                                                <td>: {{ @$order->order_payment->item_details->bank_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('common.branch_name') }}</td>
                                                <td>: {{ @$order->order_payment->item_details->branch_name }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('common.account_number') }}</td>
                                                <td>: {{ @$order->order_payment->item_details->account_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('wallet.account_holder') }}</td>
                                                <td>: {{ @$order->order_payment->item_details->account_holder }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('common.attachment') }}</td>
                                                <td>: <a href="{{ asset(asset_path(@$order->order_payment->item_details->image_src)) }}" target="_blank">{{ __('common.check') }}</a> </td>
                                            </tr>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 student-details">
                        @foreach ($processes as $key => $process)
                        <div class="dashboard_white_box style3 rounded-0 bg-white mb_20">
                            <div class="dashboard_white_box_body">
                            <h4 class="font_20 f_w_700 mb-2">{{ $process->name }}</h4>
                            <p class="lineHeight1 font_14 f_w_400 mb-0">{{ $process->description }}</p>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
