@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<form method="POST" action="" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data" id="{{$form_id}}">
    <div class="white-box">
        <div class="add-visitor">
            <div class="row">
                @if(isModuleActive('FrontendMultiLang'))
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                            @foreach ($LanguageList as $key => $language)
                                <li class="nav-item lang_code" data-id="{{$language->code}}">
                                    <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" data-id="{{$language->code}}" href="#{{$form_tab}}{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="{{$form_tab}}{{$language->code}}">
                                        <input type="hidden" id="item_id" name="id" value="" />
                                        <div class="primary_input mb-25">
                                            <label class="primary_input_label" for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                                            <input class="primary_input_field"type="text" id="name{{$language->code}}" name="name[{{$language->code}}]" autocomplete="off" value="" placeholder="{{__('common.name')}}">
                                        </div>
                                        <span class="text-danger" id="error_name_{{$language->code}}"></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <input type="hidden" id="item_id" name="id" value="" />
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                            <input class="primary_input_field"type="text" id="name" name="name" autocomplete="off" value="" placeholder="{{__('common.name')}}">
                        </div>
                        <span class="text-danger" id="error_name"></span>
                    </div>
                @endif
                <div class="col-xl-12 mt-10">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                    <input name="status" id="status_active" value="1" checked="true" class="active"
                                        type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.active') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                    <input name="status" value="0" id="status_inactive" class="de_active" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.inactive') }}</p>
                            </li>
                        </ul>
                        <span class="text-danger" id="error_status"></span>
                    </div>
                </div>


            </div>
            <div class="row mt-40">
                <div class="col-lg-12 text-center">
                <button id="{{ $btn_id }}" type="submit" class="primary-btn fix-gr-bg" data-toggle="tooltip" title=""
                        data-original-title="" dusk="queryCreate">
                        <span class="ti-check"></span>
                        {{$button_name}} </button>
                </div>
            </div>
        </div>
    </div>
</form>
