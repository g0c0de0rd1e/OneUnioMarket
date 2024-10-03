<!DOCTYPE html>
<html lang="en" @if(isRtl()) dir="rtl" class="rtl no-js" @else class="no-js" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('common.documents') }}</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap");
    :root {
    --padding: 20px 40px;
}
body {
    font-family: "Lato", sans-serif;
    font-weight: 400;
    font-size: 14.4px;
    color: #000;
}

*,
    ::after,
    ::before {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

a {
    text-decoration: none;
    color: currentColor;
}

table {
    margin: 0;
    padding: 0;
    border-collapse: collapse;
    width: 100%;
    font-family: "Lato", sans-serif;
}

.text-uppercase {
    text-transform: uppercase;
}

.badge.bg-green {
    background: #01B871;
}

.header {
    border-bottom: 1px solid #494949;
    padding: var(--padding);
    /* padding-top: 50px; */
}

.header table td h3 {
    font-size: 25.2px;
    line-height: 1.5;
    color: #010101;
    opacity: 0.2;
}

.header table td h5 {
    font-size: 18px;
    margin-bottom: 5px;
    color: #000;
}

.header table td p {
    margin-bottom: 3px;
    color: #000;
}

.main-body {
    max-width: 870px;
    margin: auto;
    position: relative;
    overflow: hidden;
    background-color: #fff;
}

.main-content {
    padding: var(--padding);
}

.info {
    display: flex;
    margin-bottom: 15px;
}

.info-left {
    width: 66.6666666667%;
    flex: 0 0 auto;
    padding-right: 10px;
}

.info-left .card {
    padding: 10px;
    display: flex;
    background-color: #E7EDF1;
    border: 1px solid #A9BAC2;
    border-radius: 2px;
    margin-bottom: 12px;
}

.info-left .card h4 {
    font-weight: 700;
    font-size: 21.6px;
    margin-bottom: 8px;
}

.info-left .card h6 {
    font-size: 16.2px;
    margin-bottom: 3px;
}

.info-left .card p:last-child {
    margin-top: 10px;
    font-weight: 700;
    font-style: italic;
}

.info-left .card .left {
    padding-right: 10px;
}

.info-left .card .right {
    padding-left: 20px;
    border-left: 1px solid #AAACAD;
}

.info-right {
    width: 33.3333333333%;
    flex: 0 0 auto;
}

.info-details {
    border: 1px solid #A9BAC2;
    background-color: #E7EDF1;
    display: flex;
    padding: 10px;
}

.info-details>* {
    flex-grow: 1;
    font-size: 18px;
}

.info table {
    border-radius: 2px;
    overflow: hidden;
}

.info table:not(:last-child) {
    margin-bottom: 14px;
}

.info table.bg-dark {
    background-color: #32393D;
}

.info table.bg-dark .text-red td {
    color: #FF4B4B;
}

.info table.bg-dark td {
    color: #fff;
    border-color: #55595A;
    opacity: 1;
}

.info table tr td {
    border: 1px solid #A9BAC2;
    padding: 5px 10px;
    opacity: 0.9;
}

.info table tr td:first-child {
    font-weight: bold;
    opacity: 1;
}

.invoice-list {
    margin-bottom: 20px;
}

.invoice-list thead tr {
    background-color: #32393D;
}

.invoice-list thead tr th {
    color: #fff;
    font-size: 16.2px;
}

.invoice-list tr th,
.invoice-list tr td {
    border-right: 1px solid #DDDEDE;
    padding: 10px 12px;
    text-align: left;
    color: #000;
}

.invoice-list tr th:last-child,
.invoice-list tr td:last-child {
    border-right: none;
}

.invoice-list tr th:first-child,
.invoice-list tr td:first-child {
    text-align: center;
}

.invoice-list tr th span,
.invoice-list tr td span {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    line-clamp: 1;
    -webkit-box-orient: vertical;
}

.invoice-list tbody tr:nth-child(2n+1) {
    background-color: #E7EDF1;
}

.invoice-list tbody tr td {
    font-size: 12.6px;
    color: #000;
}

.invoice-list tbody tr td:first-child {
    color: #000;
}

.invoice-list tbody tr td:nth-child(2) {
    color: #515359;
}

.invoice-list tfoot tr {
    border-top: 1px solid #DDDEDE;
}

.invoice-list tfoot tr td:first-child {
    text-align: end;
}

.align-self {
    display: flex;
    min-height: calc(100vh - 380px);
    max-height: 100vh;
    flex-direction: column;
    justify-content: space-between;
}

.signature {
    border: 1px solid #A9BAC2;
    border-radius: 2px;
    width: 100%;
    background-color: #F3F7F8;
    padding: 15px;
    text-align: center;
}
.badge{
    position: absolute !important;
     top: 10px !important;
     right: -40px !important;
     font-size: 18px; 
     color: #fff;
    padding: 5px 10px !important;
    min-width: 150px !important;
    text-align: center !important;
    -webkit-transform: rotate(39deg) !important;
    text-transform: capitalize !important;
    transform-origin: 50% 50% !important;
}

</style>
    

</head>
<body style="background-color: white;">
    <section class="main-body" style="max-width: 870px;
    margin: auto;
    position: relative;
    overflow: hidden;
    background-color: #fff;">
        <div class="badge" style="position: absolute !important;top: 10px !important;right: -40px !important;font-size: 18px;color: #fff; padding: 5px 10px !important;min-width: 150px !important;text-align: center !important; -webkit-transform: rotate(39deg) !important; -moz-transform: rotate(39deg) !important; transform: rotate(39deg) !important; text-transform: capitalize !important; transform-origin: 50% !important; background: {{$order->is_paid == 1 ? '#01B871' : 'rgb(251, 71, 71)'}} ;">{{ __('order.paid') }} - {{$order->is_paid == 1 ? 'Yes' : 'No'}}</div>
        <div class="header" style="padding-bottom:10px;margin-bottom:10px">
            <table>
                <tr>
                    <td>
                        <div class="logo">
                            <img src="{{showImage(app('general_setting')->logo)}}" alt="{{app('general_setting')->company_name}}" title="{{app('general_setting')->company_name}}">
                        </div>
                    </td>
                    <td class="text-align:center" style="text-align: center;">
                        <h3 class="text-uppercase">{{__('defaultTheme.invoice')}} #{{$order->order_number}}</h3>
                        @if(app('general_setting')->gst_number)
                        <h5 class="text-uppercase">{{__('gst.gst') }}/{{__('common.vat') }}# {{app('general_setting')->gst_number}}</h5>
                        @endif
                    </td>
                    <td>
                        <h5>{{app('general_setting')->company_name}}</h5>
                        <p>
                            <a href="mailto:info@spondonit.com">{{app('general_setting')->email}}</a>,
                            <a href="tel:{{app('general_setting')->phone}}">{{app('general_setting')->phone}}</a>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="main-content">
            <table class="info">
                <tr>
                   
                    <td class="info-left">
                        <table class="card">
                            <tr>

                                <td class="left">
                                    <h4>{{ __('common.billing_info') }}</h4>
                                    <h6>{{($order->customer_id) ? $order->address->billing_name : $order->guest_info->billing_name}}</h6>
                                    <p>
                                        {{($order->customer_id) ? $order->address->billing_address : $order->guest_info->billing_address}}, 
                                        {{($order->customer_id) ? @$order->address->getBillingCity->name : @$order->guest_info->getBillingCity->name}}, 
                                        {{($order->customer_id) ? @$order->address->getBillingState->name : @$order->guest_info->getBillingState->name}}, 
                                        {{($order->customer_id) ? @$order->address->getBillingCountry->name : @$order->guest_info->getBillingCountry->name}}
                                    </p>
                                    <p>
                                        {{($order->customer_id) ? $order->address->billing_email : $order->guest_info->billing_email}} <br> {{getNumberTranslate(($order->customer_id) ? $order->address->billing_phone : $order->guest_info->billing_phone)}}
                                    </p>
                                </td>
                                <td class="right">
                                    <h4>{{ __('shipping.shipping_info') }} @if($order->delivery_type == 'pickup_location')({{ __('shipping.collect_from_pickup_location') }}) @endif</h4>
                                    <h6>{{($order->customer_id) ? $order->address->shipping_name : $order->guest_info->shipping_name}}</h6>
                                    <p>
                                        {{($order->customer_id) ? $order->address->shipping_address : $order->guest_info->shipping_address}}, 
                                        {{($order->customer_id) ? @$order->address->getShippingCity->name : $order->guest_info->getShippingCity->name}}, 
                                        {{($order->customer_id) ? @$order->address->getShippingState->name : $order->guest_info->getShippingState->name}}, 
                                        {{($order->customer_id) ? $order->address->getShippingCountry->name : $order->guest_info->getShippingCountry->name}}
                                    </p>
                                    <p>
                                        {{($order->customer_id) ? $order->address->shipping_email : $order->guest_info->shipping_email}}<br> {{getNumberTranslate(($order->customer_id) ? $order->address->shipping_phone : $order->guest_info->shipping_phone)}}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="info-right">
                        <table>
                            <tr>
                                <td>{{__('defaultTheme.paid_by')}}</td>
                                <td>{{$order->GatewayName}}</td>
                            </tr>
                        </table>
                        <table class="bg-dark">
                            @if($order->customer_id == null)
                                <tr>
                                    <td>{{ __('common.secret_id') }}</td>
                                    <td>{{$order->guest_info->guest_id}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>{{__('order.txn_id')}}</td>
                                <td>@if(@$order->order_payment->txn_id && @$order->order_payment->txn_id != 'none'){{ @$order->order_payment->txn_id }} @else - @endif</td>
                            </tr>
                            <tr>
                                <td>{{ __('order.subtotal') }}</td>
                                <td>
                                    {{single_price($order->sub_total)}}
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('common.discount') }}</td>
                                <td>- {{single_price($order->discount_total)}}</td>
                            </tr>
                            @if($order->coupon)
                                <tr>
                                    <td>{{ __('common.coupon') }} {{__('common.discount')}}</td>
                                    <td>- {{single_price($order->coupon->discount_amount)}}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>{{ __('common.shipping_charge') }}</td>
                                <td>+ {{single_price($order->shipping_total)}}</td>
                            </tr>
                            <tr>
                                <td>{{ __('gst.total_gst') }}</td>
                                <td>+ {{single_price($order->tax_amount)}}</td>
                            </tr>
                            <tr>
                                <td>{{ __('common.grand_total') }}</td>
                                <td>{{single_price($order->grand_total)}}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div>
                @foreach ($order->packages as $key => $order_package)
                    <table class="info-details">
                        <tr>
                            <td style="padding: 10px">
                                @if(isModuleActive('MultiVendor'))
                                <p><strong>{{ __('common.shop_name') }}:</strong> @if($order_package->seller->role->type == 'seller'){{ (@$order_package->seller->SellerAccount->seller_shop_display_name) ? @$order_package->seller->SellerAccount->seller_shop_display_name : @$order_package->seller->first_name }} @else {{ app('general_setting')->company_name }} @endif</p>
                                @endif
                            </td>
                            <td style="padding: 10px">
                                <p><strong>{{ __('common.package') }}:</strong> {{ getNumberTranslate($order_package->package_code) }}</p>
                            </td>
                        </tr>
                    </table>

                    <table class="invoice-list">
                        <thead>
                            <tr>
                                <th width="42">{{ __('common.sl') }}</th>
                                <th width="260"><span>{{ __('common.name') }}</span></th>
                                <th width="50"><span>{{ __('common.details') }}</span></th>
                                <th width="70"><span>{{ __('common.price') }}</span></th>
                                <th width="100"><span>{{ __('common.total') }}</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $subTotal = 0;
                            @endphp
                            @foreach ($order_package->products as $key => $package_product)
                                <tr>
                                    <td><span>{{$key+1}}</span></td>
                                    <td>
                                        <span>
                                            {{ @$package_product->seller_product_sku->product->product_name??@$package_product->seller_product_sku->sku->product->product_name }}
                                        </span>
                                    </td>
                                    @if (@$package_product->seller_product_sku->sku->product->product_type == 2)
                                        <td>
                                            {{ __('common.qty') }}: {{ getNumberTranslate($package_product->qty) }}
                                            @php
                                                $countCombinatiion = count(@$package_product->seller_product_sku->product_variations);
                                            @endphp
                                            @foreach (@$package_product->seller_product_sku->product_variations as $key => $combination)
                                                @if ($combination->attribute->id == 1)
                                                    <span>{{ $combination->attribute->name }}:</span><span> {{ $combination->attribute_value->color->name }}</span>
                                                @else
                                                    {{ $combination->attribute->name }}:
                                                    {{ $combination->attribute_value->value }}
                                                @endif
                                                @if ($countCombinatiion > $key + 1)
                                                  
                                                @endif
                                            @endforeach
                                        </td>
                                    @else
                                        <td>{{__('common.qty') }}: {{ getNumberTranslate($package_product->qty) }}</td>
                                    @endif
                                    <td>{{ single_price($package_product->price) }}</td>
                                    <td>
                                        {{ single_price($package_product->price * $package_product->qty) }}
                                        @php
                                        $subTotal += $package_product->price * $package_product->qty;
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr style="border-top: 1px solid #a9bac2">
                                <td style="border: none"></td>
                                <td style="border: none"></td>
                                <td style="border: none"></td>
                                <td style="text-align: right ;border: 1px solid #a9bac2;">{{ __('order.subtotal') }}:</td>
                                <td style="border-bottom: 1px solid #a9bac2;;border-right: 1px solid #a9bac2;">{{single_price($subTotal)}}</td>
                            </tr>
                        </tfoot>
                    </table>
                @endforeach
            </div>
        </div>
    </section>
    <script src="{{asset(asset_path('backend/js/jquery.min.js'))}}"></script>
</body>
</html>
