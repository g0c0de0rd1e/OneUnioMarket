@extends('backEnd.master')

@section('styles')
<link rel="stylesheet" href="{{ asset(asset_path('backend/vendors/css/icon-picker.css')) }}" />

<link rel="stylesheet" href="{{asset(asset_path('modules/multivendor/css/setting.css'))}}" />


@endsection

@section('mainContent')
@php
if(\Session::has('seller_setting_tab')){
$settingTab = \Session::get('seller_setting_tab');
}else{
$settingTab = 'seller_logo';
}
@endphp
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="box_header">
                    <div class="main-title d-flex">
                        <h3 class="mb-0 mr-30">{{ __('common.seller') }} {{ __('general_settings.settings') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="">
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- myTab  -->
                            <div class="white_box_30px mb_30">
                                <ul class="nav custom_nav" id="myTab" role="tablist">
                                    <li class="nav-item setting_tab" data-value="seller_logo">
                                        <a class="nav-link {{$settingTab == 'seller_logo'?'active':''}} show"
                                            data-toggle="tab" href="#Logo" role="tab"
                                            aria-selected="true">{{ __('common.seller') }} {{ __('common.logo') }}</a>
                                    </li>

                                    <li class="nav-item setting_tab" data-value="social_link">
                                        <a class="nav-link {{$settingTab == 'social_link'?'active':''}} show"
                                            data-toggle="tab" href="#Social_link" role="tab"
                                            aria-selected="true">{{ __('general_settings.social_link') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <!-- tab-content  -->
                            <div class="tab-content " id="myTabContent">
                                <!-- Logo & Banner -->
                                <div class="tab-pane fade white_box_30px {{$settingTab == 'seller_logo'?'active show':''}}"
                                    id="Logo" role="tabpanel" aria-labelledby="Activation-tab">
                                    @include('multivendor::setting.components.logo_banner')
                                </div>

                                <!-- Social_link  -->
                                <div class="tab-pane fade white_box_30px {{$settingTab == 'social_link'?'active show':''}}"
                                    id="Social_link" role="tabpanel" aria-labelledby="SMS-tab">
                                    @include('multivendor::setting.components.social_link')
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
@endsection

@include('backEnd.partials._deleteModalForAjax',['item_name' => __('shipping.shipping_method'),'form_id' =>
'shipping_delete_form','modal_id' => 'shipping_delete_modal', 'delete_item_id' => 'shipping_delete_id'])


@include('multivendor::setting.components.scripts')
