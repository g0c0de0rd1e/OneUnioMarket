@foreach($giftCards->addGiftCard as $addGiftCard)
    @if ($loop->last)
        {{$addGiftCard->number_of_gift_card}}
    @else
        {{$addGiftCard->number_of_gift_card}},
    @endif
    @endforeach   
