<label class="switch_toggle" for="active_checkbox{{ $seller->user->id }}">
    <input type="checkbox" id="active_checkbox{{ $seller->user->id }}" @if ($seller->user->is_active == 1) checked @endif value="{{ $seller->user->id }}" class="seller_status" data-id="{{ $seller->user->id }}"/>
    <div class="slider round"></div>
</label>
