<div class="row">
    <div class="col-lg-12">
        <div class="main-title">
            <h3 class="mb-30">
                {{__('common.bank')}} {{__('common.account')}}</h3>
        </div>

        <form action="{{route('seller.profile.bank-account.update',$seller->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="white-box">
                <div class="add-visitor">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="primary_input">
                                <label class="primary_input_label" for="cash_payment">{{ __('common.payment') }} <span class="text-danger">*</span></label>
                                <ul id="theme_nav" class="permission_list sms_list ">
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                            <input name="payment" id="cash_payment_active" {{$seller->sellerBankAccount->payment ==1?'checked':''}} value="1" class="active"
                                                   type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.cash_payment') }}</p>
                                    </li>
                                    <li>
                                        <label data-id="bg_option" class="primary_checkbox d-flex mr-12">
                                            <input name="payment" id="cash_payment_active" value="2" class="active" {{$seller->sellerBankAccount->payment ==2?'checked':''}}
                                                   type="radio">
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.bank_payment') }}</p>
                                    </li>
                                    <li>
                                        <label data-id="color_option" class="primary_checkbox d-flex mr-12">
                                            <input name="payment" value="0" id="cash_payment_inactive" class="de_active" type="radio" {{$seller->sellerBankAccount->payment ==0?'checked':''}}>
                                            <span class="checkmark"></span>
                                        </label>
                                        <p>{{ __('common.off') }}</p>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="bank_title">{{__('common.account')}} {{__('common.title')}}<span class="text-danger">*</span></label>
                                <input name="bank_title" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('bank_title')? old('bank_title'):$seller->sellerBankAccount->bank_title }}">
                                       @error('bank_title')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror
                            </div>

                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="bank_account_number">{{__('common.account_number')}} <span class="text-danger">*</span></label>
                                <input name="bank_account_number" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('bank_account_number')? old('bank_account_number'):$seller->sellerBankAccount->bank_account_number }}">
                                       @error('bank_account_number')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror
                            </div>

                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="bank_name">{{__('common.bank_name')}} <span class="text-danger">*</span></label>
                                <input name="bank_name" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('bank_name')? old('bank_name'):$seller->sellerBankAccount->bank_name }}">
                                       @error('bank_name')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror
                            </div>

                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="branch_name">{{__('common.branch_name')}} <span class="text-danger">*</span></label>
                                <input name="branch_name" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('branch_name')? old('branch_name'): $seller->sellerBankAccount->bank_branch_name }}">
                                       @error('branch_name')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror
                            </div>

                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="routing_number">{{__('common.routing_number')}} <span class="text-danger">*</span></label>
                                <input name="routing_number" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('routing_number')? old('routing_number'):$seller->sellerBankAccount->bank_routing_number }}">
                                       @error('routing_number')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror
                            </div>

                        </div>
                        <div class="col-xl-6">
                            <div class="primary_input mb-25">
                                <label class="primary_input_label" for="ibn">{{__('common.ibn')}} <span class="text-danger">*</span></label>
                                <input name="ibn" class="primary_input_field" placeholder="-" type="text"
                                       value="{{ old('ibn')? old('ibn'):$seller->sellerBankAccount->bank_ibn }}">
                                       @error('ibn')
                                       <span class="text-danger">{{$message}}</span>
                                       @enderror
                            </div>

                        </div>

                        <div class="col-xl-6">
                            <div class="primary_input mb-35">
                                <label class="primary_input_label" for="cheque_copy">{{__('seller.upload_cheque_copy')}}</label>
                                <div class="primary_file_uploader">
                                    <input class="primary-input" type="text" id="cheque_copy_file"
                                           placeholder="{{__('common.browse_image_file')}}" readonly="">
                                    <button class="" type="button">
                                        <label class="primary-btn small fix-gr-bg" for="cheque_copy"><span
                                                class="ripple rippleEffect browse_img"></span>{{__('common.browse')}}</label>
                                        <input name="cheque_copy" type="file" accept="image/*" class="d-none" id="cheque_copy">
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div id="bankChequeImgDiv" class="logo_img">
                                @if ($seller->sellerBankAccount->bank_cheque)
                                    <p id="chequeImgCross" class="cursor_pointer img_cross" aria-disabled="true" data-id="{{$seller->sellerBankAccount->id}}"><i class="fas fa-times"></i></p>
                                @endif

                                <img id="imgDiv33" src="{{showImage(@$seller->sellerBankAccount->bank_cheque?@$seller->sellerBankAccount->bank_cheque:'backend/img/default.png')}}" alt="">
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

</div>
@include('backEnd.partials._deleteModalForAjax',
['item_name' => __('common.bank_cheque'),'modal_id' => 'cheqyeImgModal','form_id' => 'chequeImgForm','delete_item_id' => 'delete_cheque_id','dataDeleteBtn'=>'cheque_delete_btn'])


