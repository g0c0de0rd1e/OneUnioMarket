<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30">
                {{__('common.return_address')}} </h3>
        </div>

        <form method="POST" action="{{route('seller.profile.return-address.update',$seller->id)}}" id="return_address_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="white-box">
                <div class="add-visitor">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input">
                                <label class="primary_input_label" for="copy_address">{{ __('seller.same_as_warehouse_address') }}</label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                            <input name="same_as_warehouse" id="status_active" value="1" {{$seller->SellerReturnAddress->same_as_warehouse == 1?'checked':''}} class="active same_address_check" data-seller_id="{{$seller->id}}" type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.yes') }}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                            <input name="same_as_warehouse" value="0" {{$seller->SellerReturnAddress->same_as_warehouse == 0?'checked':''}}   id="status_inactive" class="de_active same_address_check" type="radio" data-seller_id="{{$seller->id}}">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.no') }}</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="return_div" class="row {{$seller->SellerReturnAddress->same_as_warehouse == 1?'d-none':''}}">
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="name">{{__('common.full_name')}} <span class="text-danger">*</span></label>
                                <input name="name" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('name')? old('name'):$seller->SellerReturnAddress->return_name }}">
                                       @error('name')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror       
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="address">{{__('common.address')}} <span class="text-danger">*</span></label>
                                <input name="address" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('address')? old('address'):$seller->SellerReturnAddress->return_address }}">
                                       @error('address')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror        
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="phone">{{__('common.phone_number')}} <span class="text-danger">*</span></label>
                                <input name="phone" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('phone')? old('phone'):$seller->SellerReturnAddress->return_phone }}">
                                       @error('phone')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror        
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <label class="primary_input_label" for="country">{{__('seller.country_region')}} <span class="text-danger">*</span></label>
                            <select name="country" id="return_country" class="primary_select mb-25">
                                <option value="" disabled selected>{{__('common.select_one')}}</option>
                                @foreach($countries as $country)
                                <option {{@$seller->SellerReturnAddress->return_country == $country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            @error('country')
                                <span class="text-danger">{{$message}}</span>
                            @enderror 
                        </div>
                        <div class="col-xl-6">
                            <label class="primary_input_label" for="state">{{__('common.state')}} <span class="text-danger">*</span></label>
                            <select name="state" id="return_state" class="primary_select mb-25">
                                <option value="" disabled selected>{{__('common.select_one')}}</option>
                                @if($seller->SellerReturnAddress->country)
                                    @foreach(@$seller->SellerReturnAddress->country->states as $key => $state)
                                    <option {{@$seller->SellerReturnAddress->state->id == $state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('state')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="primary_input_label" for="=city">{{__('common.city')}} <span class="text-danger">*</span></label>
                            <select name="city" id="return_city" class="primary_select mb-25">
                                <option value="" disabled selected>{{__('common.select_one')}}</option>
                                @if($seller->SellerReturnAddress->state)
                                    @foreach(@$seller->SellerReturnAddress->state->cities as $key => $city)
                                    <option {{@$seller->SellerReturnAddress->city->id == $city->id?'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('city')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="primary_input_label" for="postcode">{{__('common.postcode')}} <span class="text-danger">*</span></label>
                            <input name="postcode" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('postcode')? old('postcode'):$seller->SellerReturnAddress->return_postcode }}">

                                @error('postcode')
                                   <span class="text-danger">{{$message}}</span>
                                @enderror       
                        </div>
                        <div class="col-xl-12">
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



                </div>
            </div>
        </form>
    </div>
</div>
