@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('seller.my_staff')}}</h3>
                            @if (permissionCheck('seller.sub_seller.create'))
                                <ul class="d-flex">
                                    <li><a class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('seller.sub_seller.create') }}"><i class="ti-plus"></i>{{ __('seller.add_new_staff') }}</a></li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <table class="table Crm_table_active3">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.sl') }}</th>
                                            <th>{{ __('seller.joined_date') }}</th>
                                            <th>{{ __('common.name') }}</th>
                                            <th>{{ __('common.email') }}</th>
                                            <th>{{ __('common.phone') }}</th>
                                            <th>{{ __('common.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sub_sellers as $key => $seller)
                                            <tr>
                                                <td>{{ getNumberTranslate($key+1) }}</td>
                                                <td>{{ dateConvert($seller->created_at) }}</td>
                                                <td>{{ @$seller->sub_seller->first_name }}</td>
                                                <td>{{ @$seller->sub_seller->email }}</td>
                                                <td>{{ getNumberTranslate(@$seller->phone ?? 'X') }}</td>
                                                <td>
                                                    <div class="dropdown CRM_dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false"> {{__('common.select')}}
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                                            @if (permissionCheck('seller.sub_seller.edit'))
                                                                <a href="{{route('seller.sub_seller.edit',$seller->sub_seller->id)}}" class="dropdown-item" type="button">{{ __('common.edit') }}</a>
                                                            @endif
                                                            @if (permissionCheck('seller.sub_seller.access_permission'))
                                                                <a href="{{route('seller.sub_seller.access_permission',$seller->sub_seller->id)}}" class="dropdown-item" type="button">{{ __('common.access_permission') }}</a>
                                                            @endif
                                                            @if (permissionCheck('seller.sub_seller.delete'))
                                                                <a class="dropdown-item delete_staff" data-value="{{route('seller.sub_seller.delete', $seller->sub_seller->id)}}">{{__('common.delete')}}</a>
                                                            @endif
                                                            @if (!permissionCheck('seller.sub_seller.edit') && permissionCheck('seller.sub_seller.access_permission') && permissionCheck('seller.sub_seller.delete'))
                                                                {{ __('common.access_denied') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
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
    </section>
@include('backEnd.partials.delete_modal')
@endsection
@push('scripts')
    <script>
        (function($){
            "use strict";
            $(document).ready(function(){
                $(document).on('click', '.delete_staff', function(event){
                    event.preventDefault();
                    let url = $(this).data('value');
                    confirm_modal(url);
                });
            });
        })(jQuery);
    </script>
@endpush
