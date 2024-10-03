@foreach($giftCards->addGiftCard as $addGiftCard)
    @if ($loop->last)
        {{$addGiftCard->gift_selling_price}}
    @else
        {{$addGiftCard->gift_selling_price}},
    @endif
    @endforeach   
