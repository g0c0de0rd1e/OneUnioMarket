@push('scripts')
<script>

    (function($){
        "use strict";

        $(document).ready(function(){
            $('#about_seller').summernote({
                placeholder: 'Write here',
                tabsize: 2,
                height: 250,
                codeviewFilter: true,
			    codeviewIframeFilter: true
            });

            $(document).on('click', '.link_change_btn', function(event){
                sectionControl($(this)[0].id);
            });
            function sectionControl(id){
                let url = "/seller/profile/tab/" + id;
                $.ajax({
                    url: url,
                    type: "GET",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {},
                    error: function(response) {}
                });
            }

            $(document).on('click', '#holiday_mode_active', function(event){
                let value = $('#holiday_mode_active').val();
                holidayModeCheck(value);
            });
            $(document).on('click','#holiday_mode_inactive', function(event){
                let value = $('#holiday_mode_inactive').val();
                holidayModeCheck(value);
            });

            function holidayModeCheck(val){
                if(val == 1){
                    $('#select_type_div').removeClass('d-none');
                    $('#holiday_date_div').removeClass('d-none');
                }else{
                    $('#select_type_div').addClass('d-none');
                    $('#holiday_date_div').addClass('d-none');
                    $('#holiday_start_date_div').addClass('d-none');
                    $('#holiday_end_date_div').addClass('d-none');
                    $('#select_type').val(1);
                    $('#select_type').niceSelect('update');
                }
            }

            $(document).on('change', '#select_type', function(event){
                let value = $('#select_type').val();
                holidayTypeCheck(value);
            });

            function holidayTypeCheck(val){
                if (val ==2){
                    $('#holiday_date_div').addClass('d-none');
                    $('#holiday_start_date_div').removeClass('d-none');
                    $('#holiday_end_date_div').removeClass('d-none');
                }else {
                    $('#holiday_date_div').removeClass('d-none');
                    $('#holiday_start_date_div').addClass('d-none');
                    $('#holiday_end_date_div').addClass('d-none');
                }
            }

            $(document).on('change', '#cheque_copy', function(event){
                getFileName($(this).val(),'#cheque_copy_file');
                imageChangeWithFile($(this)[0],'#imgDiv33');
                removeCross('#chequeImgCross');
            });

            $(document).on('click', '#chequeImgCross', function(event){
                let id = $(this).data('id');
                imgDeleteBank(id);
            });

            $(document).on('change', '#business_document', function(){

                getFileName($(this).val(),'#business_document_file');
                imageChangeWithFile($(this)[0],'#imgDiv34');
                removeCross('#documentCross');
            });

            $(document).on('click', '#documentCross', function(){
                let id = $(this).data('id');
                imgDeleteBusiness(id);
            });

            function imgDeleteBusiness(id){
                $('#delete_document_id').val(id);
                $('#imgModal').modal('show');
            }

            $(document).on('click', '.same_address_check', function(){
                let seller_id = $(this).data('seller_id');
                let value = $(this).val();
                addressCheck(value, seller_id);
            });

            function addressCheck(val, id){
                if(val == 1){
                    $('#return_div').addClass('d-none');
                }
                if(val == 0){
                    $('#return_div').removeClass('d-none');
                }
                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('same_as_warehouse', parseInt(val));
                formData.append('id', parseInt(id));
                $.ajax({
                    url: "{{ route('seller.profile.return-address.change') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {},
                    error: function(response) {
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                    }
                });
            }

            function imgDeleteBank(id){
                $('#delete_cheque_id').val(id);
                $('#cheqyeImgModal').modal('show');
            }
            function removeCross(id){
                $(id).css('display','none');
            }

            $(document).on('submit','#imgForm',function(event){
                event.preventDefault();

                $("#document_delete_btn").prop('disabled', true);
                $('#document_delete_btn').val('{{ __('common.deleting') }}');

                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_document_id').val());
                $.ajax({
                    url: "{{ route('seller.profile.business-information.img-delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if(response ==1){
                            $('#businessImgDiv').empty();
                            $('#businessImgDiv').append(`'<img
                            id="imgDiv34" src="{{showImage("backend/img/default.png")}}" alt="">'`);
                            toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}")
                            $("#document_delete_btn").prop('disabled', false);
                            $('#document_delete_btn').val('{{ __('common.delete') }}');
                            $('#imgModal').modal('hide');
                        }else{
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $("#document_delete_btn").prop('disabled', false);
                            $('#document_delete_btn').val('{{ __('common.delete') }}');
                            $('#imgModal').modal('hide');
                        }
                    },
                    error: function(response) {
                        $("#document_delete_btn").prop('disabled', false);
                        $('#document_delete_btn').val('{{ __('common.delete') }}');
                        $('#imgModal').modal('hide');
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                    }
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    }
                });
            });
            $(document).on('submit','#chequeImgForm',function(event){
                event.preventDefault();

                $("#cheque_delete_btn").prop('disabled', true);
                $('#cheque_delete_btn').val('{{ __('common.deleting') }}');


                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_cheque_id').val());
                $.ajax({
                    url: "{{ route('seller.profile.bank-account.img-delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        if(response ==1){
                            toastr.success("{{__('common.deleted_successfully')}}","{{__('common.success')}}")
                            $('#bankChequeImgDiv').empty();
                            $('#bankChequeImgDiv').append(`'<img
                            id="imgDiv33" src="{{showImage("backend/img/default.png")}}" alt="">'`);

                            $("#cheque_delete_btn").prop('disabled', false);
                            $('#cheque_delete_btn').val('{{ __('common.delete') }}');
                            $('#cheqyeImgModal').modal('hide');
                        }else{
                            toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                            $("#cheque_delete_btn").prop('disabled', false);
                            $('#cheque_delete_btn').val('{{ __('common.delete') }}');
                            $('#cheqyeImgModal').modal('hide');
                        }
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                        toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                        $('#pre-loader').addClass('d-none');
                        return false;
                        }
                        $("#cheque_delete_btn").prop('disabled', false);
                        $('#cheque_delete_btn').val('{{ __('common.delete') }}');
                        $('#cheqyeImgModal').modal('hide');
                        toastr.error("{{__('common.error_message')}}","{{__('common.error')}}");
                    }
                });
            });


            $(document).on('change', '#business_country', function(event){
                let country = $('#business_country').val();

                $('#pre-loader').removeClass('d-none');
                if(country){
                    let base_url = $('#url').val();
                    let url = base_url + '/get-state?country_id=' +country;

                    $('#business_state').empty();

                    $('#business_state').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#business_state').niceSelect('update');
                    $('#business_city').empty();
                    $('#business_city').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#business_city').niceSelect('update');
                    $.get(url, function(data){

                        $.each(data, function(index, stateObj) {
                            $('#business_state').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                        });

                        $('#business_state').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });

            $(document).on('change', '#warehouse_country', function(event){
                let country = $('#warehouse_country').val();

                $('#pre-loader').removeClass('d-none');
                if(country){
                    let base_url = $('#url').val();
                    let url = base_url + '/get-state?country_id=' +country;

                    $('#warehouse_state').empty();

                    $('#warehouse_state').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#warehouse_state').niceSelect('update');
                    $('#warehouse_city').empty();
                    $('#warehouse_city').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#warehouse_city').niceSelect('update');
                    $.get(url, function(data){

                        $.each(data, function(index, stateObj) {
                            $('#warehouse_state').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                        });

                        $('#warehouse_state').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });

            $(document).on('change', '#return_country', function(event){
                let country = $('#return_country').val();

                $('#pre-loader').removeClass('d-none');
                if(country){
                    let base_url = $('#url').val();
                    let url = base_url + '/get-state?country_id=' +country;

                    $('#return_state').empty();

                    $('#return_state').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#return_state').niceSelect('update');
                    $('#return_city').empty();
                    $('#return_city').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#return_city').niceSelect('update');
                    $.get(url, function(data){

                        $.each(data, function(index, stateObj) {
                            $('#return_state').append('<option value="'+ stateObj.id +'">'+ stateObj.name +'</option>');
                        });

                        $('#return_state').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });

            $(document).on('change', '#business_state', function(event){
                let state = $('#business_state').val();

                $('#pre-loader').removeClass('d-none');
                if(state){
                    let base_url = $('#url').val();
                    let url = base_url + '/get-city?state_id=' +state;

                    $('#business_city').empty();

                    $('#business_city').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#business_city').niceSelect('update');

                    $.get(url, function(data){

                        $.each(data, function(index, cityObj) {
                            $('#business_city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                        });

                        $('#business_city').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });

            $(document).on('change', '#warehouse_state', function(event){
                let state = $('#warehouse_state').val();

                $('#pre-loader').removeClass('d-none');
                if(state){
                    let base_url = $('#url').val();
                    let url = base_url + '/get-city?state_id=' +state;

                    $('#warehouse_city').empty();

                    $('#warehouse_city').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#warehouse_city').niceSelect('update');

                    $.get(url, function(data){

                        $.each(data, function(index, cityObj) {
                            $('#warehouse_city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                        });

                        $('#warehouse_city').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });

            $(document).on('change', '#return_state', function(event){
                let state = $('#return_state').val();

                $('#pre-loader').removeClass('d-none');
                if(state){
                    let base_url = $('#url').val();
                    let url = base_url + '/get-city?state_id=' +state;

                    $('#return_city').empty();

                    $('#return_city').append(
                        `<option value="" disabled selected>{{__('common.select_one')}}</option>`
                    );
                    $('#return_city').niceSelect('update');

                    $.get(url, function(data){

                        $.each(data, function(index, cityObj) {
                            $('#return_city').append('<option value="'+ cityObj.id +'">'+ cityObj.name +'</option>');
                        });

                        $('#return_city').niceSelect('update');
                        $('#pre-loader').addClass('d-none');
                    });
                }
            });
            $(document).on('change', '.commission_type', function(){
                var subscription_type = this.value;
                $('.commission_rate').val($('select.commission_type').find(':selected').data('rate'));

                if (subscription_type == 3) {

                    $("#pricing_div").removeClass('d-none');
                    $("#subscription_type_div").removeClass('d-none');

                }else {
                    $("#pricing_div").addClass('d-none');
                    $("#subscription_type_div").addClass('d-none');
                }
            });

        });

    })(jQuery);

</script>
@endpush
