@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor mb-25">
        @if (isset($subscription))
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex w-100 justify-content-between">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('seller.subscription_info') }}</h3>
                            @if(permissionCheck('seller.subscription_payment_select'))
                            <a id="create_new_seller_btn" class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{route('seller.subscription_payment_select',encrypt($subscription->id))}}"><i class="ti-plus"></i>{{ __('seller.advance_renew_subscription') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="white-box single-summery">
                        <div class="d-block">
                            <h3>{{ __('seller.subscription_title') }}</h3>
                             <h1 class="gradient-color2 total_orders">{{ $subscription->pricing->name }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="white-box single-summery">
                        <div class="d-block">
                            <h3>{{ __('common.price') }}</h3>
                             <h1 class="gradient-color2 total_orders">
                                 @if($sellerAccount->subscription_type == "monthly")
                                 {{ single_price($subscription->pricing->monthly_cost)}} {{__('common.monthly')}}
                                 @else
                                    {{single_price($subscription->pricing->yearly_cost) }} {{__('common.yearly')}}
                                 @endif
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="white-box single-summery">
                        <div class="d-block">
                            <h3>{{ __('seller.last_payment_date') }}</h3>
                            
                             <h1 class="gradient-color2 total_orders">
                                @if($subscription->is_paid == 1 && $subscription->last_payment_date != null)
                                    {{dateConvert(Carbon\Carbon::createFromFormat('Y-m-d', $subscription->last_payment_date))}}
                                @else
                                    {{ __('common.pay_first_for_subcription') }}
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="white-box single-summery">
                        <div class="d-block">
                            <h3>{{ __('seller.expire_date') }}</h3>
                            
                             <h1 class="gradient-color2 total_orders">
                                @php
                                    $current_date = strtotime(date("Y-m-d"));
                                    $expiry_date = strtotime($subscription->expiry_date);
                                @endphp
                                @if($subscription->is_paid == 1 && $subscription->expiry_date != null && $current_date < $expiry_date)
                                    {{ date(app('general_setting')->dateFormat->format, strtotime(Carbon\Carbon::createFromFormat('Y-m-d', $subscription->expiry_date))) }}
                                @elseif($subscription->expiry_date != null && $current_date > $expiry_date)
                                    <span class="text-danger">{{__('seller.already_expired')}}</span>
                                @endif
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('seller.subscription_payments') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="table-responsive">
                                <table class="table Crm_table_active2">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.date') }}</th>
                                            <th>{{ __('common.name') }}</th>
                                            <th>{{ __('common.txn') }}</th>
                                            <th>{{ __('common.payment_type') }}</th>
                                            <th>{{ __('common.total_amount') }}</th>
                                            <th>{{ __('common.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($subscription))
                                            @foreach ($subscription_payment as $key => $payment)
                                                <tr>
                                                    <td class="nowrap">{{ dateConvert($payment->created_at) }}</td>
                                                    <td>{{ $payment->title }}</td>
                                                    <td>{{ $payment->subscription_payment->txn_id }}</td>
                                                    <td>
                                                        {{ $payment->subscription_payment->commission_type }}
                                                    </td>
                                                    <td>
                                                        {{ single_price($payment->amount) }}
                                                    </td>
                                                    <td>
                                                        @if($payment->subscription_payment->is_approved)
                                                        <span class="badge_1">{{__('common.approved')}}</span>
                                                        @else
                                                            <span class="badge_4">{{__('common.pending')}}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
