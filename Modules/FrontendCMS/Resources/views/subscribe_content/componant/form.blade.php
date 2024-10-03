<form id="formData" method="POST" enctype="multipart/form-data">
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
    <div class="row">
        <input type="hidden" name="id" value="{{ $subscribeContent->id }}">
        <input type="hidden" name="status" value="1">
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
                                        <label class="primary_input_label" for="">{{ __('common.title') }}</label>
                                        <input name="title[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($subscribeContent)?$subscribeContent->getTranslation('title',$language->code):old('title.'.$language->code)}}">
                                        <span class="text-danger"  id="title_error_{{$language->code}}"></span>
                                    </div>
                    
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="">{{ __('common.sub_title') }}</label>
                                        <input name="subtitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value=" {{isset($subscribeContent)?$subscribeContent->getTranslation('subtitle',$language->code):old('subtitle.'.$language->code)}}">
                                        <span class="text-danger"  id="subtitle_error_{{$language->code}}"></span>
                                    </div>
                    
                                </div>
                    
                                <div class="col-xl-12">
                                    <div class="primary_input mb-35">
                                        <label class="primary_input_label" for="description">{{ __('common.details') }}</label>
                                        <textarea name="description[{{$language->code}}]" id="description" class="lms_summernote summernote">{{isset($subscribeContent)?$subscribeContent->getTranslation('description',$language->code):old('description.'.$language->code)}}</textarea>
                                        <span class="text-danger"  id="description_error_{{$language->code}}"></span>
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
                    <label class="primary_input_label" for="">{{ __('common.title') }}</label>
                    <input name="title" class="primary_input_field" placeholder="-" type="text" value="{{ old('title') ? old('title') : $subscribeContent->title }}">
                    <span class="text-danger"  id="title_error"></span>
                </div>

            </div>
            <div class="col-xl-6">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.sub_title') }}</label>
                    <input name="subtitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('subtitle') ? old('subtitle') : $subscribeContent->subtitle }}">
                    <span class="text-danger"  id="subtitle_error"></span>
                </div>

            </div>

            <div class="col-xl-12">
                <div class="primary_input mb-35">
                    <label class="primary_input_label"
                        for="">{{ __('common.details') }}</label>
                    <textarea name="description" id="description" class="lms_summernote summernote">{{ $subscribeContent->description }}</textarea>
                    <span class="text-danger"  id="description_error"></span>
                </div>

            </div>
        @endif
        <div class="col-xl-6 d-none">
            <div class="primary_input mb-25">
                <label class="mb-2 mr-30">{{ __('common.image') }}<small>(327x446)px</small></label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="placeholderFileOneName" placeholder="{{ __('common.browse') }}" readonly="">
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.image")}} </label>
                        <input type="file" class="d-none" name="file" id="document_file_1">
                    </button>
                </div>
                <span class="text-danger"  id="file_error"></span>
                @if ($subscribeContent->image)
                <div class="img_div mt-20">
                    <img id="blogImgShow" src="{{showImage($subscribeContent->image)}}" alt="">
                </div>
                @else
                <div class="img_div mt-20">
                   <img id="blogImgShow" src="{{showImage('backend/img/default.png')}}" alt="">
                </div>
                @endif
            </div>
        </div>
        @if (permissionCheck('frontendcms.subscribe-content.update'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent" type="submit" dusk="update"><i class="ti-check"></i>{{ __('common.update') }}</button>
                </div>
            </div>
        @endif
    </div>
</form>
