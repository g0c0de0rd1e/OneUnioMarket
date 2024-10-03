    <input type="hidden" id="url" value="{{url('/')}}">
    @php
        $base_url = url('/');
        $current_url = url()->current();
        $just_path = trim(str_replace($base_url,'',$current_url));
        $flash_deal = \Modules\Marketing\Entities\FlashDeal::where('status', 1)->first();
        $new_user_zone = \Modules\Marketing\Entities\NewUserZone::where('status', 1)->first();
    @endphp
    <input type="hidden" id="just_url" value="{{$just_path}}">
    <!-- HEADER::START -->
    <header class="amazcartui_header">
        <div id="sticky-header" class="header_area">
            @include('frontend.amazy.partials._submenu',[$compares])
            @include('frontend.amazy.partials._mainmenu')
            <!-- main_header_area  -->
            @include('frontend.amazy.partials._mega_menu')
            <div class="container">
                <div class="row">
                    <div class="col-12">

                    </div>
                </div>
            </div>
            <div class="menu_search_popup">
                <form class="menu_search_popup_field" method="GET" id="search_form2">
                    <input type="text" class="category_box_input2" placeholder="{{ __('defaultTheme.search_your_item') }}" id="inlineFormInputGroup">
                    <button type="submit" id="search_button">
                        <i class="ti-search"></i>
                    </button>
                </form>
                <span class="search_close home6_search_hide">
                    <i class="fas fa-times"></i>
                </span>
                <div class="live-search">
                    <ul class="p-0" id="search_items2">
                        <li class="search_item" id="search_empty_list2">

                        </li>
                        <li class="search_item" id="search_history2">

                        </li>
                        <li class="search_item" id="tag_search2">

                        </li>
                        <li class="search_item" id="category_search2">

                        </li>
                        <li class="search_item" id="product_search2">

                        </li>
                        <li class="search_item" id="seller_search2">

                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @if(request()->is('gift-cards/*') || request()->is('product/*'))
            <div class="product_details_buttons d-md-none" id="cart_footer_mobile">

                @if(request()->is('product/*'))
                    @if(isModuleActive('MultiVendor'))
                        <a href="
                            @if ($product->seller->slug)
                                {{route('frontend.seller',$product->seller->slug)}}
                            @else
                                {{route('frontend.seller',base64_encode($product->seller->id))}}
                            @endif
                        " class="d-flex flex-column justify-content-center product_details_icon">
                            <i class="ti-save"></i>
                            <span>{{__('common.store')}}</span>
                        </a>
                    @else
                    <a href="{{url('/')}}" class="d-flex flex-column justify-content-center product_details_icon">
                        <i class="ti-home"></i>
                        <span>{{__('common.home')}}</span>
                    </a>
                    @endif
                    @if (@$product->stock_manage == 1 && @$product->skus->first()->product_stock >= @$product->product->minimum_order_qty || @$product->stock_manage == 0)

                        <button type="button" class="product_details_button style1 buy_now_btn" data-id="{{$product->id}}" data-type="product">
                            <span>{{__('common.buy_now')}}</span>
                        </button>

                        <button class="product_details_button add_to_cart_btn" type="button">{{__('common.add_to_cart')}}</button>
                    @else
                        <button type="button" class="product_details_button style1" disabled>
                            <span>{{__('defaultTheme.out_of_stock')}}</span>
                        </button>
                        <button type="button" class="product_details_button" disabled>{{__('defaultTheme.out_of_stock')}}</button>
                    @endif
                @else

                    <button type="button" class="product_details_button style1 buy_now_btn" data-gift-card-id="{{ $card->id }}" data-seller="1" data-base-price="{{$base_price}}" data-shipping-method="1" data-type="gift_card">
                        <span>{{__('common.buy_now')}}</span>
                    </button>

                    <button class="product_details_button add_gift_card_to_cart" type="button" data-gift-card-id="{{ $card->id }}" data-seller="1" data-base-price="{{$base_price}}" data-shipping-method="1" data-show="{{json_encode($showData)}}">{{__('common.add_to_cart')}}</button>
                @endif
            </div>
        @else
            <ul class="short_curt_icons">
                <li>
                    <a href="{{url('/')}}">
                        <div class="cart_singleIcon">
                            <i class="ti-home"></i>
                        </div>
                        <span>{{__('common.home')}}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/category') }}">
                        <div class="cart_singleIcon">
                            <i class="ti-align-justify"></i>
                        </div>
                        <span>{{__('common.category')}}</span>
                    </a>
                </li>
                <li>
                    <a class="position-relative" href="{{url('/cart')}}">
                        <div class="cart_singleIcon cart_singleIcon_cart d-flex align-items-center justify-content-center position-relative">
                            <i class="ti-shopping-cart"></i>
                            <svg version="1.1" id="Layer_1"  xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 127.3 144.29" style="enable-background:new 0 0 127.3 144.29;" xml:space="preserve">
                                <g>
                                    <path class="st0" d="M63.65,143.29c-1.36,0-2.7-0.36-3.88-1.04l-54.9-31.7C2.49,109.18,1,106.6,1,103.84V40.45
                                        c0-2.76,1.48-5.33,3.88-6.71l54.9-31.7C60.95,1.36,62.29,1,63.65,1c1.36,0,2.7,0.36,3.88,1.04l54.9,31.7
                                        c2.39,1.38,3.88,3.95,3.88,6.71v63.39c0,2.76-1.49,5.33-3.88,6.71l-54.9,31.7C66.35,142.93,65.01,143.29,63.65,143.29z" fill="#fff"/>
                                    <path class="st1" d="M63.65,2c1.18,0,2.35,0.31,3.38,0.9l54.9,31.7c2.08,1.2,3.38,3.44,3.38,5.85v63.39c0,2.4-1.29,4.64-3.38,5.85
                                        l-54.9,31.7c-1.02,0.59-2.19,0.9-3.38,0.9c-1.18,0-2.35-0.31-3.38-0.9l-54.9-31.7c-2.08-1.2-3.38-3.44-3.38-5.85V40.45
                                        c0-2.4,1.29-4.64,3.38-5.85l54.9-31.7C61.3,2.31,62.47,2,63.65,2 M63.65,0c-1.51,0-3.02,0.39-4.38,1.17l-54.9,31.7
                                        C1.67,34.43,0,37.32,0,40.45v63.39c0,3.13,1.67,6.02,4.38,7.58l54.9,31.7c1.35,0.78,2.86,1.17,4.38,1.17
                                        c1.51,0,3.02-0.39,4.38-1.17l54.9-31.7c2.71-1.56,4.38-4.45,4.38-7.58V40.45c0-3.13-1.67-6.02-4.38-7.58l-54.9-31.7
                                        C66.67,0.39,65.16,0,63.65,0L63.65,0z" fill="currentColor"/>
                                </g>
                            </svg>
                </div>
                <span>{{__('common.cart')}} (<span class="cart_count_bottom">{{getNumberTranslate($items)}}</span>)</span>
            </a>
        </li>
        <li>
            @if (isset($flash_deal))
                <a class="position-relative" href="{{ route('frontend.flash-deal', $flash_deal->slug) }}">
                    <div class="cart_singleIcon">
                        <img class="mb_5" src="{{showImage('frontend/amazy/img/amaz_icon/deals_white.svg')}}" alt="{{__('amazy.Daily Deals')}}" title="{{__('amazy.Daily Deals')}}">
                    </div>
                    <span>{{__('amazy.Daily Deals')}}</span>
                </a>
            @else
                <a class="position-relative" href="{{url('/profile/notifications')}}">
                    <div class="cart_singleIcon">
                        <i class="ti-bell"></i>
                    </div>
                    <span>{{__('common.notification')}}</span>
                </a>
            @endif
        </li>
        @guest
            <li>
                <a href="{{ url('/login') }}">
                    <div class="cart_singleIcon">
                        <i class="ti-user"></i>
                    </div>
                    <span>{{ __('defaultTheme.login') }}</span>
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('frontend.dashboard') }}">
                    <div class="cart_singleIcon">
                        <i class="ti-user"></i>
                    </div>
                    <span>{{__('common.account')}}</span>
                </a>
            </li>
        @endguest
    </ul>
@endif
</header>
    <!--/ HEADER::END -->

