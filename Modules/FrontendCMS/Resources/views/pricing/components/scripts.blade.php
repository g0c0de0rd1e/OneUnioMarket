@push('scripts')
<script>
    (function($){
        "use strict";
        $(document).ready(function() {
            $(document).on('submit', '#item_delete_form', function(event) {
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_item_id').val());
                let id = $('#delete_item_id').val();
                $('#deleteItemModal').modal('hide');
                $.ajax({
                    url: "{{ route('admin.pricing.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response.TableData);
                        toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                        $('#pre-loader').addClass('d-none');
                        $.ajax({
                            url: "{{ route('admin.pricing.create') }}",
                            type: "GET",
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('#formHtml').empty();
                                $('#formHtml').html(response.editHtml);
                                $('#monthly_cost').addClass(
                                    'has-content');
                                $('#yearly_cost').addClass(
                                    'has-content');
                                $('#team_size').addClass(
                                    'has-content');
                                $('#stock_limit').addClass(
                                    'has-content');
                                $('#commission').addClass(
                                    'has-content');
                                $('#transaction_fee')
                                    .addClass('has-content');
                                $('#pre-loader').addClass('d-none');
                            },
                            error: function(response) {
                                if(response.responseJSON.error){
                                    toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                                    $('#pre-loader').addClass('d-none');
                                    return false;
                                }
                                toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                                $('#pre-loader').addClass('d-none');
                            }
                        });
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                        }
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });


            $("#add_pricing_form").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                console.log(formData);
                $("#create_btn").prop('disabled', true);
                $('#create_btn').text('{{ __("common.submitting") }}');
                $('#pre-loader').removeClass('d-none');
                removeValidationError();

                $.ajax({
                    url: "{{ route('admin.pricing.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        location.reload();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            $(document).on('submit','#pricing_edit_form', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                console.log(formData);
                $("#create_btn").prop('disabled', true);
                $('#create_btn').text('{{ __("common.submitting") }}');
                $('#pre-loader').removeClass('d-none');
                removeValidationError();

                $.ajax({
                    url: "{{ route('admin.pricing.update') }}",
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        location.reload();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });


            $(document).on('change', '.statusChange', function(event){
                let item = $(this).data('value');
                $('#pre-loader').removeClass('d-none');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', item.id);
                formData.append('status', item.status);
                $.ajax({
                    url: "{{ route('admin.pricing.status') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response.TableData);
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                        }
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });

            $(document).on('click', '.show_pricing', function(event){
                event.preventDefault();
                let item = $(this).data('value');
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
                $('#show_monthly_cost').text(numbertrans(item.monthly_cost));
                $('#show_yearly_cost').text(numbertrans(item.yearly_cost));
                $('#show_team_size').text(numbertrans(item.team_size));
                $('#show_stock_limit').text(numbertrans(item.stock_limit));
                $("#show_category_limit").text(numbertrans(item.category_limit));
                $('#show_transaction_fee').text(numbertrans(item.transaction_fee));
            });

            $(document).on('click', '.delete_pricing', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#delete_item_id').val(id);
                $('#deleteItemModal').modal('show');
            });



            $(document).on('click', '.edit_pricing', function(event){
                event.preventDefault();
                let item = $(this).data('value');
                $('#pre-loader').removeClass('d-none');
                let baseUrl = $('#url').val();
                let url = baseUrl + '/admin/pricing/' + item.id + '/edit'
                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#formHtml').empty();
                        $('#formHtml').append(response.editHtml);
                        $('#pre-loader').addClass('d-none');
                        $('#item_id').val(item.id);
                        @if(isModuleActive('FrontendMultiLang'))
                        if (item.name != null) {
                            $.each(item.name, function( key, value ) {
                                $('#name_'+key).val(value);
                            });
                        }else{
                            $('#name_{{auth()->user()->lang_code}}').val(item.translateName);
                        }
                        @else
                        $('#name').val(item.name).addClass('has-content');
                        @endif

                        $('#team_size').val(item.team_size).addClass('has-content');
                        $("#plan_price").val(item.plan_price).addClass('has-content');
                        $("#expire_in").val(item.expire_in).addClass('has-content');
                        $('#stock_limit').val(item.stock_limit).addClass('has-content');
                        $('#category_limit').val(item.category_limit).addClass('has-content');
                        $('#transaction_fee').val(item.transaction_fee).addClass('has-content');
                        $('#best_for').val(item.best_for).addClass('has-content');
                        $("#old_image").val(item.image).addClass('has-content');
                        $("#discount").val(item.discount).addClass('has-content');

                        if(item.discount_type == 1)
                        {
                            $("#discount_type_percentage").prop("checked", true);
                        }else{
                            $("#discount_type_amount").prop("checked", true);
                        }

                        if (item.status == 1) {
                            $('#pricing_edit_form #status_active').prop("checked", true);
                            $('#pricing_edit_form #status_inactive').prop("checked", false);
                        } else {
                            $('#pricing_edit_form #status_active').prop("checked", false);
                            $('#pricing_edit_form #status_inactive').prop("checked", true);
                        }
                        if(item.is_featured == 1){
                            $('#pricing_edit_form #is_featured').prop("checked", true);
                        }else{
                            $('#pricing_edit_form #is_featured').prop("checked", false);
                        }

                        $("#gst_id").val(item.gst_tax_id).change();
                    },
                    error: function(response) {
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    }
                });
            });
            function showValidationErrors(formType, errors) {
                @if(isModuleActive('FrontendMultiLang'))
                    $(formType + ' #error_name_{{auth()->user()->lang_code}}').text(errors['name.{{auth()->user()->lang_code}}']);
                @else
                    $(formType + ' #error_name').text(errors.name);
                @endif
                $(formType + ' #error_monthly_cost').text(errors.monthly_cost);
                $(formType + ' #error_yearly_cost').text(errors.yearly_cost);
                $(formType + ' #error_team_size').text(errors.team_size);
                $(formType + ' #error_stock_limit').text(errors.stock_limit);
                $(formType + ' #error_commission').text(errors.commission);
                $(formType + ' #error_transaction_fee').text(errors.transaction_fee);
                $(formType + ' #error_buyer_fee').text(errors.buyer_fee);
                $(formType + ' #status_error').text(errors.status);
            }
            function resetAfterChange(tableData) {
                $('#item_table').empty();
                $('#item_table').html(tableData);
                CRMTableThreeReactive();
            }
            function resetForm() {
                $('#add_pricing_form')[0].reset();
            }
            function removeValidationError(){
                @if(isModuleActive('FrontendMultiLang'))
                $('#error_name_{{auth()->user()->lang_code}}').text('');
                @else
                $('#error_name').text('');
                @endif
                $('#error_monthly_cost').text('');
                $('#error_yearly_cost').text('');
                $('#error_team_size').text('');
                $('#error_stock_limit').text('');
                $('#error_commission').text('');
                $('#error_transaction_fee').text('');
                $('#error_buyer_fee').text('');
                $('#status_error').text('');
            }
        });
    })(jQuery);
</script>
@endpush
