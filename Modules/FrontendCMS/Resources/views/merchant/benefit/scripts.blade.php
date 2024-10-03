<script>
    (function($){
        "use strict";
        $(document).ready(function() {
            $('#item_create_form').on('submit', function(event) {
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                $("#create_benefit_btn").prop('disabled', true);
                $('#create_benefit_btn').text('{{ __("common.submitting") }}');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                let photo = $('#item_create_form_image')[0].files[0];
                formData.append('_token', "{{ csrf_token() }}");
                if (photo) {
                    formData.append('image', photo)
                }
                $.ajax({
                    url: "{{ route('frontendcms.benefit.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    async: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response.TableData);
                        resetValidationErrorsForBenefit('.item_create_form');
                        toastr.success("{{__('common.created_successfully')}}","{{__('common.success')}}");
                        $('#item_add').modal('hide');
                        $("#create_benefit_btn").prop('disabled', false);
                        $('#create_benefit_btn').text('{{ __("common.save") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                        showValidationErrorsForBenefit('.item_create_form', response.responseJSON.errors);
                        $("#create_benefit_btn").prop('disabled', false);
                        $('#create_benefit_btn').text('{{ __("common.save") }}');
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
            $('#item_edit_form').on('submit', function(event) {
                event.preventDefault();
                let formElement = $(this).serializeArray()
                $("#edit_benefit_btn").prop('disabled', true);
                $('#edit_benefit_btn').text('{{ __("common.updating") }}');
                $('#pre-loader').removeClass('d-none');
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                let photo = $('#item_edit_form_image')[0].files[0];
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#item_id').val());
                if (photo) {
                    formData.append('image', photo)
                }
                $.ajax({
                    url: "{{ route('frontendcms.benefit.update') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response.TableData)
                        toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}");
                        $('#item_edit').modal('hide');
                        $("#edit_benefit_btn").prop('disabled', false);
                        $('#edit_benefit_btn').text('{{ __("common.update") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        showValidationErrorsForBenefit('.item_edit_form', response.responseJSON
                            .errors);
                        $("#edit_benefit_btn").prop('disabled', false);
                        $('#edit_benefit_btn').text('{{ __("common.update") }}');
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
            $('#benefit_delete_form').on('submit', function(event) {
                event.preventDefault();
                $("#delete_benefit_btn").prop('disabled', true);
                $('#delete_benefit_btn').text('{{ __("common.deleting") }}');
                $('#pre-loader').removeClass('d-none');
                $('#deleteBenefitModal').modal('hide');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_benefit_id').val());
                let id = $('#delete_benefit_id').val();
                $.ajax({
                    url: "{{ route('frontendcms.benefit.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        resetAfterChange(response.TableData);
                        toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}");
                        $("#delete_benefit_btn").prop('disabled', false);
                        $('#delete_benefit_btn').text('{{ __("common.delete") }}');
                        $('#pre-loader').addClass('d-none');
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $("#delete_benefit_btn").prop('disabled', false);
                        $('#delete_benefit_btn').text('{{ __("common.delete") }}');
                        $('#pre-loader').addClass('d-none');
                    }
                });
            });
            $(document).on('change', '.benefit_image', function(event){
                let name_show_id = $(this).data('show_name_id');
                let img_show_id = $(this).data('img_id');
                getFileName($(this).val(), name_show_id);
                imageChangeWithFile($(this)[0], img_show_id);
            });
            $(document).on('click', '.add_benefit_modal', function(event){
                event.preventDefault();
                $('#item_add').modal('show');
            });
            $(document).on('click', '.edit_benefit', function(event){
                event.preventDefault();
                $('#item_edit').modal('show');
                let benefit = $(this).data('value');
                resetValidationErrorsForBenefit('.item_edit_form');
                resetFormBenefit();
                $('#item_id').val(benefit.id);
                @if(isModuleActive('FrontendMultiLang'))
                    if (benefit.title != null) {
                        $.each(benefit.title, function( key, value ) {
                            $('.item_edit_form #title'+key).val(value);
                        });
                    }else{
                        $(".item_edit_form #title{{auth()->user()->lang_code}}").val(benefit.translateName);
                    }
                    if (benefit.description != null) {
                        $.each(benefit.description, function( key, value ) {
                            $('.item_edit_form #description'+key).val(value);
                        });
                    }else{
                        $('.item_edit_form #description{{auth()->user()->lang_code}}').val(benefit.TranslateDescription);
                    }
                @else
                    $(".item_edit_form #title").val(benefit.title);
                    $('.item_edit_form #description').val(benefit.description);
                @endif
                $('.item_edit_form #slug').val(benefit.slug);
                if (benefit.status == 1) {
                    $('.item_edit_form #status_active').prop("checked", true);
                    $('.item_edit_form #status_inactive').prop("checked", false);
                } else {
                    $('.item_edit_form #status_active').prop("checked", false);
                    $('.item_edit_form #status_inactive').prop("checked", true);
                }
                if(benefit.image.includes('amazonaws.com')){
                    var benitfitImage = benefit.image;
                }else if(benefit.image.includes('digitaloceanspaces.com')){
                    var benitfitImage = benefit.image;
                }else if(benefit.image.includes('drive.google.com')){
                    var benitfitImage = benefit.image;
                }else if(benefit.image.includes('wasabisys.com')){
                    var benitfitImage = benefit.image;
                }else if(benefit.image.includes('backblazeb2.com')){
                    var benitfitImage = benefit.image;
                }else if(benefit.image.includes('dropboxusercontent.com')){
                    var benitfitImage = benefit.image;
                }else if(benefit.image.includes('storage.googleapis.com')){
                    var benitfitImage = benefit.image;
                }else if(benefit.image.includes('contabostorage.com')){
                    var benitfitImage = benefit.image;
                }else if(benefit.image.includes('b-cdn.net')){
                    var benitfitImage = benefit.image;
                }else{
                    var benitfitImage="{{asset(asset_path(''))}}" + "/"+benefit.image;
                }
                $('.item_edit_form #BenefitImgshow_item_edit_form').prop("src", benitfitImage);
            });
            $(document).on('click', '.delete_benefit', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#delete_benefit_id').val(id);
                $('#deleteBenefitModal').modal('show');
            });
            function resetFormBenefit(){
                $('#item_create_form')[0].reset();
                $('#item_edit_form')[0].reset();
                $('#cerate_img_div_for_benefit').html(
                    `<div class="primary_input mb-35">
                <label class="primary_input_label" for="">{{__('common.image')}}
                    <span class="text-danger">*</span><small
                        class="ml-1">(173x120)px</small> </label>
                <div class="primary_file_uploader">
                    <input class="primary-input" type="text" id="benifit_item_create_form"
                        placeholder="{{__('common.browse_image_file')}}" readonly="">
                    <button class="" type="button">
                    <label class="primary-btn small fix-gr-bg" for="item_create_form_image"><span
                                class="ripple rippleEffect benefit_img_custom_style"
                                ></span>{{__('common.browse')}}</label>
                        <input name="image" type="file" class="d-none benefit_image" data-show_name_id="#benifit_item_create_form" data-img_id="#BenefitImgshow_item_create_form" id="item_create_form_image">
                    </button>
                    <span class="text-danger" id="create_error_image"></span><br>
                    <img id="BenefitImgshow_item_create_form" class="benefit_img_show"
                     src="{{showImage('backend/img/default.png')}}" alt="">
                </div>
            </div>
                    `
                );
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
            function resetAfterChange(tableData) {
                $('#benefit_table').empty();
                $('#benefit_table').html(tableData);
                resetFormBenefit();
            }
             function resetValidationErrorsForBenefit(formType) {
                @if(isModuleActive('FrontendMultiLang'))
                $(formType + ' #create_error_title_{{auth()->user()->lang_code}}').text('');
                $(formType + ' #create_error_description_{{auth()->user()->lang_code}}').text('');
                @else
                $(formType + ' #create_error_title').text('');
                $(formType + ' #create_error_description').text('');
                @endif
                $(formType + ' #create_error_slug').text('');
                $(formType + ' #create_error_image').text('');
            }
        });
    })(jQuery);
</script>
