@php
    $total_number_of_item_per_page = $products->perPage();
    $total_number_of_items = ($products->total() > 0) ? $products->total() : 0;
    $total_number_of_pages = $total_number_of_items / $total_number_of_item_per_page;
    $reminder = $total_number_of_items % $total_number_of_item_per_page;
    if ($reminder > 0) {
        $total_number_of_pages += 1;
    }

    $current_page = $products->currentPage();
    $previous_page = $products->currentPage() - 1;
    if($current_page == $products->lastPage()){
        $show_end = $total_number_of_items;
    }else{
        $show_end = $total_number_of_item_per_page * $current_page;
    }


    $show_start = 0;
    if($total_number_of_items > 0){
        $show_start = ($total_number_of_item_per_page * $previous_page) + 1;
    }
@endphp
<div class="dashboard_white_box style2 bg-white mb_25">
    <div class="d-flex align-items-center gap_20 mb_30 flex-wrap">
        <h5 class="font_14 f_w_400 flex-fill mb-0">{{__('defaultTheme.showing')}} @if($show_start == $show_end) {{getNumberTranslate($show_end)}} @else {{getNumberTranslate($show_start)}} - {{getNumberTranslate($show_end)}} @endif {{__('common.of')}} {{getNumberTranslate($total_number_of_items)}} {{__('common.results')}}</h5>
        <div class="wish_selects d-flex align-items-center gap_10 flex-wrap">
            <select class="amaz_select4" name="paginate_by" id="paginate_by">
                <option value="8" @if (isset($paginate) && $paginate == "8") selected @endif>{{__('common.show')}} {{getNumberTranslate(8)}} {{__('common.item’s')}}</option>
                <option value="12" @if (isset($paginate) && $paginate == "12") selected @endif>{{__('common.show')}} {{getNumberTranslate(12)}} {{__('common.item’s')}}</option>
                <option value="16" @if (isset($paginate) && $paginate == "16") selected @endif>{{__('common.show')}} {{getNumberTranslate(16)}} {{__('common.item’s')}}</option>
                <option value="24" @if (isset($paginate) && $paginate == "24") selected @endif>{{__('common.show')}} {{getNumberTranslate(24)}} {{__('common.item’s')}}</option>
                <option value="32" @if (isset($paginate) && $paginate == "32") selected @endif>{{__('common.show')}} {{getNumberTranslate(32)}} {{__('common.item’s')}}</option>
            </select>
            <select name="sort_by" class="amaz_select4" id="product_short_list">
                <option value="new" @if (isset($sort_by) && $sort_by == "new") selected @endif>{{__('common.new')}}</option>
                <option value="old" @if (isset($sort_by) && $sort_by == "old") selected @endif>{{__('common.old')}}</option>
                <option value="low_to_high" @if (isset($sort_by) && $sort_by == "low_to_high") selected @endif>{{__('common.price')}} ({{__('amazy.Low to high')}})</option>
                <option value="high_to_low" @if (isset($sort_by) && $sort_by == "high_to_low") selected @endif>{{__('common.price')}} ({{__('amazy.High to low')}})</option>
            </select>
        </div>
    </div>
    <input type="hidden" name="filterCatCol" class="filterCatCol" value="0">
    <div class="dashboard_wishlist_grid d-block">
        <div class="row">
            @if(count($products) > 0)
                @foreach($products as $product)
                    @if($product->type =='product')
                        @php
                            if(@$product->product->thum_img != null){
                                $thumbnail = showImage(@$product->product->thum_img);
                            }
                            else {
                                $thumbnail = showImage(@$product->product->product->thumbnail_image_source);
                            }
                        @endphp
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="product_widget5 mb_30 style5">

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
                                            'url' => singleProductURL(@$product->product->seller->slug ?? 'ttt', @$product->product->slug?? "ttt"),
                                            'price' => $price_qty,
                                            'thumbnail' => $thumbnail
                                        ];
                                    @endphp
                                    <a href="{{singleProductURL(@$product->product->seller->slug ?? 't', @$product->product->slug)}}" class="thumb">
                                        @if(app('general_setting')->lazyload == 1)
                                        <img data-src="{{$thumbnail}}" src="{{ showImage(themeDefaultImg()) }}" alt="{{@$product->product->product_name}}" title="{{@$product->product->product_name}}" class="lazyload">
                                        @else
                                        <img src="{{$thumbnail}}" alt="{{@$product->product->product_name}}" title="{{@$product->product->product_name}}"  >

                                        @endif
                                    </a>
                                    <div class="product_action">
                                        <a class="addToCompareFromThumnail" data-producttype="{{ @$product->product->product->product_type }}"
                                            data-seller={{ @$product->product->user_id }} data-product-sku={{ @$product->product->skus->first()->id }} data-product-id={{ @$product->product->id }}>
                                            <i class="ti-control-shuffle" title="{{__('defaultTheme.compare') }}"></i>
                                        </a>
                                        <a class="quickView" data-product_id="{{$product->seller_product_id}}" data-type="product">
                                            <i class="ti-eye" title="{{__('defaultTheme.quick_view')}}"></i>
                                        </a>
                                        <a class="removeWishlist" data-id="{{ $product->id }}">
                                            <i class="ti-trash" title="{{__('common.delete') }}"></i>
                                        </a>
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

                                    <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                        <a class="amaz_primary_btn addToCartFromThumnail" data-producttype="{{ @$product->product->product->product_type }}" data-seller={{ $product->product->user_id }} data-product-sku={{ @$product->product->skus->first()->id }}
                                            @if(@$product->product->hasDeal)
                                                data-base-price={{ selling_price(@$product->product->skus->first()->sell_price,@$product->product->hasDeal->discount_type,@$product->product->hasDeal->discount) }}
                                            @else
                                                @if(@$product->product->hasDiscount == 'yes')
                                                    data-base-price={{ selling_price(@$product->product->skus->first()->sell_price,@$product->product->discount_type,@$product->product->discount) }}
                                                @else
                                                    data-base-price={{ @$product->product->skus->first()->sell_price }}
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
                                </div>

                            </div>
                        </div>
                    @else
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="product_widget5 mb_30 style5">
                                @php
                                    $thumbnail = showImage(@$product->giftcard->thumbnail_image);
                                    $prod_url = route('frontend.gift-card.show',@$product->giftcard->sku);
                                @endphp
                                <div class="product_thumb_upper">
                                    <a href="{{$prod_url}}" class="thumb">
                                        <img src="{{$thumbnail}}" alt="{{textLimit(@$product->giftcard->name,28)}}" title="{{textLimit(@$product->giftcard->name,28)}}">
                                    </a>
                                    <div class="product_action">
                                        <a data-bs-toggle="modal" data-bs-target="#theme_modal">
                                            <i class="ti-eye" title="{{__('defaultTheme.quick_view')}}"></i>
                                        </a>
                                        <a class="removeWishlist" data-id="{{ $product->id }}">
                                            <i class="ti-trash" title="{{__('common.delete') }}"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="product__meta text-center">
                                    <a href="{{$prod_url}}">
                                        <h4>{{textLimit(@$product->giftcard->name,28)}}</h4>
                                    </a>
                                    @php
                                        $reviews = @$product->giftcard->reviews->where('status',1)->pluck('rating');
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
                                    <div class="stars justify-content-center">
                                        <!-- rating component -->
                                        <x-rating :rating="$rating"/>
                                        <!-- rating component -->
                                    </div>

                                    @php
                                        $price_qty = getGiftcardwithDiscountPrice(@$product->giftcard);
                                        $showData = [
                                            'name' => @$product->giftcard->name,
                                            'url' => $prod_url,
                                            'price' => $price_qty,
                                            'thumbnail' => $thumbnail
                                        ];
                                    @endphp
                                    <div class="product_prise">
                                        <p>{{$price_qty}}</p>
                                        <a class="add_cart add_to_cart add_to_cart_gift_thumnail" data-prod_info = "{{json_encode($showData)}}" data-gift-card-id="{{ @$product->giftcard->id }}" data-seller="{{ App\Models\User::where('role_id', 1)->first()->id }}" data-base-price="@if(@$product->giftcard->hasDiscount()) {{selling_price(@$product->giftcard->sell_price, @$product->giftcard->discount_type, @$product->giftcard->discount)}} @else {{@$product->giftcard->sell_price}} @endif"  href="#">{{__('common.add_to_cart')}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

    </div>
    @if($products->lastPage() > 1)
    <x-pagination-component :items="$products" type=""/>
    @endif
</div>
