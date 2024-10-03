@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<div class="modal fade admin-query" id="edit_page_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('common.edit')}}</h4>
                <button type="button" class="close " data-dismiss="modal"><i class="ti-close "></i> </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="itemEditForm">
                    <div class="white_box_50px box_shadow_white mb-20">
                        <div class="row">
                            <input type="text" name="id" class="edit_id d-none" value="0">
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
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="name_{{$language->code}}">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                                        <input name="name[{{$language->code}}]" id="name_{{$language->code}}"  class="primary_input_field name" placeholder="{{ __('common.name') }}" type="text">
                                                        <span class="text-danger" id="name_error_{{$language->code}}"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label" for="description_{{$language->code}}">{{ __('common.description') }}</label>
                                                        <textarea class="primary_textarea height_112 description" id="description_{{$language->code}}" placeholder="{{ __('common.description') }}" name="description[{{$language->code}}]" spellcheck="false"></textarea>
                                                        <span class="text-danger" id="description_error_{{$language->code}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="name">{{ __('common.name') }} <span class="text-danger">*</span></label>
                                    <input name="name" class="primary_input_field name" id="name" placeholder="{{ __('common.name') }}" type="text">
                                    <span class="text-danger" id="name_error"></span>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="description">{{ __('common.description') }}</label>
                                    <textarea class="primary_textarea height_112 description" id="description" placeholder="{{ __('common.description') }}" name="description" spellcheck="false"></textarea>
                                    <span class="text-danger" id="description_error"></span>
                                </div>
                            </div>
                            @endif
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.rate') }} <span class="text-danger">*</span></label>
                                    <input name="rate" class="primary_input_field rate" placeholder="{{ __('common.rate') }}" type="number" min="0" step="{{step_decimal()}}">
                                    <span class="text-danger" id="rate_error"></span>
                                </div>
                            </div>
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
                                    <span class="text-danger" id="status_error"></span>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary-btn semi_large2  fix-gr-bg"
                                            id="save_button_parent"><i
                                            class="ti-check"></i>{{ __('common.update') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

