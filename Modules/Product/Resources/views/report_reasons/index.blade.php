@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/product/css/style.css'))}}" />
@endsection
@section('mainContent')

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="form_div">
                    @include('product::report_reasons.components._create')
                </div>
            </div>
            <div class="col-lg-8">
                <div class="box_header common_table_header">
                    <div class="main-title d-md-flex">
                        <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{ __('product.report_reason') }} {{__('common.list')}}</h3>
                    </div>
                </div>
                <div class="QA_section QA_section_heading_custom check_box_table">
                    <div class="QA_table ">
                        <!-- table-responsive -->
                        <div class="">
                            <div id="variant_list">
                                @include('product::report_reasons.components._list',compact('reasons'))
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('backEnd.partials._deleteModalForAjax',['item_name' => __("product.report_reason")])
@push('scripts')
    <script>
        $(document).ready(function(){
            $(document).on('click','.edit_category',function(){
                $("#pre-loader").removeClass('d-none');
                let url = $(this).attr('data-url');
                $.ajax({
                    url:url,
                    method: 'get',

                }).done(function(response){
                    $("#pre-loader").addClass('d-none');
                    if(response.status == 0){
                        toastr.error(response.msg,{{ __('common.error') }})
                    }else{
                        $(".form_div").html(response);
                    }
                });
            });
        });

        $(document).on('click', '.delete_brand', function(event){
                event.preventDefault();
                let id = $(this).data('id');
                $('#delete_item_id').val(id);
                $('#deleteItemModal').modal('show');
            });
            $(document).on('submit', '#item_delete_form', function(event) {
                event.preventDefault();
                $('#deleteItemModal').modal('hide');

                var formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");
                formData.append('id', $('#delete_item_id').val());
                let id = $('#delete_item_id').val();
                $.ajax({
                    url: "{{ route('product.report.delete') }}",
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        $("#pre-loader").addClass('d-none');
                        if(response.status == 1){
                            toastr.success('operation success','Success');
                        }else{
                            toastr.error('operation failed','Error');
                        }
                        location.reload();
                    },
                    error: function(response) {
                        if(response.responseJSON.error){
                            toastr.error(response.responseJSON.error ,"{{__('common.error')}}");
                            $('#pre-loader').addClass('d-none');
                            return false;
                        }
                        $("#pre-loader").addClass('d-none');
                    }
                });
            });
    </script>
@endpush
@endsection
