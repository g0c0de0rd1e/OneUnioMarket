
    <div class="modal fade admin-query" id="refundOrder">
        <div class="modal-dialog modal_1000px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{__("refund.refund_order_form")}}</h4>
                    <button type="button" class="close " data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>
    
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 student-details">
                            <div class="white_box_50px box_shadow_white" id="refundOrder">
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
                                                <td><strong>{{ __('refund.refund_related_info') }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('common.status') }}</td>
                                                <td>: {{ $merchant->refund_request->CheckConfirmed }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('refund.request_sent') }}</td>
                                                <td>: {{ $merchant->refund_request->created_at->format('d-m-Y h:i:s A') }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('refund.refund_method') }}</td>
                                                <td>: {{ strtoupper(str_replace("_"," ",$merchant->refund_request->refund_method)) }}</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('refund.shipping_method') }}</td>
                                                <td>: {{ strtoupper(str_replace("_"," ",$merchant->refund_request->shipping_gateway->method_name)) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    @if ($merchant->refund_request->shipping_method == "courier")
                                        <div class="col-md-6 col-lg-6">
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td><strong>{{ __('refund.pick_up_info') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('refund.shipping_gateway') }}</td>
                                                    <td>: {{ @$merchant->refund_request->shipping_method }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.name') }}</td>
                                                    <td>: {{ @$merchant->refund_request->pick_up_address_customer->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.email') }}</td>
                                                    <td>: {{ @$merchant->refund_request->pick_up_address_customer->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.phone') }}</td>
                                                    <td>: {{ @$merchant->refund_request->pick_up_address_customer->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.address') }}</td>
                                                    <td>: {{ @$merchant->refund_request->pick_up_address_customer->address }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('refund.post_code') }}</td>
                                                    <td>: {{ @$merchant->refund_request->pick_up_address_customer->postal_code }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    @else
                                        <div class="col-md-6 col-lg-6">
                                            <table class="table-borderless clone_line_table">
                                                <tr>
                                                    <td><strong>{{ __('refund.drop_of_info') }}</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('refund.shipping_gateway') }}</td>
                                                    <td>: {{ @$merchant->refund_request->shipping_gateway->method_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td>{{ __('common.address') }}</td>
                                                    <td>: {{ @$merchant->refund_request->drop_off_address }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                                <div class="row mt-30">
                                    <div class="col-lg-12 mt-30">
                                        <div class="box_header common_table_header">
                                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('common.package') }}: {{ @$merchant->order_package->package_code }} <small>({{ @$merchant->process_refund->name }})</small></h3>
                                            <ul class="d-flex float-right">
                                                <li> <strong>{{ (@$merchant->order_package->seller->SellerAccount->seller_shop_display_name) ? @$merchant->order_package->seller->SellerAccount->seller_shop_display_name : @$order_package->seller->first_name }}</strong> </li>
                                            </ul>
                                        </div>
                                        <div class="QA_section QA_section_heading_custom check_box_table">
                                            <div class="QA_table ">
                                                <!-- table-responsive -->
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tr>
                                                            <th scope="col">{{ __('common.sl') }}</th>
                                                                <th scope="col">{{ __('common.photo') }}</th>
                                                                <th scope="col">{{ __('common.name') }}</th>
                                                                <th scope="col">{{ __('refund.return_qty') }}</th>
                                                                <th scope="col">{{ __('common.subtotal') }}</th>
                                                                <th scope="col">{{ __('refund.reason') }}</th>
                                                        </tr>
                                                        @foreach ($merchant->refund_products as $key => $package_product)
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>
                                                                    <div class="product_img_div">
                                                                        @if (@$package_product->seller_product_sku->sku->product->product_type == 1)
                                                                            <img src="{{showImage(@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                        @else
                                                                            <img src="{{showImage(@$package_product->seller_product_sku->sku->variant_image?@$package_product->seller_product_sku->sku->variant_image:@$package_product->seller_product_sku->sku->product->thumbnail_image_source)}}" alt="#">
                                                                        @endif
                                                                    </div>
                                                                </td>
                                                                <td class="text-nowrap">{{ @$package_product->seller_product_sku->product->product_name }}</td>
                                                                <td class="text-nowrap">{{ $package_product->return_qty }}</td>
                                                                <td class="text-nowrap">{{ single_price($package_product->return_amount) }}</td>
                                                                <td>{{ @$package_product->refund_reason->reason }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 offset-lg-9">
                                        <table class="table-borderless clone_line_table">
                                            <tr>
                                                <td><strong>{{__('Refund Summary')}}</strong></td>
                                            </tr>
                                            <tr>
                                                <td class="info_tbl">{{__('order.subtotal')}}</td>
                                                @php
                                                    $subtotal = $merchant->refund_request->total_return_amount - $merchant->order_package->shipping_cost;
                                                @endphp
                                                <td>: {{single_price($subtotal)}}</td>
                                            </tr>
                                            <tr>
                                                <td class="info_tbl">{{__('common.shipping_charge')}}</td>
                                                <td>: {{single_price($merchant->order_package->shipping_cost)}}</td>
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
    
      