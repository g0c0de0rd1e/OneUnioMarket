<!-- sidebar part here -->
@if(config('app.sync'))
<a target="_blank" href="https://aorasoft.com/" class="float_button"> <i class="ti-shopping-cart-full"></i>
    <h3>{{ __('common.Purchase Amazcart') }}</h3>
</a>
@endif
<nav id="sidebar" class="sidebar">
    <div class="sidebar-header update_sidebar">
        <a class="large_logo" href="{{ auth()->user()->role->type == 'seller' ? route('seller.dashboard') : route('admin.dashboard') }}">
            <img src="{{showImage(app('general_setting')->logo)}}" alt="{{app('general_setting')->company_name}}" title="{{app('general_setting')->company_name}}">
        </a>
        <a class="mini_logo" href="{{ auth()->user()->role->type == 'seller' ? route('seller.dashboard') : route('admin.dashboard') }}">
            <img src="{{showImage(app('general_setting')->favicon)}}" alt="{{app('general_setting')->company_name}}" title="{{app('general_setting')->company_name}}">
        </a>
        <a id="close_sidebar" class="d-lg-none">
            <i class="ti-close"></i>
        </a>
    </div>
    @php

        $sidebars = \Modules\SidebarManager\Entities\BackendmenuUser::with('children', 'backendMenu')->whereNull('parent_id')->where('user_id', auth()->id())->orderBy('position')->get();
        $paid_modules = [
            'AmazonS3',
            'Affiliate',
            'Otp',
            'Bkash',
            'SslCommerz',
            'Lead',
            'MercadoPago',
            'ShipRocket',
            'GoldPrice',
            'WholeSale',
            'StorageCDN',
            'FrontendMultiLang',
            'INTShipping',
            'ClubPoint',
            'GoogleMerchantCenter',
            'CheckPincode',
            'Tabby',
            'POS',
            'AuctionProducts',
            'Pincode'
        ];

    @endphp
    @if($sidebars->count())
        <ul id="sidebar_menu">
            @if(auth()->user()->role->type == 'seller' && !hasBusinessInfo())
                <li class="">
                    <a href="{{ route('seller.profile.index') }}" class="" aria-expanded="false">
                        <div class="nav_icon_small"><span class="fas fa-business-time"></span></div>
                        <div class="nav_title"><span>{{ __("seller.update_business_info") }}</span></div>
                    </a>
                </li>
            @endif
            @foreach($sidebars as $key => $section)

                @if($section->children->count() > 0)
                    <span class="menu_seperator">
                        {{__(@$section->backendMenu->name)}}
                    </span>
                @endif





                @if($section->children->count())
                    @foreach($section->children as $menu)

                        @if(!@$menu->backendMenu->module or isModuleActive(@$menu->backendMenu->module))
                            @if(@$menu->backendMenu->route == 'payment_gateway.index' && auth()->user()->role->type == 'seller' && !app('general_setting')->seller_wise_payment)
                                @continue
                            @elseif(permissionCheck(@$menu->backendMenu->route))
                                <li class="{{spn_active_link(childrenRoute($menu))}}">
                                    <a href="
                                        @if(\Illuminate\Support\Facades\Route::has(@$menu->backendMenu->route) && !$menu->children->count())
                                            @if(@$menu->backendMenu->route == 'my-wallet.index')
                                                @if(auth()->user()->role->type == 'seller')
                                                    {{route(@$menu->backendMenu->route, 'seller')}}
                                                @else
                                                    {{route(@$menu->backendMenu->route, 'admin')}}
                                                @endif
                                            @else
                                                {{route(@$menu->backendMenu->route)}}
                                            @endif
                                         @else
                                            javascript:void(0)
                                         @endif" class="@if($menu->children->count()) has-arrow @endif" aria-expanded="false">
                                        <div class="nav_icon_small">
                                            <span class="{{@$menu->backendMenu->icon?@$menu->backendMenu->icon:'fas fa-users'}}"></span>
                                        </div>
                                        <div class="nav_title">
                                            <span>{{__($menu->backendMenu->name)}}</span>
                                            @php
                                                $exp = explode('.',$menu->backendMenu->name)

                                            @endphp
                                            @if(config('app.sync') && in_array($menu->backendMenu->module, $paid_modules))
                                              <span class="demo_addons" style="font-size: 10px;">
                                                Addon
                                              </span>
                                            @endif
                                            @if($menu->backendMenu->name == 'general_settings.file_storage' && isModuleActive('StorageCDN') && config('app.sync'))
                                              <span class="demo_addons" style="font-size: 10px;">
                                                Addon
                                              </span>
                                            @endif
                                        </div>
                                    </a>
                                    @if($menu->children->count())
                                        <ul class="mm-collapse">
                                            @foreach($menu->children as $submenu)
                                                @if(app('theme')->folder_path == 'amazy')
                                                    @if(@$submenu->backendMenu->route == 'frontendcms.features.index' || @$submenu->backendMenu->route == 'frontendcms.about-us.index')
                                                        @continue
                                                    @endif
                                                @elseif(app('theme')->folder_path == 'default')
                                                    @if(@$submenu->backendMenu->route == 'frontendcms.ads_bar.index' || @$submenu->backendMenu->route == 'frontendcms.promotionbar.index' || @$submenu->backendMenu->route == 'frontendcms.login_page')
                                                        @continue
                                                    @endif
                                                @endif
                                                @if(!@$submenu->backendMenu->module or isModuleActive(@$submenu->backendMenu->module))
                                                    @if(permissionCheck($submenu->backendMenu->route))
                                                        <li>
                                                            <a href="
                                                                @if(\Illuminate\Support\Facades\Route::has($submenu->backendMenu->route) && !$submenu->children->count())
                                                                    @if(@$submenu->backendMenu->route == 'my-wallet.index')
                                                                        @if(auth()->user()->role->type == 'seller')
                                                                            {{route(@$submenu->backendMenu->route, 'seller')}}
                                                                        @else
                                                                            {{route(@$submenu->backendMenu->route, 'admin')}}
                                                                        @endif
                                                                    @else
                                                                        {{route(@$submenu->backendMenu->route)}}
                                                                    @endif
                                                                @else
                                                                    javascript:void(0)
                                                                @endif"
                                                                class="{{spn_active_link(childrenRoute($submenu), 'active')}} @if(@$submenu->children->count()) has-arrow @endif">{{__(@$submenu->backendMenu->name)}} </a>
                                                            @if(@$submenu->children->count())
                                                                <ul class="metis_submenu">
                                                                    @foreach($submenu->children as $subsubmenu)
                                                                        <li>

                                                                            <a href="@if(\Illuminate\Support\Facades\Route::has(@$subsubmenu->backendMenu->route)) {{route(@$subsubmenu->backendMenu->route)}} @else javascript:void(0) @endif"> {{__(@$subsubmenu->backendMenu->name)}} </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    @endif
</nav>
<!-- sidebar part end -->
