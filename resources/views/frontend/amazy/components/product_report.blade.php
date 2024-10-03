<div class="modal fade" id="report_modal" tabindex="-1" aria-labelledby="report_modal_label" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('frontend.submit.report') }}" method="post">
        <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 text-upper" id="report_modal_label">{{ __('product.report_this_product') }}</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                @if(!empty($reasons))
                <div class="form-group ">
                    <label for="">{{ __("product.reason") }}</label>
                    <select name="reason_id" id="reason_id" class="amaz_select2 mb_10 w-100">
                        <option value="">Please select</option>
                        @foreach($reasons as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label for="">{{ __('common.email') }}</label>
                    <input type="email" name="email" class="primary_input3 style5 radius_3px" value="{{ auth()->check() ? auth()->user()->email:'' }}">
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->id():"" }}">
                </div>

                <div class="form-group">
                    <label for="">{{  __('product.comment') }}</label>
                    <textarea name="comment" id="comment" class="primary_textarea4 radius_5px mb_25" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="amaz_primary_btn3">{{ __('product.report_product') }}</button>
            </div>
          </div>
      </form>
    </div>
  </div>
