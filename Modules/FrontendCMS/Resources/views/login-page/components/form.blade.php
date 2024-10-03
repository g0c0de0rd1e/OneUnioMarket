<div class="row">
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade {{ $loginPageTab == 1?'active show':'' }} " id="admin">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('frontendcms.login_page.update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="login_slug" value="admin-login">

                        <div class="add-visitor">
                            <div class="row">
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
                                                                <label class="mb-2 mr-30">{{ __('frontendCms.title') }}</label>
                                                                <div class="primary_file_uploader">
                                                                    <input name="title[{{$language->code}}]" class="primary_input_field" value="{{isset($getAllLoginPageInfo[0])?$getAllLoginPageInfo[0]->getTranslation('title',$language->code):old('title.'.$language->code)}}" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="mb-2 mr-30">{{ __('frontendCms.sub_title') }}</label>
                                                                <div class="primary_file_uploader">
                                                                    <input name="sub_title[{{$language->code}}]" class="primary_input_field" value="{{isset($getAllLoginPageInfo[0])?$getAllLoginPageInfo[0]->getTranslation('sub_title',$language->code):old('sub_title.'.$language->code)}}" type="text">
                                                                </div>
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
                                            <label class="mb-2 mr-30">{{ __('frontendCms.title') }}</label>
                                            <div class="primary_file_uploader">
                                                <input name="title" class="primary_input_field" value="{{ isset($getAllLoginPageInfo[0]->title)? $getAllLoginPageInfo[0]->title:'' }}" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="mb-2 mr-30">{{ __('frontendCms.sub_title') }}</label>
                                            <div class="primary_file_uploader">
                                                <input name="sub_title" class="primary_input_field" value="{{ isset($getAllLoginPageInfo[0]->sub_title)? $getAllLoginPageInfo[0]->sub_title:'' }}" type="text">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="mb-2 mr-30">{{ __('common.image') }}<small>({{getNumberTranslate(730)}}x{{getNumberTranslate(503)}}) {{__('common.px')}}</small></label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="placeholderFileOneName1" placeholder="{{ __('common.browse') }}" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="document_file_1">{{__("common.image")}} </label>
                                                <input type="file" class="d-none" name="cover_image" id="document_file_1" accept="image/*">
                                            </button>
                                        </div>
                                        <span class="text-danger"  id="file_error"></span>

                                        <div class="img_div mt-20">
                                            <img class="blogImgShow" id="blogImgShow1" src="{{showImage( isset($getAllLoginPageInfo[0]->cover_img) ?$getAllLoginPageInfo[0]->cover_img:'backend/img/default.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center">
                                @if(permissionCheck('frontendcms.login_page'))
                                    <button class="primary-btn semi_large2  fix-gr-bg mr-1" type="submit"><i class="ti-check"></i>{{ __('common.update') }}</button>
                                @else
                                    <span class="alert alert-warning" role="alert">
                                        <strong>
                                            {{ __('common.you_don_t_have_this_permission') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade {{ $loginPageTab == 2?'active show':'' }} " id="customer">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('frontendcms.login_page.update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="login_slug" value="login">

                        <div class="add-visitor">
                            <div class="row">
                                @if(isModuleActive('FrontendMultiLang'))
                                    <div class="col-lg-12">
                                        <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                            @foreach ($LanguageList as $key => $language)
                                                <li class="nav-item lang_code" data-id="{{$language->code}}">
                                                    <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#celement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            @foreach ($LanguageList as $key => $language)
                                                <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="celement{{$language->code}}">
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="mb-2 mr-30">{{ __('frontendCms.title') }}</label>
                                                                <div class="primary_file_uploader">
                                                                    <input name="title[{{$language->code}}]" class="primary_input_field" value="{{isset($getAllLoginPageInfo[1])?$getAllLoginPageInfo[1]->getTranslation('title',$language->code):old('title.'.$language->code)}}" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="primary_input mb-25">
                                                                <label class="mb-2 mr-30">{{ __('frontendCms.sub_title') }}</label>
                                                                <div class="primary_file_uploader">
                                                                    <input name="sub_title[{{$language->code}}]" class="primary_input_field" value="{{isset($getAllLoginPageInfo[1])?$getAllLoginPageInfo[1]->getTranslation('sub_title',$language->code):old('sub_title.'.$language->code)}}" type="text">
                                                                </div>
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
                                            <label class="mb-2 mr-30">{{ __('frontendCms.title') }}</label>
                                            <div class="primary_file_uploader">
                                                <input name="title" class="primary_input_field" value="{{ isset($getAllLoginPageInfo[1]->title)? $getAllLoginPageInfo[1]->title:'' }}" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="primary_input mb-25">
                                            <label class="mb-2 mr-30">{{ __('frontendCms.sub_title') }}</label>
                                            <div class="primary_file_uploader">
                                                <input name="sub_title" class="primary_input_field" value="{{ isset($getAllLoginPageInfo[1]->sub_title)? $getAllLoginPageInfo[1]->sub_title:'' }}" type="text">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="mb-2 mr-30">{{ __('common.image') }}<small>({{getNumberTranslate(730)}}x{{getNumberTranslate(503)}}) {{__('common.px')}}</small></label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="placeholderFileOneName2" placeholder="{{ __('common.browse') }}" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="document_file_2">{{__("common.image")}} </label>
                                                <input type="file" class="d-none" name="cover_image" id="document_file_2" accept="image/*">
                                            </button>
                                        </div>
                                        <span class="text-danger"  id="file_error"></span>

                                        <div class="img_div mt-20">
                                            <img class="blogImgShow" id="blogImgShow2" src="{{showImage( isset($getAllLoginPageInfo[1]->cover_img) ? $getAllLoginPageInfo[1]->cover_img:'backend/img/default.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center">
                                @if(permissionCheck('frontendcms.login_page'))
                                    <button class="primary-btn semi_large2  fix-gr-bg mr-1"
                                            type="submit"><i class="ti-check"></i>{{ __('common.update') }}
                                    </button>
                                @else
                                    <span class="alert alert-warning" role="alert">
                                        <strong>
                                            {{ __('common.you_don_t_have_this_permission') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div role="tabpanel" class="tab-pane fade {{ $loginPageTab == 3?'active show':'' }} " id="seller">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('frontendcms.login_page.update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="login_slug" value="seller-login">

                        <div class="add-visitor">
                            <div class="row">
                                @if(isModuleActive('FrontendMultiLang'))
                                <div class="col-lg-12">
                                    <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                        @foreach ($LanguageList as $key => $language)
                                            <li class="nav-item lang_code" data-id="{{$language->code}}">
                                                <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#selement{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content">
                                        @foreach ($LanguageList as $key => $language)
                                            <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="selement{{$language->code}}">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="mb-2 mr-30">{{ __('frontendCms.title') }}</label>
                                                            <div class="primary_file_uploader">
                                                                <input name="title[{{$language->code}}]" class="primary_input_field" value="{{isset($getAllLoginPageInfo[2])?$getAllLoginPageInfo[2]->getTranslation('title',$language->code):old('title.'.$language->code)}}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="mb-2 mr-30">{{ __('frontendCms.sub_title') }}</label>
                                                            <div class="primary_file_uploader">
                                                                <input name="sub_title[{{$language->code}}]" class="primary_input_field" value="{{isset($getAllLoginPageInfo[2])?$getAllLoginPageInfo[2]->getTranslation('sub_title',$language->code):old('sub_title.'.$language->code)}}" type="text">
                                                            </div>
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
                                        <label class="mb-2 mr-30">{{ __('frontendCms.title') }}</label>
                                        <div class="primary_file_uploader">
                                            <input name="title" class="primary_input_field" value="{{ isset($getAllLoginPageInfo[2]->title)? $getAllLoginPageInfo[2]->title:'' }}" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="mb-2 mr-30">{{ __('frontendCms.sub_title') }}</label>
                                        <div class="primary_file_uploader">
                                            <input name="sub_title" class="primary_input_field" value="{{ isset($getAllLoginPageInfo[2]->sub_title)? $getAllLoginPageInfo[2]->sub_title:'' }}" type="text">
                                        </div>
                                    </div>
                                </div>
                            @endif
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="mb-2 mr-30">{{ __('common.image') }}<small>({{getNumberTranslate(730)}}x{{getNumberTranslate(503)}}) {{__('common.px')}}</small></label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="placeholderFileOneName3" placeholder="{{ __('common.browse') }}" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="document_file_3">{{__("common.image")}} </label>
                                                <input type="file" class="d-none" name="cover_image" id="document_file_3" accept="image/*">
                                            </button>
                                        </div>
                                        <span class="text-danger"  id="file_error"></span>

                                        <div class="img_div mt-20">
                                            <img class="blogImgShow" id="blogImgShow3" src="{{showImage( isset($getAllLoginPageInfo[2]->cover_img) ? $getAllLoginPageInfo[2]->cover_img:'backend/img/default.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center">
                                @if(permissionCheck('frontendcms.login_page'))
                                    <button class="primary-btn semi_large2  fix-gr-bg mr-1"
                                            type="submit"><i class="ti-check"></i>{{ __('common.update') }}
                                    </button>
                                @else
                                    <span class="alert alert-warning" role="alert">
                                        <strong>
                                            {{ __('common.you_don_t_have_this_permission') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade {{ $loginPageTab == 4?'active show':'' }} " id="password_reset">
                <div class="col-lg-12">
                    <form method="POST" action="{{ route('frontendcms.login_page.update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="login_slug" value="password-reset">

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
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="mb-2 mr-30">{{ __('frontendCms.title') }}</label>
                                                            <div class="primary_file_uploader">
                                                                <input name="title[{{$language->code}}]" class="primary_input_field" value="{{isset($getAllLoginPageInfo[3])?$getAllLoginPageInfo[3]->getTranslation('title',$language->code):old('title.'.$language->code)}}" type="text">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="primary_input mb-25">
                                                            <label class="mb-2 mr-30">{{ __('frontendCms.sub_title') }}</label>
                                                            <div class="primary_file_uploader">
                                                                <input name="sub_title[{{$language->code}}]" class="primary_input_field" value="{{isset($getAllLoginPageInfo[3])?$getAllLoginPageInfo[3]->getTranslation('sub_title',$language->code):old('sub_title.'.$language->code)}}" type="text">
                                                            </div>
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
                                        <label class="mb-2 mr-30">{{ __('frontendCms.title') }}</label>
                                        <div class="primary_file_uploader">
                                            <input name="title" class="primary_input_field" value="{{ isset($getAllLoginPageInfo[3]->title)? $getAllLoginPageInfo[3]->title:'' }}" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="mb-2 mr-30">{{ __('frontendCms.sub_title') }}</label>
                                        <div class="primary_file_uploader">
                                            <input name="sub_title" class="primary_input_field" value="{{ isset($getAllLoginPageInfo[3]->sub_title)? $getAllLoginPageInfo[3]->sub_title:'' }}" type="text">
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-xl-6">
                                    <div class="primary_input mb-25">
                                        <label class="mb-2 mr-30">{{ __('common.image') }}<small>({{getNumberTranslate(730)}}x{{getNumberTranslate(503)}}) {{__('common.px')}}</small></label>
                                        <div class="primary_file_uploader">
                                            <input class="primary-input" type="text" id="placeholderFileOneName4" placeholder="{{ __('common.browse') }}" readonly="">
                                            <button class="" type="button">
                                                <label class="primary-btn small fix-gr-bg" for="document_file_4">{{__("common.image")}} </label>
                                                <input type="file" class="d-none" name="cover_image" id="document_file_4" accept="image/*">
                                            </button>
                                        </div>
                                        <span class="text-danger"  id="file_error"></span>

                                        <div class="img_div mt-20">
                                            <img class="blogImgShow" id="blogImgShow4" src="{{showImage( isset($getAllLoginPageInfo[3]->cover_img) ? $getAllLoginPageInfo[3]->cover_img:'backend/img/default.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center">
                                @if(permissionCheck('frontendcms.login_page'))
                                    <button class="primary-btn semi_large2  fix-gr-bg mr-1"
                                            type="submit"><i class="ti-check"></i>{{ __('common.update') }}
                                    </button>
                                @else
                                    <span class="alert alert-warning" role="alert">
                                        <strong>
                                            {{ __('common.you_don_t_have_this_permission') }}
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

