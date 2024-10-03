@extends('backEnd.master')
@section('styles')
<style>
    .image_div{
        height: 85px;
        width: 85px;
        align-items: center;
        justify-content: center;
    }
    .image_div img{
        max-width: 80px;
        max-height: 80px;
    }
</style>
@endsection
@section('mainContent')
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="font_20 f_w_700 mb-0 ">{{__('amazy.Follow seller History')}}</h3>
                    </div>
                </div>
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <table id="follow_seller" class="table Crm_table_active3">
                            <thead>
                                <tr>
                                    <th>{{ __('common.sl') }}</th>
                                    <th>{{ __('common.name') }}</th>
                                    <th>{{ __('common.image') }}</th>
                                    <th>{{ __('order.No of Orders') }}</th>
                                    <th>{{ __('common.action') }}</th>
                                </tr>
                            </thead>                           
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";

            $(document).ready(function(){

                $(document).on('click', '.remove_follow', function(event){
                    $('#pre-loader').removeClass('d-none');
                    let customer_id = $(this).data('id');
                    let data = {
                        _token : "{{csrf_token()}}",
                        customer_id  : customer_id
                    }
                    $.post('{{route("seller.follower-remove")}}', data, function(response){
                        toastr.success("{{__('Foller removed successfully!')}}","{{__('common.success')}}");
                        location.reload();
                    }).fail(function(response) {
                    if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                    });

                });

                $('#follow_seller').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    "ajax": ( {
                        url: "{{ route('seller.seller_followers') }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                                { data: 'DT_RowIndex', name: 'id' },
                                { data: 'name', name: 'name' },
                                { data: 'image', name: 'image' },
                                { data: 'No of Orders', name: 'No of Orders' },
                                { data: 'action', name: 'action' },
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
            });
            

        })(jQuery);
    </script>
@endpush
