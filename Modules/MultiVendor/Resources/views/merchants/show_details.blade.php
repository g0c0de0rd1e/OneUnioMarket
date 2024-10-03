@extends('backEnd.master')
@section('styles')

<link rel="stylesheet" href="{{asset(asset_path('modules/multivendor/css/merchant.css'))}}" />
@endsection
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="box_header">
                            <div class="main-title d-flex">
                                <h3 class="mb-0 mr-30">{{ __('common.seller_details')}}</h3>
                            </div>
                            <ul class="d-flex justify-content-between button_list">
                                @if (permissionCheck('admin.merchant_edit_profile'))
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route('admin.merchant_edit_profile',$user->id)}}"><i class="ti-pencil"></i>{{ __('common.edit') }}</a></li>
                                @endif

                                @if (permissionCheck('admin.update_commission'))
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg t-white edit_commission" data-rate="{{ $user->SellerAccount->commission_rate }}" data-id="{{ $user->SellerAccount->id }}"><i class="ti-pencil"></i>{{ __('common.edit_commission_rate') }}</a></li>
                                @endif

                                @if (permissionCheck('admin.change_merchant_trusted_status'))
                                    <li>
                                        <a class="primary-btn radius_30px mr-10 fix-gr-bg abtn trusted_seller_btn" data-value="{{route('admin.change_merchant_trusted_status', @$user->SellerAccount->id)}}">
                                            @if (@$user->SellerAccount->is_trusted == 0)
                                                <i class="ti-check"></i>{{ __('seller.make_trusted') }}
                                            @else
                                                <i class="ti-close"></i>{{ __('seller.remove_from_trusted') }}
                                            @endif

                                        </a>
                                    </li>
                                @endif

                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="img_div">
                                    <img class="student-meta-img mb-3" src="{{ isset($user->avatar) ? showImage($user->avatar) : showImage('frontend/default/img/avatar.jpg') }}"  alt="">
                                </div>

                                <h3>{{$user->first_name}} {{$user->last_name}}</h3>
                                <table class="table table-borderless customer_view">
                                    <tr>
                                        <td class="first_row_width">{{ __('common.name') }}</td>
                                        <td>: <span class="ml-1"></span>{{$user->first_name}} {{$user->last_name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.email') }}</td>
                                        <td>: <span class="ml-1"></span>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.phone') }}</td>
                                        <td>: <span class="ml-1"></span>{{ $user->username }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.registered_date') }}</td>
                                        <td>: <span class="ml-1"></span>{{ dateConvert($user->created_at) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.commission_type') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerAccount->commission_type->name}} @if ($user->SellerAccount->commission_type->id == 1) ({{ $user->SellerAccount->commission_rate }} %) @endif</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.is_trusted') }}</td>
                                        <td>: <span class="ml-1"></span>
                                            @if (@$user->SellerAccount->is_trusted == 1)
                                                <i class="ti-check"></i><span class="ml-1"></span>{{ __('common.yes') }}
                                            @else
                                                <i class="ti-close"></i><span class="ml-1"></span>{{ __('common.no') }}
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 col-sm-12 customer_profile m-2">
                                <h3>{{__('common.order_summary')}}</h3>
                                <table class="table table-borderless customer_view">
                                    <tr><td class="first_row_width">{{__('common.total_orders')}}</td>
                                    <td>: <span class="ml-1"></span>{{count($user->order_packages)}}</td></tr>
                                    <tr><td class="first_row_width">{{__('common.cancelled_orders')}}</td>
                                    <td>: <span class="ml-1"></span>{{count($user->order_packages->where('is_cancelled', 1))}}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-3 col-sm-12 customer_profile m-2">
                                <h3>{{__('common.wallet_summary')}}</h3>
                                    <tr><td class="first_row_width">{{__('common.total_balance')}}</td>
                                    <td>: <span class="ml-1"></span>{{single_price($user->SellerCurrentWalletAmounts)}}</td></tr>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <h3>{{__('common.account_information')}}</h3>
                                <table class="table table-borderless customer_view">
                                    <tr>
                                        <td class="first_row_width">{{ __('common.phone') }}</td>
                                        <td>: <span class="ml-1"></span>{{ getNumberTranslate(@$user->SellerAccount->seller_phone) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.shop_name') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerAccount->seller_shop_display_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.holiday_mode') }}</td>
                                        <td>: <span class="ml-1"></span>
                                            @if (@$user->SellerAccount->holiday_mode == 1)
                                                {{__('common.on')}}
                                            @else
                                                {{__('common.off')}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.holiday_type') }}</td>
                                        <td>: <span class="ml-1"></span>
                                            @if (@$user->SellerAccount->holiday_type == 1)
                                                {{__('common.single')}}
                                            @elseif (@$user->SellerAccount->holiday_type == 2)
                                                {{__('common.multiple')}}
                                            @else
                                                {{__('common.n/a')}}
                                            @endif
                                        </td>
                                    </tr>

                                    @if (@$user->SellerAccount->holiday_type == 1)
                                        <tr>
                                            <td class="first_row_width">{{ __('common.holiday_date') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerAccount->holiday_date }}</td>
                                        </tr>
                                    @elseif (@$user->SellerAccount->holiday_type == 2)
                                        <tr>
                                            <td class="first_row_width">{{ __('common.holiday_duration') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerAccount->holiday_date_start }} {{__('common.to')}} {{ @$user->SellerAccount->holiday_date_end }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td class="first_row_width">{{ __('common.holiday_duration') }}</td>
                                            <td>: <span class="ml-1"></span>{{__('common.n/a')}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="first_row_width">{{ __('common.trusted_seller') }}</td>
                                        <td>: <span class="ml-1"></span>
                                            @if ($user->SellerAccount->is_trusted == 1)
                                                <span class="badge_1">{{__('common.yes')}}</span>
                                            @else
                                                <span class="badge_4">{{__('common.no')}}</span>
                                            @endif
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <h3>{{__('common.business_information')}}</h3>
                                <table class="table table-borderless customer_view">
                                    <tr>
                                        <td class="first_row_width">{{ __('common.owner_name') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->business_owner_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.address_1') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->business_address1 }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.address_2') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->business_address2 }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.country') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->country->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.state') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->state->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.city') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->city->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.postcode') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->business_postcode }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.registration_number') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->business_registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.business_document') }}</td>
                                        <td>: <span class="ml-1"></span>
                                            @if (@$user->SellerBusinessInformation->business_document != null)
                                                <a href="{{ asset(asset_path($user->SellerBusinessInformation->business_document)) }}" target="_blank" download> Click on it.</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.tin') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBusinessInformation->business_seller_tin }}</td>
                                    </tr>
                                    @if (file_exists(base_path().'/Modules/GST/'))
                                        @if (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax")
                                        <tr>
                                            <td class="first_row_width">{{ __('gst.gst_claimed') }}</td>
                                            <td>: <span class="ml-1"></span>
                                                @if (@$user->SellerBusinessInformation->claim_gst == 1)
                                                    <i class="ti-check"></i><span class="ml-1"></span>{{ __('common.yes') }}
                                                @else
                                                    <i class="ti-close"></i><span class="ml-1"></span>{{ __('common.no') }}
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
                                    @endif

                                </table>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <h3>{{__('common.payment_information')}}</h3>
                                <table class="table table-borderless customer_view">
                                    <tr>
                                        <td class="first_row_width">{{ __('common.payment_type') }}</td>
                                        <td>: <span class="ml-1"></span>
                                            @if (@$user->SellerBankAccount->payment == 1)
                                                {{ __('common.cash_payment') }}
                                            @elseif (@$user->SellerBankAccount->payment == 2)
                                                {{ __('common.bank_payment') }}
                                            @else
                                                {{ __('common.n/a') }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.bank_title') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBankAccount->bank_title }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.account_number') }}</td>
                                        <td>: <span class="ml-1"></span>{{ getNumberTranslate(@$user->SellerBankAccount->bank_account_number) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.bank_name') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBankAccount->bank_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.branch_name') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBankAccount->bank_branch_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.routing_number') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBankAccount->bank_routing_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.ibn') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerBankAccount->bank_ibn }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.bank_cheque') }}</td>
                                        <td>: <span class="ml-1"></span>
                                            @if (@$user->SellerBankAccount->bank_cheque != null)
                                                <a href="{{ asset(asset_path($user->SellerBankAccount->bank_cheque)) }}" target="_blank" download> Click on it.</a>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <h3>{{__('common.warehouse_address')}}</h3>
                                <table class="table table-borderless customer_view">
                                    <tr>
                                        <td class="first_row_width">{{ __('common.name') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->warehouse_name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.address_1') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->warehouse_address }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.country') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->country->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.state') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->state->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.city') }}</td>
                                        <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->city->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.postcode') }}</td>
                                        <td>: <span class="ml-1"></span>{{ getNumberTranslate(@$user->SellerWarehouseAddress->warehouse_postcode) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="first_row_width">{{ __('common.phone') }}</td>
                                        <td>: <span class="ml-1"></span>{{ getNumberTranslate(@$user->SellerWarehouseAddress->warehouse_phone) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <h3>{{__('common.return_address')}}</h3>
                                @if (@$user->SellerReturnAddress->same_as_warehouse)
                                    <table class="table table-borderless customer_view">
                                        <tr>
                                            <td class="first_row_width">{{ __('common.name') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->warehouse_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.address_1') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->warehouse_address }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.country') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->country->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.state') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->state->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.city') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerWarehouseAddress->city->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.postcode') }}</td>
                                            <td>: <span class="ml-1"></span>{{ getNumberTranslate(@$user->SellerWarehouseAddress->warehouse_postcode) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.phone') }}</td>
                                            <td>: <span class="ml-1"></span>{{ getNumberTranslate(@$user->SellerWarehouseAddress->warehouse_phone) }}</td>
                                        </tr>
                                    </table>
                                @else
                                    <table class="table table-borderless customer_view">
                                        <tr>
                                            <td class="first_row_width">{{ __('common.name') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerReturnAddress->return_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.address_1') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerReturnAddress->return_address }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.country') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerReturnAddress->country->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.state') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerReturnAddress->state->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.city') }}</td>
                                            <td>: <span class="ml-1"></span>{{ @$user->SellerReturnAddress->city->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.postcode') }}</td>
                                            <td>: <span class="ml-1"></span>{{ getNumberTranslate(@$user->SellerReturnAddress->return_postcode) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="first_row_width">{{ __('common.phone') }}</td>
                                            <td>: <span class="ml-1"></span>{{ getNumberTranslate(@$user->SellerReturnAddress->return_phone) }}</td>
                                        </tr>
                                    </table>
                                @endif
                            </div>
                        </div>
                        @if ($user->description)
                            <hr>
                                <div class="row">
                                    <div class="col">
                                        <label class="primary_input_label" for="">
                                            @php
                                                echo $user->description;
                                            @endphp
                                        </label>
                                    </div>
                                </div>
                            <hr>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div class="white_box_50px box_shadow_white">
                        <div class="col-lg-12 student-details">
                            <ul class="nav nav-tabs tab_column mb-50" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#Order" role="tab" data-toggle="tab">{{ __('common.orders') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#Wallet" role="tab" data-toggle="tab">{{ __('common.wallet_histories') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#Products" role="tab" data-toggle="tab">{{ __('common.products') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#OrderRepand" role="tab" data-toggle="tab">{{ __('common.order_refund') }}</a>
                                </li>
                            </ul>
                            <div class="tab-content pt-30">

                                <div role="tabpanel" class="tab-pane fade show active" id="Order">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">

                                                    <div class="">
                                                        <table class="table" id="orderTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{__('common.sl')}}</th>
                                                                    <th width="10%">{{__('common.date')}}</th>
                                                                    <th>{{__('common.order_id')}}</th>
                                                                    <th>{{__('common.email')}}</th>
                                                                    <th>{{__('seller.no_of_product')}}</th>
                                                                    <th>{{__('common.total_amount')}}</th>
                                                                    <th>{{__('seller.order_status')}}</th>
                                                                    <th>{{__('seller.delivery_status')}}</th>
                                                                    <th>{{__('common.order_action')}}</th>
                                                                    
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="Wallet">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">

                                                    <div class="">
                                                        <table class="table" id="walletHistoryTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{__('common.sl')}}</th>
                                                                    <th>{{__('common.date')}}</th>
                                                                    <th>{{__('common.user')}}</th>
                                                                    <th>{{__('seller.txn_id')}}</th>
                                                                    <th>{{__('common.amount')}}</th>
                                                                    <th>{{__('common.type')}}</th>
                                                                    <th>{{__('common.payment_method')}}</th>
                                                                    <th>{{__('seller.approval')}}</th>                                                                
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="Products">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">

                                                    <div class="">
                                                        <table class="table" id="productTable">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">{{ __('common.sl') }}</th>
                                                                    <th scope="col">{{ __('common.name') }}</th>
                                                                    <th scope="col">{{ __('product.category') }}</th>
                                                                    <th scope="col">{{ __('product.brand') }}</th>
                                                                    <th scope="col">{{ __('product.logo') }}</th>
                                                                    <th scope="col">{{ __('product.stock') }}</th>
                                                                    <th scope="col">{{ __('common.status') }}</th>
                                                                    <th scope="col">{{ __('common.action') }}</th>
                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="OrderRepand">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="QA_section QA_section_heading_custom check_box_table">
                                                <div class="QA_table ">

                                                    <div class="">
                                                        <table class="table" id="ordersRefundTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>{{__('common.sl')}}</th>
                                                                    <th width="10%">{{__('common.date')}}</th>
                                                                    <th>{{__('common.OrderRefund_id')}}</th>
                                                                    <th>{{__('common.email')}}</th>                                                                   
                                                                    <th>{{__('common.total_amount')}}</th>
                                                                    <th>{{__('seller.order_refund_status')}}</th>
                                                                    <th>{{__('seller.is_refunded')}}</th>
                                                                    <th>{{__('seller.OrderRefund_action')}}</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
     <div class="modal fade admin-query" id="Commission_Edit">
        <div class="modal-dialog modal_800px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('common.edit_commission_rate') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="ti-close "></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.update_commission') }}" method="POST" id="commission_EditForm">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="seller_account_id" id="seller_account_id" value="">
                            <div class="col-xl-12">
                                <div class="primary_input mb-25">
                                    <label class="primary_input_label" for="">{{ __('common.rate') }} *</label>
                                    <input name="rate" class="primary_input_field rate" placeholder="{{ __('common.rate') }}" type="text" value="" required>
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="d-flex justify-content-center pt_20">
                                    <button type="submit" class="primary_btn_2" id="save_button_parent"><i class="ti-check"></i>{{ __('common.update') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div id="product_detail_view_div"></div>
    <div id="refund_order_detail_div"></div>
    <div id="order_detail_div"></div>
@include('multivendor::merchants.confirm_modal')
@endsection
@push("scripts")
    <script type="text/javascript">

        (function($){
            "use strict";

            $(document).ready(function(){

                $(document).on('click', '.view_product_btn', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    seller_product_show(id);
                });

                $(document).on('click', '.update_active_status', function(event){

                    $("#pre-loader").removeClass('d-none');
                    let status = 0;
                    if($(this).prop('checked')){
                            status = 1;
                    }
                    else{
                        status = 0;
                    }
                    let id = $(this).data('id');
                    var formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('id', id);
                    formData.append('status', status);

                    $.ajax({
                        url: "{{ route('seller.product.update-status') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }
                    });

                });

                $(document).on('click', '.edit_commission', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    let rate = $(this).data('rate');
                    $('#Commission_Edit').modal('show');
                    $('#seller_account_id').val(id);
                    $('.rate').val(rate);
                });

                $(document).on('click', '.trusted_seller_btn', function(event){
                    event.preventDefault();
                    let url = $(this).data('value');
                    confirm_modal(url);
                });

                let baseUrl = $('#url').val();
                let orderUrl = baseUrl + '/admin/merchant/' +"{{$user->id}}" + '/details/get-orders';
                $('#orderTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: orderUrl
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                         { data: 'DT_RowIndex', name: 'id',render:function(data){
                            return numbertrans(data)
                        }},
                        { data: 'date', name: 'date' },
                        { data: 'order_number', name: 'order_number' },
                        { data: 'email', name: 'email' },
                        { data: 'no_of_product', name: 'no_of_product' },
                        { data: 'total_amount', name: 'total_amount' },
                        { data: 'order_status', name: 'order_status' },
                        { data: 'delivery_status', name: 'delivery_status' },
                        { data: 'order_action', name: 'order_action' }

                    ],

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#header_title").text(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            pageSize: 'A4',
                            margin: [0, 0, 0, 0],
                            alignment: 'center',
                            header: true,

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#header_title").text(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                        visible: false
                    }],
                    responsive: true,
                });

                let walletUrl = baseUrl + '/admin/merchant/' +"{{$user->id}}" + '/details/get-wallet-history';
                $('#walletHistoryTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: walletUrl
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                         { data: 'DT_RowIndex', name: 'id',render:function(data){
                            return numbertrans(data)
                        }},
                        { data: 'date', name: 'date' },
                        { data: 'user', name: 'user' },
                        { data: 'txn_id', name: 'txn_id' },
                        { data: 'amount', name: 'amount' },
                        { data: 'type', name: 'type' },
                        { data: 'payment_method', name: 'payment_method' },
                        { data: 'approval', name: 'approval' }

                    ],

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#header_title").text(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            pageSize: 'A4',
                            margin: [0, 0, 0, 0],
                            alignment: 'center',
                            header: true,

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#header_title").text(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                        visible: false
                    }],
                    responsive: true,
                });

                let productUrl = baseUrl + '/admin/merchant/' +"{{$user->id}}" + '/details/get-product';
                $('#productTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: productUrl
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                         { data: 'DT_RowIndex', name: 'id',render:function(data){
                            return numbertrans(data)
                        }},
                        { data: 'product_name', name: 'product_name' },
                        { data: 'category', name: 'category' },
                        { data: 'brand', name: 'brand' },
                        { data: 'logo', name: 'logo' },
                        { data: 'stock', name: 'stock' },
                        { data: 'status', name: 'status' },
                        { data: 'action', name: 'action' }

                    ],

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#header_title").text(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            pageSize: 'A4',
                            margin: [0, 0, 0, 0],
                            alignment: 'center',
                            header: true,

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#header_title").text(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                        visible: false
                    }],
                    responsive: true,
                });
                let orderRefundUrl = baseUrl + '/admin/merchant/' +"{{$user->id}}" + '/details/get-order-refund';
                $('#ordersRefundTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: orderRefundUrl
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'id',render:function(data){
                            return numbertrans(data)
                        }},
                        { data: 'date', name: 'date' },
                        { data: 'refund_number', name: 'refund_number' },
                        { data: 'email', name: 'email' },                      
                        { data: 'refund_total_amount', name: 'refund_total_amount' },
                        { data: 'order_refund_status', name: 'order_refund_status' },
                        { data: 'is_refunded', name: 'is_refunded' },
                        { data: 'refund_action', name: 'refund_action' }

                    ],

                    bLengthChange: false,
                    "bDestroy": true,
                    language: {
                        search: "<i class='ti-search'></i>",
                        searchPlaceholder: trans('common.quick_search'),
                        paginate: {
                            next: "<i class='ti-arrow-right'></i>",
                            previous: "<i class='ti-arrow-left'></i>"
                        }
                    },
                    dom: 'Bfrtip',
                    buttons: [{
                            extend: 'copyHtml5',
                            text: '<i class="fa fa-files-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'Copy',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            title: $("#header_title").text(),
                            margin: [10, 10, 10, 0],
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },

                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-text-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fa fa-file-pdf-o"></i>',
                            title: $("#header_title").text(),
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: ':visible',
                                columns: ':not(:last-child)',
                            },
                            pageSize: 'A4',
                            margin: [0, 0, 0, 0],
                            alignment: 'center',
                            header: true,

                        },
                        {
                            extend: 'print',
                            text: '<i class="fa fa-print"></i>',
                            titleAttr: 'Print',
                            title: $("#header_title").text(),
                            exportOptions: {
                                columns: ':not(:last-child)',
                            }
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fa fa-columns"></i>',
                            postfixButtons: ['colvisRestore']
                        }
                    ],
                    columnDefs: [{
                        visible: false
                    }],
                    responsive: true,
                });
               
              

                function seller_product_show(el){
                    $('#pre-loader').removeClass('d-none');
                    $.post('{{ route('seller.admin_product.show') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                        $('#product_detail_view_div').empty();
                        $('#product_detail_view_div').html(data);
                        $('#productDetails').modal('show');
                        $('#pre-loader').addClass('d-none');
                    });
                }
                $(document).on('click', '.refund_Order', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    refund_order_details(id);
                });
                function refund_order_details(el){
                    $('#pre-loader').removeClass('d-none');
                    $.post('{{ route('refund.merchant_refund_show_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                        $('#refund_order_detail_div').html(data);
                        $('#refundOrder').modal('show');
                        $('#pre-loader').addClass('d-none');
                    });
                }
                $(document).on('click', '.order_all_details', function(event){
                    event.preventDefault();
                    let id = $(this).data('id');
                    order_detail(id);
                });
                function order_detail(el){
                    $('#pre-loader').removeClass('d-none');
                    $.post('{{ route('order.merchant_order_show_details') }}', {_token:'{{ csrf_token() }}', id:el}, function(data){
                        $('#order_detail_div').html(data);
                        $('#orderdetails').modal('show');
                        $('#pre-loader').addClass('d-none');
                    });
                }
              
            });
        })(jQuery);

    </script>
@endpush
