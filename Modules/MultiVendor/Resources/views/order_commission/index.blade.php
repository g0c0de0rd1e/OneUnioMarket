@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-3">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('Filter') }}</h3>
                        </div>
                    </div>
                    <div class="white_box_50px box_shadow_white pb-3">
                        <form class="" action="{{route('seller.order-commssion-for-admin')}}" method="GET">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for="">{{ __('common.type') }}</label>
                                        <select required class="primary_select mb-15" name="filter" id="filter">
                                            <option value="today">Today</option>
                                            <option value="week">This Week</option>
                                            <option value="month">This Month</option>
                                            <option value="year">This Year</option>
                                        </select>
                                        <span class="text-danger">{{$errors->first('seller_id')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="primary_input">
                                    <button type="submit" class="primary-btn fix-gr-bg" id="save_button_parent"><i
                                            class="ti-search"></i>{{ __('report.search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('Order commission for pay') }}</h3>
                        </div>
                    </div>
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <!-- table-responsive -->
                            <div class="">
                                <div id="item_list">
                                    <table class="table" id="paymentList">
                                        <thead>
                                        <tr>
                                            <th scope="col">{{__('common.sl')}}</th>
                                            <th scope="col">{{__('Payout date')}}</th>
                                            <th scope="col">{{__('Order ID')}}</th>
                                            <th scope="col">{{__('Order amount')}}</th>
                                            <th scope="col">{{__('Charges')}}</th>
                                            <th scope="col">{{__('Payment method')}}</th>
                                            <th scope="col">{{__('TXN ID')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                    
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
    <input type="hidden" name="app_base_url" id="app_base_url" value="{{ URL::to('/') }}">
    <div class="show_div">

    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            function getUrlVars()
            {
                var vars = [], hash;
                var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
                for(var i = 0; i < hashes.length; i++)
                {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                return vars;
            }
            getData();
            function getData(){
                var filter = getUrlVars()['filter'];
                $('#paymentList').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    "ajax": ( {
                        url: "{{ route('seller.order-commssion-for-admin-data') }}"+"?filter="+filter
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                                { data: 'DT_RowIndex', name: 'id' },
                                { data: 'payout_date', name: 'payout_date' },
                                { data: 'order_id', name: 'order_id' },
                                { data: 'order_amount', name: 'order_amount' },
                                { data: 'commision_amount', name: 'commision_amount' },
                                { data: 'payment_method', name: 'payment_method' },
                                { data: 'txn_id', name: 'txn_id' }
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
            }

        })(jQuery);
    </script>
@endpush
