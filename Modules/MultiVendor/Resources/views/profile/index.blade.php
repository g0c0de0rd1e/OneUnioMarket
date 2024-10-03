@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/multivendor/css/profile.css'))}}" />
@endsection
@section('mainContent')
    @php
        if(\Session::has('profile_tab')){
            $profileTab = \Session::get('profile_tab');
        }else{
            $profileTab = 'tab_1';
        }
    @endphp

    <section class="mb-40 student-details">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-title custom_title_profile">
                        <h3 class="mb-30">{{__('common.seller')}} {{__('common.profile')}}</h3>
                    </div>

                    <ul class="nav nav-tabs justify-content-end mt-sm-md-20 mb-30" role="tablist">
                        <li class="nav-item">
                            <a class="link_change_btn nav-link {{ $profileTab == 'tab_1'?'active':'' }} show" href="#sellerAccount" role="tab" data-toggle="tab" id="tab_1"
                               aria-selected="true">{{__('common.seller')}} {{__('common.account')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="link_change_btn nav-link {{ $profileTab == 'tab_2'?'active':'' }} show" href="#businessInformation" role="tab" data-toggle="tab" id="tab_2"
                               aria-selected="false">{{__('seller.business_information')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="link_change_btn nav-link {{ $profileTab == 'tab_3'?'active':'' }} show" href="#bankAccount" role="tab" data-toggle="tab" id="tab_3"
                               aria-selected="false">{{__('common.bank')}} {{__('common.account')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="link_change_btn nav-link {{ $profileTab == 'tab_4'?'active':'' }} show" href="#warehouseAddress" role="tab" data-toggle="tab" id="tab_4"
                               aria-selected="true">{{__('common.warehouse_address')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="link_change_btn nav-link {{ $profileTab == 'tab_5'?'active':'' }} show" href="#returnAddress" role="tab" data-toggle="tab" id="tab_5"
                               aria-selected="true">{{__('common.return_address')}}</a>
                        </li>

                    </ul>
                </div>
                <div class="col-lg-12 ml-15 mr-15">

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade {{ $profileTab == 'tab_1'?'active show':'' }} " id="sellerAccount">
                            @include('multivendor::profile.components.seller_account')
                        </div>


                        <div role="tabpanel" class="tab-pane {{ $profileTab == 'tab_2'?'active show':'' }} fade" id="businessInformation">

                            @include('multivendor::profile.components.business_information')

                        </div>


                        <div role="tabpanel" class="tab-pane {{ $profileTab == 'tab_3'?'active show':'' }} fade" id="bankAccount">
                            @include('multivendor::profile.components.bank_account')

                        </div>


                        <div role="tabpanel" class="tab-pane {{ $profileTab == 'tab_4'?'active show':'' }} fade" id="warehouseAddress">
                            @include('multivendor::profile.components.warehouse_address')

                        </div>


                        <div role="tabpanel" class="tab-pane {{ $profileTab == 'tab_5'?'active show':'' }} fade" id="returnAddress">
                            @include('multivendor::profile.components.return_address')

                        </div>


                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@include('multivendor::profile.components.scripts')

