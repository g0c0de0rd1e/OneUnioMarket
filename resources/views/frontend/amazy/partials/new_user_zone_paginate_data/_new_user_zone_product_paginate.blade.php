<div class="row ">
    @foreach($products as $key => $product)
        <div class="col-xl-3 col-lg-4 col-md-6 col-6 d-flex">
            <div class="product_widget5 mb_30 style5 w-100">

                <div class="product_thumb_upper">
                    @php
                        if(@$product->product->thum_img != null){
                            $thumbnail = showImage(@$product->product->thum_img);
                        }else {
                            $thumbnail = showImage(@$product->product->product->thumbnail_image_source);
                        }
                        $price_qty = getProductDiscountedPrice(@$product->product);
                        $showData = [
                            'name' => @$product->product->product_name,
                            'url' => singleProductURL(@$product->product->seller->slug, @$product->product->slug),
                            'price' => $price_qty,
                            'thumbnail' => $thumbnail
                        ];
                    @endphp
                    <a href="{{singleProductURL(@$product->product->seller->slug, @$product->product->slug)}}" class="thumb">
                        <img src="{{$thumbnail}}" alt="{{@$product->product->product_name}}" title="{{@$product->product->product_name}}" class="lazyload">
                    </a>
                    @if(isGuestAddtoCart())
                    <div class="product_action">
                        <a href="" class="addToCompareFromThumnail" data-producttype="{{ @$product->product->product->product_type }}" data-seller={{ $product->product->user_id }} data-product-sku={{ @$product->product->skus->first()->id }} data-product-id={{ $product->product->id }}>
                            <i class="ti-control-shuffle" title="{{__('defaultTheme.compare') }}"></i>
                        </a>
                        <a href="" class="add_to_wishlist {{$product->product->is_wishlist() == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->product->id}}" data-product_id="{{$product->product->id}}" data-seller_id="{{$product->product->user_id}}">
                            <i class="far fa-heart" title="{{__('defaultTheme.wishlist')}}"></i>
                        </a>
                        <a class="quickView" data-product_id="{{$product->product->id}}" data-type="product">
                            <i class="ti-eye" title="{{__('defaultTheme.quick_view')}}"></i>
                        </a>
                    </div>
                    @endif
                    <div class="product_badge">
                        @if(isGuestAddtoCart())
                            @if($product->product->hasDeal)
                                @if($product->discount > 0)
                                    <span class="d-flex align-items-center discount">
                                        @if($product->discount_type ==0)
                                            -{{getNumberTranslate($product->discount)}}%
                                        @else
                                            -{{single_price($product->discount)}}
                                        @endif

                                    </span>
                                @endif
                            @else
                                @if($product->product->hasDiscount == 'yes')
                                    @if($product->product->discount > 0)
                                        <span class="d-flex align-items-center discount">
                                            @if($product->product->discount_type ==0)
                                            -{{getNumberTranslate($product->product->discount)}}%
                                            @else
                                            -{{single_price($product->product->discount)}}
                                            @endif
                                        </span>
                                    @endif
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
                        @if(isModuleActive('WholeSale') && @$product->product->skus->first()->wholeSalePrices->count())
                            <span class="d-flex align-items-center sale">{{__('common.wholesale')}}</span>
                        @endif
                    </div>
                </div>
                <div class="product_star mx-auto">
                    @php
                        $reviews = $product->product->reviews->where('status',1)->pluck('rating');
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
                    <x-rating :rating="$rating"/>
                </div>
                <div class="product__meta text-center">

                    <span class="product_banding ">{{ $product->brand->name ?? " " }}</span>
                    <a href="{{singleProductURL(@$product->product->seller->slug, @$product->product->slug)}}">
                        <h4>
                            @if(@$product->product->product_name) {{textLimit(@$product->product->product_name,56)}} @else {{textLimit(@$product->product->product->product_name,56)}} @endif
                        </h4>
                    </a>
                    @if(isGuestAddtoCart())
                    <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                        <a class="amaz_primary_btn addToCartFromThumnail" data-producttype="{{ @$product->product->product->product_type }}" data-seller={{ $product->product->user_id }} data-product-sku={{ @$product->product->skus->first()->id }}
                            @if(@$product->product->hasDeal)
                                data-base-price={{ selling_price(@$product->product->skus->first()->selling_price,@$product->product->hasDeal->discount_type,@$product->product->hasDeal->discount) }}
                            @else
                                @if(@$product->product->hasDiscount == 'yes')
                                    data-base-price={{ selling_price(@$product->product->skus->first()->selling_price,@$product->product->discount_type,@$product->product->discount) }}
                                @else
                                    data-base-price={{ @$product->product->skus->first()->selling_price }}
                                @endif
                            @endif
                            data-shipping-method=0
                            data-product-id={{ $product->product->id }}
                            data-stock_manage="{{$product->product->stock_manage}}"
                            data-stock="{{@$product->product->skus->first()->product_stock}}"
                            data-min_qty="{{$product->product->product->minimum_order_qty}}"
                            data-prod_info="{{ json_encode($showData) }}"
                            >
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" >
                                    <path d="M0.464844 1.14286C0.464844 0.78782 0.751726 0.5 1.10561 0.5H1.58256C2.39459 0.5 2.88079 1.04771 3.15883 1.55685C3.34414 1.89623 3.47821 2.28987 3.58307 2.64624C3.61147 2.64401 3.64024 2.64286 3.66934 2.64286H14.3464C15.0557 2.64286 15.5679 3.32379 15.3734 4.00811L13.8119 9.50163C13.5241 10.5142 12.6019 11.2124 11.5525 11.2124H6.47073C5.41263 11.2124 4.48508 10.5028 4.20505 9.47909L3.55532 7.10386L2.48004 3.4621L2.47829 3.45572C2.34527 2.96901 2.22042 2.51433 2.03491 2.1746C1.85475 1.84469 1.71115 1.78571 1.58256 1.78571H1.10561C0.751726 1.78571 0.464844 1.49789 0.464844 1.14286ZM4.79882 6.79169L5.44087 9.1388C5.56816 9.60414 5.98978 9.92669 6.47073 9.92669H11.5525C12.0295 9.92669 12.4487 9.60929 12.5795 9.14909L14.0634 3.92857H3.95529L4.78706 6.74583C4.79157 6.76109 4.79548 6.77634 4.79882 6.79169ZM7.72683 13.7857C7.72683 14.7325 6.96184 15.5 6.01812 15.5C5.07443 15.5 4.30942 14.7325 4.30942 13.7857C4.30942 12.8389 5.07443 12.0714 6.01812 12.0714C6.96184 12.0714 7.72683 12.8389 7.72683 13.7857ZM6.4453 13.7857C6.4453 13.5491 6.25405 13.3571 6.01812 13.3571C5.7822 13.3571 5.59095 13.5491 5.59095 13.7857C5.59095 14.0224 5.7822 14.2143 6.01812 14.2143C6.25405 14.2143 6.4453 14.0224 6.4453 13.7857ZM13.7073 13.7857C13.7073 14.7325 12.9423 15.5 11.9986 15.5C11.0549 15.5 10.2899 14.7325 10.2899 13.7857C10.2899 12.8389 11.0549 12.0714 11.9986 12.0714C12.9423 12.0714 13.7073 12.8389 13.7073 13.7857ZM12.4258 13.7857C12.4258 13.5491 12.2345 13.3571 11.9986 13.3571C11.7627 13.3571 11.5714 13.5491 11.5714 13.7857C11.5714 14.0224 11.7627 14.2143 11.9986 14.2143C12.2345 14.2143 12.4258 14.0224 12.4258 13.7857Z" fill="currentColor"></path>
                                </svg>
                                {{__('defaultTheme.add_to_cart')}}
                          </a>
                        <p>
                            <span>
                                @if(getProductwitoutDiscountPrice(@$product->product) != single_price(0))
                                <del>
                                    {{getProductwitoutDiscountPrice(@$product->product)}}
                                </del>
                                @endif
                            </span>
                            <strong>
                                {{getProductDiscountedPrice(@$product->product)}}
                            </strong>
                        </p>

                    </div>
                    @else
                    <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                        <a class="amaz_primary_btn w-100" style="text-indent: 0" href="{{ url('/login') }}"
                            >
                                {{__('defaultTheme.login_to_order')}}
                          </a>

                    </div>

                    @endif
                </div>

            </div>
        </div>
    @endforeach
</div>
<hr>

@if($products->lastPage() > 1)
    <x-pagination-component :items="$products" type="page_counter_flash"/>
@endif
