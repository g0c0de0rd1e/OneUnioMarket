<label class="switch_toggle" for="active_checkbox{{ $subscription->id }}">
    <input type="checkbox" class="is_approve" id="active_checkbox{{ $subscription->id }}" @if (@$subscription->is_approved == 1) checked disabled @endif value="{{ $subscription->id }}">
    <div class="slider round"></div>
</label>
