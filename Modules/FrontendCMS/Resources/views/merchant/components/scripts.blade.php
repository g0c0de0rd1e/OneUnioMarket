@push('scripts')
<script>
    (function($){
        "use strict";
        $(document).ready(function() {
            $(document).on('submit', '#formData', function(event) {
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                resetValidationErrors();
                $("#mainSubmit").prop('disabled', true);
                $('#mainSubmit').text('{{ __("common.updating") }}');
                var formElement = $(this).serializeArray()
                var formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                $.ajax({
                    url: "{{ route('frontendcms.merchant-content.update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                        $('#mainSubmit').text('{{__("common.update")}}');
                        $("#mainSubmit").prop('disabled', false);
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $("#mainSubmit").prop('disabled', false);
                        $('#mainSubmit').text('{{__("common.update")}}');
                        showValidationErrors('#formData', response.responseJSON.errors);
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
            @if(isModuleActive('FrontendMultiLang'))
            $(document).on('keyup', '#mainTitle{{auth()->user()->lang_code}}', function(event){
                processSlug($(this).val(), '#mainSlug{{auth()->user()->lang_code}}');
            });
            @else
            $(document).on('keyup', '#mainTitle', function(event){
                processSlug($(this).val(), '#mainSlug');
            });
            @endif
            function showValidationErrors(formType, errors) {
                @if(isModuleActive('FrontendMultiLang'))
                $(formType + ' #error_mainTitle_{{auth()->user()->lang_code}}').text(errors['mainTitle.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_subTitle_{{auth()->user()->lang_code}}').text(errors['subTitle.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_mainDescription_{{auth()->user()->lang_code}}').text(errors['Maindescription.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_slug_{{auth()->user()->lang_code}}').text(errors['slug.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_pricing_{{auth()->user()->lang_code}}').text(errors['pricing.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_benifitTitle_{{auth()->user()->lang_code}}').text(errors['benifitTitle.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_benifitDescription_{{auth()->user()->lang_code}}').text(errors['benifitDescription.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_howitworkTitle_{{auth()->user()->lang_code}}').text(errors['howitworkTitle.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_howitworkDescription_{{auth()->user()->lang_code}}').text(errors['howitworkDescription.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_pricingTitle_{{auth()->user()->lang_code}}').text(errors['pricingTitle.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_pricingDescription_{{auth()->user()->lang_code}}').text(errors['pricingDescription.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_queryTitle_{{auth()->user()->lang_code}}').text(errors['queryTitle.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_queryDescription_{{auth()->user()->lang_code}}').text(errors['queryDescription.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_faqTitle_{{auth()->user()->lang_code}}').text(errors['faqTitle.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_faqDescription_{{auth()->user()->lang_code}}').text(errors['faqDescription.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_sellerRegistrationTitle_{{auth()->user()->lang_code}}').text(errors['sellerRegistrationTitle.{{auth()->user()->lang_code}}']);
                $(formType + ' #error_sellerRegistrationDescription_{{auth()->user()->lang_code}}').text(errors['sellerRegistrationDescription.{{auth()->user()->lang_code}}']);
                @else
                $(formType + ' #error_mainTitle').text(errors.mainTitle);
                $(formType + ' #error_subTitle').text(errors.subTitle);
                $(formType + ' #error_mainDescription').text(errors.Maindescription);
                $(formType + ' #error_slug').text(errors.slug);
                $(formType + ' #error_pricing').text(errors.pricing);
                $(formType + ' #error_benifitTitle').text(errors.benifitTitle);
                $(formType + ' #error_benifitDescription').text(errors.benifitDescription);
                $(formType + ' #error_howitworkTitle').text(errors.howitworkTitle);
                $(formType + ' #error_howitworkDescription').text(errors.howitworkDescription);
                $(formType + ' #error_pricingTitle').text(errors.pricingTitle);
                $(formType + ' #error_pricingDescription').text(errors.pricingDescription);
                $(formType + ' #error_queryTitle').text(errors.queryTitle);
                $(formType + ' #error_queryDescription').text(errors.queryDescription);
                $(formType + ' #error_faqTitle').text(errors.faqTitle);
                $(formType + ' #error_faqDescription').text(errors.faqDescription);
                $(formType + ' #error_sellerRegistrationTitle').text(errors.sellerRegistrationTitle);
                $(formType + ' #error_sellerRegistrationDescription').text(errors.sellerRegistrationDescription);
                @endif
            }
            function resetValidationErrors() {
                @if(isModuleActive('FrontendMultiLang'))
                $('#formData' + ' #error_mainTitle_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_subTitle_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_mainDescription_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_slug_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_pricing_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_benifitTitle_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_benifitDescription_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_howitworkTitle_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_howitworkDescription_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_pricingTitle_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_pricingDescription_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_queryTitle_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_queryDescription_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_faqTitle_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_faqDescription_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_sellerRegistrationTitle_{{auth()->user()->lang_code}}').text('');
                $('#formData' + ' #error_sellerRegistrationDescription_{{auth()->user()->lang_code}}').text('');
                @else
                $('#formData' + ' #error_mainTitle').text('');
                $('#formData' + ' #error_subTitle').text('');
                $('#formData' + ' #error_mainDescription').text('');
                $('#formData' + ' #error_slug').text('');
                $('#formData' + ' #error_pricing').text('');
                $('#formData' + ' #error_benifitTitle').text('');
                $('#formData' + ' #error_benifitDescription').text('');
                $('#formData' + ' #error_howitworkTitle').text('');
                $('#formData' + ' #error_howitworkDescription').text('');
                $('#formData' + ' #error_pricingTitle').text('');
                $('#formData' + ' #error_pricingDescription').text('');
                $('#formData' + ' #error_queryTitle').text('');
                $('#formData' + ' #error_queryDescription').text('');
                $('#formData' + ' #error_faqTitle').text('');
                $('#formData' + ' #error_faqDescription').text('');
                $('#formData' + ' #error_sellerRegistrationTitle').text('');
                $('#formData' + ' #error_sellerRegistrationDescription').text('');
                @endif
            }
            function showValidationErrorsForBenefit(formType, errors) {
                @if(isModuleActive('FrontendMultiLang'))
                $(formType + ' #create_error_title_{{auth()->user()->lang_code}}').text(errors['title.{{auth()->user()->lang_code}}']);
                $(formType + ' #create_error_description_{{auth()->user()->lang_code}}').text(errors['description.{{auth()->user()->lang_code}}']);
                @else
                $(formType + ' #create_error_title').text(errors.title);
                $(formType + ' #create_error_description').text(errors.description);
                @endif
                $(formType + ' #create_error_slug').text(errors.slug);
                $(formType + ' #create_error_image').text(errors.image);
            }
            function resetForm() {
                $('form')[1].reset();
            }
            @if(isModuleActive('FrontendMultiLang'))
                $(document).on('click', '.marchent_content', function(event){
                    var lang = $(this).data('id');
                    $('.default_lang').removeClass('active show');
                    $('#benefitelement'+lang).addClass('active show');
                    $('#howitworkelement'+lang).addClass('active show');
                    $('#pricingelement'+lang).addClass('active show');
                    $('#sellerRegistrationelement'+lang).addClass('active show');
                    $('#faqelement'+lang).addClass('active show');
                    $('#queryelement'+lang).addClass('active show');
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
@include('frontendcms::merchant.benefit.scripts')
@include('frontendcms::merchant.working_process.scripts')
@include('frontendcms::merchant.faq.scripts')
@endpush
