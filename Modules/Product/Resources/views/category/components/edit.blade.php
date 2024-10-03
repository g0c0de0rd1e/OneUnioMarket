<div class="main-title">
    <h3 class="mb-30">
        {{ __('product.edit_category') }}
    </h3>
</div>
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<form method="POST" action="" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data"
id="category_edit_form">
<input type="hidden" id="item_id" name="id" value="{{$category->id}}" />
    <div class="white-box">
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
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="name">
                                        {{__('common.name')}}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input class="primary_input_field name" type="text" id="name{{auth()->user()->lang_code == $language->code?$language->code:''}}" name="name[{{$language->code}}]" autocomplete="off"  placeholder="{{__('common.name')}}" value="{{isset($category)?$category->getTranslation('name',$language->code):old('name.'.$language->code)}}">
                                    <span class="text-danger" id="error_name_{{$language->code}}"></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="name">
                            {{__('common.name')}}
                            <span class="text-danger">*</span>
                        </label>
                        <input class="primary_input_field name" type="text" id="name" name="name" autocomplete="off" value="{{$category->name}}" placeholder="{{__('common.name')}}">
                    </div>
                    <span class="text-danger" id="error_name"></span>
                </div>
            @endif
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="slug">
                           {{__('common.slug')}}
                            <span class="text-danger">*</span>
                        </label>
                        <input class="primary_input_field slug" type="text" id="slug" name="slug" autocomplete="off" value="{{$category->slug}}" placeholder="{{__('common.slug')}}">
                    </div>
                    <span class="text-danger"  id="error_slug"></span>
                </div>

                @if(isModuleActive('GoogleMerchantCenter'))
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="name">
                            {{__('product.google_product_category_id')}}
                        </label>
                        <input class="primary_input_field google_product_category_id" type="number" min="0" step="{{step_decimal()}}" value="{{$category->google_product_category_id}}" id="google_product_category_id" name="google_product_category_id" autocomplete="off"  placeholder="{{__('product.google_product_category_id')}}">
                        <span class="text-danger" id="error_google_product_category_id"></span>
                    </div>
                </div>
                @endif
                @if(isModuleActive('MultiVendor'))
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="commission_rate">{{__('common.commission_rate')}}</label>
                        <input class="primary_input_field commission_rate" type="number" min="0" step="{{step_decimal()}}" id="commission_rate" name="commission_rate" value="{{$category->commission_rate}}" autocomplete="off"  placeholder="{{__('common.commission_rate')}}">
                    </div>
                    <span class="text-danger" id="error_commission_rate"></span>
                </div>
                @endif
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="icon">
                           {{__('common.icon')}}
                        </label>
                        <input class="primary_input_field" type="text" id="icon" name="icon" value="{{$category->icon}}"
                        autocomplete="off" placeholder="{{__('common.icon')}}">
                    </div>
                    <span class="text-danger"  id="error_icon"></span>
                </div>
                <div class="col-xl-12 mt-20">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('product.searchable') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="searchable" id="searchable_active" value="1" {{$category->searchable == 1?'checked':''}}
                                        class="active" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.active') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="searchable" id="searchable_inactive" value="0" {{$category->searchable == 0?'checked':''}} class="de_active" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.inactive') }}</p>
                            </li>
                        </ul>
                        <span class="text-danger" id="error_searchable"></span>
                    </div>
                </div>
                 <div class="col-xl-12">
                    <div class="primary_input">
                        <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="status" id="status_active" value="1" {{$category->status==1?'checked':''}} class="active"
                                        type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.active') }}</p>
                            </li>
                            <li>
                                <label data-id="color_option" class="primary_checkbox d-flex mr-12 extra_width">
                                    <input name="status" value="0" id="status_inactive" {{$category->status==0?'checked':''}} class="de_active" type="radio">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('common.inactive') }}</p>
                            </li>
                        </ul>
                        <span class="text-danger" id="error_status"></span>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="primary_input">
                        <ul id="theme_nav" class="permission_list sms_list ">
                            <li>
                                <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                    <input class="in_sub_cat" name="category_type" id="sub_cat" value="subCategory" {{$category->parent_id !=0?'checked':'' }} type="checkbox">
                                    <span class="checkmark"></span>
                                </label>
                                <p>{{ __('product.add_as_sub_category') }}</p>
                            </li>
                        </ul>
                        <span class="text-danger" id=""></span>
                    </div>
                </div>
                <div class="col-xl-12 {{$category->parent_id == 0?'d-none':''}} in_parent_div" id="sub_cat_div">
                    <div class="primary_input mb-25">
                        <label class="primary_input_label" for="">{{ __('product.parent_category') }} <span class="text-danger">*</span></label>
                        <select class="mb-25" name="parent_id" id="parent_id">
                            @if($category->parent_id != 0)
                                <option value="{{$category->parent_id}}" selected>{{@$category->parentCategory->name}}</option>
                            @endif
                        </select>
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="col-xl-12 upload_photo_div">
                    <div class="primary_input">
                        <label class="primary_input_label">{{__('common.upload_photo')}} ({{getNumberTranslate(225)}} X {{getNumberTranslate(225)}}){{__('common.px')}}</label>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="primary_input mb-25">
                        <div class="primary_file_uploader" data-toggle="amazuploader" data-multiple="false" data-type="image" data-name="category_image">
                            <input class="primary-input file_amount" type="text" id="image" placeholder="{{__('common.browse_image_file')}}" readonly="">
                            <button class="" type="button">
                                <label class="primary-btn small fix-gr-bg" for="image">{{__("common.image")}} </label>
                                <input type="hidden" class="selected_files" value="{{@$category->categoryImage->category_image_media->media_id}}">
                            </button>
                        </div>
                        <div class="product_image_all_div">
                            @if(@$category->categoryImage->category_image_media->media_id)
                                <input type="hidden" name="category_image" class="product_images_hidden" value="{{@$category->categoryImage->category_image_media->media_id}}">
                            @endif
                        </div>
                    </div>
                    @if ($errors->has('category_image'))
                        <span class="text-danger"> {{ $errors->first('category_image') }}</span>
                    @endif
                </div>
            </div>
            <div class="row mt-40">
                <div class="col-lg-12 text-center">
                    <button id="create_btn" type="submit" class="primary-btn fix-gr-bg submit_btn" data-toggle="tooltip" title=""
                        data-original-title="">
                        <span class="ti-check"></span>
                        {{__('common.update')}} </button>
                </div>
            </div>
        </div>
    </div>
</form>
