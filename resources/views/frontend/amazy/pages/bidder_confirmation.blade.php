@extends('frontend.amazy.layouts.app')
@section('title')
 {{'Bidder Confirmation'}}
@endsection
@section('content')

<div class="text-center container mt_30 mb_30">
    <h1>Winner of Auction</h1>
    <h3>Please confirm your order by clicking below button</h3>
</div>
<div class="container mt_30 mb_30 min-vh-50 text-center">
    <a href="{{route('auctionproducts.confirm.order',[$auction_id,$bid_id])}}" class="amaz_primary_btn min_200 style2 cursor_pointer" data-value="">{{__('defaultTheme.auction_confirmation')}}</a>
    <a href="{{route('auctionproducts.cancel.order',[$auction_id,$bid_id])}}" class="amaz_primary_btn min_200 style2 cursor_pointer" data-value="">{{__('defaultTheme.auction_cancel')}}</a>
</div>
@endsection

