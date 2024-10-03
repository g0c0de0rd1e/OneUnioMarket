@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30">{{ __('common.edit') }} </h3>
        </div>
    </div>
</div>
<div class="row">
    <div id="formHtml" class="col-lg-12">
        <div class="white-box">
            <form action="" id="edit_form">
                <div class="add-visitor">
                    <div class="row">
                        <input type="hidden" name="id" value="{{$priority->id}}">
                        @if(isModuleActive('FrontendMultiLang'))
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                    @foreach ($LanguageList as $key => $language)
                                        <li class="nav-item lang_code" data-id="{{$language->code}}">
                                            <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#steelement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($LanguageList as $key => $language)
                                        <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="steelement{{$language->code}}">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="name">{{__('common.name')}}<span class="text-danger">*</span></label>
                                                <input class="primary_input_field name" type="text" id="name{{auth()->user()->lang_code == $language->code?$language->code:''}}" name="name[{{$language->code}}]" autocomplete="off"  placeholder="{{__('common.name')}}" value="{{isset($priority)?$priority->getTranslation('name',$language->code):old('name.'.$language->code)}}">
                                                <span class="text-danger" id="error_name_{{$language->code}}"></span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="name">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                    <input class="primary_input_field" type="text" id="name" name="name" autocomplete="off" value="{{$priority->name}}" placeholder="{{ __('common.name') }}">
                                </div>
                                <span class="text-danger" id="error_name"></span>
                            </div>
                        @endif
                        <div class="col-xl-12">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option"
                                               class="primary_checkbox d-flex mr-12">
                                            <input name="status" id="status_active" value="1" {{$priority->status == 1?'checked':''}} class="active" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.active') }}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option"
                                               class="primary_checkbox d-flex mr-12">
                                            <input name="status" value="0" id="status_inactive" {{$priority->status == 0?'checked':''}} class="de_active"
                                                   type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.inactive') }}</p>
                                    </li>
                                </ul>
                                <span class="text-danger" id="status_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-40">
                        @if (permissionCheck('ticket.priority.update'))
                            <div class="col-lg-12 text-center">
                                <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg"
                                    data-toggle="tooltip" title="" data-original-title="">
                                    <span class="ti-check"></span>
                                    {{ __('common.update') }} </button>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
