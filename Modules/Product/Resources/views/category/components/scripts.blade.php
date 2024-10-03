@push('scripts')
<script src="{{asset(asset_path('backend/vendors/js/icon-picker.js'))}}"></script>
<script>
    (function($){
        "use strict";
        let module_check = $('#module_check').val();
        $(document).ready(function() {
            dynamicSelect2WithAjax("#parent_id", "{{url('/products/get-category-data')}}", "GET");
            $(document).on('mouseover', 'body', function(){
                $('#icon').iconpicker({
                    animation:true
                });
            });
            if(module_check == 'false'){
                var columnData = [
                    { data: 'DT_RowIndex', name: 'id',render:function(data){
                        return numbertrans(data)
                    }},
                    { data: 'name', name: 'name' },
                    { data: 'parent_category', name: 'parent_category' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' }
                ]
            }else{
                var columnData = [
                    { data: 'DT_RowIndex', name: 'id',render:function(data){
                        return numbertrans(data)
                    }},
                    { data: 'name', name: 'name' },
                    { data: 'parent_category', name: 'parent_category' },
                    { data: 'commision_rate', name: 'commision_rate' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action' }
                ]
            }
            disabledProductDataTable();
            function disabledProductDataTable(){
                $('#categoryDataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    stateSave: true,
                    "ajax": ( {
                        url: "{{route('product.categories.get-data')}}"
                    }),
                    "initComplete":function(json){
                    },
                    columns: columnData,
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
            $(document).on('click','.in_sub_cat', function(event){
                $(".in_parent_div").toggleClass('d-none');
            });
            @if(isModuleActive('FrontendMultiLang'))
            $(document).on('keyup', '#name{{auth()->user()->lang_code}}', function(event){
                processSlug($('#name{{auth()->user()->lang_code}}').val(), '#slug');
            });
            @else
            $(document).on('keyup', '#name', function(event){
                processSlug($('#name').val(), '#slug');
            });
            @endif
            $(document).on('submit', '#add_category_form',  function(event) {
                event.preventDefault();
                $("#pre-loader").removeClass('d-none');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                if($('#sub_cat').is(":checked") && $('#parent_id').val() == null){
                    $('#error_parent_id').text('The parent category field is required.');
                    $('#pre-loader').addClass('d-none');
                    return false;
                }else{
                    $('#error_parent_id').text('');
                }
                resetValidationErrors();
                $.ajax({
                    url: "{{ route('product.category.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response.TableData)
                        $('#formHtml').html(response.createForm);
                        toastr.success("{{__('common.created_successfully')}}", "{{__('common.success')}}");
                        $("#pre-loader").addClass('d-none');
                        dynamicSelect2WithAjax("#parent_id", "{{url('/products/get-category-data')}}", "GET");
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        showValidationErrors('#add_category_form', response.responseJSON.errors);
                        $("#create_btn").prop('disabled', false);
                        $('#create_btn').text('{{ __("common.save") }}');
                        dynamicSelect2WithAjax("#parent_id", "{{url('/products/get-category-data')}}", "GET");
                        $("#pre-loader").addClass('d-none');
                    }
                });
            });
            $(document).on('click', '.edit_category', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $("#pre-loader").removeClass('d-none');
                let base_url = $('#url').val();
                let url = base_url + '/products/category/' + id + '/edit'
                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#formHtml').html(response.editHtml);
                        Amaz.uploader.previewGenerate();
                        $("#pre-loader").addClass('d-none');
                        dynamicSelect2WithAjax("#parent_id", "{{url('/products/get-category-data')}}", "GET",'#item_id');
                    },
                    error: function(response) {
                        toastr.error("{{__('common.error_message')}}", "{{__('common.error')}}");
                        $("#pre-loader").addClass('d-none');
                    }
                });
            });
            $(document).on('change', '#category_image', function(event){
                getFileName($('#category_image').val(),'#image');
                imageChangeWithFile($(this)[0],'#MetaImgDiv');
            });
            $(document).on('submit', '#category_edit_form', function(event) {
                event.preventDefault();
                $("#pre-loader").removeClass('d-none');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('product.category.update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response.TableData)
                        toastr.success("{{__('common.updated_successfully')}}", "{{__('common.success')}}");
                        $('#formHtml').html(response.createForm);
                        $("#pre-loader").addClass('d-none');
                        dynamicSelect2WithAjax("#parent_id", "{{url('/products/get-category-data')}}", "GET");
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        showValidationErrors('#category_edit_form', response.responseJSON.errors);
                        $("#pre-loader").addClass('d-none');
                    }
                });
            });
            $(document).on('click', '.delete_brand', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#delete_item_id').val(id);
                $('#deleteItemModal').modal('show');
            });
            $(document).on('submit', '#item_delete_form', function(event) {
                event.preventDefault();
                $('#deleteItemModal').modal('hide');
                $("#pre-loader").removeClass('d-none');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_item_id').val());
                let id = $('#delete_item_id').val();
                $.ajax({
                    url: "{{ route('product.category.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if(response.parent_msg){
                            toastr.warning(response.parent_msg);
                            $("#pre-loader").addClass('d-none');
                        }
                        else{
                            resetAfterChange(response.TableData);
                            toastr.success("{{__('common.deleted_successfully')}}", "{{__('common.success')}}");
                            $("#pre-loader").addClass('d-none');
                            $('#formHtml').html(response.createForm);
                            dynamicSelect2WithAjax("#parent_id", "{{url('/products/get-category-data')}}", "GET");
                        }
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        $("#pre-loader").addClass('d-none');
                    }
                });
            });
            $(document).on('click', '.show_category', function(event){
                event.preventDefault();
                let item = $(this).data('value');
                showDetails(item);
            });
            function showDetails(item) {
                $('#item_show').modal('show');
                @if(isModuleActive('FrontendMultiLang'))
                if (item.name != null) {
                    var cat_name = '';
                    $.each(item.name, function( key, value ) {
                        if(key == '{{auth()->user()->lang_code}}'){
                            cat_name = value;
                        }
                    });
                    $('#show_name').text(cat_name);
                }else{
                    $('#show_name').text(item.translateName);
                }
                @else
                $("#show_name").text(item.name);
                @endif
                $('#show_slug').text(item.slug);
                $('#show_searchable').text(item.searchable? '{{__("common.active")}}':'{{__("common.inactive")}}');
                var parent_cat = '';
                if (item.parent_category) {
                    @if(isModuleActive('FrontendMultiLang'))
                    if (item.parent_category.name != null) {
                        var cat_name = '';
                        $.each(item.parent_category.name, function( key, value ) {
                            if(key == '{{auth()->user()->lang_code}}'){
                                cat_name = value;
                            }
                        });
                        parent_cat = cat_name;
                    }else{
                        parent_cat = item.parent_category.translateName;
                    }
                    @else
                        parent_cat = item.parent_category.name;
                    @endif
                }
                $('#show_parent_category').text(parent_cat ? parent_cat : '{{__("common.parent")}}');
                $('#google_product_category_id').text(item.google_product_category_id? item.google_product_category_id : '{{getNumberTranslate(0)}}');
                $('#commission_rate').text(item.commission_rate? numbertrans(item.commission_rate): '{{getNumberTranslate(0)}}');
                $('#show_icon').text(item.icon);
                $('#show_status').text(item.status? '{{__("common.active")}}':'{{__("common.inactive")}}');
                if(item.category_image.image) {
                    $('#single_image_div').removeClass('d-none');
                    var imag= item.category_image.image;
                    if(imag.includes('amazonaws.com')){
                        var image_path = imag;
                    }else if(imag.includes('digitaloceanspaces.com')){
                        var image_path = imag;
                    }else if(imag.includes('drive.google.com')){
                        var image_path = imag;
                    }else if(imag.includes('wasabisys.com')){
                        var image_path = imag;
                    }else if(imag.includes('backblazeb2.com')){
                        var image_path = imag;
                    }else if(imag.includes('dropboxusercontent.com')){
                        var image_path = imag;
                    }else if(imag.includes('storage.googleapis.com')){
                        var image_path = imag;
                    }else if(imag.includes('contabostorage.com')){
                        var image_path = imag;
                    }else if(imag.includes('b-cdn.net')){
                        var image_path = imag;
                    }else{
                    var image_path = "{{asset(asset_path(''))}}" + "/"+imag;
                    }
                    document.getElementById('view_image').src=image_path;
                }else{
                    $('#single_image_div').addClass('d-none');
                }
            }
            function showValidationErrors(formType, errors) {
            @if(isModuleActive('FrontendMultiLang'))
                $(formType +' #error_name_{{auth()->user()->lang_code}}').text(errors['name.{{auth()->user()->lang_code}}']);
            @else
                $(formType +' #error_name').text(errors.name);
            @endif
                $(formType +' #error_slug').text(errors.slug);
                $(formType +' #error_searchable').text(errors.searchable);
                $(formType +' #error_icon').text(errors.icon);
                $(formType +' #error_status').text(errors.status);
                $(formType +' #error_image').text(errors.image);
                $(formType +' #error_google_product_category_id').text(errors.image);
            }
            function resetValidationErrors(){
                @if(isModuleActive('FrontendMultiLang'))
                $('#error_name_{{auth()->user()->lang_code}}').text('');
                @else
                $('#error_name').text('');
                @endif
                $('#error_slug').text('');
                $('#error_searchable').text('');
                $('#error_icon').text('');
                $('#error_status').text('');
                $('#error_image').text('');
                $('#error_google_product_category_id').text('');
            }
            function resetAfterChange(tableData) {
                $('#item_table').empty();
                $('#item_table').html(tableData);
                disabledProductDataTable();
            }

            $(document).on('change','#sub_cat',function(){
                if($("#sub_cat").prop("checked") == true){
                    $("#icon_selector").addClass('d-none');
                }else{
                    $("#icon_selector").removeClass('d-none');
                }
            });


        });


    })(jQuery);
</script>
@endpush
