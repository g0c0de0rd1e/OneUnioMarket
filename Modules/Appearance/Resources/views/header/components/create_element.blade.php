<div class="white_box_50px box_shadow_white mb-40 min-height-430">
    <form action="POST" id="add_element_form">
        <div class="row">
            <input type="hidden" name="id" value="{{$header->id}}">
            <input type="hidden" id="create_header_type" value="{{$header->type}}">
            @if($type == 'category')
            <div class="col-lg-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('common.category_list') }}</label>
                    <select name="category[]" id="category" class="category mb-15" multiple>

                    </select>
                    <span class="text-danger"></span>
                </div>
            </div>
            @elseif($type == 'slider')
            @if(isModuleActive('FrontendMultiLang'))
                <div class="col-lg-12">
                    <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                        @foreach ($LanguageList as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($LanguageList as $key => $language)
                            <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                                <div class="col-lg-12">
                                    <div class="primary_input mb-25">
                                        <label class="primary_input_label" for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                                        <input class="primary_input_field" type="text" id="name{{$language->code}}" name="name[{{$language->code}}]" autocomplete="off" value="{{old('name.'.$language->code)}}" placeholder="{{__('common.name')}}">
                                    </div>
                                    <span class="text-danger" id="error_name_{{$language->code}}"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else   
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="name">{{__('common.name')}} <span class="text-danger">*</span></label>
                        <input class="primary_input_field" type="text" id="name" name="name" autocomplete="off" value="" placeholder="{{__('common.name')}}">
                    </div>
                    <span class="text-danger" id="error_name"></span>
                </div>
            @endif
            <div class="col-lg-12" id="slider_data_type_div">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('appearance.slider_for') }}</label>
                    <select name="data_type" id="slider_for" class="primary_select mb-15">
                        <option value="" selected disabled>{{ __('common.select_one') }}</option>
                        <option value="product">{{ __('appearance.for_product') }}</option>
                        <option value="category">{{ __('appearance.for_category') }}</option>
                        <option value="brand">{{ __('appearance.for_brand') }}</option>
                        <option value="tag">{{ __('appearance.for_tag') }}</option>
                        <option value="url">{{ __('appearance.for_url_not_support_in_mobile_app') }}</option>
                    </select>
                    <span class="text-danger" id="error_slider_data_type"></span>
                </div>
            </div>
            <div class="col-lg-12" id="slider_for_data_div">
            </div>
            <div class="col-xl-12 upload_photo_div">
                <div class="primary_input">
                    <label class="primary_input_label">{{__('common.upload_photo')}} (@if(app('theme')->folder_path == 'default') {{getNumberTranslate(660)}} X {{getNumberTranslate(365)}} @else {{getNumberTranslate(1920)}} X {{getNumberTranslate(600)}} @endif) {{__('common.px')}} <span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="single_p col-xl-12 upload_photo_div">
                <div id="sliderImgFileDiv">
                    <div class="primary_input mb-25">
                        <div class="primary_file_uploader" data-toggle="amazuploader" data-multiple="false" data-type="image" data-name="slider_image_media">
                            <input class="primary-input file_amount" type="text" id="image" placeholder="{{__('common.browse_image_file')}}" readonly="">
                            <button class="" type="button">
                                <label class="primary-btn small fix-gr-bg" for="image">{{__("common.image")}} </label>
                                <input type="hidden" class="selected_files" value="">
                            </button>
                        </div>
                        <div class="product_image_all_div">
                        </div>
                    </div>
                    <span class="text-danger" id="error_image"> </span>
                </div>
                </div>
            <div class="col-lg-12">
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
                    <span class="text-danger" id="status_error"></span>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="primary_input">
                    <ul id="theme_nav" class="permission_list sms_list ">
                        <li>
                            <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                <input name="is_newtab" id="is_newtab" value="1" checked type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                            <p>{{ __('common.open_link_in_a_new_tab') }}</p>
                        </li>
                    </ul>
                </div>
            </div>
            @elseif($type == 'product')
            <div class="col-lg-12">
                <div class="primary_input mb-25">
                    <label class="primary_input_label" for="">{{ __('appearance.product_list') }}</label>
                    <select name="product[]" id="product" class=" product mb-15" multiple>
                    </select>
                    <span class="text-danger"></span>
                </div>
            </div>
            @endif
            <div class="col-xl-12 text-center">
                <button class="primary_btn_2 mt-5" id="widget_form_btn"><i
                        class="ti-check"></i>{{ __('common.save') }}
                </button>
            </div>
        </div>
    </form>
</div>
