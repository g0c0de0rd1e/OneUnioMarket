<div class="modal fade admin-query" id="add_page_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('page-builder.Create Page')}}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="create_form">
                    <div class="row">
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
                                                <div class="col-lg-12">
                                                    <div class="primary_input mb-15">
                                                        <label class="primary_input_label" for="title"> {{__('page-builder.Title')}} <span class="text-danger">*</span></label>
                                                        <input class="primary_input_field page_title" id="title{{$language->code}}" name="title[{{$language->code}}]" placeholder="{{__('page-builder.Title')}}" type="text" value="{{old('title.'.$language->code)}}">
                                                        <span class="text-danger" id="error_title_{{$language->code}}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="col-lg-12">
                                <div class="primary_input mb-15">
                                    <label class="primary_input_label" for="title"> {{__('page-builder.Title')}} <span class="text-danger">*</span></label>
                                    <input class="primary_input_field page_title" id="title" name="title" placeholder="{{__('page-builder.Title')}}" type="text" value="{{old('title')}}">
                                    <span class="text-danger" id="error_title"></span>
                                </div>
                            </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="slug"> {{__('page-builder.Slug')}} <span class="text-danger">*</span></label>
                                <input class="primary_input_field page_slug" id="slug" name="slug" placeholder="{{__('page-builder.Slug')}}" type="text" value="{{old('slug')}}">
                                <span class="text-danger" id="error_slug"></span>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center">
                                <button class="primary-btn semi_large2  fix-gr-bg mr-10"  type="submit"><i class="ti-check"></i>{{__('common.submit') }}</button>
                                <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent" data-dismiss="modal" type="button"><i class="ti-check"></i>{{__('common.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

