<script type="text/javascript">
    function confirm_modal_seller_password(data)
    {
        jQuery('#seller_change_password_modal').modal('show', {backdrop: 'static'});
        document.getElementById('sellerPasswordChangeUserId').value = data;
    }
</script>

<div class="modal fade admin-query" id="seller_change_password_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ __('common.change_password') }}</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="selPassSt" method="POST">
                    @csrf
                    <input type="hidden" name="seller_user_id" id="sellerPasswordChangeUserId">
                    <div class="col-md-12">
                        <div class="primary_input mb-25">
                            <label class="primary_input_label" for="customerNewPassword">{{ __('seller.new_password') }}</label>
                            <input name="seller_new_password" class="primary_input_field sPr" placeholder="{{ __('seller.new_password') }}" type="password">
                            <span class="text-danger error sellerErrorS"></span>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <div class="d-flex justify-content-center pt_20">
                            <button type="submit" class="primary-btn semi_large2 fix-gr-bg sellerChangePassword"><i class="ti-check"></i>{{ __('common.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
