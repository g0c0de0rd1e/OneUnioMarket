@extends('backEnd.master')

@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="white_box_30px">
            <form action="{{ route('admin.seller_configuration_update') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-xl-12">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('common.configuration') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{ __('wallet.auto_approve') }} {{ __('common.seller') }}</label>
                            <ul id="theme_nav" class="permission_list sms_list ">
                                <li>
                                    <label data-id="bg_option"
                                           class="primary_checkbox d-flex mr-12">
                                        <input name="status" id="status_active" value="1" {{$sellerConfiguration->auto_approve_seller == 1?'checked':''}} class="active" type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{ __('common.active') }}</p>
                                </li>
                                <li>
                                    <label data-id="color_option"
                                           class="primary_checkbox d-flex mr-12">
                                        <input name="status" value="0" id="status_inactive" {{$sellerConfiguration->auto_approve_seller == 0?'checked':''}}  class="de_active"
                                               type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{ __('common.inactive') }}</p>
                                </li>
                            </ul>
                            <span class="text-danger" id="status_error"></span>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{ __('seller.multi_category') }}</label>
                            <ul id="theme_nav" class="permission_list sms_list ">
                                <li>
                                    <label data-id="bg_option"
                                           class="primary_checkbox d-flex mr-12">
                                        <input name="multi_category" value="1" {{$sellerConfiguration->multi_category == 1?'checked':''}} class="active" type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{ __('common.active') }}</p>
                                </li>
                                <li>
                                    <label data-id="color_option"
                                           class="primary_checkbox d-flex mr-12">
                                        <input name="multi_category" value="0" {{$sellerConfiguration->multi_category == 0?'checked':''}}  class="de_active"
                                               type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{ __('common.inactive') }}</p>
                                </li>
                            </ul>
                            <span class="text-danger" id="status_error"></span>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">{{ __('seller.commission_calculate_for_multi_category') }}</label>
                            <ul id="theme_nav" class="permission_list sms_list ">
                                <li>
                                    <label data-id="color_option"
                                           class="primary_checkbox d-flex mr-12">
                                        <input name="commission_by" value="1" {{$sellerConfiguration->commission_by == 1?'checked':''}}  class="de_active"
                                               type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{ __('seller.minimum_rate') }}</p>
                                </li>

                                <li>
                                    <label data-id="bg_option"
                                           class="primary_checkbox d-flex mr-12">
                                        <input name="commission_by" value="2" {{$sellerConfiguration->commission_by == 2?'checked':''}} class="active" type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{ __('seller.maximum_rate') }}</p>
                                </li>
                                
                                <li>
                                    <label data-id="color_option"
                                           class="primary_checkbox d-flex mr-12">
                                        <input name="commission_by" value="3" {{$sellerConfiguration->commission_by == 3?'checked':''}}  class="de_active"
                                               type="radio">
                                        <span class="checkmark"></span>
                                    </label>
                                    <p>{{ __('seller.average_rate') }}</p>
                                </li>
                            </ul>
                            <span class="text-danger" id="status_error"></span>
                        </div>
                    </div>
                </div>
                <div class="submit_btn text-center">
                    <button class="primary_btn_2" type="submit"> <i class="ti-check"
                            dusk="save"></i>{{ __('common.update') }}</button>
                </div>
            </form>
        </div>
    </div>

</section>
@endsection
