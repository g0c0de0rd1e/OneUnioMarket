@extends('backEnd.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset(asset_path('modules/giftcard/css/style.css')) }}" />
    <style>
        .thumb_img_div_two,
        .thumb_img_div_one {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .thumb_img_div_two img,
        .thumb_img_div_one img {
            position: absolute;
            top: 0;
            width: 100%;
            height: 100%;
            min-height: 100%;
            object-fit: contain;
        }

        .vertical-align-middle {
            vertical-align: middle !important;
        }
    </style>
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="">
                <div class="col-lg-12">
                    <div class="main-title">
                        <h3 class="mb-30">
                            {{ __('product.edit_gift_card') }} </h3>
                    </div>
                </div>
            </div>
            <div id="formHtml" class="col-lg-12">
                <div class="white-box">
                   <form action="{{route('admin.giftcard.digital_gift_update',$giftCards->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="add-visitor">
                            <div class="row">
                                <div class="col-lg-6">                            
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="gift_name">{{ __('common.name') }}<span class="text-danger">*</span></label>
                                                <input class="primary_input_field" type="text" id="gift_name" name="gift_name" autocomplete="off" value="{{old('gift_name')?? $giftCards->name}}" placeholder="{{ __('common.name') }}">
                                                @error('gift_name')
                                                    <span class="text-danger" id="error_gift_name">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="sku">{{ __('product.sku') }}<span class="text-danger">*</span></label>
                                                <input class="primary_input_field" id="skuGift" type="text" name="gift_sku" autocomplete="off" value="{{ $giftCards->sku }}" placeholder="{{ __('product.sku') }}">
                                                @error('gift_sku')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="single_field ">
                                                <label for="">@lang('blog.tags') (@lang('product.comma_separated'))<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="tagInput_field mb_26">
                                                @php
                                                    $tags = [];
                                                    foreach ($giftCards->tags as $tag) {
                                                        $tags[] = $tag->name;
                                                    }
                                                    $tags = implode(',', $tags);
                                                @endphp
                                               <input name="gift_tags" class="tag-input sr-only" type="text" data-role="tagsinput" value="{{ $tags }}">
                                            </div>
                                            @error('gift_tags.*')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="descriptionOne">{{ __('common.description') }}</label>
                                                <textarea name="descriptionOne" class="summernote" id="descriptionOne" class="">{{ $giftCards->description }}</textarea>
                                            </div>
                                            @error('descriptionOne')
                                                <span class="text-danger" id="error_message">{{ $message }}
                                                </span>
                                            @enderror
                                        </div>  
                                        {{-- gift box --}}
                                        <div class="col-lg-12">
                                            <div class="QA_table mb_15">
                                                <!-- table-responsive -->
                                                <div class="table create_table">
                                                    <div class="variant_row_lists_amount">
                                                        <div>
                                                            <div class="add_items_button pt-4">
                                                                <button type="button"
                                                                    class="primary-btn radius_30px add_single_variant_row_one fix-gr-bg">
                                                                    <svg width="14" height="14" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M5.58517 9.17466H12.8132M9.19894 5.56026V12.7883M1.2474 15.5584C1.31002 16.3838 1.96543 17.0389 2.79101 17.1013C7.1648 17.4318 11.2338 17.4318 15.6076 17.1013C16.4331 17.0389 17.0886 16.3838 17.1512 15.5584C17.481 11.2095 17.481 7.13956 17.1512 2.79076C17.0886 1.96521 16.4331 1.31022 15.6076 1.24783C11.2338 0.917389 7.1648 0.917389 2.79101 1.24783C1.96543 1.31022 1.31002 1.96519 1.2474 2.79076C0.917534 7.13956 0.917534 11.2095 1.2474 15.5584Z" stroke="currentColor" stroke-width="1.71429" stroke-linecap="round"/>
                                                                    </svg>                                                                        
                                                                    {{ __('product.add_product') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                        {{-- static data --}}
                                                        <div class="gift_box">
                                                            <nav>
                                                                <div class="nav nav-tabs border-0" id="section-nav-tab" role="tablist">
                                                                    @foreach($giftCards->addGiftCard as $key => $data)
                                                                        <button class="nav-link {{$key == 0 ? 'show active' : ''}}" id="nav-home-tab-{{$key+1}}" data-toggle="tab" data-target="#secton-{{$key+1}}" type="button"  role="tab" aria-selected="true">
                                                                            <span class="section_name">{{__('gift_card.section')}} {{($key+1 == 1) ? '' : $key+1 }}</span>
                                                                            <i class="ti-close remove_nav" data-id="{{$key+1}}"></i>
                                                                        </button>
                                                                    @endforeach
                                                                </div>
                                                            </nav>
                                                            <div class="tab-content" id="section-nav-tabContent">
                                                                @foreach($giftCards->addGiftCard as $key=>$data)
                                                                    <div class="tab-pane fade {{$key == 0 ? 'show active' : ''}}" id="secton-{{$key+1}}" role="tabpanel" tabindex="0">
                                                                        <div class="row">
                                                                            <div class="col-lg-6">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label" for="gift_card_value">
                                                                                        {{__('gift_card.gift_card_value')}}: 
                                                                                        <span class="text-danger">*</span>
                                                                                    </label>
                                                                                    <input class="primary_input_field" type="number" id="gift_card_value_[{{$key}}]" name="section[{{$key}}][gift_card_value]" autocomplete="off" value="{{$data->gift_card_value}}" placeholder="00">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-6">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label" for="gift_selling_price_">
                                                                                        {{__('gift_card.selling_price')}}: <span class="text-danger">*</span></label>
                                                                                    <input class="primary_input_field" type="number" id="gift_selling_price_[{{$key}}]" name="section[{{$key}}][gift_selling_price]" autocomplete="off" value="{{$data->gift_selling_price}}" placeholder="00">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-6">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label" for="gift_discount_type">{{__('gift_card.discount_type')}}:
                                                                                    </label>
                                                                                    <select name="section[{{$key}}][gift_discount_type]" id="gift_discount_type_[{{$key}}]" class="primary_select">     
                                                                                            <option {{$data->gift_discount_type == 1 ? 'selected' : ''}} value="1">{{ __('common.amount') }}</option>
                                                                                            <option {{$data->gift_discount_type == 0 ? 'selected' : ''}} value="0">{{ __('common.percentage') }}</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-6">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label" for="gift_discount_amount">
                                                                                        {{__('gift_card.gift_discount_amount')}}: 
                                                                                        <span class="text-danger">*</span></label>
                                                                                    <input class="primary_input_field" type="number" id="gift_discount_amount_[{{$key}}]" name="section[{{$key}}][gift_discount_amount]" autocomplete="off" value="{{$data->gift_discount_amount}}" placeholder="00">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-6">

                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label"
                                                                                        for="gift_expire_date">{{__('gift_card.gift_expire_date')}}: <span
                                                                                            class="text-danger">*</span></label>
                                                                                            <input placeholder="{{ __('common.date') }}" class="primary_input_field primary-input date form-control popUpDateRange"
                                                                                                id="gift_expire_date_{{$key+1}}"
                                                                                                data-id="{{$key+1}}" type="text" name="section[{{$key}}][gift_expire_date]" value="{{\Carbon\Carbon::parse($data->end_date)->format('m-d-Y')}}" autocomplete="off">
                                                                                </div>


                                                                                
                                                                            </div>

                                                                            <div class="col-lg-6">
                                                                                <div class="primary_input mb-25">
                                                                                    <label class="primary_input_label" for="number_of_gift_card">{{__('gift_card.number_of_gift_card')}}: 
                                                                                        <span class="text-danger">*</span></label>
                                                                                    <input class="primary_input_field" type="number" id="number_of_gift_card_[{{$key}}]" name="section[{{$key}}][number_of_gift_card]" autocomplete="off" value="{{$data->number_of_gift_card}}" placeholder="00">
                                                                                </div>
                                                                            </div>  

                                                                            <div class="col-lg-12 mt-5">   
                                                                                <div class="primary_input">
                                                                                    <label class="primary_input_label mb-4" for="name">{{__('gift_card.coupon_code')}}: <span class="text-danger">*</span></label>
                                                                                    <div class="d-flex align-items-center flex-wrap">
                                                                                        <div class="flex-grow-1 d-flex align-items-center cursor_pointer manual_coupon_radio">
                                                                                            <label for="manual_coupon" class="primary_checkbox d-flex mr-12">
                                                                                                <input name="coupon" id="manual_coupon" value="1" class="active prod_type" type="radio" checked="">
                                                                                                <span class="checkmark"></span>
                                                                                            </label>
                                                                                            <label for="manual_coupon" class="text-capitalize mb-0 cursor_pointer">{{__('gift_card.manual_coupon_code_input')}}</label>
                                                                                        </div>
                                                                                        <div class="flex-grow-1 d-flex align-items-center cursor_pointer bluk_coupon_radio">
                                                                                            <label for="bluk_coupon" class="primary_checkbox d-flex mr-12">
                                                                                                <input id="bluk_coupon" value="1" class="active prod_type" name="coupon" type="radio">
                                                                                                <span class="checkmark"></span>
                                                                                            </label>
                                                                                            <label for="bluk_coupon" class="text-capitalize mb-0 cursor_pointer">{{__('gift_card.bulk_coupon_code_input')}} (<span class="text-primary">CSV, .xls, .xlsx</span>)</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            @foreach($data->giftCoupons as $data) 
                                                                                <div class="gift_create_box mt-4">
                                                                                    <div id="manual_coupon2" class="active">
                                                                                        <div class="flex-grow-1">
                                                                                            <div class="primary_input show_data"></div>
                                                                                            <div class="gift_manual d-flex align-items-center mt-3">
                                                                                                <div class="primary_input">
                                                                                                    <input class="primary_input_field" name="section[{{$key}}][gift_selling_coupon][]" value="{{$data->gift_selling_coupon}}" id="gift_selling_coupon_[{{$key}}]" type="text">                                                                                                  </div>                                               
                                                                                                    <div class="flex-grow-1">
                                                                                                        <button type="button" class="primary-btn radius_30px p-2 fix-gr-bg rounded-circle gift_code_clone">
                                                                                                            <i class="ti-plus mt-2 mx-0"></i>
                                                                                                        </button>
                                                                                                    </div>                                                                                        
                                                                                                </div>                                            
                                                                                            </div> 
                                                                                        </div>
                                                                                        <div id="bulk_coupon" class="row">
                                                                                            <div class="col-lg-6">
                                                                                                <label class="gift_upload mb-0 d-flex align-items-center flex-
                                                                                                    column justify-
                                                                                                    content-center" for="upload-img_file_[{{$key}}]">
                                                                                                    <input type="file" id="upload-img_file_[{{$key}}]" name="section[{{$key}}][gift_selling_coupon]" value="{{$data->gift_selling_coupon}}" class="d-none">
                                                                                                    <svg width="30" height="23" viewBox="0 0 30 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                        <path d="M8.33129 22.2366C6.51002 22.117 4.77951 21.5086 
                                                                                                            3.38683 
                                                                                                            20.4982C1.99416 19.4879 1.01055 18.1272 0.576435 
                                                                                                            16.6104C0.142325 
                                                                                                            15.0937 0.279917 13.4985 0.969566 12.0526C1.65922 
                                                                                                            10.6067 2.86566 
                                                                                                            9.384 4.41663 8.55916C4.74664 6.35947 6.00302 
                                                                                                            4.33797 7.95065 
                                                                                                            2.87295C9.89828 1.40793 12.4037 0.599808 14.998 
                                                                                                            0.599808C17.5922 
                                                                                                            0.599808 20.0976 1.40793 22.0453 2.87295C23.9929 
                                                                                                            4.33797 25.2493 
                                                                                                            6.35947 25.5793 8.55916C27.1303 9.384 28.3367 
                                                                                                            10.6067 29.0263 
                                                                                                            12.0526C29.716 13.4985 29.8536 15.0937 29.4195 
                                                                                                            16.6104C28.9854 
                                                                                                            18.1272 28.0018 19.4879 26.6091 20.4982C25.2164 
                                                                                                            21.5086 23.4859 
                                                                                                            22.117 21.6646 
                                                                                                            22.2366V22.2582H8.33129V22.2366ZM16.3313 
                                                                                                            13.14H20.3313L14.998 7.44103L9.66462 
                                                                                                            13.14H13.6646V17.6991H16.3313V13.14Z" fill="currentColor"></path>
                                                                                                    </svg>
                                                                                                    <p><span class="text-decoration-underline">"{{__(' gift_card.browse_files')}}
                                                                                                            </span>"{{__('gift_card.or_drag')}}" &amp; {{__('gift_card.drop_file_here_to_upload')}}</p>
                                                                                                </label>
                                                                                            </div>                                                      
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>                                                                                                          
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6" id="lg-toggle-4">
                                    <div class="row mt-5 pt-4" id="giftt_card_row">
                                        <div class="col-lg-12">
                                            <div class="row mb-25">
                                                <div class="col-lg-8">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label">{{ __('product.thumbnail_image') }} ({{ getNumberTranslate(165) }} X {{ getNumberTranslate(165) }}){{ __('common.px') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text" id="thumbnail_image_file_one" placeholder="{{ __('product.thumbnail_image') }}" readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg" for="thumbnail_image_one">{{ __('product.Browse') }}</label>
                                                                <input type="file" class="d-none" name="thumbnail_image_one" id="thumbnail_image_one">
                                                            </button>
                                                        </div>
                                                        @error('thumbnail_image_one')
                                                            <span class="text-danger" id="error_message">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4">
                                                    <div class="thumb_img_div_one">
                                                        <img id="ThumbnailImgOne" src="{{ showImage($giftCards->thumbnail_image) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div id="gallery_img_prev">
                                                @foreach($giftCards->galaryImages as $key => $image)
                                                    <div class="galary_img_div">
                                                        <img class="galaryImg" src="{{showImage($image->image_name)}}" alt="">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="row  mb-25">
                                                <div class="col-lg-8">
                                                    <div class="primary_input mb-25">
                                                        <label class="primary_input_label">{{ __('product.galary_image') }} ({{ getNumberTranslate(400) }} X {{ getNumberTranslate(400) }}){{ __('common.px') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="primary_file_uploader">
                                                            <input class="primary-input" type="text" id="placeholderFileOneName"
                                                                placeholder="{{ __('product.galary_image') }}" readonly="">
                                                            <button class="" type="button">
                                                                <label class="primary-btn small fix-gr-bg"
                                                                    for="galary_image">{{ __('product.Browse') }} </label>
                                                                <input type="file" class="d-none" name="galary_image[]" id="galary_image" multiple>
                                                            </button>
                                                        </div>
                                                        @error('galary_image.*')
                                                            <span class="text-danger" id="error_message">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">{{ __('common.status') }}</label>
                                                <ul id="theme_nav" class="permission_list sms_list ">
                                                    <li>
                                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="status" id="status_active" value="1" {{@$giftCards->status == 1?'checked':''}} class="active" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.active') }}</p>
                                                    </li>
                                                    <li>
                                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                                            <input name="status" value="0" id="status_inactive" {{@$giftCards->status == 0?'checked':''}} class="de_active" type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <p>{{ __('common.inactive') }}</p>
                                                    </li>
                                                </ul>
                                                @error('status')
                                                    <span class="text-danger" id="status_error">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>                         
                            </div>
                            <div class="row mt-40">
                                <div class="col-lg-6 offset-lg-3">
                                    <div class="col-lg-12 text-center">
                                        <button id="submit_btn" type="submit" class="primary-btn fix-gr-bg"
                                            data-toggle="tooltip" title="" data-original-title="">
                                            <span class="ti-check"></span>
                                            {{ __('common.update') }} </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                   </form>
                </div>
                
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function($) {
            "use strict";
            $(document).ready(function() {
                $(document).on('click', '#gift_card_prod', function(e) {
                    $(this).closest('.add-visitor').find('#lg-toggle-8').removeClass('col-lg-8').addClass('col-lg-6');
                    $(this).closest('.add-visitor').find('#lg-toggle-4').removeClass('col-lg-4').addClass('col-lg-6');
                    $(this).closest('.add-visitor').find('#redeem_card_row').addClass('d-none');
                    $(this).closest('.add-visitor').find('#gift_card').removeClass('d-none');
                    $(this).closest('.add-visitor').find('#lg-toggle-4 #giftt_card_row').removeClass('d-none');
                    $(this).closest('.add-visitor').find('#lg-toggle-4 #redem_card_row').addClass('d-none');
                    $('#note_editor').hide()
                })
                $(document).on('click', '#redeem_card', function(e) {
                    $(this).closest('.add-visitor').find('#lg-toggle-8').addClass('col-lg-8').removeClass('col-lg-6');
                    $(this).closest('.add-visitor').find('#lg-toggle-4').addClass('col-lg-4').removeClass('col-lg-6');
                    $(this).closest('.add-visitor').find('#gift_card').addClass('d-none');
                    $(this).closest('.add-visitor').find('#redeem_card_row').removeClass('d-none');
                    $(this).closest('.add-visitor').find('#lg-toggle-4 #redem_card_row').removeClass('d-none');
                    $(this).closest('.add-visitor').find('#lg-toggle-4 #giftt_card_row').addClass('d-none');
                    $('#note_editor').show()
                })
                $(document).on('click', '.manual_coupon_radio', function(e){
                    $(this).closest('.col-lg-12.mt-5').find('#manual_coupon2').addClass('active');
                    $(this).closest('.col-lg-12.mt-5').find('#bulk_coupon').removeClass('active');
                })
                $(document).on('click', '.bluk_coupon_radio', function(e){
                    $(this).closest('.col-lg-12.mt-5').find('#bulk_coupon').addClass('active');
                    $(this).closest('.col-lg-12.mt-5').find('#manual_coupon2').removeClass('active');
                })

                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();
                today = mm + '/' + dd + '/' + yyyy;

                $('.date_show').daterangepicker({
                    "timePicker": false,
                    "linkedCalendars": false,
                    "autoUpdateInput": false,
                    "showCustomRangeLabel": false,
                    "startDate": today,
                    "endDate": today
                }, function(start, end, label) {
                    $('.date_show').val(start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
                    $('#start_date').val(start.format('DD-MM-YYYY'));
                    $('#end_date').val(end.format('DD-MM-YYYY'));
                });


                $('#description').summernote({
                    placeholder: '',
                    tabsize: 2,
                    height: 400,
                    codeviewFilter: true,
                    codeviewIframeFilter: true
                });
                $('#descriptionOne').summernote({
                    placeholder: '',
                    tabsize: 2,
                    height: 200,
                    codeviewFilter: true,
                    codeviewIframeFilter: true
                });

                $(document).on('submit', '#add_form', function(event) {
                    resetValidationErrors();
                });

                $(document).on('change', '#thumbnail_image', function(event) {
                    getFileName($('#thumbnail_image').val(), '#thumbnail_image_file');
                    imageChangeWithFile($(this)[0], '#ThumbnailImg');
                });
                $(document).on('change', '#thumbnail_image_one', function(event) {
                    getFileName($('#thumbnail_image_one').val(), '#thumbnail_image_file_one');
                    imageChangeWithFile($(this)[0], '#ThumbnailImgOne');
                });
                $(document).on('change', '#thumbnail_image_two', function(event) {
                    getFileName($('#thumbnail_image_two').val(), '#thumbnail_image_file_two');
                    imageChangeWithFile($(this)[0], '#ThumbnailImgTwo');
                });

                $(document).on('change', '#galary_image', function(event) {
                    galleryImage($(this)[0], '#galler_img_prev')
                });
                $(document).on('change', '#galary_image_one', function(event) {
                    galleryImage($(this)[0], '#galler_img_prev_one')
                });
                $(document).on('change', '#galary_image_two', function(event) {
                    galleryImage($(this)[0], '#galler_img_prev_two')
                });

                $(document).on('keyup', '#name', function(event) {
                    processSlug($('#name').val(), '#sku')
                });

                $(document).on('keyup', '#gift_name', function(event) {
                    processSlug($('#gift_name').val(), '#skuGift')
                });
                var rowData = $('.gift_manual').length;
                var sections= "{{$giftCards->addGiftCard->count()}}";
                $(document).on('click', '.add_single_variant_row_one', function() {
                    sections++;
                    if($('#section-nav-tab').length){
                        $('#section-nav-tab').append(`
                            <button class="nav-link" id="nav-home-tab-${sections}" data-toggle="tab" data-target="#secton-${sections}" type="button"  role="tab" aria-selected="true">
                                <span class="section_name">{{__('gift_card.section')}} ${sections}</span>
                                <i class="ti-close remove_nav" data-id="${sections}"></i>
                            </button>`);
                            $('#section-nav-tabContent').append(`
                                <div class="tab-pane fade" id="secton-${sections}" role="tabpanel" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label" for="gift_card_value">
                                                    {{__('gift_card.gift_card_value')}}: 
                                                    <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input class="primary_input_field" type="number"
                                                    id="gift_card_value_${sections}"
                                                    name="section[${sections}][gift_card_value]" 
                                                    autocomplete="off"
                                                    value="" placeholder="00">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="gift_selling_price_">
                                                    {{__('gift_card.selling_price')}}: <span
                                                        class="text-danger">*</span></label>
                                                <input class="primary_input_field" type="number"
                                                    id="gift_selling_price_${sections}"
                                                    name="section[${sections}][gift_selling_price]" 
                                                    autocomplete="off"
                                                    value="" placeholder="00">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="gift_discount_type">{{__('gift_card.discount_type')}}:
                                                </label>
                                                <select name="section[${sections}][gift_discount_type]" 
                                                id="gift_discount_type_${sections}"
                                                    class="primary_select">     
                                                        <option value="1">{{ __('common.amount') }}</option>
                                                        <option value="0">{{ __('common.percentage') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="gift_discount_amount">
                                                    {{__('gift_card.gift_discount_amount')}}: 
                                                    <span
                                                        class="text-danger">*</span></label>
                                                <input class="primary_input_field" type="number"
                                                    id="gift_discount_amount_${sections}" 
                                                    name="section[${sections}][gift_discount_amount]" 
                                                    autocomplete="off"
                                                    value="" placeholder="00">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="gift_expire_date">{{__('gift_card.gift_expire_date')}}: <span
                                                        class="text-danger">*</span></label>
                                                        <input placeholder="{{ __('common.date') }}"
                                                            class="primary_input_field primary-input date form-control popUpDateRange"
                                                            id="gift_expire_date_${sections}"
                                                            data-id="${sections}" type="text" name="section[${sections}][gift_expire_date]"
                                                            value="{{date('m/d/Y')}}"
                                                            autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary_input mb-25">
                                                <label class="primary_input_label"
                                                    for="number_of_gift_card">{{__('gift_card.number_of_gift_card')}}: 
                                                    <span
                                                        class="text-danger">*</span></label>
                                                <input class="primary_input_field" type="number"
                                                    id="number_of_gift_card_[${sections}]" 
                                                    name="section[${sections}][number_of_gift_card]" autocomplete="off"
                                                    value="" placeholder="00">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-5">
                                            <div class="primary_input">
                                                <label class="primary_input_label mb-4"
                                                    for="name">{{__('gift_card.coupon_code')}}: <span
                                                        class="text-danger">*</span></label>
                                                <div class="d-flex align-items-center flex-wrap">
                                                    <div
                                                        class="flex-grow-1 d-flex align-items-center 
                                                        cursor_pointer manual_coupon_radio"            
                                                        id="">
                                                        <label for="manual_couponR${sections}"
                                                            class="primary_checkbox d-flex mr-12">
                                                            <input name="coupon${sections}"
                                                                id="manual_couponR${sections}" value="1"
                                                                class="active prod_type"
                                                                type="radio"
                                                                checked>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label for="manual_couponR${sections}"
                                                            class="text-capitalize mb-0 cursor_pointer">
                                                            {{__('gift_card.manual_coupon_code_input')}}</label>
                                                    </div>
                                                    <div
                                                        class="flex-grow-1 d-flex align-items-center cursor_pointer bluk_coupon_radio" 
                                                        id="">
                                                        <label for="bluk_coupon${sections}"
                                                            class="primary_checkbox d-flex mr-12">
                                                            <input id="bluk_coupon${sections}"
                                                                value="1"
                                                                class="active prod_type" name="coupon${sections}"
                                                                type="radio">
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <label for="bluk_coupon${sections}"
                                                            class="text-capitalize mb-0 cursor_pointer">
                                                            {{__('gift_card.bulk_coupon_code_input')}} (<span 
                                                            class="text-primary">CSV,
                                                                .xls, .xlsx</span>)</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="gift_create_box mt-4">
                                                <div id="manual_coupon2" class="active">
                                                    <div class="flex-grow-1">
                                                        <div class="primary_input show_data">
                                                            
                                                        </div>
                                                    <div class="gift_manual d-flex align-items-center mt-3">
                                                        <div class="primary_input">
                                                            <input class="primary_input_field" 
                                                            name="section[${sections}][gift_selling_coupon][]"  
                                                            id="gift_selling_coupon_[${sections}]"
                                                                type="text" placeholder="">                                                                                                                                     
                                                        </div>                                               
                                                        <div class="flex-grow-1">
                                                            <button type="button"
                                                                class="primary-btn radius_30px p-2 fix-gr-bg rounded-circle 
                                                                gift_code_clone">
                                                                <i class="ti-plus mt-2 mx-0"></i>
                                                            </button>
                                                        </div>                                                                                         
                                                    </div>                                            
                                                </div> 
                                                </div>
                                                <div id="bulk_coupon" class="row">
                                                    <div class="col-lg-6">
                                                        <label
                                                            class="gift_upload mb-0 d-flex align-items-center flex-
                                                            column justify-
                                                            content-center"
                                                            for="upload_img_file_[${sections}]">
                                                            <input type="file" id="upload_img_file_[${sections}]" 
                                                            name="section[${sections}][upload_img_file]" 
                                                            class="d-none">
                                                            <svg width="30" height="23"
                                                                viewBox="0 0 30 23" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M8.33129 22.2366C6.51002 22.117 4.77951 21.5086 
                                                                    3.38683 
                                                                    20.4982C1.99416 19.4879 1.01055 18.1272 0.576435 
                                                                    16.6104C0.142325 
                                                                    15.0937 0.279917 13.4985 0.969566 12.0526C1.65922 
                                                                    10.6067 2.86566 
                                                                    9.384 4.41663 8.55916C4.74664 6.35947 6.00302 
                                                                    4.33797 7.95065 
                                                                    2.87295C9.89828 1.40793 12.4037 0.599808 14.998 
                                                                    0.599808C17.5922 
                                                                    0.599808 20.0976 1.40793 22.0453 2.87295C23.9929 
                                                                    4.33797 25.2493 
                                                                    6.35947 25.5793 8.55916C27.1303 9.384 28.3367 
                                                                    10.6067 29.0263 
                                                                    12.0526C29.716 13.4985 29.8536 15.0937 29.4195 
                                                                    16.6104C28.9854 
                                                                    18.1272 28.0018 19.4879 26.6091 20.4982C25.2164 
                                                                    21.5086 23.4859 
                                                                    22.117 21.6646 
                                                                    22.2366V22.2582H8.33129V22.2366ZM16.3313 
                                                                    13.14H20.3313L14.998 7.44103L9.66462 
                                                                    13.14H13.6646V17.6991H16.3313V13.14Z"
                                                                    fill="currentColor" />
                                                            </svg>
                                                            <p><span class="text-decoration-underline">"{{__(' gift_card.browse_files')}}
                                                            </span>"{{__('gift_card.or_drag')}}" &amp; {{__('gift_card.drop_file_here_to_upload')}}</p>
                                                        </label>
                                                    </div>                                               
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `)
                    }
                    else{
                        $('.variant_row_lists_amount:last').after(`
                            <div class="gift_box">
                                <nav>
                                    <div class="nav nav-tabs border-0" id="section-nav-tab" role="tablist">
                                        <button class="nav-link active" id="nav-home-tab"
                                            data-toggle="tab" data-target="#secton-1" type="button"
                                            role="tab" aria-selected="true">
                                        <span class="section_name">{{__('gift_card.section')}}</span>
                                        <i class="ti-close remove_nav" data-id="${sections}"></i>
                                        </button>
                                        
                                    </div>
                                </nav>
                                <div class="tab-content" id="section-nav-tabContent">
                                    <div class="tab-pane fade show active" id="secton-1" role="tabpanel"
                                        tabindex="0">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="gift_card_value">
                                                        {{__('gift_card.gift_card_value')}}: 
                                                        <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input class="primary_input_field" type="number"
                                                        id="gift_card_value_${sections}"
                                                        name="section[${sections}][gift_card_value]" 
                                                        autocomplete="off"
                                                        value="" placeholder="00">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="gift_selling_price_">
                                                        {{__('gift_card.selling_price')}}: <span
                                                            class="text-danger">*</span></label>
                                                    <input class="primary_input_field" type="number"
                                                        id="gift_selling_price_${sections}"
                                                        name="section[${sections}][gift_selling_price]" 
                                                        autocomplete="off"
                                                        value="" placeholder="00">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="gift_discount_type">{{__('gift_card.discount_type')}}:
                                                    </label>
                                                    <select name="section[${sections}][gift_discount_type]" 
                                                    id="gift_discount_type_${sections}"
                                                        class="primary_select">     
                                                            <option value="1">{{ __('common.amount') }}</option>
                                                            <option value="0">{{ __('common.percentage') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="gift_discount_amount">
                                                        {{__('gift_card.gift_discount_amount')}}: 
                                                        <span
                                                            class="text-danger">*</span></label>
                                                    <input class="primary_input_field" type="number"
                                                        id="gift_discount_amount_${sections}" 
                                                        name="section[${sections}][gift_discount_amount]" 
                                                        autocomplete="off"
                                                        value="" placeholder="00">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                    for="gift_expire_date">{{__('gift_card.gift_expire_date')}}: <span
                                                        class="text-danger">*</span></label>
                                                        <input placeholder="{{ __('common.date') }}"
                                                            class="primary_input_field primary-input date form-control popUpDateRange"
                                                            id="gift_expire_date_${sections}"
                                                            data-id="${sections}" type="text" name="section[${sections}][gift_expire_date]"
                                                            value="{{date('m/d/Y')}}"
                                                            autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label"
                                                        for="number_of_gift_card">{{__('gift_card.number_of_gift_card')}}: 
                                                        <span
                                                            class="text-danger">*</span></label>
                                                    <input class="primary_input_field" type="number"
                                                        id="number_of_gift_card_[${sections}]" 
                                                        name="section[${sections}][number_of_gift_card]" autocomplete="off"
                                                        value="" placeholder="00">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-5">
                                                <div class="primary_input">
                                                    <label class="primary_input_label mb-4"
                                                        for="name">{{__('gift_card.coupon_code')}}: <span
                                                            class="text-danger">*</span></label>
                                                    <div class="d-flex align-items-center flex-wrap">
                                                        <div
                                                            class="flex-grow-1 d-flex align-items-center 
                                                            cursor_pointer manual_coupon_radio"            
                                                            id="">
                                                            <label for="manual_coupon"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input name="coupon"
                                                                    id="manual_coupon" value="1"
                                                                    class="active prod_type"
                                                                    type="radio"
                                                                    checked>
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <label for="manual_coupon"
                                                                class="text-capitalize mb-0 cursor_pointer">
                                                                {{__('gift_card.manual_coupon_code_input')}}</label>
                                                        </div>
                                                        <div
                                                            class="flex-grow-1 d-flex align-items-center cursor_pointer bluk_coupon_radio" 
                                                            id="">
                                                            <label for="bluk_coupon"
                                                                class="primary_checkbox d-flex mr-12">
                                                                <input id="bluk_coupon"
                                                                    value="1"
                                                                    class="active prod_type" name="coupon"
                                                                    type="radio">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <label for="bluk_coupon"
                                                                class="text-capitalize mb-0 cursor_pointer">
                                                                {{__('gift_card.bulk_coupon_code_input')}} (<span 
                                                                class="text-primary">CSV,
                                                                    .xls, .xlsx</span>)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="gift_create_box mt-4">
                                                    <div id="manual_coupon2" class="active">
                                                        <div class="flex-grow-1">
                                                            <div class="primary_input show_data">
                                                                
                                                            </div>
                                                        <div class="gift_manual d-flex align-items-center mt-3">
                                                            <div class="primary_input">
                                                                <input class="primary_input_field" 
                                                                name="section[${sections}][gift_selling_coupon][]"  
                                                                id="gift_selling_coupon_[${sections}]"
                                                                    type="text" placeholder="">                                                                                                                                     
                                                            </div>                                               
                                                            <div class="flex-grow-1">
                                                                <button type="button"
                                                                    class="primary-btn radius_30px p-2 fix-gr-bg rounded-circle 
                                                                    gift_code_clone">
                                                                    <i class="ti-plus mt-2 mx-0"></i>
                                                                </button>
                                                            </div>                                                                                         
                                                        </div>                                            
                                                    </div> 
                                                    </div>
                                                    <div id="bulk_coupon" class="row">
                                                        <div class="col-lg-6">
                                                            <label
                                                                class="gift_upload mb-0 d-flex align-items-center flex-
                                                                column justify-
                                                                content-center"
                                                                for="upload-img_file_[${sections}]">
                                                                <input type="file" id="upload-img_file_[${sections}]" 
                                                                name="section[${sections}][upload_img_file]" 
                                                                class="d-none">
                                                                <svg width="30" height="23"
                                                                    viewBox="0 0 30 23" fill="none"
                                                                    xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M8.33129 22.2366C6.51002 22.117 4.77951 21.5086 
                                                                        3.38683 
                                                                        20.4982C1.99416 19.4879 1.01055 18.1272 0.576435 
                                                                        16.6104C0.142325 
                                                                        15.0937 0.279917 13.4985 0.969566 12.0526C1.65922 
                                                                        10.6067 2.86566 
                                                                        9.384 4.41663 8.55916C4.74664 6.35947 6.00302 
                                                                        4.33797 7.95065 
                                                                        2.87295C9.89828 1.40793 12.4037 0.599808 14.998 
                                                                        0.599808C17.5922 
                                                                        0.599808 20.0976 1.40793 22.0453 2.87295C23.9929 
                                                                        4.33797 25.2493 
                                                                        6.35947 25.5793 8.55916C27.1303 9.384 28.3367 
                                                                        10.6067 29.0263 
                                                                        12.0526C29.716 13.4985 29.8536 15.0937 29.4195 
                                                                        16.6104C28.9854 
                                                                        18.1272 28.0018 19.4879 26.6091 20.4982C25.2164 
                                                                        21.5086 23.4859 
                                                                        22.117 21.6646 
                                                                        22.2366V22.2582H8.33129V22.2366ZM16.3313 
                                                                        13.14H20.3313L14.998 7.44103L9.66462 
                                                                        13.14H13.6646V17.6991H16.3313V13.14Z"
                                                                        fill="currentColor" />
                                                                </svg>
                                                                <p><span class="text-decoration-underline">"{{__(' gift_card.browse_files')}}
                                                                </span>"{{__('gift_card.or_drag')}}" &amp; {{__('gift_card.drop_file_here_to_upload')}}</p>
                                                            </label>
                                                        </div>                                                      
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    }
                    updateSectionName();
                    $('.primary_select').niceSelect('destroy');
                    $('.primary_select').niceSelect();
                    $('.primary-input.date').datepicker({
                        autoclose: true,
                        setDate: new Date()
                    });
                });
                
                $(document).on('click', '.remove_item', function(e) {
                    e.preventDefault();
                    $(this).parent().parent().remove();
                })

                $(document).on('click', '.remove_nav', function(e) {
                    e.preventDefault();
                    var id=$(this).data('id');
                    $('#nav-home-tab-'+id).remove();
                    $('#secton-'+id).remove();
                    updateSectionName();
                })
                $(document).on('click', '.gift_code_clone', function(e) {
                    e.preventDefault();
                    var rowsection = $(this).data('section')
                    var rowData = $('.gift_manual').length;
                    $(this).closest('#manual_coupon2').find('.show_data').prepend(`  
                    <div id="manual_coupon2" class="active">
                        <div class="gift_manual align-items-center d-flex mt-3">
                            <div class="primary_input">
                                <input class="primary_input_field" 
                                name="section[${rowsection}][gift_selling_coupon][]" 
                                id="gift_selling_coupon_[${rowsection}]${rowData}"
                                    type="text"  placeholder="">                                                                                                                                   
                            </div>                          
                            <div class="flex-grow-1">
                                <button type="button"
                                    class="primary-btn radius_30px p-2 fix-gr-bg rounded-circle remove_item">
                                    <i class="ti-minus m-0"></i>
                                </button>
                            </div> 
                                                                        
                        </div>
                    `);
                });
                $(document).on('click', '.gift_file_clone',function(e){
                    e.preventDefault();
                })

                function resetValidationErrors() {
                    $('#error_name').text('');
                    $('#error_gift_name').text('');
                    $('#error_amount').text('');
                    $('#error_status').text('');
                    $('#error_date').text('');
                    $('#error_description').text('');
                    $('#error_descriptionOne').text('');
                }

                function galleryImage(data, divId) {
                    if (data.files) {

                        $.each(data.files, function(key, value) {
                            $('#gallery_img_prev').empty();
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $('#gallery_img_prev').append(
                                    `
                                    <div class="galary_img_div">
                                        <img class="galaryImg" src="` + e.target.result + `" alt="">
                                    </div>
                                    `
                                );

                            };
                            reader.readAsDataURL(value);
                        });
                    }
                }

                function updateSectionName(){
                    $('.section_name').each(function(v, i){
                        let text = "{{__('gift_card.section')}}";
                        if( v > 0){
                            text+= " "+(v+1)
                        }
                        $(this).text(text)
                    })
                }
            });
        })(jQuery);
    </script>
@endpush
