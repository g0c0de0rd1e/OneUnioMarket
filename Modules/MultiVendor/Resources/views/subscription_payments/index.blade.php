@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('seller.subscription_payment') }}  {{ __('common.list') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">

                            <div class="">
                                <table class="table" id="sellerTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.sl') }}</th>
                                            <th>{{ __('common.seller') }}</th>
                                            <th>{{ __('common.subscription') }}</th>
                                            <th>{{ __('common.type') }}</th>
                                            <th>{{ __('common.date') }}</th>
                                            <th>{{ __('common.method') }}</th>
                                            <th>{{ __('common.amount') }}</th>
                                            <th>{{ __('common.txn_id') }}</th>
                                            <th>{{ __('common.is_approve') }}</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('multivendor::merchants.confirm_modal')
@endsection
@push('scripts')
    <script type="text/javascript">

        (function($){
            "use strict";
            $(document).on('change','.is_approve', function(){
                if($(this).is(':checked') == true){
                    var status = 1;
                }
                else{
                    var status = 0;
                }
                $("#pre-loader").removeClass('d-none');
                $.post('{{ route("admin.subscription_payment_approve") }}', {_token:'{{ csrf_token() }}', id:this.value, status:status}, function(data){
                    if(data == 1){
                        toastr.success("{{__('common.successful')}}","{{__('common.success')}}")
                        $("#pre-loader").addClass('d-none');
                    }
                    else{
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");

                        $("#pre-loader").addClass('d-none');
                    }
                })

                .fail(function(response) {
                    if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }

                    });
            });
            $(document).ready(function(){
                let columns =[];
                columns = [
                            { data: 'DT_RowIndex', name: 'id',render:function(data){
                                return numbertrans(data)
                            }},
                            { data: 'name', name: 'name' },
                            { data: 'subcription', name: 'subcription' },
                            { data: 'type', name: 'type' },
                            { data: 'date', name: 'date' },
                            { data: 'payment_method', name: 'payment_method' },
                            { data: 'amount', name: 'amount' },
                            { data: 'txn_id', name: 'txn_id' },
                            { data: 'is_approved', name: 'is_approved' },
                        ];
                $('#sellerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    "ajax": ( {
                        url: "{{ route('admin.subscription_payment_dtbl') }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: columns,

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

            });
        })(jQuery);


    </script>
@endpush
