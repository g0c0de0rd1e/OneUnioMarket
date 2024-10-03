@if ($subscription->item_details)
<a href="{{ showImage($subscription->item_details->image_src) }}" target="_blank">{{ @$subscription->transaction->payment_method }}</a>
@else
    {{ @$subscription->transaction->payment_method }}
@endif
