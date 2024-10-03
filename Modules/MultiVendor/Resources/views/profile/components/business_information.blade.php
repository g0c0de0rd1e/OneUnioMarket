<div class="col-lg-12">
    <div class="main-title">
        <h3 class="mb-30">
            {{__('common.business_information')}} </h3>
    </div>

    <form method="POST" action="{{route('seller.profile.business-information.update',$seller->id)}}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="white-box">
            <div class="add-visitor">
                <div class="row">

                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="business_owner_name">{{__('seller.business_owner_name')}} <span class="text-danger">*</span></label>
                            <input name="business_owner_name" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('business_owner_name')? old('business_owner_name'):$seller->SellerBusinessInformation->business_owner_name }}">
                                   @error('business_owner_name')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                        </div>

                    </div>

                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="business_address1">{{__('common.address_1')}} <span class="text-danger">*</span></label>
                            <input name="business_address1" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('business_address1')? old('business_address1'):$seller->SellerBusinessInformation->business_address1 }}">
                                   @error('business_address1')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                        </div>

                    </div>
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="business_address2">{{__('common.address_2')}}</label>
                            <input name="business_address2" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('business_address2')? old('business_address2'):$seller->SellerBusinessInformation->business_address2 }}">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <label class="primary_input_label" for="country">{{__('seller.country_region')}} <span class="text-danger">*</span></label>
                        <select name="country" id="business_country" class="primary_select mb-25">
                            <option value="" disabled selected>{{__('common.select_one')}}</option>
                            @foreach($countries as $country)
                            <option {{@$seller->SellerBusinessInformation->business_country == $country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                        @error('country')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-xl-6">
                        <label class="primary_input_label" for="state">{{__('common.state')}} <span class="text-danger">*</span></label>
                        <select name="state" id="business_state" class="primary_select mb-25">
                            <option value="" disabled selected>{{__('common.select_one')}}</option>
                            @if($seller->SellerBusinessInformation->country)
                                @foreach($seller->SellerBusinessInformation->country->states as $key => $state)
                                <option {{@$seller->SellerBusinessInformation->state->id == $state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('state')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-xl-6">
                        <label class="primary_input_label" for="city">{{__('common.city')}} <span class="text-danger">*</span></label>
                        <select name="city" id="business_city" class="primary_select mb-25">
                            <option value="" disabled selected>{{__('common.select_one')}}</option>

                            @if($seller->SellerBusinessInformation->state)
                                @foreach($seller->SellerBusinessInformation->state->cities as $key => $city)
                                <option {{@$seller->SellerBusinessInformation->city->id == $city->id?'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            @endif

                        </select>
                        @error('city')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="business_postcode">{{__('common.postcode')}} <span class="text-danger">*</span></label>
                            <input name="business_postcode" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('business_postcode')? old('business_postcode'): getNumberTranslate($seller->SellerBusinessInformation->business_postcode) }}">
                                   @error('business_postcode')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                        </div>

                    </div>
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="business_person_incharge_name">{{__('seller.person_in_charge_name')}}</label>
                            <input name="business_person_incharge_name" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('business_person_incharge_name')? old('business_person_incharge_name'):$seller->SellerBusinessInformation->business_person_in_charge_name }}">
                                   @error('business_person_incharge_name')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                        </div>

                    </div>
                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="business_registration_number">{{__('seller.business_registration_number')}}</label>
                            <input name="business_registration_number" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('business_registration_number')? old('business_registration_number'): getNumberTranslate($seller->SellerBusinessInformation->business_registration_number)}}">
                                   @error('business_registration_number')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror
                        </div>

                    </div>

                    <div class="col-xl-6">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="seller_tin">{{__('seller.seller_tin')}}</label>
                            <input name="seller_tin" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('seller_tin')? old('seller_tin'):$seller->SellerBusinessInformation->business_seller_tin }}">
                        </div>
                        <span class="text-danger" id="error_seller_tin"></span>
                    </div>

                    <div class="col-xl-6">
                        <div class="primary_input mb-35">
                            <label class="primary_input_label" for="">{{__('seller.upload_business_document')}}</label>
                            <div class="primary_file_uploader">
                                <input class="primary-input" type="text" id="business_document_file"
                                       placeholder="{{__('common.browse_image_file')}}" readonly="">
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg" for="business_document"><span
                                            class="ripple rippleEffect browse_img"></span>{{__('common.browse')}}</label>
                                    <input name="business_document" type="file" accept="image/*" class="d-none" id="business_document">
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div id="businessImgDiv" class="logo_img">
                            @if ($seller->SellerBusinessInformation->business_document)
                                <p id="documentCross" class="cursor_pointer img_cross" aria-disabled="true" data-id="{{$seller->SellerBusinessInformation->id}}"><i class="fas fa-times"></i></p>
                            @endif

                            <img id="imgDiv34"
                             src="{{showImage($seller->SellerBusinessInformation->business_document??'backend/img/default.png')}}" alt="">
                        </div>
                    </div>



                </div>

                <div class="row mt-40">
                    <div class="col-lg-12 text-center tooltip-wrapper" data-title=""
                         data-original-title="" title="">
                        <button class="primary-btn fix-gr-bg tooltip-wrapper " id="copyrightBtn">
                            <span class="ti-check"></span>
                            {{__('common.update')}} </button>
                    </div>


                </div>

            </div>
        </div>
    </form>
</div>
@include('backEnd.partials._deleteModalForAjax',
['item_name' => __('common.business_document'),'modal_id' => 'imgModal','form_id' => 'imgForm','delete_item_id' => 'delete_document_id','dataDeleteBtn'=>'document_delete_btn'])
