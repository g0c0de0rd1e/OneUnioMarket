<div class="col-xl-10">
    <div class="compare_title_div">
        <h3 class="fs-4 fw-bold mb_30">{{ __('defaultTheme.product_compare') }}</h3>
        @if(count($products) > 0)
            <a href="#" class="reset_compare_text reset_compare">{{ __('defaultTheme.reset_compare') }}</a>
        @endif
    </div>
    <div class="comparing_box_area mb_30">
        @if(count($products) > 0)
        <div class="compare_product_descList">

            <div class="single_product_list product_tricker compare_product">

                <ul class="comparison_lists style2">
                    <li>
                        {{__('common.name')}}
                    </li>
                    <li>
                        {{__('defaultTheme.sku')}}
                    </li>
                    @if(isModuleActive('MultiVendor'))
                    <li>
                        {{__('common.seller')}}
                    </li>
                    @endif
                    @php
                        $data = $products[0];
                        $total_key = 2;
                        $attribute_list = [];
                    @endphp
                    @if(@$data->product->product->product_type == 2)
                        @foreach(@$data->product_variations as $key => $combination)
                        @php
                            $total_key += 1;
                            $attribute_list[] = @$combination->attribute->name;
                        @endphp
                            <li>{{@$combination->attribute->name}}</li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <div class="compare_product_carousel">
            <div class="compare_product_active owl-carousel">
                @foreach($products as $key => $sellerProductSKU)
                    <!-- single item  -->
                    <div class="single_product_list product_tricker compare_product">
                        <div class="product_widget5 style5">
                            <div class="product_thumb_upper">
                                @php
                                        if(@$sellerProductSKU->product->product->product_type == 1){
                                            if(@$sellerProductSKU->product->thum_img != null){
                                                $thumbnail = showImage(@$sellerProductSKU->product->thum_img);
                                            }else{
                                                $thumbnail = showImage(@$sellerProductSKU->product->product->thumbnail_image_source);
                                            }
                                        }else{
                                            $thumbnail = showImage(@$sellerProductSKU->sku->variant_image?@$sellerProductSKU->sku->variant_image:@$sellerProductSKU->product->product->thumbnail_image_source);
                                        }

                                        $price_qty = getProductDiscountedPrice(@$sellerProductSKU->product);
                                        $showData = [
                                            'name' => @$sellerProductSKU->product->product_name,
                                            'url' => singleProductURL(@$sellerProductSKU->product->seller->slug, @$sellerProductSKU->product->slug),
                                            'price' => $price_qty,
                                            'thumbnail' => $thumbnail
                                        ];
                                    @endphp
                                    <a href="{{singleProductURL(@$sellerProductSKU->product->seller->slug, @$sellerProductSKU->product->slug)}}" class="thumb">
                                        <img src="{{$thumbnail}}" alt="{{@$sellerProductSKU->product->product_name}}" title="{{@$sellerProductSKU->product->product_name}}">
                                    </a>
                                    <div class="product_action">
                                        <a href="" class="add_to_wishlist {{$sellerProductSKU->product->is_wishlist() == 1?'is_wishlist':''}}" data-product_id="{{$sellerProductSKU->product->id}}" data-seller_id="{{$sellerProductSKU->product->user_id}}">
                                            <i class="far fa-heart" title="{{__('defaultTheme.wishlist')}}"></i>
                                        </a>
                                        <a href="" class="remove_from_compare" data-id="{{$sellerProductSKU->id}}">
                                            <i class="ti-trash" title="{{__('common.delete')}}"></i>
                                        </a>
                                    </div>

                                    <div class="product_badge">
                                        @if($sellerProductSKU->product->hasDeal)
                                            @if($sellerProductSKU->product->hasDeal->discount >0)
                                                <span class="d-flex align-items-center discount">
                                                    @if($sellerProductSKU->product->hasDeal->discount_type ==0)
                                                        {{getNumberTranslate($sellerProductSKU->product->hasDeal->discount)}} % {{__('common.off')}}
                                                    @else
                                                        {{single_price($sellerProductSKU->product->hasDeal->discount)}} {{__('common.off')}}
                                                    @endif
                                                </span>
                                            @endif
                                        @else
                                            @if($sellerProductSKU->product->hasDiscount == 'yes')
                                                @if($sellerProductSKU->product->discount >0)
                                                    <span class="d-flex align-items-center discount">
                                                        @if($sellerProductSKU->product->discount_type ==0)
                                                            {{getNumberTranslate($sellerProductSKU->product->discount)}} % {{__('common.off')}}
                                                        @else
                                                            {{single_price($sellerProductSKU->product->discount)}} {{__('common.off')}}
                                                        @endif
                                                    </span>
                                                @endif
                                            @endif
                                        @endif
                                        @if(isModuleActive('ClubPoint'))
                                        <span class="d-flex align-items-center point">
                                            <svg width="16" height="14" viewBox="0 0 16 14" fill="none" >
                                                <path d="M15 7.6087V10.087C15 11.1609 12.4191 12.5652 9.23529 12.5652C6.05153 12.5652 3.47059 11.1609 3.47059 10.087V8.02174M3.71271 8.2357C4.42506 9.18404 6.628 10.0737 9.23529 10.0737C12.4191 10.0737 15 8.74704 15 7.60704C15 6.96683 14.1872 6.26548 12.9115 5.77313M12.5294 3.47826V5.95652C12.5294 7.03044 9.94847 8.43478 6.76471 8.43478C3.58094 8.43478 1 7.03044 1 5.95652V3.47826M6.76471 5.9433C9.94847 5.9433 12.5294 4.61661 12.5294 3.47661C12.5294 2.33578 9.94847 1 6.76471 1C3.58094 1 1 2.33578 1 3.47661C1 4.61661 3.58094 5.9433 6.76471 5.9433Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            {{getNumberTranslate(@$product->product->club_point)}}
                                        </span>
                                        @endif
                                        @if(isModuleActive('WholeSale') && @$sellerProductSKU->product->skus->first()->wholeSalePrices != '')
                                            <span class="d-flex align-items-center sale">{{__('common.wholesale')}}</span>
                                        @endif
                                    </div>
                            </div>
                            <div class="product_star mx-auto">
                                @php
                                $reviews = @$sellerProductSKU->product->reviews->where('status',1)->pluck('rating');
                                if(count($reviews)>0){
                                    $value = 0;
                                    $rating = 0;
                                    foreach($reviews as $review){
                                        $value += $review;
                                    }
                                    $rating = $value/count($reviews);
                                    $total_review = count($reviews);
                                }else{
                                    $rating = 0;
                                    $total_review = 0;
                                }
                            @endphp
                                <x-rating :rating="$rating" />
                            </div>
                            <div class="product__meta text-center">
                                <span class="product_banding ">{{ $sellerProductSKU->product->brand->name ?? " " }}</span>
                                <a href="{{singleProductURL($sellerProductSKU->product->seller->slug, $sellerProductSKU->product->slug)}}">
                                    <h4>@if ($sellerProductSKU->product->product_name) {{ textLimit($sellerProductSKU->product->product_name, 50) }} @else {{ textLimit($sellerProductSKU->product->product->product_name, 50) }} @endif</h4>
                                </a>
                                <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                    @php
                                    $price = 0;
                                    $shipping_method = 0;

                                    if(@$sellerProductSKU->product->hasDeal){
                                        $price = selling_price(@$sellerProductSKU->sell_price,@$sellerProductSKU->product->hasDeal->discount_type,@$sellerProductSKU->product->hasDeal->discount);
                                    }
                                    else{
                                        if($sellerProductSKU->product->hasDiscount == 'yes'){
                                            $price = selling_price(@$sellerProductSKU->sell_price,@$sellerProductSKU->product->discount_type,@$sellerProductSKU->product->discount);
                                        }else{
                                            $price = @$sellerProductSKU->sell_price;
                                        }
                                    }
                                @endphp
                                    <a class="amaz_primary_btn addToCart" data-product_sku_id="{{$sellerProductSKU->id}}" data-seller_id="{{@$sellerProductSKU->product->user_id}}" data-shipping_method="{{$shipping_method}}" data-price="{{$price}}" data-prod_info="{{ json_encode($showData) }}">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" >
                                                <path d="M0.464844 1.14286C0.464844 0.78782 0.751726 0.5 1.10561 0.5H1.58256C2.39459 0.5 2.88079 1.04771 3.15883 1.55685C3.34414 1.89623 3.47821 2.28987 3.58307 2.64624C3.61147 2.64401 3.64024 2.64286 3.66934 2.64286H14.3464C15.0557 2.64286 15.5679 3.32379 15.3734 4.00811L13.8119 9.50163C13.5241 10.5142 12.6019 11.2124 11.5525 11.2124H6.47073C5.41263 11.2124 4.48508 10.5028 4.20505 9.47909L3.55532 7.10386L2.48004 3.4621L2.47829 3.45572C2.34527 2.96901 2.22042 2.51433 2.03491 2.1746C1.85475 1.84469 1.71115 1.78571 1.58256 1.78571H1.10561C0.751726 1.78571 0.464844 1.49789 0.464844 1.14286ZM4.79882 6.79169L5.44087 9.1388C5.56816 9.60414 5.98978 9.92669 6.47073 9.92669H11.5525C12.0295 9.92669 12.4487 9.60929 12.5795 9.14909L14.0634 3.92857H3.95529L4.78706 6.74583C4.79157 6.76109 4.79548 6.77634 4.79882 6.79169ZM7.72683 13.7857C7.72683 14.7325 6.96184 15.5 6.01812 15.5C5.07443 15.5 4.30942 14.7325 4.30942 13.7857C4.30942 12.8389 5.07443 12.0714 6.01812 12.0714C6.96184 12.0714 7.72683 12.8389 7.72683 13.7857ZM6.4453 13.7857C6.4453 13.5491 6.25405 13.3571 6.01812 13.3571C5.7822 13.3571 5.59095 13.5491 5.59095 13.7857C5.59095 14.0224 5.7822 14.2143 6.01812 14.2143C6.25405 14.2143 6.4453 14.0224 6.4453 13.7857ZM13.7073 13.7857C13.7073 14.7325 12.9423 15.5 11.9986 15.5C11.0549 15.5 10.2899 14.7325 10.2899 13.7857C10.2899 12.8389 11.0549 12.0714 11.9986 12.0714C12.9423 12.0714 13.7073 12.8389 13.7073 13.7857ZM12.4258 13.7857C12.4258 13.5491 12.2345 13.3571 11.9986 13.3571C11.7627 13.3571 11.5714 13.5491 11.5714 13.7857C11.5714 14.0224 11.7627 14.2143 11.9986 14.2143C12.2345 14.2143 12.4258 14.0224 12.4258 13.7857Z" fill="currentColor"></path>
                                            </svg>

                                      </a>
                                    <p>
                                        <span>
                                            @if(getProductwitoutDiscountPrice($sellerProductSKU->product->product) != single_price(0))
                                            <del>
                                                {{getProductwitoutDiscountPrice($sellerProductSKU->product->product)}}
                                            </del>
                                            @endif
                                        </span>
                                        <strong>
                                            {{getProductDiscountedPrice($sellerProductSKU->product->product)}}
                                        </strong>
                                    </p>

                                </div>
                            </div>
                        </div>
                        <ul class="comparison_lists">
                            <li>
                                {{textLimit($sellerProductSKU->product->product_name,35)}}
                            </li>
                            <li>
                                {{@$sellerProductSKU->sku->sku??'-'}}
                            </li>
                            @if(isModuleActive('MultiVendor'))
                                <li>
                                    @if($sellerProductSKU->product->seller->role->type == 'seller')
                                        @if (@$sellerProductSKU->product->seller->SellerAccount->seller_shop_display_name)
                                            {{ @$sellerProductSKU->product->seller->SellerAccount->seller_shop_display_name }}
                                        @else
                                            {{$sellerProductSKU->product->seller->first_name .' '.$sellerProductSKU->product->seller->last_name}}
                                        @endif
                                    @else
                                        {{ app('general_setting')->company_name }}
                                    @endif
                                </li>
                            @endif

                            @php
                                $key_count = 2;
                            @endphp
                            @if(@$sellerProductSKU->product->product->product_type == 2)
                                @foreach(@$sellerProductSKU->product_variations as $key => $combination)
                                    @php
                                        $key_count += 1;
                                    @endphp
                                    @if($attribute_list[$key] == @$combination->attribute->name)
                                        @if(@$combination->attribute->id == 1)
                                            <li>{{@$combination->attribute_value->color->name}}</li>
                                        @else
                                            <li>{{@$combination->attribute_value->value}}</li>
                                        @endif
                                    @else
                                        <li>-</li>
                                    @endif

                                @endforeach
                            @endif

                            @if($total_key > $key_count)
                                @for($key_count; $key_count < $total_key; $key_count++)
                                    <li>-</li>
                                @endfor
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        @else
            <h4 class="test-center compare_empty">{{ __('defaultTheme.compare_list_is_empty') }}</h4>
        @endif
    </div>
</div>
