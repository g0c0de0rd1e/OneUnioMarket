@push('scripts')

<script src="{{asset(asset_path('backend/vendors/js/icon-picker.js'))}}">
</script>

<script type="text/javascript">
    (function($){
        "use strict";
        $(document).ready(function() {

            $(document).on('mouseover', 'body', function(){
                $('#icon').iconpicker({
                    animation:true
                });
                $('#iconEdit').iconpicker({
                    animation:true
                });

            });

            $(document).on('submit', '#socialLinkCreate', function(event) {
                event.preventDefault();
                $("#social_add_btn").prop('disabled', true);
                $('#social_add_btn').text('{{ __('submitting') }}');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('seller.setting.social-link.store') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {

                        toastr.success("{{__('common.added_successfully')}}","{{__('common.success')}}")
                        $('#social_add').modal('hide');
                        $("#social_add_btn").prop('disabled', false);
                        $('#social_add_btn').text('{{ __('common.save') }}');
                        $('#socialLinkCreate')[0].reset();

                        location.reload();
                    },
                    error: function(response) {
                        $('#social_add_btn').text('{{ __('common.save') }}');
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                        toastr.error("{{__('common.error_message')}}")
                        showSocialValidationErrors('#socialLinkCreate', response.responseJSON.errors);
                        $("#social_add_btn").prop('disabled', false);
                    }
                });
            });
            $(document).on('submit', '#socialLinkEdit', function(event){
                event.preventDefault();
                $("#social_edit_btn").prop('disabled', true);
                $('#social_edit_btn').text('{{ __('common.updating') }}');
                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name, element.value);
                });
                formData.append('_token', "{{ csrf_token() }}");
                $.ajax({
                url: "{{ route('seller.setting.social-link.update') }}",
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response) {
                    $('#social_edit').modal('hide');
                    toastr.success("{{__('common.updated_successfully')}}","{{__('common.success')}}")
                    $("#social_edit_btn").prop('disabled', false);
                    $('#social_edit_btn').text('{{ __('common.update') }}');

                    location.reload();

                },
                error: function(response) {
                    $('#social_edit_btn').text('{{ __('common.update') }}');
                    if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                    showSocialValidationErrors('#socialLinkEdit', response.responseJSON
                        .errors);
                    $("#social_edit_btn").prop('disabled', false);
                }
                });

            });

            $(document).on('submit','#item_delete_form', function(event) {
                event.preventDefault();

                $("#dataDeleteBtn").prop('disabled', true);
                $('#dataDeleteBtn').val('{{ __('common.deleting') }}');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_item_id').val());
                let id = $('#delete_item_id').val();
                $.ajax({
                    url: "{{ route('seller.setting.social-link.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}")
                        $('#deleteItemModal').modal('hide');
                        $("#dataDeleteBtn").prop('disabled', false);
                        $('#dataDeleteBtn').val('{{ __('common.delete') }}');
                        location.reload();
                    },
                    error: function(response) {
                        $('#dataDeleteBtn').val('{{ __('common.delete') }}');
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                        $("#dataDeleteBtn").prop('disabled', false);
                    }
                });
            });

            $(document).on('submit', '#createForm', function(event){
                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                $('#error_shipment_time').text('');

                let shipment_time = $('#shipment_time').val();

                let userKeyRegExp1 = /^[0-9]\-[0-9] [a-z]{4}?$/;
                let userKeyRegExp2 = /^[0-9]\-[0-9]{2}\ [a-z]{4}?$/;
                let userKeyRegExp3 = /^[0-9]\-[0-9]{3}\ [a-z]{4}?$/;
                let userKeyRegExp4 = /^[0-9]{2}\-[0-9]{2}\ [a-z]{4}?$/;
                let userKeyRegExp5 = /^[0-9]{2}\-[0-9]{3}\ [a-z]{4}?$/;
                let userKeyRegExp6 = /^[0-9]{3}\-[0-9]{3}\ [a-z]{4}?$/;

                let userKeyRegExp7 = /^[0-9]\-[0-9]\ [a-z]{3}?$/;
                let userKeyRegExp8 = /^[0-9]\-[0-9]{2}\ [a-z]{3}?$/;
                let userKeyRegExp9 = /^[0-9]\-[0-9]{3}\ [a-z]{3}?$/;
                let userKeyRegExp10 = /^[0-9]{2}\-[0-9]{2}\ [a-z]{3}?$/;
                let userKeyRegExp11 = /^[0-9]{2}\-[0-9]{3}\ [a-z]{3}?$/;
                let userKeyRegExp12 = /^[0-9]{3}\-[0-9]{3}\ [a-z]{3}?$/;

                let valid1 = userKeyRegExp1.test(shipment_time);
                let valid2 = userKeyRegExp2.test(shipment_time);
                let valid3 = userKeyRegExp3.test(shipment_time);
                let valid4 = userKeyRegExp4.test(shipment_time);
                let valid5 = userKeyRegExp5.test(shipment_time);
                let valid6 = userKeyRegExp6.test(shipment_time);
                let valid7 = userKeyRegExp7.test(shipment_time);
                let valid8 = userKeyRegExp8.test(shipment_time);
                let valid9 = userKeyRegExp9.test(shipment_time);
                let valid10 = userKeyRegExp10.test(shipment_time);
                let valid11 = userKeyRegExp11.test(shipment_time);
                let valid12 = userKeyRegExp12.test(shipment_time);

                if(valid1 !=false || valid2!=false || valid3!=false || valid4!=false || valid5!=false ||
                 valid6!=false || valid7!=false || valid8!=false || valid9!=false || valid10!=false || valid11!=false || valid12!=false){
                    let data1 = shipment_time.split(" ");

                    if(data1[1] == 'days' || data1[1] == 'hrs'){

                    }else{
                        $('#pre-loader').addClass('d-none');
                        $('#error_shipment_time').text('Format must be like 3-5 days or 3-5 hrs');
                        return false;
                    }

                }
                else{
                    $('#pre-loader').addClass('d-none');
                    $('#error_shipment_time').text('Format must be like 3-5 days or 3-5 hrs');
                    return false;
                }

                let formElement = $(this).serializeArray()
                let formData = new FormData();
                formElement.forEach(element => {
                    formData.append(element.name,element.value);
                });

                let method_logo = $('#thumbnail_logo')[0].files[0];

                if(method_logo){
                    formData.append('method_logo',method_logo);
                }

                formData.append('_token',"{{ csrf_token() }}");


                resetValidationError();
                $('#pre-loader').addClass('d-none');
                $.ajax({
                    url: "{{ route('seller.shipping_methods.store')}}",
                    type:"POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:function(response){
                        toastr.success('{{__("common.created_successfully")}}', "{{__('common.success')}}");
                        $('#pre-loader').addClass('d-none');
                        $('.closeModal').trigger('click');
                        location.reload();
                    },
                    error:function(response) {
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                        showValidationErrors('#createForm',response.responseJSON.errors);
                        $('#pre-loader').addClass('d-none');
                    }
                });

            });

            function resetValidationError(){
                $('#error_method_name').text('');
                $('#error_phone').text('');
                $('#error_cost').text('');
                $('#error_shipment_time').text('');
                $('#error_thumbnail_logo').text('');
            }

            function showValidationErrors(formType, errors){
                $(formType +' #error_method_name').text(errors.method_name);
                $(formType +' #error_phone').text(errors.phone);
                $(formType +' #error_cost').text(errors.cost);
                $(formType +' #error_shipment_time').text(errors.shipment_time);
                $(formType +' #error_thumbnail_logo').text(errors.method_logo);
            }

            $(document).on("change", "#thumbnail_logo", function (event) {
                event.preventDefault();
                imageChangeWithFile($(this)[0],'#ThumbnailImgDiv');
                getFileName($(this).val(),'#logo_file');
            });


            $(document).on("click", ".delete_methodShipping", function () {
                let id = $(this).data("id");
                $('#shipping_delete_id').val(id);
                $('#shipping_delete_modal').modal('show');

            });

            $(document).on('change', '#site_logo', function(event){
                imageChangeWithFile($(this)[0],'#seller_logos');
            });

            $(document).on('change', '#favicon_logo', function(event){
                imageChangeWithFile($(this)[0],'#seller_banner');
            });

            $(document).on('submit', '#shipping_delete_form', function(event) {

                event.preventDefault();
                $('#pre-loader').removeClass('d-none');
                $('#shipping_delete_modal').modal('hide');
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#shipping_delete_id').val());
                $.ajax({
                    url: "{{ route('seller.shipping_methods.destroy') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {

                        toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}")
                        $('#pre-loader').addClass('d-none');
                        location.reload();
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                        toastr.error("{{__('common.error_message')}}'","{{__('common.error')}}");
                    }
                });
            });


            $(document).on('click', '.edit_link', function(event){
                event.preventDefault();
                let item = $(this).data('value');
                socialEdit(item);
            });

            $(document).on('click', '.delete_link', function(event){
                let id = $(this).data('id');
                $('#delete_item_id').val(id);
                $('#deleteItemModal').modal('show');
            });

            $(document).on('click', '#dataDeleteBtn', function(event){
                setTimeout(function(){
                    location.reload();
                }, 2000)
            });

            $(document).on('click', '#add_new_shipping', function(event){
                event.preventDefault();
                $('#social_add').modal('show');
            });

            function socialEdit(item){
                $('#social_edit').modal('show');
                $('#socialLinkEdit #iconEdit').val(item.icon);
                $('#socialLinkEdit #urlEdit').val(item.url);
                $('#socialLinkEdit #id').val(item.id);
                if (item.status == 1) {
                    $('#socialLinkEdit #status_activeEdit').prop("checked", true);
                    $('#socialLinkEdit #status_inactiveEdit').prop("checked", false);
                } else {
                    $('#socialLinkEdit #status_activeEdit').prop("checked", false);
                    $('#socialLinkEdit #status_inactiveEdit').prop("checked", true);
                }
            }

            function resetAfterChange(tableData) {
                $('#socialListDiv').empty();
                $('#socialListDiv').html(tableData);
                CRMTableTwoReactive();
            }


            function showSocialValidationErrors(formType, errors){
                $(formType + ' #error_url').text(errors.url);
                $(formType + ' #error_icon').text(errors.icon);
                $(formType + ' #error_status').text(errors.status);
            }

            $(document).on('click', '.setting_tab', function(){
                let value = $(this).data('value');
                sectionControl(value);
            })

            function sectionControl(id){
                let url = "/seller/setting/tab/" + id;
                $.ajax({
                        url: url,
                        type: "GET",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {

                        },
                        error: function(response) {

                    }
                });
            }


        });

    })(jQuery);

</script>
@endpush
