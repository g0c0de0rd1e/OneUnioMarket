<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30">
                {{__('common.seller')}} {{__('common.account')}}</h3>
        </div>
    
        <form method="POST" action="{{route('seller.profile.seller-account.update',$seller->id)}}" id="seller_account_form"
            accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="white-box">
                <div class="add-visitor">
                    <div class="row">
                        <input type="hidden" name="seller_account_id" value="{{$seller->sellerAccount->id}}">
                        <input type="hidden" name="id" value="{{$seller->id}}">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label d-inline" for="">{{__('common.seller')}}
                                    {{__('common.id')}} :</label> <strong>{{$seller->sellerAccount->seller_id}}</strong>
    
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="first_name">{{__('common.first_name')}} <span
                                        class="text-danger">*</span></label>
                                <input name="first_name" class="primary_input_field" placeholder="-" type="text"
                                    value="{{ old('first_name')? old('first_name'):$seller->first_name }}">
                                @error('first_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="last_name">{{__('common.last_name')}}</label>
                                <input name="last_name" class="primary_input_field" placeholder="-" type="text"
                                    value="{{ old('last_name')? old('last_name'):$seller->last_name }}">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="email">{{__('common.email_address')}} <span
                                        class="text-danger">*</span></label>
                                <input name="email" class="primary_input_field" placeholder="-" type="text"
                                    value="{{ old('email')? old('email'):$seller->email }}">
                                @error('email')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="seller_phone">{{__('common.phone_number')}} <span
                                        class="text-danger">*</span></label>
                                <input name="seller_phone" class="primary_input_field" placeholder="-" type="text"
                                    value="{{ old('seller_phone')? old('seller_phone'):$seller->username }}">
                                @error('seller_phone')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
    
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                    for="shop_display_name">{{__('seller.display_name')}}/{{__('seller.shop_name')}}
                                    ({{__('common.unique')}}) <span class="text-danger">*</span></label>
                                <input name="shop_display_name" class="primary_input_field" placeholder="-" type="text"
                                    value="{{ old('shop_display_name')? old('shop_display_name'):$seller->sellerAccount->seller_shop_display_name }}">
                                @error('shop_display_name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
    
                        </div>
                        @if(permissionCheck('seller.change_subscription_type'))
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                    for="shop_display_name">{{__('seller.commission_type')}}<span
                                        class="text-danger">*</span> <a
                                        href="{{route('seller.category_commission_info.index')}}">{{ __('seller.check_category_commissions') }}</a>
                                </label>
                                <select class="primary_select mb-25 commission_type" name="commission_type" id="commission_type" required>
                                    @foreach ($commissions as $key => $commission)
                                    <option value="{{ $commission->id }}"  data-rate='{{ $commission->rate }}' @if ($seller->sellerAccount->seller_commission_id
                                        == $commission->id) selected @endif>{{ $commission->name }} @if ($commission->id ==
                                        1)
                                        ({{ ($seller->sellerAccount->seller_commission_id != 0) ? $seller->sellerAccount->commission_rate : $commission->rate }}
                                        %) @endif</option>
                                    @endforeach
                                </select>
                            </div>
    
                        </div>
    
                        <div class="col-xl-6 @if($seller->sellerAccount->seller_commission_id == 3) @else d-none @endif" id="pricing_div">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label"
                                    for="shop_display_name">{{__('frontendCms.pricing')}} <span
                                    class="text-danger">*</span> ({{__('seller.after_change_and_save_previous_lisence_will_expried')}})
                                </label>
                                <select class="primary_select mb-25 pricing_id" name="pricing_id" id="pricing_id" required>
                                    @foreach ($pricings as $pricing)
                                    <option value="{{ $pricing->id }}" @if (isset($seller->SellerSubscriptions) && $seller->SellerSubscriptions->pricing_id == $pricing->id) selected @endif>{{$pricing->name}}</option>
                                    @endforeach
                                </select>
                            </div>
    
                        </div>
                        <div class="col-lg-6 @if($seller->sellerAccount->seller_commission_id == 3) @else d-none @endif" id="subscription_type_div">
                            <div class="primary_input">
                                <label class="primary_input_label"
                                    for="holiday_mode">{{ __('seller.subscription_type') }}</label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                            <input name="subscription_type" id="subscription_type_active" value="monthly" @if($seller->sellerAccount->subscription_type=='monthly' ||$seller->sellerAccount->subscription_type==null) checked @endif class="active" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.monthly') }}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                            <input name="subscription_type" value="yearly"
                                                {{$seller->sellerAccount->subscription_type=='yearly'?'checked':''}}
                                                id="subscription_type_inactive" class="de_active" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.yearly') }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="col-xl-6">
                            <div class="primary_input">
                                <label class="primary_input_label"
                                    for="holiday_mode">{{ __('seller.holiday_mode') }}</label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                            <input name="holiday_mode" id="holiday_mode_active" value="1"
                                                {{$seller->sellerAccount->holiday_mode==1?'checked':''}} class="active" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.on') }}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                            <input name="holiday_mode" value="0"
                                                {{$seller->sellerAccount->holiday_mode==0?'checked':''}}
                                                id="holiday_mode_inactive" class="de_active" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.off') }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="select_type_div" class="col-xl-6 {{$seller->sellerAccount->holiday_mode ==0?'d-none':''}}">
                            <label class="primary_input_label" for="business_country">{{__('common.select_type')}} <span
                                    class="text-danger">*</span></label>
                            <select name="holiday_type" id="select_type" class="primary_select mb-25">
                                <option {{$seller->sellerAccount->holiday_type ==1?'selected':''}} value="1">{{__('common.single_day')}}</option>
                                <option {{$seller->sellerAccount->holiday_type ==2?'selected':''}}  value="2">{{__('common.multiple_day')}}</option>
                            </select>
                            <span class="text-danger" id="error_business_country"></span>
                        </div>
                        <div id="holiday_date_div"
                            class="col-xl-6 {{$seller->sellerAccount->holiday_mode ==0 || $seller->sellerAccount->holiday_type ==2?'d-none':''}}">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="holiday_date">{{__('common.holiday_date')}}</label>
                                <div class="primary_datepicker_input">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="{{ __('common.date') }}"
                                                    class="primary_input_field primary-input date form-control"
                                                    id="startDate" type="text" name="holiday_date"
                                        value="{{date('m/d/Y',strtotime($seller->sellerAccount->holiday_date)) ?? date('m/d/Y')}}"
                                                    autocomplete="off" required>
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="holiday_start_date_div"
                            class="col-xl-6 {{$seller->sellerAccount->holiday_type ==1 || $seller->sellerAccount->holiday_type ==null?'d-none':''}}">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="holiday_date_start">{{__('seller.holiday_start')}}</label>
                                <div class="primary_datepicker_input">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="{{ __('common.date') }}"
                                                    class="primary_input_field primary-input date form-control"
                                                    id="startDate" type="text" name="holiday_date_start"
                                                    value="{{date('m/d/Y',strtotime($seller->sellerAccount->holiday_date_start)) ?? date('m/d/Y')}}" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="holiday_end_date_div"
                            class="col-xl-6 {{$seller->sellerAccount->holiday_type ==1 || $seller->sellerAccount->holiday_type ==null?'d-none':''}}">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label"
                                    for="holiday_date_end">{{__('seller.holiday_end')}}</label>
                                <div class="primary_datepicker_input">
                                    <div class="no-gutters input-right-icon">
                                        <div class="col">
                                            <div class="">
                                                <input placeholder="{{ __('common.date') }}"
                                                    class="primary_input_field primary-input date form-control"
                                                    id="startDate" type="text" name="holiday_date_end"
                                                    value="{{date('m/d/Y',strtotime($seller->sellerAccount->holiday_date_end)) ?? date('m/d/Y')}}" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <button class="" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="col-lg-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="about_seller">{{ __('seller.about_seller') }}</label>
                                <textarea name="about_seller" id="about_seller"
                                    class="summernote">{{$seller->sellerAccount->about_seller}}</textarea>
                            </div>
                            @if ($errors->has('about_seller'))
                            <span class="text-danger" id="error_message">{{ $errors->first('about_seller') }}</span>
                            @endif
                        </div>
    
                    </div>
    
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center tooltip-wrapper" data-title="" data-original-title="" title="">
                            <button class="primary-btn fix-gr-bg tooltip-wrapper " id="sellerAccountBtn">
                                <span class="ti-check"></span>
                                {{__('common.update')}} </button>
                        </div>
    
    
                    </div>
    
                </div>
            </div>
        </form>
    </div>
    
</div>