<div class="col-lg-12">
    <section class="send_query bg-white contact_form">
        <form name="bank_payment" id="contactForm" enctype="multipart/form-data" action="{{route('frontend.order_payment')}}" class="p-0" method="POST">
            @csrf
            <input type="hidden" name="method" value="BankPayment">
            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <label for="name" class="primary_label2 style3">{{ __('payment_gatways.bank_name') }} <span>*</span></label>
                    <input type="text" required class="primary_input3 style4 radius_3px mb_20" placeholder="{{ __('payment_gatways.bank_name') }}" name="bank_name" value="{{@old('bank_name')}}">
                    <span class="invalid-feedback" role="alert" id="bank_name"></span>
                </div>
                <div class="col-xl-6 col-md-6">
                    <label for="name" class="primary_label2 style3">{{ __('payment_gatways.branch_name') }} <span>*</span></label>
                    <input type="text" required name="branch_name" class="primary_input3 style4 radius_3px mb_20" placeholder="{{ __('payment_gatways.branch_name') }}" value="{{@old('branch_name')}}">
                    <span class="invalid-feedback" role="alert" id="owner_name"></span>
                </div>
            </div>
            <div class="row mb-20">
                <div class="col-xl-6 col-md-6">
                    <label for="name" class="primary_label2 style3">{{ __('payment_gatways.account_number') }} <span>*</span></label>
                    <input type="text" required class="primary_input3 style4 radius_3px mb_20" placeholder="{{ __('payment_gatways.account_number') }}" name="account_number" value="{{@old('account_number')}}">
                    <span class="invalid-feedback" role="alert" id="account_number"></span>
                </div>
                <div
                    class="col-xl-6 col-md-6">
                    <label for="name" class="primary_label2 style3">{{ __('payment_gatways.account_holder') }} <span>*</span></label>
                    <input type="text" required name="account_holder" class="primary_input3 style4 radius_3px mb_20" placeholder="{{ __('payment_gatways.account_holder') }}" value="{{@old('account_holder')}}">
                    <span class="invalid-feedback" role="alert" id="account_holder"></span>
                </div>
                <input type="hidden" name="bank_amount" value="{{$total_amount - $coupon_am}}">

            </div>
            <div class="row  mb-20">

                <div
                    class="col-xl-12 col-md-12">
                    <label for="name" class="primary_label2 style3">{{ __('payment_gatways.cheque_slip') }} <span>*</span></label>
                    <input type="file" required name="image" class="primary_input3 style4 radius_3px pd_12">
                    <span class="invalid-feedback" role="alert" id="amount_validation"></span>
                </div>
            </div>
            <div class="row">
                @php
                    $gateway = DB::table('payment_methods')->where('slug','bank-payment')->first();
                    if($gateway){
                        $credential = DB::table('seller_wise_payment_gateways')->where('payment_method_id',$gateway->id)->first();
                    }
                @endphp
                <div class="col-md-12">
                    <table class="table table-bordered">

                        <tr>
                            <td>{{ __('payment_gatways.bank_name') }}</td>
                            <td>{{ !empty($gateway) && !empty($credential) ? $credential->perameter_1:''}}</td>
                        </tr>
                        <tr>
                            <td>{{ __('payment_gatways.branch_name') }}</td>
                            <td>{{!empty($gateway) && !empty($credential) ? $credential->perameter_2:''}}</td>
                        </tr>

                        <tr>
                            <td>{{ __('payment_gatways.account_number') }}</td>
                            <td>{{!empty($gateway) && !empty($credential) ? $credential->perameter_3:''}}</td>
                        </tr>

                        <tr>
                            <td>{{ __('payment_gatways.account_holder') }}</td>
                            <td>{{!empty($gateway) && !empty($credential) ? $credential->perameter_4:''}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="send_query_btn d-flex justify-content-between">
                <button class="btn_1 d-none" id="bank_btn" type="submit">{{ __('common.payment') }}</button>
            </div>
        </form>
    </section>
</div>
