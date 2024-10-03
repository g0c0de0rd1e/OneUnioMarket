@push('scripts')
    <script type="text/javascript">
        (function($){
            "use strict";
            var baseUrl = $('#app_base_url').val();
            $(document).ready(function () {
                $(document).on("submit", "#reasonForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    @if(isModuleActive('FrontendMultiLang'))
                        $('#reason_create_error_{{auth()->user()->lang_code}}').text('');
                    @else
                        $('#reason_create_error').text('');
                    @endif
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: "{{ route('refund.reasons_store') }}",
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}")
                            $("#reasonForm").trigger("reset");
                            refund_list();
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
                                    $('#reason_create_error_{{auth()->user()->lang_code}}').text(response.responseJSON.errors['reason.{{auth()->user()->lang_code}}']);
                                @else
                                    $('#reason_create_error').text(response.responseJSON.errors.reason);
                                @endif
                            }
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });
                $(document).on("submit", "#reasonEditForm", function (event) {
                    event.preventDefault();
                    $('#pre-loader').removeClass('d-none');
                    let id = $(".edit_id").val();
                    @if(isModuleActive('FrontendMultiLang'))
                        $('#edit_reason_error_{{auth()->user()->lang_code}}').text('');
                    @else
                        $('#edit_reason_error').text('');
                    @endif
                    let formData = $(this).serializeArray();
                    $.ajax({
                        url: baseUrl + "/refund/refund-reason-update/" + id,
                        data: formData,
                        headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')},
                        type: "POST",
                        dataType: "JSON",
                        success: function (response) {
                            $("#reasonEditForm").trigger("reset");
                            $('.edit_div').hide();
                            toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                            $('.create_div').show();
                            $('#reason_create_error').html('');
                            refund_list();
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
                                $('#edit_reason_error_{{auth()->user()->lang_code}}').text(response.responseJSON.errors['reason.{{auth()->user()->lang_code}}']);
                            @else
                                $('#edit_reason_error').text(response.responseJSON.errors.reason);
                            @endif
                            }
                            toastr.error(response.responseJSON.errors,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });
                $(document).on('click', '.delete-item', function(event){
                    event.preventDefault();
                    let url = $(this).data('value');
                    confirm_modal(url);
                })
                $("#refund_list").on("click", ".edit_reason", function () {
                    let item = $(this).data("value");
                    $('.edit_div').show();
                    $('.edit_div').removeClass("d-none");
                    $('.create_div').hide();
                    @if(isModuleActive('FrontendMultiLang'))
                    if (item.reason != null) {
                        $.each(item.reason, function( key, value ) {
                            $("#reason"+key).val(value);
                        });
                    }else{
                        $("#reason{{auth()->user()->lang_code}}").val(item.translateReason);
                    }
                    @else
                    $(".reason").val(item.reason);
                    @endif
                    $(".edit_id").val(item.id);
                });
                function refund_list() {
                    $('#pre-loader').removeClass('d-none');
                    $.ajax({
                        url: "{{route("refund.index")}}",
                        type: "GET",
                        dataType: "HTML",
                        success: function (response) {
                            $("#refund_list").html(response);
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
