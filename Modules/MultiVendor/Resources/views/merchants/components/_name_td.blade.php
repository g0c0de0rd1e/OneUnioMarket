@if (@$seller->user->slug)

<a target="_blank" href="{{route('frontend.seller',@$seller->user->slug)}}">{{@$seller->user->first_name}} {{@$seller->user->last_name}}</a>
@else
<a target="_blank" href="{{route('frontend.seller',base64_encode(@$seller->user->id))}}">{{@$seller->user->first_name}} {{@$seller->user->last_name}}</a>
@endif

