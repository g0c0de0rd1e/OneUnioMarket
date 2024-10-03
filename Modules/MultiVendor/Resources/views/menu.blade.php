@if (isModuleActive('MultiVendor') && auth()->check() && auth()->user()->role->type == "superadmin" || isModuleActive('MultiVendor') && auth()->check() && auth()->user()->role->type == "admin" && permissionCheck('manage_seller') || isModuleActive('MultiVendor') && auth()->check() && auth()->user()->role->type == "staff" && permissionCheck('manage_seller'))
    @php
        $seller_route_admin = false;
        if(request()->is('admin/merchants') || request()->is('admin/merchant-create') || (strpos(request()->getUri(),'details') != false && strpos(request()->getUri(),'refund-request-details') != true && strpos(request()->getUri(),'my-sales-details') != true && strpos(request()->getUri(),'sales-details') != true && strpos(request()->getUri(),'seller-refund-request-details') != true) || request()->is('admin/seller-commisions') || request()->is('admin/subscription-payment-list') || request()->is('admin/pricing') || request()->is('admin/inactive-merchants') || request()->is('admin/seller-configuration')
        )
        {
            $seller_route_admin = true;
        }
    @endphp
    <li class="{{ $seller_route_admin ?'mm-active' : '' }} sortable_li" data-position="{{ menuManagerCheck(1,6)->position }}" data-status="{{ menuManagerCheck(1,6)->status }}">
        <a href="javascript:;" class="has-arrow" aria-expanded="{{ $seller_route_admin ? 'true' : 'false' }}">
            <div class="nav_icon_small">
                <span class="fas fa-user"></span>
            </div>
            <div class="nav_title">
                <span>{{ __('seller.manage_seller') }}</span>
                @if (config('app.sync'))
                    <span class="demo_addons">Addon</span>
                @endif
            </div>
        </a>
        <ul>
            @if (permissionCheck('admin.merchants_list') && menuManagerCheck(2,6,'admin.merchants_list')->status == 1)
                <li data-position="{{ menuManagerCheck(2,6,'admin.merchants_list')->position }}">
                    <a href="{{ route('admin.merchants_list') }}" @if (request()->is('admin/merchants') || request()->is('admin/merchant-create') || (strpos(request()->getUri(),'details') != false && strpos(request()->getUri(),'my-sales-details') != true) && strpos(request()->getUri(),'sales-details') != true && strpos(request()->getUri(),'refund-request-details') != true && strpos(request()->getUri(),'seller-refund-request-details') != true) class="active" @endif>{{ __('common.active') }} {{ __('seller.seller_list') }}</a>
                </li>
            @endif
            @if (permissionCheck('admin.merchants_list') && menuManagerCheck(2,6,'admin.merchants_list')->status == 1)
                <li data-position="{{ menuManagerCheck(2,6,'admin.merchants_list')->position }}">
                    <a href="{{ route('admin.inactiveMerchants') }}" @if (request()->is('admin/inactive-merchants') || request()->is('admin/merchant-create') || (strpos(request()->getUri(),'details') != false && strpos(request()->getUri(),'my-sales-details') != true) && strpos(request()->getUri(),'sales-details') != true && strpos(request()->getUri(),'refund-request-details') != true && strpos(request()->getUri(),'seller-refund-request-details') != true) class="active" @endif>{{ __('common.inactive') }}/{{ __('common.request') }} {{ __('seller.seller_list') }}</a>
                </li>
            @endif
            @if (permissionCheck('admin.seller_commission_item_index') && menuManagerCheck(2,6,'admin.seller_commission_index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,6,'admin.seller_commission_index')->position }}">
                    <a href="{{ route('admin.seller_commission_index') }}" @if (request()->is('admin/seller-commisions')) class="active" @endif>{{ __('seller.commision_setup') }}</a>
                </li>
            @endif

            @if (permissionCheck('admin.pricing.index') && menuManagerCheck(2,6,'admin.pricing.index')->status == 1)
                <li data-position="{{ menuManagerCheck(2,6,'admin.pricing.index')->position }}">
                    <a href="{{ route('admin.pricing.index') }}" class="{{request()->is('admin/pricing') ? 'active' : ''}}">{{ __('frontendCms.pricing_plan') }}</a>
                </li>
            @endif

            @if(permissionCheck('admin.subscription_payment_list') &&  menuManagerCheck(2,6,'admin.subscription_payment_list')->status == 1)
            <li data-position="{{ menuManagerCheck(2,6,'admin.subscription_payment_list')->position }}">
                <a href="{{ route('admin.subscription_payment_list') }}" @if (request()->is('admin/subscription-payment-list')) class="active" @endif>{{ __('seller.subscription_payment') }}</a>
            </li>
            @endif
            
            @if(permissionCheck('admin.seller_configuration') &&  menuManagerCheck(2,6,'admin.seller_configuration')->status == 1)
            <li data-position="{{ menuManagerCheck(2,6,'seller.seller_configuration')->position }}">
                <a href="{{route('admin.seller_configuration')}}" @if (request()->is('admin/seller-configuration')) class="active" @endif>{{ __('common.configuration') }}</a>
            </li>
            @endif
        
        </ul>
    </li>
@endif