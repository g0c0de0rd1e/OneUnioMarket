<style>
    input[type="number"] {
    -moz-appearance: auto;
}
</style>
<form id="formData" method="POST" enctype="multipart/form-data">
@if(isModuleActive('FrontendMultiLang'))
@php
    $LanguageList = getLanguageList();
    @endphp
@endif
    <div class="row">
        <input type="hidden" name="id" value="{{ $subscribeContent->id }}">
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
                                    <label class="primary_input_label" for="">{{ __('common.sub_title') }} </label>
                                    <input name="subtitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($subscribeContent)?$subscribeContent->getTranslation('subtitle',$language->code):old('subtitle.'.$language->code)}}">
                                    <span class="text-danger"  id="subtitle_error_{{$language->code}}"></span>
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
                <label class="primary_input_label" for="">{{ __('common.sub_title') }} </label>
                <input name="subtitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('subtitle') ? old('subtitle') : $subscribeContent->subtitle }}">
                <span class="text-danger"  id="subtitle_error"></span>
            </div>
        </div>

    @endif

        <div class="col-xl-6">
            <div class="primary_input mb-25">
                <label class="primary_input_label" for="">{{ __('frontendCms.popup_show_after_second') }}</label>
                <input name="second" class="primary_input_field" required min="1" placeholder="-" type="number" value="{{ old('second') ? old('second') : $subscribeContent->second }}">
                <span class="text-danger"  id="second_error"></span>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="primary_input">
                <label class="primary_input_label" for="">{{ __('common.status') }} </label>
                <ul id="theme_nav" class="permission_list sms_list ">
                    <li>
                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                            <input name="status" id="status_active" value="1" @if ($subscribeContent->status == 1) checked @endif class="active"
                                type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('common.active') }}</p>
                    </li>
                    <li>
                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                            <input name="status" value="0" id="status_inactive" @if ($subscribeContent->status == 0) checked @endif class="de_active" type="radio">
                            <span class="checkmark"></span>
                        </label>
                        <p>{{ __('common.inactive') }}</p>
                    </li>
                </ul>
                <span class="text-danger" id="status_error"></span>
            </div>
        </div>

        <div class="single_p col-xl-6 upload_photo_div">
            <label class="mb-2 mr-30">{{ __('common.image') }} ({{getNumberTranslate(327)}}x{{getNumberTranslate(446)}}) {{__('common.px')}}</label>
            <div class="primary_input mb-25">
                <div class="primary_file_uploader" data-toggle="amazuploader" data-multiple="false" data-type="image" data-name="popup_image">
                    <input class="primary-input file_amount" type="text" id="image" placeholder="{{__('common.browse_image_file')}}" readonly="">
                    <button class="" type="button">
                        <label class="primary-btn small fix-gr-bg" for="image">{{__("common.image")}} </label>
                        <input type="hidden" class="selected_files" value="{{@$subscribeContent->popup_image_media->media_id}}">
                    </button>
                </div>
                <div class="product_image_all_div">
                    @if(@$subscribeContent->popup_image_media->media_id)
                        <input type="hidden" name="popup_image" class="product_images_hidden" value="{{@$subscribeContent->popup_image_media->media_id}}">
                    @endif
                </div>
            </div>
                    @if ($errors->has('popup_image'))
                        <span class="text-danger"> {{ $errors->first('popup_image') }}</span>
                    @endif
        </div>

        @if (permissionCheck('frontendcms.subscribe-content.update'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent"
                        type="submit" dusk="update"><i
                            class="ti-check"></i>{{ __('common.update') }}</button>
                </div>
            </div>
        @endif

    </div>
</form>
