@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/marketing/css/new_user_zone_create.css'))}}" />
@endsection
@section('mainContent')
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="row">
        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title">
                        <h3 class="mb-30">{{ __('marketing.create_new_user_zone') }} </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <ul class="nav nav-tabs justify-content-end mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" href="#GeneralSeting" role="tab" data-toggle="tab" id="1" aria-selected="true">{{__('marketing.general_setting')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link show" href="#productSetup" role="tab" data-toggle="tab" id="2" aria-selected="false">{{__('marketing.product_section')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link show" href="#priceSetup" role="tab" data-toggle="tab" id="3" aria-selected="false">{{__('marketing.exclusive_price_section')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link show" href="#couponSetup" role="tab" data-toggle="tab" id="4" aria-selected="false">{{__('marketing.coupon_section')}}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="container-fluid p-0">
        <form action="{{ route('marketing.new-user-zone.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade active show" id="GeneralSeting">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="no-gutters">
                                        <div class="main-title">
                                            <h3 class="mb-30">{{ __('marketing.general_setting') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div id="formHtml" class="col-lg-12">
                                    <div class="white-box">
                                        <div class="add-visitor">
                                            <div class="row">
                                            @if(isModuleActive('FrontendMultiLang'))
                                                <div class="col-lg-12">
                                                    <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item lang_code" data-id="{{$language->code}}">
                                                                <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#gelement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="gelement{{$language->code}}">
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="title">{{__('common.title') }} <span class="text-danger">*</span></label>
                                                                        <input class="primary_input_field" type="text" id="title" name="title[{{$language->code}}]" autocomplete="off" value="{{ old('title.'.$language->code) }}" placeholder="{{ __('common.title') }}">
                                                                    </div>
                                                                    @if ($errors->has('title.'.auth()->user()->lang_code))
                                                                        <span class="text-danger">{{ $errors->first('title.'.auth()->user()->lang_code) }}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="title">{{__('common.sub_title') }} <span class="text-danger">*</span></label>
                                                                        <input class="primary_input_field" type="text" id="sub_title" name="sub_title[{{$language->code}}]" autocomplete="off" value="{{ old('sub_title.'.$language->code) }}" placeholder="{{ __('common.sub_title') }}">
                                                                    </div>
                                                                    @if ($errors->has('sub_title.'.auth()->user()->lang_code))
                                                                        <span class="text-danger">{{ $errors->first('sub_title.'.auth()->user()->lang_code) }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="title">{{__('common.title') }} <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" type="text" id="title" name="title" autocomplete="off" value="{{ old('title') }}" placeholder="{{ __('common.title') }}">
                                                    </div>
                                                    @error('title')
                                                    <span class="text-danger" id="error_title">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="title">{{__('common.sub_title') }} <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" type="text" id="sub_title" name="sub_title" autocomplete="off" value="{{ old('sub_title') }}" placeholder="{{ __('common.sub_title') }}">
                                                    </div>
                                                    @error('sub_title')
                                                    <span class="text-danger" id="error_sub_title">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endif
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="background_color">{{__('marketing.background_color') }} </label>
                                                        <input class="primary_input_field" type="text" id="background_color" class="form-control" name="background_color" autocomplete="off" value="{{ old('background_color') }}" placeholder="{{ __('#000000') }}">
                                                    </div>
                                                    @error('background_color')
                                                    <span class="text-danger" id="error_background_color">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <label class="primary_input_label" for="">{{ __('common.banner') }} {{__('common.image')}} ({{getNumberTranslate(1920)}} X {{getNumberTranslate(500)}}){{__('common.px')}} </label>
                                                    <div class="primary_input mb-25">
                                                        <div class="primary_file_uploader" data-toggle="amazuploader" data-multiple="false" data-type="image" data-name="new_user_zone_banner_image">
                                                            <input class="primary-input file_amount" type="text" id="image" placeholder="{{__('common.browse_image_file')}}" readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg" for="image">{{__("common.image")}} </label>
                                                                <input type="hidden" class="selected_files" value="">
                                                            </button>
                                                        </div>
                                                        <div class="product_image_all_div">   
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="title_show">{{__('common.show') }} {{ __('common.title') }} </label>
                                                        <label class="switch_toggle" for="checkbox">
                                                            <input type="checkbox" id="checkbox" checked value="1" name='title_show' class="product_status_change">
                                                            <div class="slider round"></div>
                                                        </label>
                                                    </div>
                                                    @error('title_show')
                                                    <span class="text-danger" id="error_title_show">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="productSetup">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="main-title">
                                        <h3 class="mb-30">{{ __('marketing.setup_products') }} </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="formHtmlProduct" class="col-lg-12">
                                    <div class="white-box">
                                        <div class="add-visitor">
                                            <div class="row">
                                            @if(isModuleActive('FrontendMultiLang'))
                                                <div class="col-lg-12">
                                                    <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item lang_code" data-id="{{$language->code}}">
                                                                <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#pelement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="pelement{{$language->code}}">
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="product_navigation_label">{{__('marketing.navigation_label') }}<span class="text-danger">*</span></label>
                                                                        <input class="primary_input_field" type="text" id="product_navigation_label" name="product_navigation_label[{{$language->code}}]" autocomplete="off" value="{{ old('product_navigation_label.'.$language->code) }}" placeholder="{{ __('marketing.navigation_label') }}">
                                                                    </div>
                                                                    @if ($errors->has('product_navigation_label.'.auth()->user()->lang_code))
                                                                    <span class="text-danger">{{ $errors->first('product_navigation_label.'.auth()->user()->lang_code) }}</span>
                                                                @endif
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="product_slogan">{{__('marketing.slogan') }}</label>
                                                                        <input class="primary_input_field" type="text" id="product_slogan" name="product_slogan[{{$language->code}}]" autocomplete="off" value="{{ old('product_slogan.'.$language->code) }}" placeholder="{{ __('marketing.slogan') }}">
                                                                    </div>
                                                                    @error('product_slogan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="product_navigation_label">{{__('marketing.navigation_label') }}<span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" type="text" id="product_navigation_label" name="product_navigation_label" autocomplete="off" value="{{ old('product_navigation_label') }}" placeholder="{{ __('marketing.navigation_label') }}">
                                                    </div>
                                                    @error('product_navigation_label')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="product_slogan">{{__('marketing.slogan') }}</label>
                                                        <input class="primary_input_field" type="text" id="product_slogan" name="product_slogan" autocomplete="off" value="{{ old('product_slogan') }}" placeholder="{{ __('marketing.slogan') }}">
                                                    </div>
                                                    @error('product_slogan')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endif
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="product">{{ __('common.products') }} <span class="text-danger">*</span></label>
                                                        <select id="product" class="mb-15">
                                                            <option selected disabled value="">{{__('marketing.select_products') }}</option>
                                                        </select>
                                                    </div>
                                                    @error('product')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row ">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4 no-gutters">
                                            <div class="main-title">
                                                <h3 class="mb-30">{{ __('marketing.selected_product_list') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="white-box overflow-auto">
                                        <div id="item_table">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="35%" class="text-center">{{__('common.product')}}</th>
                                                        @if(isModuleActive('MultiVendor'))
                                                        <th width="25%" class="text-center">{{__('common.seller')}}</th>
                                                        @endif
                                                        <th width="30%" class="text-center">{{__('common.price')}}</th>
                                                        <th width="10%" class="text-center">{{__('common.delete')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sku_tbody">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="priceSetup">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="col-lg-12">
                                <div class="no-gutters">
                                    <div class="main-title">
                                        <h3 class="mb-30">{{ __('common.category') }} {{__('common.setup')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="white_box_50px box_shadow_white mb-40 minh-430">
                                    <div class="row">
                                        @if(isModuleActive('FrontendMultiLang'))
                                            <div class="col-lg-12">
                                                <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                                    @foreach ($LanguageList as $key => $language)
                                                        <li class="nav-item lang_code" data-id="{{$language->code}}">
                                                            <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#epselement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="tab-content">
                                                    @foreach ($LanguageList as $key => $language)
                                                        <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="epselement{{$language->code}}">
                                                            <div class="col-lg-12">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label" for="category_navigation_label">{{__('marketing.navigation_label') }}<span class="text-danger">*</span></label>
                                                                    <input class="primary_input_field" type="text" id="category_navigation_label" name="category_navigation_label[{{$language->code}}]" autocomplete="off" value="{{ old('category_navigation_label.'.$language->code) }}" placeholder="{{ __('marketing.navigation_label') }}">
                                                                </div>
                                                                @if ($errors->has('category_navigation_label.'.auth()->user()->lang_code))
                                                                    <span class="text-danger">{{ $errors->first('category_navigation_label.'.auth()->user()->lang_code) }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="primary_input mb-25">
                                                                    <label class="primary_input_label" for="category_slogan">{{__('marketing.slogan') }}</label>
                                                                    <input class="primary_input_field" type="text" id="category_slogan" name="category_slogan[{{$language->code}}]" autocomplete="off" value="{{ old('category_slogan.'.$language->code) }}" placeholder="{{ __('marketing.slogan') }}">
                                                                </div>
                                                                @error('category_slogan')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="category_navigation_label">{{__('marketing.navigation_label') }}<span class="text-danger">*</span></label>
                                                    <input class="primary_input_field" type="text" id="category_navigation_label" name="category_navigation_label" autocomplete="off" value="{{ old('category_navigation_label') }}" placeholder="{{ __('marketing.navigation_label') }}">
                                                </div>
                                                @error('category_navigation_label')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="category_slogan">{{__('marketing.slogan') }}</label>
                                                    <input class="primary_input_field" type="text" id="category_slogan" name="category_slogan" autocomplete="off" value="{{ old('category_slogan') }}" placeholder="{{ __('marketing.slogan') }}">
                                                </div>
                                                @error('category_slogan')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @endif
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="">{{ __('common.category_list')}} <span class="text-danger">*</span></label>
                                                <select id="category" class="mb-15">
                                                    <option value="" selected disabled>{{__('marketing.select_category')}}</option>
                                                </select>
                                                @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="no-gutters">
                                        <div class="main-title">
                                            <h3 class="mb-30">{{ __('marketing.selected_category_list') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="white-box ">
                                        <div id="categoryDiv" class="minh-250">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="couponSetup">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="no-gutters">
                                        <div class="main-title">
                                            <h3 class="mb-30">{{ __('marketing.coupon_section_setup') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div id="formHtmlCoupon" class="col-lg-12">
                                    <div class="white-box">
                                        <div class="add-visitor">
                                            <div class="row">
                                                @if(isModuleActive('FrontendMultiLang'))
                                                <div class="col-lg-12">
                                                    <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <li class="nav-item lang_code" data-id="{{$language->code}}">
                                                                <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#cselement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content">
                                                        @foreach ($LanguageList as $key => $language)
                                                            <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="cselement{{$language->code}}">
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="coupon_navigation_label">{{__('marketing.navigation_label') }} <span class="text-danger">*</span></label>
                                                                        <input class="primary_input_field" type="text" id="coupon_navigation_label" name="coupon_navigation_label[{{$language->code}}]" autocomplete="off" value="{{ old('coupon_navigation_label.'.$language->code) }}" placeholder="{{ __('marketing.navigation_label') }}">
                                                                    </div>
                                                                    @if ($errors->has('coupon_navigation_label.'.auth()->user()->lang_code))
                                                                        <span class="text-danger">{{ $errors->first('coupon_navigation_label.'.auth()->user()->lang_code) }}</span>
                                                                    @endif
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label" for="coupon_slogan">{{__('marketing.slogan') }}</label>
                                                                        <input class="primary_input_field" type="text" id="coupon_slogan" name="coupon_slogan[{{$language->code}}]" autocomplete="off" value="{{ old('coupon_slogan.'.$language->code) }}" placeholder="{{ __('marketing.slogan') }}">
                                                                    </div>
                                                                    @error('coupon_slogan')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="coupon_navigation_label">{{__('marketing.navigation_label') }} <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field" type="text" id="coupon_navigation_label" name="coupon_navigation_label" autocomplete="off" value="{{ old('coupon_navigation_label') }}" placeholder="{{ __('marketing.navigation_label') }}">
                                                    </div>
                                                    @error('coupon_navigation_label')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="coupon_slogan">{{__('marketing.slogan') }}</label>
                                                        <input class="primary_input_field" type="text" id="coupon_slogan" name="coupon_slogan" autocomplete="off" value="{{ old('coupon_slogan') }}" placeholder="{{ __('marketing.slogan') }}">
                                                    </div>
                                                    @error('coupon_slogan')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            @endif
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="coupon">{{__('marketing.coupon_list') }} </label>
                                                        <select name="coupon" id="coupon" class="primary_select mb-15">
                                                            <option value="" disabled selected> {{__('common.select')}}</option>
                                                            @foreach($coupons as $key => $coupon)
                                                            <option value="{{$coupon->id}}">{{$coupon->title}}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="coupon_category">{{__('common.category_list') }} <span class="text-danger">*</span></label>
                                                        <select id="coupon_category" class="mb-15">
                                                            <option value="" disabled selected> {{__('marketing.select_category')}}</option>
                                                        </select>
                                                        @error('coupon_category')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 mt-40 text-center">
                                                    <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg" data-toggle="tooltip" title="" data-original-title=""> <span class="ti-check"></span> {{ __('common.save') }} </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="no-gutters">
                                        <div class="main-title">
                                            <h3 class="mb-30">{{ __('marketing.selected_category_list') }}</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="white-box ">
                                        <div id="CouponCategoryDiv" class="minh-250">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</section>
@endsection
@push('scripts')
<script>
(function($){
        "use strict";
        $(document).ready(function() {
            $("#background_color").spectrum();
            $("#text_color").spectrum();
            $(document).on('change', '#product', function(event) {
                $('#submit_btn').prop('disabled', true);
                $('#pre-loader').removeClass('d-none');
                let product_id = $('#product').val();
                if (product_id != null) {
                    $.post('{{ route('marketing.new-user-zone.product-list') }}', {
                        _token: '{{ csrf_token() }}',
                        product_id: product_id
                    }, function(data) {
                        let exsists = $('#product_check_'+product_id).length;
                        if(exsists < 1){
                            $('#sku_tbody').append(data);
                            $('#submit_btn').prop('disabled', false);
                            $('#product').val('');
                            $('#product').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        }else{
                            toastr.error("{{__('marketing.this_item_already_added_to_list')}}");
                            $('#submit_btn').prop('disabled', false);
                            $('#product').val('');
                            $('#product').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                } else {
                    $('#submit_btn').prop('disabled', false);
                }
            });
            $(document).on('change', '#category', function(event) {
                $('#submit_btn').prop('disabled', true);
                $('#pre-loader').removeClass('d-none');
                let category_id = $('#category').val();
                if (category_id != null) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'category_id': category_id
                    }
                    $.post('{{ route('marketing.new-user-zone.category-list') }}', data, function(data) {
                        let exsists = $('#catego_'+category_id).length;
                        if(exsists < 1){
                            $('#categoryDiv').append(data);
                            $('#submit_btn').prop('disabled', false);
                            $('#category').val('');
                            $('#category').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        }else{
                            toastr.error("{{__('marketing.this_item_already_added_to_list')}}");
                            $('#submit_btn').prop('disabled', false);
                            $('#category').val('');
                            $('#category').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                } else {
                    $('#submit_btn').prop('disabled', false);
                }
            });
            $(document).on('change', '#coupon_category', function(event){
                $('#submit_btn').prop('disabled', true);
                $('#pre-loader').removeClass('d-none');
                let category_id = $('#coupon_category').val();
                if (category_id != null) {
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'category_id': category_id
                    }
                    $.post('{{ route('marketing.new-user-zone.coupon-category-list') }}', data, function(data) {
                        let exsists = $('#coupon_catego_'+category_id).length;
                        if(exsists < 1){
                            $('#CouponCategoryDiv').append(data);
                            $('#submit_btn').prop('disabled', false);
                            $('#coupon_category').val('');
                            $('#coupon_category').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        }else{
                            toastr.error("{{__('marketing.this_item_already_added_to_list')}}");
                            $('#submit_btn').prop('disabled', false);
                            $('#coupon_category').val('');
                            $('#coupon_category').niceSelect('update');
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                } else {
                    $('#submit_btn').prop('disabled', false);
                }
            });
            $(document).on('mouseover','body',function(){
                $('#categoryDiv').sortable({
                    cursor:"move"
                }).disableSelection();
                $('#CouponCategoryDiv').sortable({
                    cursor:"move"
                }).disableSelection();
            });
            $(document).on('change', '#banner_image', function(){
                getFileName($(this).val(),'#banner_image_file');
                imageChangeWithFile($(this)[0],'#MetaImgDiv');
            });
            $(document).on('click', '.product_delete_btn', function(event){
                event.preventDefault();
                delete_product_row($(this)[0]);
            });
            $(document).on('click', '.cat_btn', function(event){
                event.preventDefault();
                categoryDelete($(this)[0]);
            });
            $(document).on('click', '.coupon_category_delete_btn', function(event){
                event.preventDefault();
                couponCategoryDelete($(this)[0]);
            });
            function delete_product_row(this_data){
                let row = this_data.parentNode.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }
            function categoryDelete(this_data){
                let row = this_data.parentNode.parentNode.parentNode.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }
            function couponCategoryDelete(this_data){
                let row = this_data.parentNode.parentNode.parentNode.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }
            dynamicSelect2WithAjax("#product", "{{url('/products/seller-products/get-by-ajax')}}", "GET");
            dynamicSelect2WithAjax("#category", "{{url('/products/get-category-data')}}", "GET");
            dynamicSelect2WithAjax("#coupon_category", "{{url('/products/get-category-data')}}", "GET");
        });
    })(jQuery);
</script>
@endpush
