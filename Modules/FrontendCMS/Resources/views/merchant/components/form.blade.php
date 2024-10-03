<form id="formData" action="{{ route('frontendcms.merchant-content.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <input type="hidden" name="id" id="mainId" value="{{ $content->id }}">
        <div class="col-xl-12 mb-20">
            <div class="row">
                @if(isModuleActive('FrontendMultiLang'))
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                            @foreach ($LanguageList as $key => $language)
                                <li class="nav-item lang_code" data-id="{{$language->code}}">
                                    <a class="nav-link anchore_color marchent_content @if (auth()->user()->lang_code == $language->code) active @endif" data-id="{{$language->code}}" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                                    <div class="row">                                
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="mainTitle">{{ __('frontendCms.main_title') }} <span class="text-danger">*</span></label>
                                                    <input id="mainTitle{{$language->code}}" name="mainTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('mainTitle',$language->code):old('mainTitle.'.$language->code)}}">
                                                    <span class="text-danger" id="error_mainTitle_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="subTitle">{{ __('frontendCms.sub_title') }} <span class="text-danger">*</span></label>
                                                    <input id="subTitle{{$language->code}}" name="subTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('subTitle',$language->code):old('subTitle.'.$language->code)}}">
                                                    <span class="text-danger" id="error_subTitle_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 d-none" id="default_lang_{{$language->code}}">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="slug">{{ __('common.slug') }} <span class="text-danger">*</span></label>
                                                    <input id="mainSlug{{$language->code}}" name="slug[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{ old('slug') ? old('slug') : $content->slug }}">
                                                    <span class="text-danger" id="error_slug_{{$language->code}}"></span>
                                                </div>
                                            </div>
                    
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="pricing">{{ __('frontendCms.pricing_slogan') }} <span class="text-danger">*</span></label>
                                                    <input id="pricing{{$language->code}}" name="pricing[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('pricing',$language->code):old('pricing.'.$language->code)}}">
                                                    <span class="text-danger" id="error_pricing_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="">{{ __('frontendCms.main_details') }} <span class="text-danger">*</span></label>
                                                    <textarea id="Maindescription{{$language->code}}" name="Maindescription[{{$language->code}}]" class="lms_summernote">{{isset($content)?$content->getTranslation('Maindescription',$language->code):old('Maindescription.'.$language->code)}}</textarea>
                                                    <span class="text-danger" id="error_mainDescription_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="mainTitle">{{ __('frontendCms.main_title') }} <span class="text-danger">*</span></label>
                                <input id="mainTitle" name="mainTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('mainTitle') ? old('mainTile') : $content->mainTitle }}">
                                <span class="text-danger" id="error_mainTitle"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="subTitle">{{ __('frontendCms.sub_title') }} <span class="text-danger">*</span></label>
                                <input id="subTitle" name="subTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('subTitle') ? old('subTile') : $content->subTitle }}">
                                <span class="text-danger" id="error_subTitle"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="slug">{{ __('common.slug') }} <span class="text-danger">*</span></label>
                                <input id="mainSlug" name="slug" class="primary_input_field" placeholder="-" type="text" value="{{ old('slug') ? old('slug') : $content->slug }}">
                                <span class="text-danger" id="error_slug"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="pricing">{{ __('frontendCms.pricing_slogan') }} <span class="text-danger">*</span></label>
                                <input id="pricing" name="pricing" class="primary_input_field" placeholder="-" type="text" value="{{ old('pricing') ? old('pricing') : $content->pricing }}">
                                <span class="text-danger" id="error_pricing"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{ __('frontendCms.main_details') }} <span class="text-danger">*</span></label>
                                <textarea id="Maindescription" name="Maindescription" class="lms_summernote">{{$content->Maindescription}}</textarea>
                                <span class="text-danger" id="error_mainDescription"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-xl-12 mb-20">
            <div class="row">
                @if(isModuleActive('FrontendMultiLang'))
                    <div class="col-lg-12">
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel" class="tab-pane fade default_lang @if (auth()->user()->lang_code == $language->code) show active @endif" id="benefitelement{{$language->code}}">
                                    <div class="row">                                
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="benifitTitle">{{ __('frontendCms.benifit_title') }} <span class="text-danger">*</span></label>
                                                    <input id="benifitTitle{{$language->code}}" name="benifitTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('benifitTitle',$language->code):old('benifitTitle.'.$language->code)}}">
                                                    <span class="text-danger" id="error_benifitTitle_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label class="primary_input_label" for="benefit">{{ __('frontendCms.benefit_list') }}</label>
                                                <div id="benefit_table">
                                                    @include('frontendcms::merchant.benefit.list')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="">{{ __('frontendCms.benefits_details') }} <span class="text-danger">*</span></label>
                                                    <textarea id="benifitDescription{{$language->code}}" name="benifitDescription[{{$language->code}}]" class="lms_summernote">{{isset($content)?$content->getTranslation('benifitDescription',$language->code):old('benifitDescription.'.$language->code)}}</textarea>
                                                    <span class="text-danger" id="error_benifitDescription_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="benifitTitle">{{ __('frontendCms.benifit_title') }} <span class="text-danger">*</span></label>
                                <input id="benifitTitle" name="benifitTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('benifitTitle') ? old('benifitTile') : $content->benifitTitle }}">
                                <span class="text-danger" id="error_benifitTitle"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <label class="primary_input_label" for="benefit">{{ __('frontendCms.benefit_list') }}</label>
                            <div id="benefit_table">
                                @include('frontendcms::merchant.benefit.list')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="">{{ __('frontendCms.benefits_details') }} <span class="text-danger">*</span></label>
                                <textarea id="benifitDescription" name="benifitDescription" class="lms_summernote">{{$content->benifitDescription}}</textarea>
                                <span class="text-danger" id="error_benifitDescription"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-xl-12 mb-20">
            <div class="row">
                @if(isModuleActive('FrontendMultiLang'))
                    <div class="col-lg-12">
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel" class="tab-pane fade default_lang @if (auth()->user()->lang_code == $language->code) show active @endif" id="howitworkelement{{$language->code}}">
                                    <div class="row">                                
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="howitworkTitle">{{ __('frontendCms.how_it_work_title') }} <span class="text-danger">*</span></label>
                                                    <input id="howitworkTitle{{$language->code}}" name="howitworkTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('howitworkTitle',$language->code):old('howitworkTitle.'.$language->code)}}">
                                                    <span class="text-danger" id="error_howitworkTitle_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label class="primary_input_label" for="howitworkTitle">{{ __('frontendCms.how_it_work_list') }}</label>
                                                <div id="work_table">
                                                    @include('frontendcms::merchant.working_process.list')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="howitworkDescription">{{ __('frontendCms.how_it_work_details') }} <span class="text-danger">*</span></label>
                                                    <textarea id="howitworkDescription{{$language->code}}" name="howitworkDescription[{{$language->code}}]" class="lms_summernote">{{isset($content)?$content->getTranslation('howitworkDescription',$language->code):old('howitworkDescription.'.$language->code)}}</textarea>
                                                    <span class="text-danger" id="error_howitworkDescription_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="howitworkTitle">{{ __('frontendCms.how_it_work_title') }} <span class="text-danger">*</span></label>
                                <input id="howitworkTitle" name="howitworkTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('howitworkTitle') ? old('howitworkTitle') : $content->howitworkTitle }}">
                                <span class="text-danger" id="error_howitworkTitle"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <label class="primary_input_label" for="howitworkTitle">{{ __('frontendCms.how_it_work_list') }}</label>
                            <div id="work_table">
                                @include('frontendcms::merchant.working_process.list')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="howitworkDescription">{{ __('frontendCms.how_it_work_details') }} <span class="text-danger">*</span></label>
                                <textarea id="howitworkDescription" name="howitworkDescription" class="lms_summernote">{{$content->howitworkDescription}}</textarea>
                                <span class="text-danger" id="error_howitworkDescription"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-xl-12 mb-20">
            <div class="row">
                @if(isModuleActive('FrontendMultiLang'))
                    <div class="col-lg-12">
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel" class="tab-pane fade default_lang @if (auth()->user()->lang_code == $language->code) show active @endif" id="pricingelement{{$language->code}}">
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="pricingTitle">{{ __('frontendCms.pricing_title') }} <span class="text-danger">*</span></label>
                                                    <input id="pricingTitle{{$language->code}}" name="pricingTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('pricingTitle',$language->code):old('pricingTitle.'.$language->code)}}">
                                                    <span class="text-danger" id="error_pricingTitle_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="pricingDescription">{{ __('frontendCms.pricing_details') }} <span class="text-danger">*</span></label>
                                                    <textarea id="pricingDescription{{$language->code}}" name="pricingDescription[{{$language->code}}]" class="lms_summernote">{{isset($content)?$content->getTranslation('pricingDescription',$language->code):old('pricingDescription.'.$language->code)}}</textarea>
                                                    <span class="text-danger" id="error_pricingDescription_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="col-xl-12">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="">{{ __('frontendCms.subscription_crone_job_url') }}</label>
                                        <input id="subscription_crone_job" name="subscription_crone_job" class="primary_input_field" readonly type="text" value="{{ route('subscription_crone_job') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="pricingTitle">{{ __('frontendCms.pricing_title') }} <span class="text-danger">*</span></label>
                                <input id="pricingTitle" name="pricingTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('pricingTitle') ? old('pricingTitle') : $content->pricingTitle }}">
                                <span class="text-danger" id="error_pricingTitle"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">{{ __('frontendCms.subscription_crone_job_url') }}</label>
                                <input id="subscription_crone_job" name="subscription_crone_job" class="primary_input_field" readonly type="text" value="{{ route('subscription_crone_job') }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="pricingDescription">{{ __('frontendCms.pricing_details') }} <span class="text-danger">*</span></label>
                                <textarea id="pricingDescription" name="pricingDescription" class="lms_summernote">{{$content->pricingDescription}}</textarea>
                                <span class="text-danger" id="error_pricingDescription"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-xl-12 mb-20">
            <div class="row">
                @if(isModuleActive('FrontendMultiLang'))
                    <div class="col-lg-12">
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel" class="tab-pane fade default_lang @if (auth()->user()->lang_code == $language->code) show active @endif" id="sellerRegistrationelement{{$language->code}}">
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="pricingTitle">{{ __('frontendCms.seller_registration_title_for_first_page') }}<span class="text-danger">*</span></label>
                                                    <input id="sellerRegistrationTitle{{$language->code}}" name="sellerRegistrationTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('sellerRegistrationTitle',$language->code):old('sellerRegistrationTitle.'.$language->code)}}">
                                                    <span class="text-danger" id="error_sellerRegistrationTitle_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="pricingDescription">{{ __('frontendCms.description') }}<span class="text-danger">*</span></label>
                                                    <textarea id="sellerRegistrationDescription{{$language->code}}" name="sellerRegistrationDescription[{{$language->code}}]" class="lms_summernote">{{isset($content)?$content->getTranslation('sellerRegistrationDescription',$language->code):old('sellerRegistrationDescription.'.$language->code)}}</textarea>
                                                    <span class="text-danger" id="error_sellerRegistrationDescription_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="pricingTitle">{{ __('frontendCms.seller_registration_title_for_first_page') }}<span class="text-danger">*</span></label>
                                <input id="sellerRegistrationTitle" name="sellerRegistrationTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('sellerRegistrationTitle') ? old('sellerRegistrationTitle') : $content->sellerRegistrationTitle }}">
                                <span class="text-danger" id="error_sellerRegistrationTitle"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="pricingDescription">{{ __('frontendCms.description') }}<span class="text-danger">*</span></label>
                                <textarea id="sellerRegistrationDescription" name="sellerRegistrationDescription" class="lms_summernote">{{$content->sellerRegistrationDescription}}</textarea>
                                <span class="text-danger" id="error_sellerRegistrationDescription"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-xl-12 mb-20">
            <div class="row">
                @if(isModuleActive('FrontendMultiLang'))
                    <div class="col-lg-12">
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel" class="tab-pane fade default_lang @if (auth()->user()->lang_code == $language->code) show active @endif" id="faqelement{{$language->code}}">
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="queryTitle">{{ __('frontendCms.faq_title') }} <span class="text-danger">*</span></label>
                                                    <input id="faqTitle{{$language->code}}" name="faqTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('faqTitle',$language->code):old('faqTitle.'.$language->code)}}">
                                                    <span class="text-danger" id="error_faqTitle_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <label class="primary_input_label" for="howitworkTitle">{{ __('frontendCms.faq_list') }}</label>
                                                <div id="faq_table">
                                                    @include('frontendcms::merchant.faq.list')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="queryDescription">{{ __('frontendCms.faq_details') }} <span class="text-danger">*</span></label>
                                                    <textarea id="faqDescription{{$language->code}}" name="faqDescription[{{$language->code}}]" class="lms_summernote">{{isset($content)?$content->getTranslation('faqDescription',$language->code):old('faqDescription.'.$language->code)}}</textarea>
                                                    <span class="text-danger" id="error_faqDescription_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="faqTitle">{{ __('frontendCms.faq_title') }} <span class="text-danger">*</span></label>
                                <input id="faqTitle" name="faqTitle" class="primary_input_field" placeholder="-" type="text" value="{{ $content->faqTitle }}">
                                <span class="text-danger" id="error_faqTitle"></span>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <label class="primary_input_label" for="howitworkTitle">{{ __('frontendCms.faq_list') }}</label>
                            <div id="faq_table">
                                @include('frontendcms::merchant.faq.list')
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="faqDescription">{{ __('frontendCms.faq_details') }} <span class="text-danger">*</span></label>
                                <textarea id="faqDescription" name="faqDescription" class="lms_summernote">{{$content->faqDescription}}</textarea>
                                <span class="text-danger" id="error_faqDescription"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-xl-12">
            <div class="row">
                @if(isModuleActive('FrontendMultiLang'))
                    <div class="col-lg-12">
                        <div class="tab-content">
                            @foreach ($LanguageList as $key => $language)
                                <div role="tabpanel" class="tab-pane fade default_lang @if (auth()->user()->lang_code == $language->code) show active @endif" id="queryelement{{$language->code}}">
                                    <div class="row">
                                        <div class="col-xl-7">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="queryTitle">{{ __('frontendCms.query_title') }} <span class="text-danger">*</span></label>
                                                    <input id="queryTitle{{$language->code}}" name="queryTitle[{{$language->code}}]" class="primary_input_field" placeholder="-" type="text" value="{{isset($content)?$content->getTranslation('queryTitle',$language->code):old('queryTitle.'.$language->code)}}">
                                                    <span class="text-danger" id="error_queryTitle_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="col-xl-12">
                                                <div class="primary_input mb-35">
                                                    <label class="primary_input_label" for="queryDescription">{{ __('frontendCms.query_details') }} <span class="text-danger">*</span></label>
                                                    <textarea id="queryDescription{{$language->code}}" name="queryDescription[{{$language->code}}]" class="lms_summernote">{{isset($content)?$content->getTranslation('queryDescription',$language->code):old('queryDescription.'.$language->code)}}</textarea>
                                                    <span class="text-danger" id="error_queryDescription_{{$language->code}}"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="col-xl-7">
                        <div class="col-xl-12">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="queryTitle">{{ __('frontendCms.query_title') }} <span class="text-danger">*</span></label>
                                <input id="queryTitle" name="queryTitle" class="primary_input_field" placeholder="-" type="text" value="{{ old('queryTitle') ? old('queryTitle') : $content->queryTitle }}">
                                <span class="text-danger" id="error_queryTitle"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-xl-12">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="queryDescription">{{ __('frontendCms.query_details') }} <span class="text-danger">*</span></label>
                                <textarea id="queryDescription" name="queryDescription" class="lms_summernote">{{$content->queryDescription}}</textarea>
                                <span class="text-danger" id="error_queryDescription"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if (permissionCheck('frontendcms.merchant-content.update'))
            <div class="col-lg-12 text-center">
                <div class="d-flex justify-content-center">
                    <button id="mainSubmit" class="primary-btn semi_large2  fix-gr-bg mr-1" id="save_button_parent" type="submit" dusk="Update"><i class="ti-check"></i>{{ __('common.update') }}</button>
                </div>
            </div>
        @endif
    </div>
</form>
