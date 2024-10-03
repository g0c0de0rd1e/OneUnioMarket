
@foreach($giftCards->addGiftCard as $giftCouponData)
    @foreach($giftCouponData->giftCoupons as $data)
        {{$data->gift_selling_coupon}},
    @endforeach 
@endforeach



