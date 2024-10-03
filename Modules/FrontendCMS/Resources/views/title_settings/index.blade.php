@extends('backEnd.master')
@section('mainContent')
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="white_box_30px">
            <form action="{{ route('frontendcms.title_settings.update') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30" >{{ __('frontendCms.related_sale_setting') }}</h3>
                            </div>
                        </div>
                    </div>
                    @if(isModuleActive('FrontendMultiLang'))
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                @foreach ($LanguageList as $key => $language)
                                    <li class="nav-item lang_code" data-id="{{$language->code}}">
                                        <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach ($LanguageList as $key => $language)
                                    <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="up_sale_product_display_title">{{__('common.up_sale_product_display_title')}}</label>
                                                    <input class="primary_input_field" placeholder="{{__('common.up_sale_product_display_title')}}" type="text" id="up_sale_product_display_title" name="up_sale_product_display_title[{{$language->code}}]" value="{{isset($FooterContent)?$FooterContent->getTranslation('up_sale_product_display_title',$language->code):old('up_sale_product_display_title.'.$language->code)}}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="cross_sale_product_display_title">{{__('common.cross_sale_product_display_title')}}</label>
                                                    <input class="primary_input_field" placeholder="{{__('common.cross_sale_product_display_title')}}" type="text" id="cross_sale_product_display_title" name="cross_sale_product_display_title[{{$language->code}}]" value="{{isset($FooterContent)?$FooterContent->getTranslation('cross_sale_product_display_title',$language->code):old('cross_sale_product_display_title.'.$language->code)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="up_sale_product_display_title">{{__('common.up_sale_product_display_title')}}</label>
                                <input class="primary_input_field" placeholder="{{__('common.up_sale_product_display_title')}}" type="text" id="up_sale_product_display_title" name="up_sale_product_display_title" value="{{ $FooterContent->up_sale_product_display_title }}">
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="cross_sale_product_display_title">{{__('common.cross_sale_product_display_title')}}</label>
                                <input class="primary_input_field" placeholder="{{__('common.cross_sale_product_display_title')}}" type="text" id="cross_sale_product_display_title" name="cross_sale_product_display_title" value="{{ $FooterContent->cross_sale_product_display_title }}">
                            </div>
                        </div>
                    @endif
                </div>
                @if (permissionCheck('frontendcms.title_settings.update'))
                    <div class="submit_btn text-center">
                        <button class="primary_btn_2" type="submit"> <i class="ti-check" dusk="save"></i>{{ __('common.save') }}</button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</section>
@endsection
