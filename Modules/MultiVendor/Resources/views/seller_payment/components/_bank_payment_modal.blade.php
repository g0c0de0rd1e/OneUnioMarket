<div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('common.bank_payment') }} </h5>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <form name="bank_payment" enctype="multipart/form-data" action="{{route('seller.subscription_payment')}}"
                class="single_account-form" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="method" value="BankPayment">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('common.bank_name') }} <span class="text-danger">*</span></label>
                            <input type="text" required class="primary_input_field form-control mb_20"

                            placeholder="{{ __('common.bank_name') }}"

                                name="bank_name" value="{{@old('bank_name')}}">
                            <span class="invalid-feedback" role="alert" id="bank_name"></span>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('common.branch_name') }} <span class="text-danger">*</span></label>
                            <input type="text" required name="branch_name"
                                class="primary_input_field form-control mb_20" placeholder="{{ __('common.branch_name') }}"
                                value="{{@old('branch_name')}}">
                            <span class="invalid-feedback" role="alert" id="owner_name"></span>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('common.account_number') }} <span class="text-danger">*</span></label>
                            <input type="text" required class="primary_input_field form-control mb_20"
                                placeholder="{{ __('common.account_number') }}" name="account_number"
                                value="{{@old('account_number')}}">
                            <span class="invalid-feedback" role="alert" id="account_number"></span>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('wallet.account_holder') }} <span class="text-danger">*</span></label>
                            <input type="text" required name="account_holder"
                                class="primary_input_field form-control mb_20"
                                placeholder="{{ __('wallet.account_holder') }}" value="{{@old('account_holder')}}">
                            <span class="invalid-feedback" role="alert" id="account_holder"></span>
                        </div>
                        <input type="hidden" name="bank_amount" value="{{ $recharge_amount}}">

                    </div>

                    <div class="row  mb-20">
                        <div class="col-xl-12 col-md-12">
                            <div class="primary_file_uploader">
                                <input class="primary-input imgName" type="text"
                                    placeholder="{{ __('common.browse_file') }}" readonly="">
                                <button class="" type="button">
                                    <label class="primary-btn small fix-gr-bg"
                                        for="document_file_1">{{ __('wallet.cheque_slip') }} </label>
                                    <input type="file" class="d-none imgBrowse" name="image" id="document_file_1">
                                </button>
                            </div>
                            
                        </div>
                    </div>
                    <div class="QA_section3 QA_section_heading_custom th_padding_l0">
                        <div class="QA_table">
                            <!-- table-responsive -->
                            <div class="table-responsive">
                                @php
                                    $credential = getPaymentInfoViaSellerId(1, 7);
                                @endphp
                                <table class="table pos_table pt-0 shadow_none pb-0 ">
                                    <tbody>
                                        <tr>
                                            <td>{{ __('common.bank_name') }}</td>
                                            <td>{{@$credential->perameter_1}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ __('common.branch_name') }}</td>
                                            <td>{{@$credential->perameter_2}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('wallet.account_number') }}</td>
                                            <td>{{@$credential->perameter_3}}</td>
                                        </tr>

                                        <tr>
                                            <td>{{ __('common.account_holder') }}</td>
                                            <td>{{@$credential->perameter_4}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="d-flex justify-content-center pt_20">
                            <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i
                                    class="ti-check"></i>{{ __('common.payment') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@push("scripts")
   <script type="text/javascript">
       $(".imgBrowse").change(function (e) {
    e.preventDefault();
    var file = $(this).closest('.primary_file_uploader').find('.imgName');
    var filename = $(this).val().split('\\').pop();
    file.val(filename);
});
    </script>
@endpush

