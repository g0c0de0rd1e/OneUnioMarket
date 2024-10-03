@push('scripts')
<script type="text/javascript">
    (function($){
        "use strict";
         var baseUrl = $('#app_base_url').val();
        $(document).ready(function () {
            $(document).on("click", ".edit_item", function () {
                let id = $(this).data("value");
                $('#pre-loader').removeClass('d-none');
                $.ajax({
                    url: baseUrl + "/admin/seller-commisions/" + id + "/edit",
                    type: "GET",
                    success: function (response) {
                        $('#edit_page_modal').modal('show');
                        $('#pre-loader').addClass('d-none');
                        $(".edit_id").val(response.id);
                        @if(isModuleActive('FrontendMultiLang'))
                        if (response.name != null) {
                            $.each(response.name, function( key, value ) {
                                $('#name_'+key).val(value);
                            });
                        }else{
                            $('#name_{{auth()->user()->lang_code}}').val(response.translateName);
                        }
                        if (response.description != null) {
                            $.each(response.description, function( key, value ) {
                                $('#description_'+key).val(value);
                            });
                        }else{
                            $('#description_{{auth()->user()->lang_code}}').val(response.TranslateDescripton);
                        }
                        @else
                        $(".name").val(response.name);
                        $(".description").val(response.description);
                        @endif
                        $(".rate").val(response.rate);
                        if(response.status == 0){
                            $("#status_active").prop("checked", false);
                            $("#status_inactive").prop("checked", true);
                        }else{
                            $("#status_active").prop("checked", true);
                            $("#status_inactive").prop("checked", false);
                        }
                    },
                    error: function (error) {
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
            $(document).on("submit", "#itemEditForm", function (event) {
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                let id = $(".edit_id").val();
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: baseUrl + "/admin/seller-commisions/" + id + "/update",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType: "JSON",
                    success: function (response) {
                        $("#itemEditForm").trigger("reset");
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                        itemList();
                        $('#pre-loader').addClass('d-none');
                        $('#edit_name_error').text('');
                        $('#edit_rate_error').text('');
                        $('#edit_page_modal').modal('hide');
                    },
                    error: function (response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        showValidationErrors(response.responseJSON.errors);
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
            function showValidationErrors(formType, errors) {
            @if(isModuleActive('FrontendMultiLang'))
                $(' #error_name_{{auth()->user()->lang_code}}').text(errors['name.{{auth()->user()->lang_code}}']);
            @else
                $(' #error_name').text(errors.name);
            @endif
                $(' #rate_error').text(errors.rate);
            }
            function resetValidationErrors(){
                @if(isModuleActive('FrontendMultiLang'))
                $('#error_name_{{auth()->user()->lang_code}}').text('');
                @else
                $('#error_name').text('');
                @endif
                $('#rate_error').text('');
            }
            function itemList() {
                $.ajax({
                    url: "{{route("admin.seller_commission_item_index")}}",
                    type: "GET",
                    dataType: "HTML",
                    success: function (response) {
                        $("#item_list").html(response);
                        CRMTableThreeReactive();
                    },
                    error: function (error) {
                    }
                });
            }
        });
    })(jQuery);
</script>
@endpush
