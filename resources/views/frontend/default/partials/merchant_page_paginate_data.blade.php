
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
<style>
     @media (max-width: 375px)
        {
            .shorting_box:nth-child(2){
                display: none;
            }

        }
</style>

<div class="row ">
  <div class="col-12">
      <div class="box_header d-flex flex-wrap align-items-center justify-content-between">
          <h5 class="font_16 f_w_500 mr_10 mb-0">{{__('defaultTheme.showing')}} @if($show_start == $show_end) {{getNumberTranslate($show_end)}} @else {{getNumberTranslate($show_start)}} - {{getNumberTranslate($show_end)}} @endif {{__('defaultTheme.out_of_total')}} {{getNumberTranslate($total_number_of_items)}} {{__('common.products')}}</h5>
          <div class="box_header_right ">
              <div class="short_select d-flex align-items-center gap_10 flex-wrap">
                <div class="prduct_showing_style">
                  <ul class="nav align-items-center" id="myTab" role="tablist">
                      <li class="nav-item lh-1">
                          <a class="nav-link view-product active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                              <img src="{{ showImage('frontend/amazy/img/svg/grid_view.svg') }}" alt="Grid View" title="Grid View">
                          </a>
                      </li>
                      <li class="nav-item lh-1">
                          <a class="nav-link view-product" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                              <img src="{{ showImage('frontend/amazy/img/svg/list_view.svg') }}" alt="List View" title="List View">
                          </a>
                      </li>
                  </ul>
                </div>
                    <div class="shorting_box">
                        <select class="amaz_select getFilterUpdateByIndex" name="paginate_by" id="paginate_by">
                            <option value="9" @if (isset($paginate) && $paginate == "9") selected @endif>{{__('common.show')}} {{getNumberTranslate(9)}} {{__('common.item’s')}}</option>
                            <option value="12" @if (isset($paginate) && $paginate == "12") selected @endif>{{__('common.show')}} {{getNumberTranslate(12)}}  {{__('common.item’s')}}</option>
                            <option value="16" @if (isset($paginate) && $paginate == "16") selected @endif>{{__('common.show')}} {{getNumberTranslate(16)}}  {{__('common.item’s')}}</option>
                            <option value="25" @if (isset($paginate) && $paginate == "25") selected @endif>{{__('common.show')}} {{getNumberTranslate(25)}}  {{__('common.item’s')}}</option>
                            <option value="30" @if (isset($paginate) && $paginate == "30") selected @endif>{{__('common.show')}} {{getNumberTranslate(30)}}  {{__('common.item’s')}}</option>
                        </select>
                    </div>
                    <div class="shorting_box">
                        <select class="amaz_select getFilterUpdateByIndex" name="sort_by" id="product_short_list">
                            <option value="new" @if (isset($sort_by) && $sort_by == "new") selected @endif>{{ __('common.new') }}</option>
                            <option value="old" @if (isset($sort_by) && $sort_by == "old") selected @endif>{{ __('common.old') }}</option>
                            <option value="alpha_asc" @if (isset($sort_by) && $sort_by == "alpha_asc") selected @endif>{{ __('defaultTheme.name_a_to_z') }}</option>
                            <option value="alpha_desc" @if (isset($sort_by) && $sort_by == "alpha_desc") selected @endif>{{ __('defaultTheme.name_z_to_a') }}</option>
                            <option value="low_to_high" @if (isset($sort_by) && $sort_by == "low_to_high") selected @endif>{{ __('defaultTheme.price_low_to_high') }}</option>
                            <option value="high_to_low" @if (isset($sort_by) && $sort_by == "high_to_low") selected @endif>{{ __('defaultTheme.price_high_to_low') }}</option>
                        </select>
                    </div>
                    <div class="flex-fill text-end">
                        <div class="category_toggler d-inline-block d-lg-none  gj-cursor-pointer">
                            <svg  width="19.5" height="13" viewBox="0 0 19.5 13">
                                <g id="filter-icon" transform="translate(28)">
                                    <rect id="Rectangle_1" data-name="Rectangle 1" width="19.5" height="2" rx="1" transform="translate(-28)" fill="#fd4949"/>
                                    <rect id="Rectangle_2" data-name="Rectangle 2" width="15.5" height="2" rx="1" transform="translate(-26 5.5)" fill="#fd4949"/>
                                    <rect id="Rectangle_3" data-name="Rectangle 3" width="5" height="2" rx="1" transform="translate(-20.75 11)" fill="#fd4949"/>
                                </g>
                            </svg>
                        </div>
                    </div>
              </div>
          </div>
      </div>
  </div>
