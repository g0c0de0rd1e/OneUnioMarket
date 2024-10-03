
    @foreach($giftCards->addGiftCard as $addGiftCard)
    @if ($loop->last)
        {{$addGiftCard->gift_card_value}}
    @else
        {{$addGiftCard->gift_card_value}},
    @endif
    @endforeach   




    