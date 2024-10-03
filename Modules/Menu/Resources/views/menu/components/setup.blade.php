@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/nestable2.css')) }}" />
<link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/icon-picker.css')) }}" />
<link rel="stylesheet" href="{{asset(asset_path('modules/menu/css/style.css'))}}" />
<link rel="stylesheet" href="{{asset(asset_path('modules/menu/css/setup.css'))}}" />
@endsection
@section('mainContent')
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
    <section class="admin-visitor-area up_st_admin_visitor">
        @if($menu->menu_type == 'mega_menu')
        <div class="row">
            <div class="col-md-12 mb-20">
                <div class="box_header_right">
                    <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                        <ul class="nav" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active show" href="#Setup" role="tab" data-toggle="tab" id="1"
                                    aria-selected="true">{{__('common.setup')}}</a>
                            </li>
                            @if(app('theme')->folder_path == 'default')
                                <li class="nav-item">
                                    <a class="nav-link show" href="#RightPanel" role="tab" data-toggle="tab" id="2"
                                        aria-selected="false">{{__('menu.right_panel')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link show" href="#BottomPanel" role="tab" data-toggle="tab" id="3"
                                        aria-selected="false">{{__('menu.bottom_panel')}}</a>
                                </li>
                            @elseif(app('theme')->folder_path == 'amazy')
                                <li class="nav-item">
                                    <a class="nav-link show" href="#AdsSectionPanel" role="tab" data-toggle="tab" id="4"
                                        aria-selected="false">{{__('common.ads_section')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($menu->menu_type == 'mega_menu')
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade active show" id="Setup">
                <div class="container-fluid p-0">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('menu.setup_menu') }} -> {{$menu->name}}</h3>
                                    <ul class="d-flex">
                                        <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            @include('menu::menu.components.create_element')
                        </div>

                        <div id="div333" class="col-lg-8">
                            @include('menu::menu.components.element_list')
                        </div>
                   </div>
                </div>
            </div>
            @if(app('theme')->folder_path == 'default')
                <div role="tabpanel" class="tab-pane fade" id="RightPanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('menu.right_panel_setup') }} -> {{$menu->name}}</h3>
                                    <ul class="d-flex">
                                        <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div id="formHtml" class="col-lg-12 mb-20">
                                    <div class="white-box minh-250">
                                        <div class="add-visitor">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="accordion_rightpanel_create">
                                                        <div class="card">
                                                            <div class="card-header" id="heading_rightpanel_create">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link add_btn_link collapsed" data-toggle="collapse"
                                                                        data-target="#menusrightpanel_create" aria-expanded="false" aria-controls="collapse_rightpanel_create">
                                                                        {{__('product.add_category')}}
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="menusrightpanel_create" class="collapse" aria-labelledby="heading_rightpanel_create"
                                                                data-parent="#accordion_rightpanel_create">
                                                                <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="primary_input mb-15">
                                                                            <label class="primary_input_label" for="">{{ __('common.category') }} <span class="text-danger">*</span></label>
                                                                            <select name="category" id="category_rightpanel" class="mb-15" multiple>
                                                                            </select>
                                                                            <span class="text-danger"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 text-center">
                                                                        <button id="add_category_rightpanel_btn" type="submit" class="primary-btn fix-gr-bg submit_btn" data-toggle="tooltip" title="" data-original-title=""><span class="ti-check"></span>{{__('common.save')}} </button>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="white-box p-15">
                                <h4 class="mb-10">{{__('common.category_list')}}</h4>
                                <div id="rightpanelListDiv" class="minh-250">
                                    @include('menu::menu.components.rightpanel_category_list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="BottomPanel">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('menu.bottom_panel_setup') }} -> {{$menu->name}}</h3>
                                    <ul class="d-flex">
                                        <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="row">
                                <div id="formHtml" class="col-lg-12 mb-20">
                                    <div class="white-box minh-250">
                                        <div class="add-visitor">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="accordion_bottompanel_create">
                                                        <div class="card mb-10">
                                                            <div class="card-header" id="headingBrand_bottompanel_create">
                                                                <h5 class="mb-0">
                                                                    <button class="btn btn-link add_btn_link collapsed" data-toggle="collapse"
                                                                        data-target="#brands_bottompanel_create" aria-expanded="false"
                                                                        aria-controls="collapseBrand_bottompanel_create">
                                                                        {{__('menu.add_brand')}}
                                                                    </button>
                                                                </h5>
                                                            </div>
                                                            <div id="brands_bottompanel_create" class="collapse" aria-labelledby="headingBrand_bottompanel_create"
                                                                data-parent="#accordion_bottompanel_create">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="primary_input mb-15">
                                                                                <label class="primary_input_label" for="">{{ __('product.brand') }}
                                                                                    <span class="text-danger">*</span></label>
                                                                                <select name="brand" id="brand_bottompanel" class="mb-15" multiple>
                                                                                </select>
                                                                                <span class="text-danger"></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 text-center">
                                                                            <button id="add_brand_bottompanel_create_btn" type="submit"
                                                                                class="primary-btn fix-gr-bg submit_btn" data-toggle="tooltip"
                                                                                title="" data-original-title="">
                                                                                <span class="ti-check"></span>
                                                                                {{__('common.save')}} </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="white-box p-15">
                                <h4 class="mb-10">{{__('product.brand_list')}}</h4>
                                <div id="bottompanelListDiv" class="minh-250">
                                    @include('menu::menu.components.bottompanel_brand_list')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(app('theme')->folder_path == 'amazy')
                <div role="tabpanel" class="tab-pane fade" id="AdsSectionPanel">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box_header common_table_header">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('Ads section setup for') }} -> {{$menu->name}}</h3>
                                    <ul class="d-flex">
                                        <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div id="formHtml" class="col-lg-12 mb-20">
                                    <div class="white-box minh-250">
                                        <div class="add-visitor">
                                            <form action="" id="ads_form" enctype="multipart/form-data">
                                                <div class="row">
                                                    @if(isModuleActive('FrontendMultiLang'))
                                                        <div class="col-lg-12">
                                                            <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <li class="nav-item">
                                                                        <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#megamenuadselement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="tab-content">
                                                                @foreach ($LanguageList as $key => $language)
                                                                    <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="megamenuadselement{{$language->code}}">
                                                                       <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label" for="subtitle">{{__('common.title')}} <span class="text-danger">*</span>
                                                                                    </label>
                                                                                    <input class="primary_input_field" type="text" id="title" value="{{isset($menu->menuAds)?$menu->menuAds->getTranslation('title',$language->code):old('title.'.$language->code)}}" name="title[{{$language->code}}]" autocomplete="off"  placeholder="{{__('common.title')}}">
                                                                                    <span class="text-danger" id="ads_error_title_{{$language->code}}"></span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label" for="subtitle">{{__('common.sub_title')}} <span class="text-danger">*</span>
                                                                                    </label>
                                                                                    <input class="primary_input_field" type="text" id="subtitle" value="{{isset($menu->menuAds)?$menu->menuAds->getTranslation('subtitle',$language->code):old('subtitle.'.$language->code)}}" name="subtitle[{{$language->code}}]" autocomplete="off"  placeholder="{{__('common.sub_title')}}">
                                                                                    <span class="text-danger" id="ads_error_subtitle_{{$language->code}}"></span>
                                                                                </div>
                                                                            </div>
                                                                       </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-lg-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label" for="subtitle">{{__('common.title')}} <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="primary_input_field" type="text" id="title" value="{{@$menu->menuAds->title}}" name="title" autocomplete="off"  placeholder="{{__('common.title')}}">
                                                                <span class="text-danger" id="ads_error_title"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="primary_input_label" for="subtitle">{{__('common.sub_title')}} <span class="text-danger">*</span>
                                                                </label>
                                                                <input class="primary_input_field" type="text" id="subtitle" value="{{@$menu->menuAds->subtitle}}" name="subtitle" autocomplete="off"  placeholder="{{__('common.sub_title')}}">
                                                                <span class="text-danger" id="ads_error_subtitle"></span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="col-lg-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="primary_input_label" for="link">{{__('common.link')}} <span class="text-danger">*</span>
                                                            </label>
                                                            <input class="primary_input_field" type="text" id="link" value="{{@$menu->menuAds->link}}" name="link" autocomplete="off"  placeholder="{{__('common.link')}}">
                                                            <span class="text-danger" id="ads_error_link"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="primary_input mt_40">
                                                            <ul id="theme_nav" class="permission_list sms_list ">
                                                                <li>
                                                                    <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                                        <input name="status" id="status" value="1" {{@$menu->menuAds->status?'checked':''}} type="checkbox">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                    <p>{{ __('appearance.enable_this_section') }}</p>
                                                                </li>
                                                            </ul>
                                                            <span class="text-danger" id="error_status"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 upload_photo_div">
                                                        <div class="primary_input">
                                                            <label class="primary_input_label">{{__('common.image')}} ({{getNumberTranslate(330)}} X {{getNumberTranslate(300)}}){{__('common.px')}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="primary_input mb-25">
                                                            <div class="primary_file_uploader" data-toggle="amazuploader" data-multiple="false" data-type="image" data-name="menu_ads_image">
                                                                <input class="primary-input file_amount" type="text" id="image" placeholder="{{__('common.browse_image_file')}}" readonly="">
                                                                <button class="" type="button">
                                                                    <label class="primary-btn small fix-gr-bg" for="image">{{__("blog.image")}} </label>
                                                                    <input type="hidden" class="selected_files" value="{{@$menu->menuAds->menu_ads_image_media->media_id}}">
                                                                </button>
                                                            </div>
                                                            <div class="product_image_all_div">
                                                                @if(@$menu->menuAds->menu_ads_image_media->media_id)
                                                                    <input type="hidden" name="menu_ads" class="product_images_hidden" value="{{@$menu->menuAds->menu_ads_image_media->media_id}}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <span class="text-danger" id="error_menu_ads"></span>
                                                    </div>
                                                    <input type="hidden" value="{{$menu->id}}" name="menu_id">
                                                    <div class="col-xl-4 offset-xl-4">
                                                        <button class="primary_btn_2 mt-5" id="ads_form_btn"><i class="ti-check"></i>{{ __('common.update') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @else
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('menu.setup_menu') }} -> {{$menu->name}}</h3>
                            <ul class="d-flex">
                                <li><a href="{{ url('/menu/manage') }}" class="primary-btn radius_30px mr-10 fix-gr-bg">{{ __('menu.back_to_menu') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('menu::menu.components.create_element')
                </div>

                <div id="div333" class="col-lg-8">
                    @include('menu::menu.components.element_list')
                </div>
           </div>
        </div>
        @endif
    </section>
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('menu.column'),'modal_id' => 'deleteColumnModal',
    'form_id' => 'column_delete_form','delete_item_id' => 'delete_column_id','dataDeleteBtn' =>'columnDeleteBtn'])
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('menu.element'),'modal_id' => 'deleteElementModal',
    'form_id' => 'element_delete_form','delete_item_id' => 'delete_element_id','dataDeleteBtn' =>'elementDeleteBtn'])
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('menu.menu'),'modal_id' => 'deleteMenuModal',
    'form_id' => 'menu_delete_form','delete_item_id' => 'delete_menu_id','dataDeleteBtn' =>'menuDeleteBtn'])
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('common.category'),'modal_id' => 'deleteCategoryModal',
    'form_id' => 'category_delete_form','delete_item_id' => 'delete_category_id','dataDeleteBtn' =>'categoryDeleteBtn'])
    @include('backEnd.partials._deleteModalForAjax',
    ['item_name' => __('product.brand'),'modal_id' => 'deleteBrandModal',
    'form_id' => 'brand_delete_form','delete_item_id' => 'delete_brand_id','dataDeleteBtn' =>'brandDeleteBtn'])

@endsection

@include('menu::menu.components._setup_script')