</div>
<div class="tab-content mb_30" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <!-- content  -->
        <div class="row custom_rowProduct">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    @if (get_class($product) == \Modules\Seller\Entities\SellerProduct::class)
                        <input type="hidden" name="base_sku_price" id="base_sku_price"
                            value="
                    @if (@$product->hasDeal) {{ selling_price(@$product->skus->first()->sell_price, @$product->hasDeal->discount_type, @$product->hasDeal->discount) }}
                    @else
                        @if (@$product->hasDiscount == 'yes')
                        {{ selling_price(@$product->skus->first()->sell_price, @$product->discount_type, @$product->discount) }}
                        @else
                        {{ @$product->skus->first()->sell_price }} @endif
                    @endif
                    ">
                    <div class="col-xl-4 col-md-6 col-sm-6 d-flex">
                        <div class="product_widget5 mb_30 style5 w-100">
                            <div class="product_thumb_upper">
                                @php
                                    if (@$product->thum_img != null) {
                                        $thumbnail = showImage(@$product->thum_img);
                                    } else {
                                        $thumbnail = showImage(@$product->product->thumbnail_image_source);
                                    }

                                    $price_qty = getProductDiscountedPrice(@$product);
                                    $showData = [
                                        'name' => @$product->product_name,
                                        'url' => singleProductURL(@$product->seller->slug, @$product->slug),
                                        'price' => $price_qty,
                                        'thumbnail' => $thumbnail,
                                    ];
                                @endphp
                                <a href="{{ singleProductURL($product->seller->slug, $product->slug) }}"
                                    class="thumb">
                                    <img data-src="{{ $thumbnail }}" src="{{ $thumbnail }}"
                                        alt="{{ @$product->product_name }}" title="{{ @$product->product_name }}"
                                        class="lazyload">
                                </a>
                                @if(isGuestAddtoCart())
                                <div class="product_action">
                                    <a href="" class="addToCompareFromThumnail"
                                        data-producttype="{{ @$product->product->product_type }}"
                                        data-seller={{ $product->user_id }}
                                        data-product-sku={{ @$product->skus->first()->id }}
                                        data-product-id={{ $product->id }}>
                                        <i class="ti-control-shuffle"
                                            title="{{ __('defaultTheme.compare') }}"></i>
                                    </a>
                                    <a href=""
                                        class="add_to_wishlist {{ $product->is_wishlist() == 1 ? 'is_wishlist' : '' }}"
                                        id="wishlistbtn_{{ $product->id }}"
                                        data-product_id="{{ $product->id }}"
                                        data-seller_id="{{ $product->user_id }}">
                                        <i class="far fa-heart" title="{{ __('defaultTheme.wishlist') }}"></i>
                                    </a>
                                    <a class="quickView" data-product_id="{{ $product->id }}"
                                        data-type="product">
                                        <i class="ti-eye" title="{{ __('defaultTheme.quick_view') }}"></i>
                                    </a>
                                </div>
                                @endif
                                <div class="product_badge">
                                    @if(isGuestAddtoCart())
                                        @if($product->hasDeal)
                                            @if($product->hasDeal->discount >0)
                                                <span class="d-flex align-items-center discount">
                                                    @if($product->hasDeal->discount_type ==0)
                                                        {{getNumberTranslate($product->hasDeal->discount)}} % {{__('common.off')}}
                                                    @else
                                                        {{single_price($product->hasDeal->discount)}} {{__('common.off')}}
                                                    @endif
                                                </span>
                                            @endif
                                        @else
                                            @if($product->hasDiscount == 'yes')
                                                @if($product->discount >0)
                                                    <span class="d-flex align-items-center discount">
                                                        @if($product->discount_type ==0)
                                                            {{getNumberTranslate($product->discount)}} % {{__('common.off')}}
                                                        @else
                                                            {{single_price($product->discount)}} {{__('common.off')}}
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
                                    @if(isModuleActive('WholeSale') && @$product->skus->first()->wholeSalePrices != '')
                                        <span class="d-flex align-items-center sale">{{__('common.wholesale')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="product_star mx-auto">
                                @php
                                    $reviews = @$product->reviews->where('status', 1)->pluck('rating');

                                    if (count($reviews) > 0) {
                                        $value = 0;
                                        $rating = 0;
                                        foreach ($reviews as $review) {
                                            $value += $review;
                                        }
                                        $rating = $value / count($reviews);
                                        $total_review = count($reviews);
                                    } else {
                                        $rating = 0;
                                        $total_review = 0;
                                    }
                                @endphp
                                <x-rating :rating="$rating" />
                            </div>
                            <div class="product__meta text-center">
                                <span class="product_banding ">{{ @$product->brand->name ?? " " }}</span>
                                <a href="{{singleProductURL(@$product->seller->slug, $product->slug)}}">
                                    <h4>@if ($product->product_name) {{ textLimit(@$product->product_name, 50) }} @else {{ textLimit(@$product->product->product_name, 50) }} @endif</h4>
                                </a>
                                @if(isGuestAddtoCart())
                                <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                    <a class="amaz_primary_btn addToCartFromThumnail" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                                        @if (@$product->hasDeal)
                                            data-base-price={{ selling_price(@$product->skus->first()->sell_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) }}
                                        @else
                                            @if (@$product->hasDiscount == 'yes')
                                                data-base-price={{ selling_price(@$product->skus->first()->sell_price,@$product->discount_type,@$product->discount) }}
                                            @else
                                                data-base-price={{ @$product->skus->first()->sell_price }}
                                            @endif
                                        @endif
                                        data-shipping-method=0
                                        data-product-id={{ $product->id }}
                                        data-stock_manage="{{$product->stock_manage}}"
                                        data-stock="{{@$product->skus->first()->product_stock}}"
                                        data-min_qty="{{@$product->product->minimum_order_qty}}"
                                        data-prod_info="{{ json_encode($showData) }}"
                                        >
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" >
                                            <path d="M0.464844 1.14286C0.464844 0.78782 0.751726 0.5 1.10561 0.5H1.58256C2.39459 0.5 2.88079 1.04771 3.15883 1.55685C3.34414 1.89623 3.47821 2.28987 3.58307 2.64624C3.61147 2.64401 3.64024 2.64286 3.66934 2.64286H14.3464C15.0557 2.64286 15.5679 3.32379 15.3734 4.00811L13.8119 9.50163C13.5241 10.5142 12.6019 11.2124 11.5525 11.2124H6.47073C5.41263 11.2124 4.48508 10.5028 4.20505 9.47909L3.55532 7.10386L2.48004 3.4621L2.47829 3.45572C2.34527 2.96901 2.22042 2.51433 2.03491 2.1746C1.85475 1.84469 1.71115 1.78571 1.58256 1.78571H1.10561C0.751726 1.78571 0.464844 1.49789 0.464844 1.14286ZM4.79882 6.79169L5.44087 9.1388C5.56816 9.60414 5.98978 9.92669 6.47073 9.92669H11.5525C12.0295 9.92669 12.4487 9.60929 12.5795 9.14909L14.0634 3.92857H3.95529L4.78706 6.74583C4.79157 6.76109 4.79548 6.77634 4.79882 6.79169ZM7.72683 13.7857C7.72683 14.7325 6.96184 15.5 6.01812 15.5C5.07443 15.5 4.30942 14.7325 4.30942 13.7857C4.30942 12.8389 5.07443 12.0714 6.01812 12.0714C6.96184 12.0714 7.72683 12.8389 7.72683 13.7857ZM6.4453 13.7857C6.4453 13.5491 6.25405 13.3571 6.01812 13.3571C5.7822 13.3571 5.59095 13.5491 5.59095 13.7857C5.59095 14.0224 5.7822 14.2143 6.01812 14.2143C6.25405 14.2143 6.4453 14.0224 6.4453 13.7857ZM13.7073 13.7857C13.7073 14.7325 12.9423 15.5 11.9986 15.5C11.0549 15.5 10.2899 14.7325 10.2899 13.7857C10.2899 12.8389 11.0549 12.0714 11.9986 12.0714C12.9423 12.0714 13.7073 12.8389 13.7073 13.7857ZM12.4258 13.7857C12.4258 13.5491 12.2345 13.3571 11.9986 13.3571C11.7627 13.3571 11.5714 13.5491 11.5714 13.7857C11.5714 14.0224 11.7627 14.2143 11.9986 14.2143C12.2345 14.2143 12.4258 14.0224 12.4258 13.7857Z" fill="currentColor"/>
                                        </svg>
                                        {{__('defaultTheme.add_to_cart')}}
                                    </a>
                                    <p>
                                        @if (getProductwitoutDiscountPrice(@$product) != single_price(0))
                                            <del>
                                                {{getProductwitoutDiscountPrice(@$product)}}
                                            </del>
                                        @endif
                                        <strong>
                                            {{getProductDiscountedPrice(@$product)}}
                                        </strong>
                                    </p>
                                </div>
                                @else
                                <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                    <a class="amaz_primary_btn w-100" href="{{ url('/login') }}" style="text-indent: 0;">

                                        {{__('defaultTheme.login_to_order')}}
                                    </a>
                                </div>

                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="col-xl-4 col-md-6 col-sm-6 d-flex">
                            <div class="product_widget5 mb_30 style5 w-100">
                                <div class="product_thumb_upper">
                                    @php
                                    $thumbnail = showImage($product->thumbnail_image);
                                    $price_qty = getGiftcardwithDiscountPrice(@$product);
                                    $showData = [
                                        'name' => @$product->product_name,
                                        'url' => route('frontend.gift-card.show', $product->slug),
                                        'price' => $price_qty,
                                        'thumbnail' => $thumbnail,
                                    ];
                                @endphp
                                    <a href="{{ route('frontend.gift-card.show', $product->slug) }}" class="thumb">
                                        <img src="{{ $thumbnail }}" alt="{{ @$product->product_name }}"
                                            title="{{ @$product->product_name }}" class="lazyload">
                                    </a>
                                    @if(isGuestAddtoCart())
                                        <div class="product_action">
                                            <a href="" class="add_to_wishlist_from_search {{@$product->IsWishlist == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-type="gift_card" data-seller_id="1"> <i class="ti-heart"></i> </a>
                                            <a class="add_to_cart_gift_thumnail" data-gift-card-id="{{ $product->id }}" data-seller="1"
                                                data-base-price="@if($product->hasDiscount()) {{selling_price($product->sell_price, $product->discount_type, $product->discount)}} @else {{$product->sell_price}} @endif"
                                                data-prod_info = "{{json_encode($showData)}}"
                                                href="javascript:void(0)"
                                                > <i class="ti-bag"></i> </a>
                                        </div>
                                    @endif
                                    <div class="product_badge">
                                        @if(isGuestAddtoCart())
                                            @if($product->hasDiscount())
                                                @if($product->discount > 0)
                                                    <span class="badge_1">
                                                        @if(@$product->discount_type ==0)
                                                            -{{getNumberTranslate(@$product->discount)}}%
                                                        @else
                                                            -{{single_price(@$product->discount)}}
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
                                    </div>
                                </div>
                                <div class="product_star mx-auto">
                                    @php
                                        $reviews = @$product->reviews->where('status', 1)->pluck('rating');

                                        if (count($reviews) > 0) {
                                            $value = 0;
                                            $rating = 0;
                                            foreach ($reviews as $review) {
                                                $value += $review;
                                            }
                                            $rating = $value / count($reviews);
                                            $total_review = count($reviews);
                                        } else {
                                            $rating = 0;
                                            $total_review = 0;
                                        }
                                    @endphp
                                        <x-rating :rating="$rating" />
                                </div>
                                <div class="product__meta text-center">
                                    <span class="product_banding ">{{ @$product->brand->name ?? " " }}</span>
                                    <a href="{{ route('frontend.gift-card.show', $product->slug) }}">
                                        <h4>
                                            {{ textLimit($product->product_name, 28) }}
                                        </h4>
                                    </a>
                                    @if(isGuestAddtoCart())
                                        <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                            <a class="amaz_primary_btn add_cart add_to_cart add_to_cart_gift_thumnail" data-gift-card-id="{{ $product->id }}"
                                                data-seller="1" data-base-price="@if($product->hasDiscount()) {{selling_price($product->sell_price, $product->discount_type, $product->discount)}} @else {{$product->sell_price}} @endif"
                                                data-prod_info= "{{json_encode($showData)}}"
                                                href="javascript:void(0)"
                                                >
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" >
                                                    <path d="M0.464844 1.14286C0.464844 0.78782 0.751726 0.5 1.10561 0.5H1.58256C2.39459 0.5 2.88079 1.04771 3.15883 1.55685C3.34414 1.89623 3.47821 2.28987 3.58307 2.64624C3.61147 2.64401 3.64024 2.64286 3.66934 2.64286H14.3464C15.0557 2.64286 15.5679 3.32379 15.3734 4.00811L13.8119 9.50163C13.5241 10.5142 12.6019 11.2124 11.5525 11.2124H6.47073C5.41263 11.2124 4.48508 10.5028 4.20505 9.47909L3.55532 7.10386L2.48004 3.4621L2.47829 3.45572C2.34527 2.96901 2.22042 2.51433 2.03491 2.1746C1.85475 1.84469 1.71115 1.78571 1.58256 1.78571H1.10561C0.751726 1.78571 0.464844 1.49789 0.464844 1.14286ZM4.79882 6.79169L5.44087 9.1388C5.56816 9.60414 5.98978 9.92669 6.47073 9.92669H11.5525C12.0295 9.92669 12.4487 9.60929 12.5795 9.14909L14.0634 3.92857H3.95529L4.78706 6.74583C4.79157 6.76109 4.79548 6.77634 4.79882 6.79169ZM7.72683 13.7857C7.72683 14.7325 6.96184 15.5 6.01812 15.5C5.07443 15.5 4.30942 14.7325 4.30942 13.7857C4.30942 12.8389 5.07443 12.0714 6.01812 12.0714C6.96184 12.0714 7.72683 12.8389 7.72683 13.7857ZM6.4453 13.7857C6.4453 13.5491 6.25405 13.3571 6.01812 13.3571C5.7822 13.3571 5.59095 13.5491 5.59095 13.7857C5.59095 14.0224 5.7822 14.2143 6.01812 14.2143C6.25405 14.2143 6.4453 14.0224 6.4453 13.7857ZM13.7073 13.7857C13.7073 14.7325 12.9423 15.5 11.9986 15.5C11.0549 15.5 10.2899 14.7325 10.2899 13.7857C10.2899 12.8389 11.0549 12.0714 11.9986 12.0714C12.9423 12.0714 13.7073 12.8389 13.7073 13.7857ZM12.4258 13.7857C12.4258 13.5491 12.2345 13.3571 11.9986 13.3571C11.7627 13.3571 11.5714 13.5491 11.5714 13.7857C11.5714 14.0224 11.7627 14.2143 11.9986 14.2143C12.2345 14.2143 12.4258 14.0224 12.4258 13.7857Z" fill="currentColor"/>
                                                </svg>
                                                {{__('defaultTheme.add_to_cart')}}</a>
                                            <p>
                                                <span>
                                                    @if(getGiftcardwithoutDiscountPrice(@$product) != single_price(0))
                                                        {{getGiftcardwithoutDiscountPrice(@$product)}}
                                                    @endif
                                                </span>
                                                {{getGiftcardwithDiscountPrice($product)}}
                                            </p>
                                        </div>
                                    @else
                                    <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                        <a class="amaz_primary_btn w-100" href="{{ url('/login') }}" style="text-indent: 0;">

                                            {{__('defaultTheme.login_to_order')}}</a>

                                    </div>

                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center alert alert-danger">
                        {{ __('defaultTheme.no_product_found') }}
                    </div>
                </div>
            @endif
        </div>
        <!--/ content  -->
    </div>
    <div class="tab-pane fade " id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <!-- content  -->
        <div class="row">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    @if (get_class($product) == \Modules\Seller\Entities\SellerProduct::class)
                        <div class="col-xl-12">
                            <div class="product_widget5 mb_30 list_style_product">
                                <div class="product_thumb_upper m-0">
                                    @php
                                        if (@$product->thum_img != null) {
                                            $thumbnail = showImage(@$product->thum_img);
                                        } else {
                                            $thumbnail = showImage(@$product->product->thumbnail_image_source);
                                        }
                                        $price_qty = getProductDiscountedPrice(@$product->product);
                                        $showData = [
                                            'name' => @$product->product->product_name,
                                            'url' => singleProductURL(@$product->seller->slug, @$product->slug),
                                            'price' => $price_qty,
                                            'thumbnail' => $thumbnail,
                                        ];
                                    @endphp
                                    <a href="{{ singleProductURL(@$product->seller->slug, $product->slug) }}"
                                        class="thumb">
                                        <img src="{{ $thumbnail }}"
                                            alt="{{ @$product->product_name ? @$product->product_name : @$product->product->product_name }}"
                                            title="{{ @$product->product_name ? @$product->product_name : @$product->product->product_name }}">
                                    </a>
                                    <div class="product_action">
                                        <a href="" class="addToCompareFromThumnail"
                                            data-producttype="{{ @$product->product->product_type }}"
                                            data-seller={{ $product->user_id }}
                                            data-product-sku={{ @$product->skus->first()->id }}
                                            data-product-id={{ $product->id }}>
                                            <i class="ti-control-shuffle" title="{{ __('defaultTheme.compare') }}"></i>
                                        </a>
                                        <a href=""
                                            class="add_to_wishlist {{ $product->is_wishlist() == 1 ? 'is_wishlist' : '' }}"
                                            id="wishlistbtn_{{ $product->id }}" data-product_id="{{ $product->id }}"
                                            data-seller_id="{{ $product->user_id }}">
                                            <i class="far fa-heart" title="{{ __('defaultTheme.wishlist') }}"></i>
                                        </a>
                                        <a class="quickView" data-product_id="{{ $product->id }}" data-type="product">
                                            <i class="ti-eye" title="{{ __('defaultTheme.quick_view') }}"></i>
                                        </a>
                                    </div>
                                    <div class="product_badge">
                                        @if($product->hasDeal)
                                            @if($product->hasDeal->discount >0)
                                                <span class="d-flex align-items-center discount">
                                                    @if($product->hasDeal->discount_type ==0)
                                                        {{getNumberTranslate($product->hasDeal->discount)}} % {{__('common.off')}}
                                                    @else
                                                        {{single_price($product->hasDeal->discount)}} {{__('common.off')}}
                                                    @endif
                                                </span>
                                            @endif
                                        @else
                                            @if($product->hasDiscount == 'yes')
                                                @if($product->discount >0)
                                                    <span class="d-flex align-items-center discount">
                                                        @if($product->discount_type ==0)
                                                            {{getNumberTranslate($product->discount)}} % {{__('common.off')}}
                                                        @else
                                                            {{single_price($product->discount)}} {{__('common.off')}}
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
                                        @if(isModuleActive('WholeSale') && @$product->skus->first()->wholeSalePrices != '')
                                            <span class="d-flex align-items-center sale">{{__('common.wholesale')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="product__meta text-start">
                                    <span class="product_banding ">{{ @$product->brand->name ?? " " }}</span>
                                    <div class="product_star mt-0 mb-3">
                                        @php
                                            $reviews = @$product->reviews->where('status', 1)->pluck('rating');

                                            if (count($reviews) > 0) {
                                                $value = 0;
                                                $rating = 0;
                                                foreach ($reviews as $review) {
                                                    $value += $review;
                                                }
                                                $rating = $value / count($reviews);
                                                $total_review = count($reviews);
                                            } else {
                                                $rating = 0;
                                                $total_review = 0;
                                            }
                                        @endphp
                                        <x-rating :rating="$rating" />
                                    </div>
                                    <a href="{{singleProductURL(@$product->seller->slug, $product->slug)}}">
                                        <h4>@if ($product->product_name) {{ textLimit(@$product->product_name, 50) }} @else {{ textLimit(@$product->product->product_name, 50) }} @endif</h4>
                                    </a>
                                    <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                        <a class="amaz_primary_btn addToCartFromThumnail" data-producttype="{{ @$product->product->product_type }}" data-seller={{ $product->user_id }} data-product-sku={{ @$product->skus->first()->id }}
                                            @if (@$product->hasDeal)
                                                data-base-price={{ selling_price(@$product->skus->first()->sell_price,@$product->hasDeal->discount_type,@$product->hasDeal->discount) }}
                                            @else
                                                @if (@$product->hasDiscount == 'yes')
                                                    data-base-price={{ selling_price(@$product->skus->first()->sell_price,@$product->discount_type,@$product->discount) }}
                                                @else
                                                    data-base-price={{ @$product->skus->first()->sell_price }}
                                                @endif
                                            @endif
                                            data-shipping-method=0
                                            data-product-id={{ $product->id }}
                                            data-stock_manage="{{$product->stock_manage}}"
                                            data-stock="{{@$product->skus->first()->product_stock}}"
                                            data-min_qty="{{@$product->product->minimum_order_qty}}"
                                            data-prod_info="{{ json_encode($showData) }}"
                                            >
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" >
                                                <path d="M0.464844 1.14286C0.464844 0.78782 0.751726 0.5 1.10561 0.5H1.58256C2.39459 0.5 2.88079 1.04771 3.15883 1.55685C3.34414 1.89623 3.47821 2.28987 3.58307 2.64624C3.61147 2.64401 3.64024 2.64286 3.66934 2.64286H14.3464C15.0557 2.64286 15.5679 3.32379 15.3734 4.00811L13.8119 9.50163C13.5241 10.5142 12.6019 11.2124 11.5525 11.2124H6.47073C5.41263 11.2124 4.48508 10.5028 4.20505 9.47909L3.55532 7.10386L2.48004 3.4621L2.47829 3.45572C2.34527 2.96901 2.22042 2.51433 2.03491 2.1746C1.85475 1.84469 1.71115 1.78571 1.58256 1.78571H1.10561C0.751726 1.78571 0.464844 1.49789 0.464844 1.14286ZM4.79882 6.79169L5.44087 9.1388C5.56816 9.60414 5.98978 9.92669 6.47073 9.92669H11.5525C12.0295 9.92669 12.4487 9.60929 12.5795 9.14909L14.0634 3.92857H3.95529L4.78706 6.74583C4.79157 6.76109 4.79548 6.77634 4.79882 6.79169ZM7.72683 13.7857C7.72683 14.7325 6.96184 15.5 6.01812 15.5C5.07443 15.5 4.30942 14.7325 4.30942 13.7857C4.30942 12.8389 5.07443 12.0714 6.01812 12.0714C6.96184 12.0714 7.72683 12.8389 7.72683 13.7857ZM6.4453 13.7857C6.4453 13.5491 6.25405 13.3571 6.01812 13.3571C5.7822 13.3571 5.59095 13.5491 5.59095 13.7857C5.59095 14.0224 5.7822 14.2143 6.01812 14.2143C6.25405 14.2143 6.4453 14.0224 6.4453 13.7857ZM13.7073 13.7857C13.7073 14.7325 12.9423 15.5 11.9986 15.5C11.0549 15.5 10.2899 14.7325 10.2899 13.7857C10.2899 12.8389 11.0549 12.0714 11.9986 12.0714C12.9423 12.0714 13.7073 12.8389 13.7073 13.7857ZM12.4258 13.7857C12.4258 13.5491 12.2345 13.3571 11.9986 13.3571C11.7627 13.3571 11.5714 13.5491 11.5714 13.7857C11.5714 14.0224 11.7627 14.2143 11.9986 14.2143C12.2345 14.2143 12.4258 14.0224 12.4258 13.7857Z" fill="currentColor"/>
                                            </svg>
                                            {{__('defaultTheme.add_to_cart')}}
                                        </a>
                                        <p class="d-flex flex-wrap gap-2 align-items-center">
                                            @if (getProductwitoutDiscountPrice(@$product) != single_price(0))
                                                <del>
                                                    {{getProductwitoutDiscountPrice(@$product)}}
                                                </del>
                                            @endif
                                            <strong>
                                                {{getProductDiscountedPrice(@$product)}}
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                    <div class="col-xl-12">
                        <div class="product_widget5 mb_30 list_style_product">
                            <div class="product_thumb_upper m-0">
                                @php
                                    $thumbnail = showImage($product->thumbnail_image);
                                    $price_qty = getGiftcardwithDiscountPrice(@$product);
                                    $showData = [];
                                    $showData = [
                                        'name' => @$product->product_name,
                                        'url' => route('frontend.gift-card.show',$product->slug),
                                        'price' => $price_qty,
                                        'thumbnail' => $thumbnail
                                    ];
                                @endphp
                                <a href="{{route('frontend.gift-card.show',$product->slug)}}" class="thumb">
                                    <img src="{{$thumbnail}}" alt="{{@$product->product_name}}" title="{{@$product->product_name}}">
                                </a>
                                <div class="product_action">
                                    <a href="" class="add_to_wishlist_from_search {{@$product->IsWishlist == 1?'is_wishlist':''}}" id="wishlistbtn_{{$product->id}}" data-product_id="{{$product->id}}" data-type="gift_card" data-seller_id="1"> <i class="ti-heart"></i> </a>
                                    <a class="add_to_cart_gift_thumnail" data-gift-card-id="{{ $product->id }}" data-seller="1"
                                        data-base-price="@if($product->hasDiscount()) {{selling_price($product->sell_price, $product->discount_type, $product->discount)}} @else {{$product->sell_price}} @endif"
                                        data-prod_info = "{{json_encode($showData)}}"
                                        href="javascript:void(0)"
                                        > <i class="ti-bag"></i> </a>
                                </div>
                                <div class="product_badge">
                                    @if($product->hasDiscount())
                                            @if($product->discount > 0)
                                                <span class="badge_1">
                                                    @if(@$product->discount_type ==0)
                                                        -{{getNumberTranslate(@$product->discount)}}%
                                                    @else
                                                        -{{single_price(@$product->discount)}}
                                                    @endif
                                                </span>
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
                                </div>
                            </div>
                            <div class="product__meta text-start">
                                <span class="product_banding ">{{ @$product->brand->name ?? " " }}</span>
                                <div class="product_star mt-0 mb-3">
                                    @php
                                        $reviews = @$product->reviews->where('status', 1)->pluck('rating');

                                        if (count($reviews) > 0) {
                                            $value = 0;
                                            $rating = 0;
                                            foreach ($reviews as $review) {
                                                $value += $review;
                                            }
                                            $rating = $value / count($reviews);
                                            $total_review = count($reviews);
                                        } else {
                                            $rating = 0;
                                            $total_review = 0;
                                        }
                                    @endphp
                                    <x-rating :rating="$rating" />
                                </div>
                                <a href="{{singleProductURL(@$product->seller->slug, $product->slug)}}">
                                    <h4>@if ($product->product_name) {{ textLimit(@$product->product_name, 50) }} @else {{ textLimit(@$product->product->product_name, 50) }} @endif</h4>
                                </a>
                                <div class="product_price d-flex align-items-center justify-content-between flex-wrap">
                                    <a class="amaz_primary_btn add_cart add_to_cart add_to_cart_gift_thumnail" data-gift-card-id="{{ $product->id }}"
                                        data-seller="1" data-base-price="@if($product->hasDiscount()) {{selling_price($product->sell_price, $product->discount_type, $product->discount)}} @else {{$product->sell_price}} @endif"
                                        data-prod_info= "{{json_encode($showData)}}"
                                        href="javascript:void(0)">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" >
                                            <path d="M0.464844 1.14286C0.464844 0.78782 0.751726 0.5 1.10561 0.5H1.58256C2.39459 0.5 2.88079 1.04771 3.15883 1.55685C3.34414 1.89623 3.47821 2.28987 3.58307 2.64624C3.61147 2.64401 3.64024 2.64286 3.66934 2.64286H14.3464C15.0557 2.64286 15.5679 3.32379 15.3734 4.00811L13.8119 9.50163C13.5241 10.5142 12.6019 11.2124 11.5525 11.2124H6.47073C5.41263 11.2124 4.48508 10.5028 4.20505 9.47909L3.55532 7.10386L2.48004 3.4621L2.47829 3.45572C2.34527 2.96901 2.22042 2.51433 2.03491 2.1746C1.85475 1.84469 1.71115 1.78571 1.58256 1.78571H1.10561C0.751726 1.78571 0.464844 1.49789 0.464844 1.14286ZM4.79882 6.79169L5.44087 9.1388C5.56816 9.60414 5.98978 9.92669 6.47073 9.92669H11.5525C12.0295 9.92669 12.4487 9.60929 12.5795 9.14909L14.0634 3.92857H3.95529L4.78706 6.74583C4.79157 6.76109 4.79548 6.77634 4.79882 6.79169ZM7.72683 13.7857C7.72683 14.7325 6.96184 15.5 6.01812 15.5C5.07443 15.5 4.30942 14.7325 4.30942 13.7857C4.30942 12.8389 5.07443 12.0714 6.01812 12.0714C6.96184 12.0714 7.72683 12.8389 7.72683 13.7857ZM6.4453 13.7857C6.4453 13.5491 6.25405 13.3571 6.01812 13.3571C5.7822 13.3571 5.59095 13.5491 5.59095 13.7857C5.59095 14.0224 5.7822 14.2143 6.01812 14.2143C6.25405 14.2143 6.4453 14.0224 6.4453 13.7857ZM13.7073 13.7857C13.7073 14.7325 12.9423 15.5 11.9986 15.5C11.0549 15.5 10.2899 14.7325 10.2899 13.7857C10.2899 12.8389 11.0549 12.0714 11.9986 12.0714C12.9423 12.0714 13.7073 12.8389 13.7073 13.7857ZM12.4258 13.7857C12.4258 13.5491 12.2345 13.3571 11.9986 13.3571C11.7627 13.3571 11.5714 13.5491 11.5714 13.7857C11.5714 14.0224 11.7627 14.2143 11.9986 14.2143C12.2345 14.2143 12.4258 14.0224 12.4258 13.7857Z" fill="currentColor"/>
                                        </svg>
                                        {{__('defaultTheme.add_to_cart')}}
                                    </a>
                                    <p class="d-flex flex-wrap gap-2 align-items-center">
                                        @if(getGiftcardwithoutDiscountPrice(@$product) != single_price(0))
                                            <del>
                                                {{getGiftcardwithoutDiscountPrice(@$product)}}
                                            </del>
                                        @endif
                                        <strong>
                                            {{getGiftcardwithDiscountPrice($product)}}
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center alert alert-danger">
                        {{ __('defaultTheme.no_product_found') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
    <input type="hidden" name="filterCatCol" class="filterCatCol" value="0">
    <!--/ content  -->
    @if ($products->lastPage() > 1)
        <x-pagination-component :items="$products" type="" />
    @endif
</div>

