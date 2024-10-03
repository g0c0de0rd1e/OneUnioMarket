@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/giftcard/css/style.css'))}}" />

@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    @if (permissionCheck('admin.giftcard.delete'))
        @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.gift_card')])
    @endif
    @if (permissionCheck('admin.giftcard.digital_gift_delete'))
        @include('backEnd.partials._deleteModalForAjax',['item_name' => __('common.digital_gift_card'),'form_id' =>
        'digital_gift_card_delete_form','modal_id' => 'digital_gift_card_delete_modal', 'delete_item_id' => 'digital_gift_card_id'])
    @endif
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-12 mb-20">
                <div class="box_header_right">
                    <div class="float-lg-right float-none pos_tab_btn justify-content-end">
                        <ul class="nav nav_list" role="tablist">
                            @if (permissionCheck('admin.giftcard.get-data'))
                            <li class="nav-item">
                                <a class="nav-link active show" href="#digitalgiftcard" role="tab" data-toggle="tab" id="digital_gift_card" aria-selected="true">{{ __('common.gift_card') }} {{__('common.list')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#order_processing_data" role="tab" data-toggle="tab" id="gift_card" aria-selected="true">{{ __('product.redeem_card') }} {{__('common.list')}}</a>
                            </li>

                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
                <div class="white_box_30px mb_30">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active show" id="digitalgiftcard">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.gift_card') }} {{__('common.list')}}</h3>
                                    @if (permissionCheck('admin.giftcard.create'))
                                    <ul class="d-flex">
                                        <li><a href="{{ route('admin.giftcard.create') }}" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="ti-plus"></i>{{ __('common.add_new') }}</a></li>
                                        @if (permissionCheck('admin.giftcard.bulk_gift_card_upload_page'))
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('admin.giftcard.bulk_gift_card_upload_page') }}"><i class="ti-plus"></i>{{ __('product.bulk_upload') }}</a></li>
                                        @endif
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <!-- table-responsive -->
                                    <div class="" id="product_sku_div">
                                        @include('giftcard::giftcard.components._giftcard_list')
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="order_processing_data">
                            <div class="box_header common_table_header ">
                                <div class="main-title d-md-flex">
                                    <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.redeem_card') }} {{__('common.list')}}</h3>
                                    @if (permissionCheck('admin.giftcard.create'))
                                    <ul class="d-flex">
                                        <li><a href="{{ route('admin.giftcard.create',['type' => 1]) }}" class="primary-btn radius_30px mr-10 fix-gr-bg"><i class="ti-plus"></i>{{ __('common.add_new') }}</a></li>
                                        @if (permissionCheck('admin.giftcard.bulk_gift_card_upload_page'))
                                        <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('admin.giftcard.bulk_gift_card_upload_page') }}"><i class="ti-plus"></i>{{ __('product.bulk_upload') }}</a></li>
                                        @endif
                                    </ul>
                                    @endif
                                </div>
                            </div>
                            <div class="QA_section QA_section_heading_custom check_box_table">
                                <div class="QA_table">
                                    <div id="item_table">
                                        @include('giftcard::giftcard.components._list')
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
@include('giftcard::giftcard.components._giftcard_scripts')
@include('giftcard::giftcard.components._scripts')
