@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30"> {{__('marketing.create_coupon') }} </h3>
        </div>
    </div>
</div>
<div class="row">
    <div id="formHtml" class="col-lg-12">
        <div class="white-box">
            <form id="add_form">
                <div class="add-visitor">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="coupon_type">{{ __('marketing.coupon_type') }} <span
                                    class="text-danger">*</span></label>
                                <select name="coupon_type" id="coupon_type" class="primary_select mb-15">
                                    <option disabled selected>{{ __('common.select') }}</option>
                                    <option value="1">{{__('marketing.product_base')}}</option>
                                    <option value="2">{{__('marketing.order_base')}}</option>
                                    <option value="3">{{__('marketing.free_shipping')}}</option>
                                    <option value="4">{{__('marketing.merchant_coupon')}}</option>
                                </select>
                            </div>
                            <span class="text-danger" id="error_coupon_type"></span>
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
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="coupon_title">{{ __('common.title') }} <span class="text-danger">*</span></label>
                                                    <input class="primary_input_field" type="text" id="coupon_title" name="coupon_title[{{$language->code}}]" autocomplete="off" value="{{ old('coupon_title.'.$language->code) }}" placeholder="{{ __('common.title') }}">
                                                    <span class="text-danger" id="error_coupon_title_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="coupon_title">{{ __('common.title') }} <span class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="coupon_title" name="coupon_title" autocomplete="off" value="{{ old('coupon_title') }}" placeholder="{{ __('common.title') }}">
                                    <span class="text-danger" id="error_coupon_title"></span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="formDataDiv">
                    </div>
                    <div class="row mt-40">
                        <div class="col-lg-12 text-center">
                            <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg" data-toggle="tooltip" title="" data-original-title=""> <span class="ti-check"></span> {{ __('common.save') }} </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


