<div class="dropdown CRM_dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false"> {{__('common.select')}}
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
        @if (permissionCheck('admin.merchant_show_details'))
            <a href="{{route('admin.merchant_show_details',$seller->user->id)}}" class="dropdown-item" type="button">{{ __('common.details') }}</a>
        @endif

        @if (permissionCheck('admin.secret_login'))
            <a href="{{route('admin.secret_login',$seller->user->id)}}" class="dropdown-item" type="button">{{ __('common.secret_login') }}</a>
        @endif

        @if (permissionCheck('admin.change_merchant_trusted_status'))
            <a class="dropdown-item trust_seller_change" type="button" data-value="{{route('admin.change_merchant_trusted_status', @$seller->id)}}">
                @if (@$seller->is_trusted == 0)
                    {{ __('seller.make_trusted') }}
                @else
                    {{ __('seller.remove_from_trusted') }}
                @endif
            </a>
        @endif

        @if (permissionCheck('admin.change_merchant_trusted_status'))
            <a class="dropdown-item trust_seller_change" type="button" data-value="{{route('admin.update_status', @$seller->user->id)}}">
                @if (@$seller->user->is_active  == 1)
                    {{ __('common.deactive') }}
                @else
                    {{ __('common.active') }}
                @endif
            </a>
        @endif

        <a class="dropdown-item seller_change_password" type="button" data-value="{{$seller->user->id}}">
            {{ __('seller.change_password') }}
        </a>

    </div>
</div>
