@push('scripts')

<script>
(function($) {
    "use strict";
    let _token = $('meta[name=_token]').attr('content') ;
    $(document).ready(function(){
        @if(isModuleActive('FrontendMultiLang'))
        $(document).on('keyup', '#title{{auth()->user()->lang_code}}', function(event){
            processSlug($(this).val(), '#slug');
        });
        @else
        $(document).on('keyup','#title',function (){
            processSlug($(this).val(), '#slug');
        });
        @endif
        @if(isModuleActive('FrontendMultiLang'))
        $(document).on('keyup', '#etitle{{auth()->user()->lang_code}}', function(event){
            processSlug($(this).val(), '#eslug');
        });
        @else
        $(document).on('keyup','#etitle',function (){
            processSlug($(this).val(), '#eslug');
        });
        @endif

        $(document).on('submit', '#create_form', function(event){
            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name,element.value);
            });
            formData.append('_token',_token);
            resetValidationError();
            $('#pre-loader').removeClass('d-none');
            $('#add_page_modal').modal('hide');
            $.ajax({
                url: $('#store_url').val(),
                type:"POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success:function(response){
                    create_form_reset();
                    toastr.success('New Page Create Successfully','Success');
                    resetAfterChange(response.TableData);
                    $('#pre-loader').addClass('d-none');
                },
                error:function(response) {
                    $('#pre-loader').addClass('d-none');
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,trans('common.error'));
                        return false;
                    }
                    showValidationErrors('#create_form',response.responseJSON.errors);
                }
            });
        });
        $(document).on('click', '.edit_row', function(event){
            event.preventDefault();
            let id = $(this).data('id');
            let url =  $('#edit_url').val();
            url = url.replace(':id',id);
            $('#pre-loader').removeClass('d-none');
            $.get(url, function(response){
                if(response){
                    $('#append_html').html(response);
                    $('#edit_page_modal').modal('show');
                }
                $('#pre-loader').addClass('d-none');
            });
        });
        $(document).on('submit', '#update_form', function(event){
            event.preventDefault();
            let formElement = $(this).serializeArray()
            let formData = new FormData();
            formElement.forEach(element => {
                formData.append(element.name,element.value);
            });
            formData.append('_token',_token);
            let id = $('#rowId').val();
            let url = $('#update_url').val();
            url = url.replace(':id',id);
            editresetValidationError();
            $('#edit_page_modal').modal('hide');
            $('#pre-loader').removeClass('d-none');
            $.ajax({
                url: url,
                type:"POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success:function(response){
                    resetAfterChange(response.TableData);
                    toastr.success('Page Update Successfully');
                    $('#pre-loader').addClass('d-none');
                },
                error:function(response) {
                    $('#pre-loader').addClass('d-none');
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,trans('common.error'));
                        return false;
                    }
                    editshowValidationErrors('#update_form',response.responseJSON.errors);
                }
            });
        });
        $(document).on('click','.delete_row',function (event){
            event.preventDefault();
            let id = $(this).data('id');
            $('#delete_item_id').val(id);
            $('#deleteItemModal').modal('show');
        });
        $(document).on('submit', '#item_delete_form', function(event) {
            event.preventDefault();
            $('#deleteItemModal').modal('hide');
            $('#pre-loader').removeClass('d-none');
            var formData = new FormData();
            formData.append('_token', _token);
            formData.append('id', $('#delete_item_id').val());
            $.ajax({
                url:  $('#delete_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    resetAfterChange(response.TableData);
                    toastr.success("Deleted Successfully");
                    $('#pre-loader').addClass('d-none');
                },
                error: function(response) {
                    $('#pre-loader').addClass('d-none');
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,trans('common.error'));
                        return false;
                    }
                }
            });
        });
        $(document).on('change', '.status_change', function(event){
            event.preventDefault();
            let status = 0;
            if($(this).prop('checked')){
                status = 1;
            }
            else{
                status = 0;
            }
            let id = $(this).data('id');
            let formData = new FormData();
            formData.append('_token', _token);
            formData.append('id', id);
            formData.append('status', status);
            $('#pre-loader').removeClass('d-none');
            $.ajax({
                url: $('#status_change_url').val(),
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    toastr.success("Status Updated successfully");
                    $('#pre-loader').addClass('d-none');
                },
                error: function(response) {
                    $('#pre-loader').addClass('d-none');
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,trans('common.error'));
                        return false;
                    }
                    toastr.error("Something went wrong");
                }
            });
        });

        function resetAfterChange(TableData){
            $('#lms_data_table').html(TableData);
            CRMTableReactive();
        }
        function create_form_reset(){
            $('#create_form')[0].reset();
        }
        function showValidationErrors(formType, errors){
            $('#add_page_modal').modal('show');
            @if(isModuleActive('FrontendMultiLang'))
            $(formType +' #error_title_{{auth()->user()->lang_code}}').text(errors['title.{{auth()->user()->lang_code}}']);
            @else
            $(formType +' #error_title').text(errors.title);
            @endif
            $(formType +' #error_slug').text(errors.slug);
        }
        function resetValidationError(){
            @if(isModuleActive('FrontendMultiLang'))
            $('#error_title_{{auth()->user()->lang_code}}').text('');
            @else
            $('#error_title').text('');
            @endif
            $('#error_slug').text('');
        }
        function editshowValidationErrors(formType, errors){
            $('#edit_page_modal').modal('show');
            @if(isModuleActive('FrontendMultiLang'))
            $(formType +' #edit_error_title_{{auth()->user()->lang_code}}').text(errors['title.{{auth()->user()->lang_code}}']);
            @else
            $(formType +' #edit_error_title').text(errors.title);
            @endif
            $(formType +' #edit_error_slug').text(errors.slug);
        }
        function editresetValidationError(){
            @if(isModuleActive('FrontendMultiLang'))
            $('#edit_error_title_{{auth()->user()->lang_code}}').text('');
            @else
            $('#edit_error_title').text('');
            @endif
            $('#edit_error_slug').text('');
        }
    });
})(jQuery);

</script>
@endpush