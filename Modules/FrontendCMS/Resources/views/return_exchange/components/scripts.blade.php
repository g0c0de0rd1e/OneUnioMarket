
@push('scripts')

<script>

    (function($){

        "use strict";

        var baseUrl = $('#app_base_url').val();

        $(document).ready(function() {
            $(document).on('submit', '#formData',function(event){
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name,element.value);
                });
                formData.append('_token',"{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('frontendcms.return-exchange.update') }}",
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        resetValidationError('#formData');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        
                        showValidationErrors('#formData',response.responseJSON.errors);
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
            function showValidationErrors(formType, errors){
                @if(isModuleActive('FrontendMultiLang'))
                $(formType +' #error_mainTitle_{{auth()->user()->lang_code}}').text(errors['mainTitle.{{auth()->user()->lang_code}}']);
                $(formType +' #error_returnTitle_{{auth()->user()->lang_code}}').text(errors['returnTitle.{{auth()->user()->lang_code}}']);
                $(formType +' #error_exchangeTitle_{{auth()->user()->lang_code}}').text(errors['exchangeTitle.{{auth()->user()->lang_code}}']);
                $(formType +' #error_returnDescription_{{auth()->user()->lang_code}}').text(errors['returnDescription.{{auth()->user()->lang_code}}']);
                $(formType +' #error_exchangeDescription_{{auth()->user()->lang_code}}').text(errors['exchangeDescription.{{auth()->user()->lang_code}}']);
                @else
                $(formType +' #error_mainTitle').text(errors.mainTitle);
                $(formType +' #error_returnTitle').text(errors.returnTitle);
                $(formType +' #error_exchangeTitle').text(errors.exchangeTitle);
                $(formType +' #error_returnDescription').text(errors.returnDescription);
                $(formType +' #error_exchangeDescription').text(errors.exchangeDescription);
                @endif
            }
            function resetValidationError(formType){
                @if(isModuleActive('FrontendMultiLang'))
                $(formType +' #error_mainTitle_{{auth()->user()->lang_code}}').text('');
                $(formType +' #error_returnTitle_{{auth()->user()->lang_code}}').text('');
                $(formType +' #error_exchangeTitle_{{auth()->user()->lang_code}}').text('');
                $(formType +' #error_returnDescription_{{auth()->user()->lang_code}}').text('');
                $(formType +' #error_exchangeDescription_{{auth()->user()->lang_code}}').text('');
                @else
                $(formType +' #error_mainTitle').text('');
                $(formType +' #error_returnTitle').text('');
                $(formType +' #error_exchangeTitle').text('');
                $(formType +' #error_returnDescription').text('');
                $(formType +' #error_exchangeDescription').text('');
                @endif
            }
            @if(isModuleActive('FrontendMultiLang'))
            $(document).on('click', '.anchore_color', function(event){
                var lang = $(this).data('id');
                if (lang == "{{auth()->user()->lang_code}}") {
                    $('#default_lang_{{auth()->user()->lang_code}}').removeClass('d-none');
                }
            });
            if ("{{auth()->user()->lang_code}}") {  
                    $('#default_lang_{{auth()->user()->lang_code}}').removeClass('d-none');
            }
        @endif

        });
    })(jQuery);


</script>
@endpush
