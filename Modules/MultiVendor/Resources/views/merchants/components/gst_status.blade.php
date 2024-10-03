@if (file_exists(base_path().'/Modules/GST/'))
    @if (app('gst_config')['enable_gst'] == "gst" || app('gst_config')['enable_gst'] == "flat_tax")
        <label class="switch_toggle" for="active_checkbox{{ @$seller->user->id }}">
            <input type="checkbox" class="ac" id="active_checkbox{{ @$seller->user->id }}" @if (@$seller->user->SellerBusinessInformation->claim_gst == 1) checked @endif @if (!permissionCheck('gst_claim_status')) disabled @else value="{{ @$seller->user->id }}" @endif>
            <div class="slider round"></div>
        </label>
    @endif
@endif
