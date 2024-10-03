<!-- wallet_modal::start  -->

<!-- wallet_modal::end  -->
<form action="{{route('my-wallet.store')}}" method="post">
    @csrf
    <input type="hidden" name="method" value="Clickpay">
    <input type="hidden" value="{{ $converted_amount }}" name="amount">
    @php
        $address = !empty(auth()->user()->customerAddresses[0]) ? auth()->user()->customerAddresses[0]:null;
    @endphp
    <input type="hidden" name="customer_name" value="{{ !empty($address) ? $address->name:'' }}">
    <input type="hidden" name="customer_phone" value="{{ !empty($address) ? $address->phone:'' }}">
    <input type="hidden" name="customer_email" value="{{ !empty($address) ? $address->email:'' }}">
    <input type="hidden" name="customer_address" value="{{ !empty($address) ? $address->address:'' }}">
    <input type="hidden" name="customer_state" value="{{ !empty($address) ? $address->state:'' }}">
    <input type="hidden" name="customer_city" value="{{ !empty($address) ? $address->city:'' }}">
    <input type="hidden" name="customer_country" value="{{ !empty($address) ? $address->country:'' }}">
    <input type="hidden" name="customer_postal_code" value="{{ !empty($address) ? $address->postal_code:'' }}">
    <button class="wallet_elemnt">
        <img src="http://localhost/amazcart/public/payment_gateway/click-pay.png" alt="">
    </button>
</form>

