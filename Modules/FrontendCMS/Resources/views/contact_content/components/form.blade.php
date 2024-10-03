<form id="formData" action="{{ route('frontendcms.contact-content.update') }}" method="POST">
    <div class="row">
        <input type="hidden" name="id" value="{{ $contactContent->id }}">
        @if(isModuleActive('FrontendMultiLang'))
            <div class="col-lg-12">
                <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                    @foreach ($LanguageList as $key => $language)
                        <li class="nav-item lang_code" data-id="{{$language->code}}">
                            <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" data-id="{{$language->code}}" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content">
                    @foreach ($LanguageList as $key => $language)
                        <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="mainTitle">{{ __('common.main_title') }} <span class="text-danger">*</span></label>
                                        <input name="mainTitle[{{$language->code}}]" id="mainTitle{{$language->code}}" class="primary_input_field" placeholder="-" type="text" value="{{isset($contactContent)?$contactContent->getTranslation('mainTitle',$language->code):old('mainTitle.'.$language->code)}}">
                                    </div>
                                    <span class="text-danger"  id="error_mainTitle_{{$language->code}}"></span>
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="subTitle">{{ __('common.sub_title') }} <span class="text-danger">*</span></label>
                                        <input name="subTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($contactContent)?$contactContent->getTranslation('subTitle',$language->code):old('subTitle.'.$language->code)}}">
                                    </div>
                                    <span class="text-danger"  id="error_subTitle_{{$language->code}}"></span>
                                </div>
                                <div class="col-xl-12">
                                    <div class="primary_input mb-35">
                                        <label class="primary_input_label" for="">{{ __('common.details') }} <span class="text-danger">*</span></label>
                                        <textarea name="description[{{$language->code}}]" class="lms_summernote">{{isset($contactContent)?$contactContent->getTranslation('description',$language->code):old('description.'.$language->code)}}</textarea>
                                    </div>
                                    <span class="text-danger"  id="error_description_{{$language->code}}"></span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.main_title') }} <span class="text-danger">*</span></label>
                    <input name="mainTitle" id="mainTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('mainTitle') ? old('mainTitle') : $contactContent->mainTitle }}">
                </div>
                <span class="text-danger"  id="error_mainTitle"></span>
            </div>
            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="subTitle">{{ __('common.sub_title') }} <span class="text-danger">*</span></label>
                    <input name="subTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('subTitle') ? old('subTitle') : $contactContent->subTitle }}">
                </div>
                <span class="text-danger"  id="error_subTitle"></span>
            </div>
            <div class="col-xl-12">
                <div class="primary_input mb-35">
                    <label class="primary_input_label" for="">{{ __('common.details') }} <span class="text-danger">*</span></label>
                    <textarea name="description" class="lms_summernote">{{ $contactContent->description }}</textarea>
                </div>
                <span class="text-danger"  id="error_description"></span>
            </div>
        @endif
        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('common.email') }} <span class="text-danger">*</span></label>
                <input name="email" class="primary_input_field" placeholder="-" type="email" value="{{ old('email') ? old('email') : $contactContent->email }}">
            </div>
            <span class="text-danger"  id="email_error"></span>
        </div>
        <div class="col-lg-12 text-center mb-90">
            <div class="d-flex justify-content-center">
                <button id="mainSubmit" class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent" type="submit" dusk="update"><i class="ti-check"></i>{{ __('common.update') }}</button>
            </div>
        </div>
    </div>
</form>