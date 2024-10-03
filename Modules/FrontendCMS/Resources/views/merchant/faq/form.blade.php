<form enctype="multipart/form-data" id="{{ $form_id }}">
    <div class="row">
        @if(isModuleActive('FrontendMultiLang'))
            <div class="col-lg-12">
                <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                    @foreach ($LanguageList as $key => $language)
                        <li class="nav-item lang_code" data-id="{{$language->code}}">
                            <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#{{$faq_modal_tab_id}}{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($LanguageList as $key => $language)
                        <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="{{$faq_modal_tab_id}}{{$language->code}}">
                            <div class="row">                                
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.title') }} <span class="text-danger">*</span></label></label>
                                        <input name="title[{{$language->code}}]" class="primary_input_field title" id="title{{$language->code}}" placeholder="{{__('common.title') }}" type="text" value="{{old('title.'.$language->code)}}">
                                    </div>
                                    <span class="text-danger"  id="create_error_title_{{$language->code}}"></span>
                                </div>
                                <div class="col-xl-12">
                                    <div class="primary_input mb-35">
                                        <label class="primary_input_label" for="">{{ __('common.details') }} <span class="text-danger">*</span></label>
                                        <textarea name="description[{{$language->code}}]" placeholder="{{ __('common.description') }}" class="benefit_description" id="description{{$language->code}}">{{old('description.'.$language->code)}}</textarea>
                                    </div>
                                    <span class="text-danger" id="create_error_description_{{$language->code}}"></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.title') }} *</label>
                    <input name="title" class="primary_input_field title" id="title" placeholder="{{ __('common.title') }}" type="text">
                    <span class="text-danger"  id="create_error_title"></span>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="primary_input mb-35">
                    <label class="primary_input_label" for="">{{ __('common.details') }} <span class="text-danger">*</span></label>
                    <textarea name="description" placeholder="{{ __('common.description') }}" class="benefit_description" id="description"></textarea>
                </div>
                <span class="text-danger" id="create_error_description"></span>
            </div>
        @endif
        <div class="col-xl-12">
            <div class="primary_input">
                <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                <ul id="theme_nav" class="permission_list sms_list ">
                    <li>
                        <label data-id="bg_option"
                               class="primary_checkbox d-flex mr-12">
                            <input name="status" id="status_active" value="1" checked="true" class="active" type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('common.active') }}</p>
                    </li>
                    <li>
                        <label data-id="color_option"
                               class="primary_checkbox d-flex mr-12">
                            <input name="status" value="0" id="status_inactive"  class="de_active"
                                   type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('common.inactive') }}</p>
                    </li>
                </ul>
                <span class="text-danger" id="create_error_status"></span>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <div class="d-flex justify-content-center pt_20">
            <button id="{{ $btn_id }}" type="submit" class="primary-btn semi_large2 fix-gr-bg"><i
                        class="ti-check"></i>
                        {{ $button_level_name }}
                </button>
            </div>
        </div>

    </div>
</form>
