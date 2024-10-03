@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<div class="modal fade admin-query" id="edit_carrier_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('shipping.update_carrier')}}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form" enctype="multipart/form-data">
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$row->id}}" id="rowId">
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
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-15">
                                                    <label class="primary_input_label" for="name_{{$language->code}}"> {{__('common.name')}} <span class="required_mark_theme">*</span></label>
                                                    <input class="primary_input_field" id="name_{{$language->code}}" name="name[{{$language->code}}]" placeholder="{{__('common.name')}}" type="text" value="{{isset($row)?$row->getTranslation('name',$language->code):old('name.'.$language->code)}}">
                                                    <span class="text-danger" id="error_name_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="name"> {{__('common.name')}} <span class="required_mark_theme">*</span></label>
                                    <input class="primary_input_field" id="name" name="name" placeholder="{{__('common.name')}}" type="text" value="{{$row->name}}">
                                    <span class="text-danger" id="error_name"></span>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="tracking_url"> {{__('shipping.tracking_url')}} <a href="#" class="required_mark_theme" data-toggle="tooltip" title="'@' will be replaced by the dynamic tracking number"><i class="fas fa-question-circle"></i></a></label>
                                <input class="primary_input_field" id="tracking_url" name="tracking_url" placeholder="{{__('shipping.tracking_url')}}" type="text" value="{{$row->tracking_url}}">
                                <span class="required_mark_theme">e.g.: http://example.com/track.php?num=@</span>
                                <span class="text-danger" id="error_tracking_url"></span>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="">{{ __('common.logo') }}</label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input" type="text" id="logo_name"
                                           placeholder="{{__('common.browse_image')}}" readonly="">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg"
                                               for="logo">{{ __('common.browse') }} </label>
                                        <input type="file" class="d-none" name="logo" id="logo">
                                    </button>
                                </div>
                            </div>
                            <span class="text-danger" id="error_logo"></span>
                        </div>
                        <div class="col-lg-4 mt-25">
                            <div class="flag_img_div">
                                <img id="logo_preview" src="{{ $row->logo ? showImage($row->logo):showImage('flags/no_image.png') }}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center">
                                <button class="primary-btn semi_large2  fix-gr-bg mr-10"  type="submit"><i class="ti-check"></i>{{__('common.update') }}</button>
                                <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent" data-dismiss="modal" type="button"><i class="ti-check"></i>{{__('common.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
