@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('common.seller')}} {{__('common.list')}}</h3>
                            @if (permissionCheck('admin.merchants_create'))
                                <ul class="d-flex">
                                    <li><a id="create_new_seller_btn" class="primary-btn radius_30px mr-10 fix-gr-bg" href="{{ route('admin.merchants_create') }}"><i class="ti-plus"></i>{{ __('common.add_new_seller') }}</a></li>
                                </ul>
                            @endif
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
                                            <th>{{ __('common.name') }}</th>
                                            <th>{{ __('common.email') }}</th>
                                            <th>{{ __('common.phone') }}</th>
                                            <th>{{ __('common.commission_type') }}</th>
                                            @if (file_exists(base_path().'/Modules/GST/'))
                                                @if (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax")
                                                    <th>{{ __('gst.gst_or_flat_tax_claim_by_seller') }}</th>
                                                @endif
                                            @endif
                                            <th>{{ __('common.is_trusted') }}</th>
                                            <th>{{ __('common.shop_name') }}</th>
                                            <th>{{ __('common.wallet_balance') }}</th>
                                            <th>{{ __('common.total_orders') }}</th>
                                            <th>{{ __('common.action') }}</th>
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
    @if (file_exists(base_path().'/Modules/GST/'))
        @if (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax")
            <input type="hidden" name="gst_module_enable"  id="gst_module_enable" value="1">
        @endif
    @else
        <input type="hidden" name="gst_module_enable"  id="gst_module_enable" value="0">
    @endif

@include('multivendor::merchants.confirm_modal')
@include('multivendor::merchants.seller_change_password_modal')
@endsection
@push('scripts')
    <script type="text/javascript">

        (function($){
            "use strict";
            $(document).ready(function(){

                $(document).on('click', '.trust_seller_change', function(event){
                    let url = $(this).data('value');
                    confirm_modal(url);
                });

                $(document).on('click', '.seller_change_password', function(event){
                    $('.sPr').val('');
                    $('.sellerErrorS').text('');
                    let url = $(this).data('value');
                    confirm_modal_seller_password(url);
                });

                $(document).on('click','.sellerChangePassword', function(e){
                    e.preventDefault();
                    $('#pre-loader').removeClass('d-none');

                    var formElement = $('#selPassSt').serializeArray();
                    var formData = new FormData();
                    formElement.forEach(element => {
                        formData.append(element.name, element.value);
                    });
                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        url: "{{ route('admin.change-seller-password-store') }}",
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        success: function(response) {
                            $('.error').text('');
                            $('#seller_change_password_modal').modal('hide');
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');

                        },
                        error: function(response) {
                            if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }else{
                                $('.error').text('');
                                $('.sellerErrorS').text(response.responseJSON.errors.seller_new_password);
                                $('#pre-loader').addClass('d-none');
                            }

                        }
                    });
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
                    $.post('{{ route('customer.update_active_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                        if(data == 1){

                            tr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        }
                        else{
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }
                        $("#pre-loader").addClass('d-none');
                    })

                    .fail(function(response) {
                            if(response.responseJSON.error){
                                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                    $('#pre-loader').addClass('d-none');
                                    return false;
                                }

                            });

                });

                let columns =[];
                if ($("#gst_module_enable").val() == 1) {
                    columns = [
                                { data: 'DT_RowIndex', name: 'id',render:function(data){
                                    return numbertrans(data)
                                }},
                                { data: 'name', name: 'user.first_name'},
                                { data: 'email', name: 'user.email' },
                                { data: 'phone', name: 'user.username' },
                                { data: 'commission_type', name: 'commission_type' },
                                { data: 'gst', name: 'gst' },
                                { data: 'is_trusted', name: 'is_trusted' },
                                { data: 'shop_name', name: 'shop_name' },
                                { data: 'wallet_balance', name: 'wallet_balance' },
                                { data: 'total_orders', name: 'total_orders' },
                                { data: 'action', name: 'action' }
                            ];
                }else {
                    columns = [
                                { data: 'DT_RowIndex', name: 'id',render:function(data){
                                    return numbertrans(data)
                                }},
                                { data: 'name', name: 'user.first_name' },
                                { data: 'email', name: 'user.email' },
                                { data: 'phone', name: 'user.username' },
                                { data: 'commission_type', name: 'commission_type' },
                                { data: 'is_trusted', name: 'is_trusted' },
                                { data: 'shop_name', name: 'shop_name' },
                                { data: 'wallet_balance', name: 'wallet_balance' },
                                { data: 'total_orders', name: 'total_orders' },
                                { data: 'action', name: 'action' }
                            ];
                }
                $('#sellerTable').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    "ajax": ( {
                        url: "{{ route('admin.merchants_list.get-data') }}"
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

                $(document).on('change', ".ac", function(){
                    if($(this).is(':checked') == true){
                        var status = 1;
                    }
                    else{
                        var status = 0;
                    }
                    $.post('{{ route('admin.merchants_gst_status_update') }}', {_token:'{{ csrf_token() }}', id:this.value, status:status}, function(data){
                        if(data == 1){
                            toastr.success("{{__('gst.gst_or_flat_rate_claimed_by_seller')}}","{{__('common.success')}}");
                        }
                        else{
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        }
                        $("#pre-loader").addClass('d-none');
                    })

                    .fail(function(response) {
                            if(response.responseJSON.error){
                                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                    $('#pre-loader').addClass('d-none');
                                    return false;
                                }

                            });
                });



            });
        })(jQuery);


    </script>
@endpush
