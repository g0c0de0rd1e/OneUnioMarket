
<form action="{{ route('company_information_update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="General_system_wrap_area">
        <div class="single_system_wrap">
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('general_settings.system_logo') }}</span>
                </div>
                <div class="logo_img_div">
                    <img src="{{showImage(app('general_setting')->logo?app('general_setting')->logo:'backend/img/default.png') }}" alt="" id="generalSettingLogo">
                </div>
                <div class="update_logo_btn">
                    <button type="button" class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_logo') }}" type="file" accept="image/*" name="site_logo" id="site_logo">
                        {{ __('general_settings.upload_logo') }}
                    </button>
                </div>

            </div>
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('general_settings.fav_icon') }}</span>
                </div>

                <div class="logo_img_div" >
                    <img src="{{showImage(app('general_setting')->favicon?app('general_setting')->favicon:'backend/img/default.png') }}" alt="" id="generalSettingFavicon">
                </div>

                <div class="update_logo_btn">
                    <button type="button" class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_logo') }}" type="file" accept="image/*" name="favicon_logo" id="favicon_logo">
                        {{ __('general_settings.upload_fav_icon') }}
                    </button>
                </div>

            </div>
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('general_settings.lazyload_image') }}<small>({{getNumberTranslate(250)}} X {{getNumberTranslate(250)}})px</small></span>
                </div>

                <div class="logo_img_div" >
                    <img src="{{showImage(themeDefaultImg()) }}" alt="" id="generalSettingLazyloadImage">
                </div>

                <div class="update_logo_btn">
                    <button type="button" class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_lazyload_image') }}" type="file" accept="image/*" name="lazyload_image" id="lazyload_image">
                        {{ __('general_settings.lazyload_image') }}
                    </button>
                </div>

            </div>
            @if(isModuleActive('MultiVendor'))
            <div class="single_system_wrap_inner text-center">
                <div class="logo">
                    <span>{{ __('general_settings.shop_link_banner') }}<small>({{getNumberTranslate(1920)}} X {{getNumberTranslate(350)}}){{__('common.px')}}</small></span>
                </div>

                <div class="logo_img_div" >
                    <img height="100px" width="200px" src="{{showImage(app('general_setting')->shop_link_banner?app('general_setting')->shop_link_banner:'backend/img/default.png') }}" alt="" id="shopLinkBanner">
                </div>

                <div class="update_logo_btn">
                    <button type="button" class="primary-btn small fix-gr-bg ">
                        <input placeholder="{{ __('general_settings.upload_logo') }}" type="file" accept="image/*" name="shop_link_banner" id="shop_link_banner">
                        {{ __('general_settings.upload_shop_link_banner') }}
                    </button>
                </div>

            </div>
            @endif
        </div>

        <div class="single_system_wrap">
            <div class="row">
                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.system_title') }}</label>
                        <input class="primary_input_field" placeholder="{{ __('general_settings.system_title') }}" type="text" id="site_title" name="site_title" value="{{ $setting->site_title }}">
                    </div>
                </div>

                <div class="col-xl-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.file_supported') }} ({{__('general_settings.include_comma_with_each_word')}})</label>
                        <div class="tagInput_field">
                            <input class="sr-only"  type="text" id="file_supported" name="file_supported" value="{{ $setting->file_supported }}" data-role="tagsinput" class="sr-only">
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.system_default_language') }}</label>
                        <select class="primary_select mb-25" name="language_code" id="language_code">
                            @foreach (\Modules\Language\Entities\Language::where('status', 1)->get() as $key => $language)
                                <option value="{{ $language->code }}" @if (app('general_setting')->language_code == $language->code) selected @endif>{{ $language->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.date_format') }}</label>
                        <select class="primary_select mb-25" name="date_format_id" id="date_format_id">
                            @foreach ($dateformats as $key => $dateFormat)
                                <option value="{{ $dateFormat->id }}" @if (app('general_setting')->date_format_id == $dateFormat->id) selected @endif> ({{ dateConvert($dateFormat->normal_view) }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.system_default_currency') }}</label>
                        <select class="primary_select mb-25" name="currency_id" id="currency">
                            @foreach (\Modules\GeneralSetting\Entities\Currency::where('status',1)->get() as $key => $currency)
                                <option value="{{ $currency->id }}" @if ($setting->currency_code == $currency->code) selected @endif>{{ $currency->name }} ({{$currency->code}})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.time_zone') }}</label>
                        <select class="primary_select mb-25" name="time_zone" id="time_zone_id">
                            @foreach ($timezones as $key => $timeZone)
                                <option value="{{ $timeZone->code }}" @if ($setting->time_zone == $timeZone->code) selected @endif>{{ getNumberTranslate($timeZone->time_zone) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_inpu mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.currency_symbol') }}</label>
                        <input class="primary_input_field" placeholder="-" type="text" id="currency_symbol" name="currency_symbol" value="{{ $setting->currency_symbol }}" readonly>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.currency_code') }}</label>
                        <input class="primary_input_field" placeholder="-" type="text" id="currency_code" name="currency_code" value="{{ getNumberTranslate($setting->currency_code) }}" readonly>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.currency_symbol_position') }}</label>
                        <select class="primary_select mb-25" name="currency_symbol_position" id="currency_symbol_position_id">
                            <option value="left" {{(app('general_setting')->currency_symbol_position == 'left')?'selected':''}}>{{__('menu.left')}} -> [{{getNumberTranslate(app('general_setting')->currency_symbol)}}{{getNumberTranslate(20.20)}}]</option>
                            <option value="left_with_space" {{(app('general_setting')->currency_symbol_position == 'left_with_space')?'selected':''}}>{{__('general_settings.left_with_space')}} -> [{{getNumberTranslate(app('general_setting')->currency_symbol)}}{{getNumberTranslate(20.20)}}]</option>
                            <option value="right" {{(app('general_setting')->currency_symbol_position == 'right')?'selected':''}}>{{__('menu.right')}} -> [ 20.20{{app('general_setting')->currency_symbol}} ]</option>
                            <option value="right_with_space" {{(app('general_setting')->currency_symbol_position == 'right_with_space')?'selected':''}}>{{__('general_settings.right_with_space')}} -> [{{getNumberTranslate(20.20)}} {{getNumberTranslate(app('general_setting')->currency_symbol)}}]</option>
                        </select>

                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="decimal_limit_id">{{__('general_settings.decimal_number_limit') }}</label>
                        <input class="primary_input_field" placeholder="{{getNumberTranslate(0)}}" type="number" id="decimal_limit_id" name="decimal_limit" step="{{getNumberTranslate(0)}}" min="{{getNumberTranslate(0)}}" value="{{getNumberTranslate(app('general_setting')->decimal_limit)}}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{__('general_settings.default_country') }}</label>
                        <select class="primary_select mb-25" name="default_country" id="default_country_id">
                            <option value="">{{__('common.select_one')}}</option>
                            @foreach($countries as $country)
                                <option {{$setting->default_country == $country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{__('general_settings.default_state') }}</label>
                        <select class="primary_select mb-25" name="default_state" id="default_state_id">
                            <option value="">{{__('common.select_one')}}</option>
                            @if($setting->country_id)
                                @foreach($states as $key => $state)
                                <option {{$setting->default_state == $state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            @endif
                        </select>

                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('general_settings.pwa_app_name') }}<span class="text-danger">*</span></label>
                        <input class="primary_input_field" placeholder="-" type="text" id="pwa_app_name" name="pwa_app_name" value="{{env('PWA_NAME','365-amazcart')}}" required>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('general_settings.guest_checkout') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="guest_checkout" id="guestcheckout_active" value="1" class="active" type="radio" {{(app('general_setting')->guest_checkout == 1)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.active') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="guest_checkout" id="guestcheckout_inactive" value="0" class="de_active" type="radio" {{(app('general_setting')->guest_checkout == 0)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.inactive') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('general_settings.product_subtitle_show') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="product_subtitle_show" id="product_subtitle_show_active" value="1" class="active" type="radio" {{(app('general_setting')->product_subtitle_show == 1)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.active') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="product_subtitle_show" id="product_subtitle_show_inactive" value="0" class="de_active" type="radio" {{(app('general_setting')->product_subtitle_show == 0)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.inactive') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('general_settings.category_show_in_menu') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="category_show_in_frontend" id="category_show_in_frontend_all" value="all" class="active" type="radio" {{(app('general_setting')->category_show_in_frontend == 'all')?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{__('defaultTheme.all_categories') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="category_show_in_frontend" id="category_show_in_frontend_parent" value="parent" class="de_active" type="radio" {{(app('general_setting')->category_show_in_frontend == 'parent')?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('general_settings.parent_categories') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('general_settings.disable_seller_plan') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="disable_seller_plan" id="disable_seller_plan_active" value="1" class="active" type="radio" {{(app('general_setting')->disable_seller_plan == 1)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="disable_seller_plan" id="disable_seller_plan_inactive" value="0" class="de_active" type="radio" {{(app('general_setting')->disable_seller_plan == 0)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('general_settings.News letter subscription without email verification') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="verify_on_newsletter" id="verify_on_newsletter_off" value="0" class="active" type="radio" {{(app('general_setting')->verify_on_newsletter == 0)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="verify_on_newsletter" id="verify_on_newsletter_on" value="1" class="de_active" type="radio" {{(app('general_setting')->verify_on_newsletter == 1)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input">
                        <label class="primary_input_label" for="mail_signature">{{ __('general_settings.email_signature') }}</label>
                        <input class="primary_input_field" placeholder="{{ __('general_settings.email_signature') }}" type="text" id="mail_signature" name="mail_signature" value="{{ app('general_setting')->mail_signature }}">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="primary_input">
                        <label class="primary_input_label" for="gst_number">{{ __('gst.gst_or_vat_number') }}</label>
                        <input class="primary_input_field" placeholder="{{ __('gst.gst_or_vat_number') }}" type="text" id="gst_number" name="gst_number" value="{{ app('general_setting')->gst_number }}">
                    </div>
                </div>
                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('general_settings.price_with_vat') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="price_with_vat" id="price_with_vat" value="1" class="active" type="radio" {{(app('general_setting')->price_with_vat == 1)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="price_with_vat" id="price_with_vat" value="0" class="de_active" type="radio" {{(app('general_setting')->price_with_vat == 0)?'checked':''}}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>



                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{__('general_settings.Application Type') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="vendor_type" id="mulativendor" value="1" class="active" type="radio" {{ isModuleActive('MultiVendor') == true ? 'checked':'' }}  >
                                    <span class="checkmark"></span>
                                </label>
                                <p> {{__('general_settings.Multi vendor') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="vendor_type" id="singlevendor" value="0" class="de_active" type="radio" {{ isModuleActive('MultiVendor') == false ? 'checked':'' }}>
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{__('general_settings.Single Vendor') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{__('general_settings.Login Users Checkout') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="user_login_checkout" id="login_user_checkout_enable" value="1" class="active" type="radio" {{ app('general_setting')->user_login_checkout == 1 ? 'checked':'' }}  >
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="user_login_checkout" id="login_user_checkout_disable" value="0" class="de_active" type="radio" {{ app('general_setting')->user_login_checkout == 0 ? 'checked':'' }} >
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{__('general_settings.user_manual_activation') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="user_manual_activation" id="user_manual_activation_yes" value="1" class="active" type="radio" {{ app('general_setting')->user_manual_activation == 1 ? 'checked':'' }}  >
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="user_manual_activation" id="user_manual_activation_no" value="0" class="de_active" type="radio" {{ app('general_setting')->user_manual_activation == 0 ? 'checked':'' }} >
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{__('general_settings.registration_success_url') }}</label>
                        <input type="text" class='primary_input_field' name="registration_success_url" id="registration_success_url" value="{{ app('general_setting')->registration_success_url }}">
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">
                            {{ __('general_settings.image_convert_on_upload') }}
                            <small>({{ __('general_settings.Convert Image to webp when upload new images') }})</small>
                        </label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" for="image_convert_yes" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="image_convert" id="image_convert_yes" {{ app('general_setting')->image_convert == 1 ? 'checked':'' }} value="1" class="active status" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" for="image_convert_no" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="image_convert" id="image_convert_no" {{ app('general_setting')->image_convert == 0 ? 'checked':'' }} value="0" class="de_active status" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">
                            {{ __('general_settings.Minimum Phone number Digit') }}
                        </label>
                        <input class="primary_input_field" placeholder="-" type="text" id="min_digit"  name="min_digit" value="{{ app('general_setting')->min_digit }}" >
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">
                            {{ __('general_settings.Maximum Phone number Digit') }}
                        </label>
                        <input class="primary_input_field" placeholder="-" type="text" id="min_digit"    name="max_digit" value="{{ app('general_setting')->max_digit }}" >
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">
                            {{ __('general_settings.customer_info_update') }}
                        </label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" for="customer_info_enable" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="user_info_update" id="customer_info_enable" {{ app('general_setting')->user_info_update == 1 ? 'checked':'' }} value="1" class="active status" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" for="customer_info_disable" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="user_info_update" id="customer_info_disable" {{ app('general_setting')->user_info_update == 0 ? 'checked':'' }} value="0" class="de_active status" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">
                            {{ __('general_settings.enable_lazyload_image') }}
                        </label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" for="lazyload_enable" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="lazyload" id="lazyload_enable" {{ app('general_setting')->lazyload == 1 ? 'checked':'' }} value="1" class="active status" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" for="lazyload_disable" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="lazyload" id="lazyload_disable" {{ app('general_setting')->lazyload == 0 ? 'checked':'' }} value="0" class="de_active status" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-6 mt-1">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">
                            {{ __('general_settings.product_report_enable') }}
                        </label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" for="product_report_enable" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="product_report" id="product_report_enable" {{ app('general_setting')->product_report == 1 ? 'checked':'' }} value="1" class="active status" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.yes') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" for="product_report_disable" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="product_report" id="product_report_disable" {{ app('general_setting')->product_report == 0 ? 'checked':'' }} value="0" class="de_active status" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.no') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>





                @if(isModuleActive('Pos'))
                    <div class="col-xl-6">
                        <div class="primary_input">
                            <label class="primary_input_label" for="remarks_title">{{__('pos.remarks_title') }}</label>
                            <input class="primary_input_field" type="text" id="remarks_title" name="remarks_title" value="{{ app('general_setting')->remarks_title }}">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="primary_input">
                            <label class="primary_input_label" for="remarks_body">{{__('pos.remarks_body') }}</label>
                            <textarea class="primary_textarea" id="remarks_body" cols="30" rows="10" name="remarks_body">{{ app('general_setting')->remarks_body}}</textarea>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="primary_input">
                            <label class="primary_input_label" for="terms_conditions">{{__('pos.terms_conditions') }}</label>
                            <textarea class="primary_textarea"  id="terms_conditions" cols="30" rows="10" name="terms_conditions">{{ app('general_setting')->terms_conditions}}</textarea>
                        </div>
                    </div>
                @endif





            </div>
        </div>
    </div>
    @if (permissionCheck('company_information_update'))
        <div class="submit_btn text-center mt-4">
            <button class="primary_btn_large" type="submit"> <i class="ti-check"></i> {{ __('common.save') }}</button>
        </div>
    @endif
</form>
