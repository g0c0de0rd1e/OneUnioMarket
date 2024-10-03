<form id="formData" action="" method="POST" enctype="multipart/form-data">
    <div class="row">
        <input type="hidden" name="id" id="id" value="{{$return->id}}">
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
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="mainTitle">{{ __('frontendCms.main_title') }} <span class="text-danger">*</span></label>
                                                    <input id="mainTitle{{$language->code}}" name="mainTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($return)?$return->getTranslation('mainTitle',$language->code):old('mainTitle.'.$language->code)}}">
                                                </div>
                                                <span class="text-danger" id="error_mainTitle_{{$language->code}}"></span>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="returnTitle">{{__('frontendCms.return_title') }} <span class="text-danger">*</span></label>
                                                    <input id="returnTitle" name="returnTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($return)?$return->getTranslation('returnTitle',$language->code):old('returnTitle.'.$language->code)}}">
                                                </div>
                                                <span class="text-danger" id="error_returnTitle_{{$language->code}}"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="returnDescription">{{ __('frontendCms.return_details') }} <span class="text-danger">*</span></label>
                                                    <textarea id="returnDescription" name="returnDescription[{{$language->code}}]" class="lms_summernote summernote">{{isset($return)?$return->getTranslation('returnDescription',$language->code):old('returnDescription.'.$language->code)}}</textarea>
                                                </div>
                                                <span class="text-danger" id="error_returnDescription_{{$language->code}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="exchangeTitle">{{ __('frontendCms.exchange_title') }} <span class="text-danger">*</span></label>
                                                    <input id="exchangeTitle" name="exchangeTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($return)?$return->getTranslation('exchangeTitle',$language->code):old('exchangeTitle.'.$language->code)}}">
                                                </div>
                                                <span class="text-danger" id="error_exchangeTitle_{{$language->code}}"></span>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="">{{ __('frontendCms.exchange_details') }} <span class="text-danger">*</span></label>
                                                    <textarea id="exchangeDescription" name="exchangeDescription[{{$language->code}}]" class="lms_summernote summernote2">{{isset($return)?$return->getTranslation('exchangeDescription',$language->code):old('exchangeDescription.'.$language->code)}}</textarea>
                                                </div>
                                                <span class="text-danger" id="error_exchangeDescription_{{$language->code}}"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="mainTitle">{{ __('frontendCms.main_title') }} <span class="text-danger">*</span></label>
                                <input id="mainTitle" name="mainTitle" class="primary_input_field" placeholder="-" type="text" value="{{$return->mainTitle}}">
                            </div>
                            <span class="text-danger" id="error_mainTitle"></span>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="returnTitle">{{__('frontendCms.return_title') }} <span class="text-danger">*</span></label>
                                <input id="returnTitle" name="returnTitle" class="primary_input_field" placeholder="-" type="text" value="{{$return->returnTitle}}">
                            </div>
                            <span class="text-danger" id="error_returnTitle"></span>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="returnDescription">{{ __('frontendCms.return_details') }} <span class="text-danger">*</span></label>
                                <textarea id="returnDescription" name="returnDescription" class="lms_summernote summernote">{{$return->returnDescription}}</textarea>
                            </div>
                            <span class="text-danger" id="error_returnDescription"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="exchangeTitle">{{ __('frontendCms.exchange_title') }} <span class="text-danger">*</span></label>
                                <input id="exchangeTitle" name="exchangeTitle" class="primary_input_field" placeholder="-" type="text" value="{{$return->exchangeTitle}}">
                            </div>
                            <span class="text-danger" id="error_exchangeTitle"></span>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{ __('frontendCms.exchange_details') }} <span class="text-danger">*</span></label>
                                <textarea id="exchangeDescription" name="exchangeDescription" class="lms_summernote summernote2">{{$return->exchangeDescription}}</textarea>
                            </div>
                            <span class="text-danger" id="error_exchangeDescription"></span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (permissionCheck('frontendcms.return-exchange.update'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button id="mainSubmit" class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent" type="submit" dusk="update"><i class="ti-check"></i>{{ __('common.update') }}</button>
                </div>
            </div>
        @endif
    </div>
</form>
