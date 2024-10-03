@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('seller.category_list_with_commission')}}</h3>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table Crm_table_active3 text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">{{ __('common.sl') }}</th>
                                                <th scope="col">{{ __('common.name') }}</th>
                                                <th scope="col">{{ __('product.parent_category') }}</th>
                                                <th scope="col">{{ __('common.commission_rate') }}</th>
                                                <th scope="col">{{ __('common.status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($CategoryList as $key => $item)
                                            <tr>
                                                <th>{{ getNumberTranslate($key + 1) }}</th>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->parentCategory? $item->parentCategory->name:'Parent'}}</td>
                                                <td>{{ $item->commission_rate }} %</td>
                                                <td class="pending">{{ showStatus($item->status) }}</td>
                                            </tr>

                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
           </div>
        </div>
    </section>
@endsection
