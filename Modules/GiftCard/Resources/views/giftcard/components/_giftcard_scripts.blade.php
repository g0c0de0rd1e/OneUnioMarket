@push('scripts')
    <script>
        $(document).ready(function(){
            var digital_gift_card_id=1
            cardDataTable();
            function cardDataTable(){
                $('#digitalcardTable').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    "ajax": ( {
                        url: "{{ route('admin.giftcard.digital_gift_card') }}"
                    }),
                    "initComplete":function(json){

                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'id',render:function(data){
                            return numbertrans(data)
                        }},
                        { data: 'gift_name', name: 'name' },
                        { data: 'thumbnail_image_one', name: 'thumbnail_image_one',orderable:false,searchable:false },
                        { data: 'gift_card_value', name: 'gift_card_value',orderable:false },
                        { data: 'gift_selling_price', name: 'gift_selling_price',orderable:false },
                        { data: 'number_of_gift_card', name: 'number_of_gift_card',orderable:false,searchable:false },
                        { data: 'gift_selling_coupon', name: 'gift_selling_coupon',orderable:false,searchable:false  },
                        { data: 'status', name: 'status' },
                        { data: 'action_td', name: 'action',orderable:false,searchable:false }

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
            $(document).on('click', '.digital_gift_card_delete', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#digital_gift_card_delete_modal').modal('show');
               $('#digital_gift_card_id').val(id);
            });

            $(document).on('submit', '#digital_gift_card_delete_form', function(event) {
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                $('#digital_gift_card_delete_modal').modal('hide');
                let formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#digital_gift_card_id').val());
                $.ajax({
                    url: "{{ route('admin.giftcard.digital_gift_delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if(response.msg){
                            toastr.warning(response.msg);
                        }else {
                            reloadWithData(response);
                            toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                        }
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {

                        if(response.responseJSON.error){
                                toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                                return false;
                            }
                        toastr.error('{{__("common.error_message")}}')
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            function reloadWithData(response){
                $('#item_table').html(response);
                cardDataTable();
            }
        });
    </script>
@endpush
