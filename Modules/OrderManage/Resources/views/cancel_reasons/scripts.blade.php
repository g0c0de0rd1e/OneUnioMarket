@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            $(document).ready(function () {
                var baseUrl = $('#app_base_url').val();
                $(document).on("submit", "#processForm", function (event) {
                    event.preventDefault();
                @if(isModuleActive('FrontendMultiLang'))
                    $('#name_create_error_{{auth()->user()->lang_code}}').text('');
                    $('#description_create_error_{{auth()->user()->lang_code}}').text('');
                @else
                    $('#name_create_error').text('');
                    $('#description_create_error').text('');
                @endif
                    $('#pre-loader').removeClass('d-none');
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: "{{ route('order_manage.cancel_reason_store') }}",
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}")
                            $("#processForm").trigger("reset");
                            refund_process_list();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function (response) {

                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            if (response) {
                                @if(isModuleActive('FrontendMultiLang'))
                                    $('#name_create_error_{{auth()->user()->lang_code}}').text(response.responseJSON.errors['name.{{auth()->user()->lang_code}}']);
                                    $('#description_create_error_{{auth()->user()->lang_code}}').text(response.responseJSON.errors['description.{{auth()->user()->lang_code}}']);
                                @else
                                    $('#name_create_error').text(response.responseJSON.errors.name);
                                    $('#description_create_error').text(response.responseJSON.errors.description);
                                @endif
                            }
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });
                //
                $(document).on("submit", "#processEditForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    @if(isModuleActive('FrontendMultiLang'))
                        $('#edit_name_error_{{auth()->user()->lang_code}}').text('');
                        $('#edit_description_error_{{auth()->user()->lang_code}}').text('');
                    @else
                        $('#edit_name_error').text('');
                        $('#edit_description_error').text('');
                    @endif
                    let id = $(".edit_id").val();
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: baseUrl + "/ordermanage/cancel-reason-update/" + id,
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#processEditForm").trigger("reset");
                            $('.edit_div').hide();
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                            $('.create_div').show();
                            $('#name_create_error').html('');
                            $('#description_create_error').html('');
                            refund_process_list();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function (response) {

                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                            if (response) {
                            @if(isModuleActive('FrontendMultiLang'))
                                $('#edit_name_error_{{auth()->user()->lang_code}}').text(response.responseJSON.errors['name.{{auth()->user()->lang_code}}']);
                                $('#edit_description_error_{{auth()->user()->lang_code}}').text(response.responseJSON.errors['description.{{auth()->user()->lang_code}}']);
                            @else
                                $('#edit_name_error').text(response.responseJSON.errors.name);
                                $('#edit_description_error').text(response.responseJSON.errors.description);
                            @endif
                            }
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });

                $("#refund_process_list").on("click", ".edit_reason", function () {
                    let item = $(this).data("value");
                    $('.edit_div').show();
                    $('.edit_div').removeClass("d-none");
                    $('.create_div').hide();
                    @if(isModuleActive('FrontendMultiLang'))
                    if (item.name != null) {
                        $.each(item.name, function( key, value ) {
                            $("#name"+key).val(value);
                        });
                    }else{
                        $("#name{{auth()->user()->lang_code}}").val(item.translateName);
                    }
                    if (item.description != null) {
                        $.each(item.description, function( key, value ) {
                            $("#description"+key).val(value);
                        });
                    }else{
                        $("#description{{auth()->user()->lang_code}}").val(item.TranslateDescription);
                    }
                    @else
                    $(".name").val(item.name);
                    $(".description").val(item.description);
                    @endif
                    $(".edit_id").val(item.id);
                });
                $(document).on('click', '.delete_item', function(event){
                    event.preventDefault();
                    let url = $(this).data('value');
                    confirm_modal(url);
                });
                function refund_process_list() {
                    $('#pre-loader').removeClass('d-none');
                    $.ajax({
                        url: "{{route("order_manage.cancel_reason_list")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#refund_process_list").html(response);
                            CRMTableThreeReactive();
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function (error) {
                        }
                    });
                }
            });
        })(jQuery);
    </script>
@endpush
