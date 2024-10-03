<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30">
                {{__('common.warehouse_address')}} </h3>
        </div>

        <form method="POST" action="{{route('seller.profile.warehouse-address.update',$seller->id)}}" id="warehouse_address_form" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="white-box">
                <div class="add-visitor">
                    <div class="row">

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="warehouse_name">{{__('common.full_name')}} <span class="text-danger">*</span></label>
                                <input name="warehouse_name" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('warehouse_name')? old('warehouse_name'):$seller->SellerWarehouseAddress->warehouse_name }}">
                                       @error('warehouse_name')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror       
                            </div>
                            
                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="warehouse_address">{{__('common.address')}} <span class="text-danger">*</span></label>
                                <input name="warehouse_address" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('warehouse_address')? old('warehouse_address'):$seller->SellerWarehouseAddress->warehouse_address }}">

                                       @error('warehouse_address')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror       
                            </div>
                            
                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="warehouse_phone">{{__('common.phone_number')}} <span class="text-danger">*</span></label>
                                <input name="warehouse_phone" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('warehouse_phone')? old('warehouse_phone'):$seller->SellerWarehouseAddress->warehouse_phone }}">
                                       @error('warehouse_phone')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror           
                            </div>
                            
                        </div>

                        <div class="col-xl-6">
                            <label class="primary_input_label" for="country">{{__('seller.country_region')}} <span class="text-danger">*</span></label>
                            <select name="country" id="warehouse_country" class="primary_select mb-25">
                                <option value="" disabled selected>{{__('common.select_one')}}</option>
                                @foreach($countries as $country)
                                <option {{@$seller->SellerWarehouseAddress->warehouse_country == $country->id?'selected':''}} value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            @error('country')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="primary_input_label" for="state">{{__('common.state')}} <span class="text-danger">*</span></label>
                            <select name="state" id="warehouse_state" class="primary_select mb-25">
                                <option value="" disabled selected>{{__('common.select_one')}}</option>
                                @if($seller->SellerWarehouseAddress->country)
                                    @foreach(@$seller->SellerWarehouseAddress->country->states as $key => $state)
                                    <option {{@$seller->SellerWarehouseAddress->state->id == $state->id?'selected':''}} value="{{$state->id}}">{{$state->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('state')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="primary_input_label" for="=city">{{__('common.city')}} <span class="text-danger">*</span></label>
                            <select name="city" id="warehouse_city" class="primary_select mb-25">
                                <option value="" disabled selected>{{__('common.select_one')}}</option>
                                @if($seller->SellerWarehouseAddress->state)
                                    @foreach(@$seller->SellerWarehouseAddress->state->cities as $key => $city)
                                    <option {{@$seller->SellerWarehouseAddress->city->id == $city->id?'selected':''}} value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('city')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-xl-6">
                            <label class="primary_input_label" for="warehouse_postcode">{{__('common.postcode')}} <span class="text-danger">*</span></label>
                            <input name="warehouse_postcode" class="primary_input_field" placeholder="-" type="text"
                                   value="{{ old('warehouse_postcode')? old('warehouse_postcode'):$seller->SellerWarehouseAddress->warehouse_postcode }}">
                                   @error('warehouse_postcode')
                                   <span class="text-danger">{{$message}}</span>
                                   @enderror              
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
</div>
