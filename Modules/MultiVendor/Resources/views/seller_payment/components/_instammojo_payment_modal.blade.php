<div class="modal fade " id="InstamojoModal" tabindex="-1" role="dialog" aria-labelledby="InstamojoModallLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('payment_gatways.instamojo_payment') }}</h5>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <form action="{{route('seller.subscription_payment')}}" class="single_account-form" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="method" value="Instamojo">
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('common.name') }}<span class="text-danger">*</span></label>
                            <input type="text" required class="primary_input4 form-control mb_20" placeholder="" name="name" value="{{@old('name')}}">
                            <span class="invalid-feedback" role="alert" id="name"></span>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('common.email') }}<span class="text-danger">*</span></label>
                            <input type="email" required name="email" class="primary_input4 form-control mb_20" placeholder="" value="{{@old('email')}}">
                            <span class="invalid-feedback" role="alert" id="email"></span>
                        </div>
                    </div>
                    <div class="row mb-20">
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('common.mobile') }}<span class="text-danger">*</span></label>
                            <input type="text" required class="primary_input4 form-control mb_20" placeholder="" name="mobile" value="{{@old('mobile')}}">
                            <span class="invalid-feedback" role="alert" id="mobile"></span>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <label for="name" class="mb-2">{{ __('common.amount') }}<span class="text-danger">*</span></label>
                            <input type="number" min="0" step="{{step_decimal()}}" value="{{ $recharge_amount }}" id="amount" name="amount" class="primary_input4 form-control mb_20">
                            <span class="invalid-feedback" role="alert" id="name"></span>
                        </div>
                    </div>
                    <div class="send_query_btn d-flex justify-content-between mt-4">
                        <button type="button" class="primary-btn semi_large2 fix-gr-bg" data-dismiss="modal">{{ __('common.cancel') }}</button>
                        <button class="primary-btn semi_large2 fix-gr-bg" type="submit">{{ __('common.continue_to_pay') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
