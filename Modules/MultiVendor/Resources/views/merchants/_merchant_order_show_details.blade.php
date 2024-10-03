
   <div class="modal fade admin-query" id="orderdetails">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__('order.order_form')}}</h4>
                    <button type="button" class="close " data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
    
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 student-details">
                            <div class="white_box_50px box_shadow_white" id="printableArea">
                                <div class="row pb-30 border-bottom">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="logo_div">
                                            <img src="{{ showImage(app('general_setting')->logo) }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 text-right">
                                        <h4>{{ $order_package->order_number }}</h4>
                                    </div>
                                </div>
                                <div class="row mt-30">
                                    @if ($order_package->customer_id)
                                        <div class="col-md-6 col-lg-6">
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td><strong>{{__('defaultTheme.billing_info')}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.name')}}</td>
                                                    <td>: {{ @$order_package->address->billing_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.email')}}</td>
                                                    <td><a class="link_color" href="mailto:{{ @$order_package->address->billing_email }}">:
                                                            {{ @$order_package->address->billing_email }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.phone')}}</td>
                                                    <td>: {{ getNumberTranslate(@$order_package->address->billing_phone) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.address')}}</td>
                                                    <td>: {{ @$order_package->address->billing_address }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.city')}}</td>
                                                    <td>: {{ @$order_package->address->getBillingCity->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.state')}}</td>
                                                    <td>: {{ @$order_package->address->getBillingState->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.country')}}</td>
                                                    <td>: {{ @$order_package->address->getBillingCity->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.postcode')}}</td>
                                                    <td>: {{ getNumberTranslate(@$order_package->address->billing_postcode) }}</td>
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
                                                    <td>: {{$order_package->guest_info->billing_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.email')}}</td>
                                                    <td><a class="link_color" href="mailto:{{$order_package->guest_info->billing_email}}">: {{$order_package->guest_info->billing_email}}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.phone')}}</td>
                                                    <td>: {{ getNumberTranslate($order_package->guest_info->billing_phone)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.address')}}</td>
                                                    <td>: {{$order_package->guest_info->billing_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.city')}}</td>
                                                    <td>: {{@$order_package->guest_info->getBillingCity->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.state')}}</td>
                                                    <td>: {{@$order_package->guest_info->getBillingState->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.country')}}</td>
                                                    <td>: {{@$order_package->guest_info->getBillingCountry->name}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    @endif
                                    <div class="col-md-6 col-lg-6">
                                        @if ($order_package->customer_id)
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td><strong>{{__('defaultTheme.shipping_info')}} @if($order_package->delivery_type == 'pickup_location')(Collect from Pickup location) @endif</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.name')}}</td>
                                                    <td>: {{ @$order_package->address->shipping_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.email')}}</td>
                                                    <td><a class="link_color" href="mailto:{{ @$order_package->address->shipping_email }}">:
                                                            {{ @$order_package->address->shipping_email }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.phone')}}</td>
                                                    <td>: {{ getNumberTranslate(@$order_package->address->shipping_phone) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.address')}}</td>
                                                    <td>: {{ @$order_package->address->shipping_address }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.city')}}</td>
                                                    <td>: {{ @$order_package->address->getShippingCity->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.state')}}</td>
                                                    <td>: {{ @$order_package->address->getShippingState->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.country')}}</td>
                                                    <td>: {{ @$order_package->address->getShippingCountry->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.postcode')}}</td>
                                                    <td>: {{ getNumberTranslate(@$order_package->address->shipping_postcode) }}</td>
                                                </tr>
                                            </table>
                                        @else
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td><strong>{{__('defaultTheme.shipping_info')}} @if($order_package->delivery_type == 'pickup_location')(Collect from Pickup location) @endif</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.secret_id')}}</td>
                                                    <td>: {{$order_package->guest_info->guest_id}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.name')}}</td>
                                                    <td>: {{$order_package->guest_info->shipping_name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.email')}}</td>
                                                    <td><a class="link_color" href="mailto:{{$order_package->guest_info->shipping_email}}">: {{$order_package->guest_info->shipping_email}}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.phone')}}</td>
                                                    <td>: {{ getNumberTranslate($order_package->guest_info->shipping_phone)}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.address')}}</td>
                                                    <td>: {{$order_package->guest_info->shipping_address}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.city')}}</td>
                                                    <td>: {{@$order_package->guest_info->getShippingCity->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.state')}}</td>
                                                    <td>: {{@$order_package->guest_info->getShippingState->name}}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.country')}}</td>
                                                    <td>: {{@$order_package->guest_info->getShippingCountry->name}}</td>
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
                                                <td>: {{ $order_package->GatewayName }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.amount')}}</td>
                                                <td>: {{ single_price(@$order_package->order_payment->amount) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('order.txn_id')}}</td>
                                                <td>: {{ @$order_package->order_payment->txn_id }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.date')}}</td>
                                                <td>:
                                                    {{ dateConvert(@$order_package->order_payment->created_at) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('defaultTheme.payment_status')}}</td>
                                                <td>:
                                                    @if ($order_package->is_paid == 1)
                                                        <span>{{__('common.paid')}}</span>
                                                    @else
                                                        <span>{{__('common.pending')}}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    @if(isModuleActive('Affiliate'))
                                        @if($order_package->affiliateUser)
                                        <div class="col-md-6 col-lg-6">
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td><strong>{{__('Affiliate User')}}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.name')}}</td>
                                                    <td>: <a target="_blank" class="link_color" href="{{route('affiliate.user.show',$order_package->affiliateUser->payment_to)}}">{{ @$order_package->affiliateUser->user->first_name }}</a></td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.email')}}</td>
                                                    <td>: {{ @$order_package->affiliateUser->user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{__('common.phone')}}</td>
                                                    <td>: {{ getNumberTranslate(@$order_package->affiliateUser->user->phone) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="row mt-30">
                                    @foreach ($order_package->packages as $key => $order_package_package)
                                        <div class="col-12 mt-30">
                                            @if ($order_package_package->is_cancelled == 1)
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label red" for="">
                                                        {{__('defaultTheme.order_cancelled')}} - ({{ $order_package_package->package_code }})
                                                    </label>
                                                </div>
    
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label sub-title" for="">
                                                        {{ @$order_package_package->cancel_reason->name }}
                                                    </label>
                                                </div>
                                            @endif
                                            <div class="box_header common_table_header">
                                                <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.package')}}:
                                                    {{ $order_package_package->package_code }} @if ($order_package_package->delivery_process)
                                                        <small>({{ @$order_package_package->delivery_process->name }})</small>
                                                    @endif
                                                </h3>
                                                @if(isModuleActive('MultiVendor'))
                                                <ul class="d-flex float-right">
                                                    <li>
                                                        <strong>
                                                            @if($order_package_package->seller->role->type == 'seller')
                                                                {{ @$order_package_package->seller->SellerAccount->seller_shop_display_name ? @$order_package_package->seller->SellerAccount->seller_shop_display_name : @$order_package_package->seller->first_name }}
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
                                                    <li> <strong>{{__('shipping.shipping_method')}} : {{ $order_package_package->shipping->method_name }}</strong></li>
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
                                                                <th scope="col">{{__('common.tax')}}/{{__('common.gst')}}</th>
                                                                <th scope="col">{{__('common.total')}}</th>
                                                            </tr>
                                                            @foreach ($order_package_package->products as $key => $package_product)
                                                                <tr>
                                                                    <td>{{ getNumberTranslate($key + 1) }}</td>
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
                                                                            <span class="text-nowrap">{{substr(@$package_product->giftCard->name,0,22)}} @if(strlen(@$package_product->giftCard->name) > 22)... @endif</span><br>
                                                                            <a class="green gift_card_div pointer" data-gift-card-id='{{ $package_product->giftCard->id }}' data-qty='{{ $package_product->qty }}' data-customer-mail='{{($order_package->customer_id) ? $order_package->customer_email : $order_package->guest_info->shipping_email}}' data-order-id='{{ $order_package->id }}'>
                                                                                <i class="ti-email mr-1 green"></i>
                                                                                {{($order_package->gift_card_uses->where('gift_card_id', $package_product->giftCard->id)->first() != null && $order_package->gift_card_uses->where('gift_card_id', $package_product->giftCard->id)->first()->is_mail_sent) ? "__('order.sent_already')" : "__('order.send_code_now')"}}
                                                                            </a>
                                                                        @else
                                                                            <span class="text-nowrap">{{substr(@$package_product->seller_product_sku->sku->product->product_name,0,22)}} @if(strlen(@$package_product->seller_product_sku->sku->product->product_name) > 22)... @endif</span>
                                                                        @endif
                                                                    </td>
                                                                    @if ($package_product->type == "gift_card")
                                                                        <td class="text-nowrap">{{__('common.qty')}}: {{ $package_product->qty }}</td>
                                                                    @else
                                                                        @if (@$package_product->seller_product_sku->sku->product->product_type == 2)
                                                                            <td class="text-nowrap">
                                                                                {{__('common.qty')}}: {{ $package_product->qty }}
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
                                                                                    @if ($countCombinatiion > $key + 1)
                                                                                        <br>
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                        @else
                                                                            <td class="text-nowrap">{{__('common.qty')}}: {{ $package_product->qty }}</td>
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
                                    <div class="col-md-4 col-lg-4">
                                        <table class="table-borderless clone_line_table w-100">
                                            <tr>
                                                <td><strong>{{__('order.order_info')}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>{{__('order.is_paid')}}</td>
                                                <td class="pl-25 text-nowrap">: {{ $order_package->is_paid == 1 ? __('common.yes') : __('common.no') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('order.subtotal')}}</td>
                                                <td class="pl-25 text-nowrap">: {{ single_price($order_package->sub_total) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.discount')}}</td>
                                                <td class="pl-25 text-nowrap">: - {{ single_price($order_package->discount_total) }}</td>
                                            </tr>
                                            @if($order_package->coupon)
                                            <tr>
                                                <td>{{__('common.coupon')}} {{__('common.discount')}}</td>
                                                <td class="pl-25 text-nowrap">: - {{single_price($order_package->coupon->discount_amount)}}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td>{{__('common.shipping_charge')}}</td>
                                                <td class="pl-25 text-nowrap">: {{ single_price($order_package->shipping_total) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('common.tax')}}/{{__('common.gst')}}</td>
                                                <td class="pl-25 text-nowrap">: {{ single_price($order_package->tax_amount) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('order.grand_total')}}</td>
                                                <td class="pl-25 text-nowrap">: {{ single_price($order_package->grand_total) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
      