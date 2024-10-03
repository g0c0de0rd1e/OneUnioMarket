@php
    if(session()->has('order_payment') && app('general_setting')->seller_wise_payment && session()->has('seller_for_checkout')){
        $credential = getPaymentInfoViaSellerId(session()->get('seller_for_checkout'), 'jazzcash');
    }else{
        $credential = getPaymentInfoViaSellerId(1, 'jazzcash');
    }

    if (@$credential->perameter_1 == "sandbox") {
        $PAYU_BASE_URL = "https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/";
    }
    else {
        $PAYU_BASE_URL = @$credential->perameter_5;
    }


    $MerchantID = $credential->perameter_2; //Your Merchant from transaction Credentials
    $Password = $credential->perameter_3; //Your Password from transaction Credentials
    $HashKey = $credential->perameter_4; //Your HashKey/integrity salt from transaction Credentials
    $ReturnURL = route('jazzcash.payment_status'); //Your Return URL, It must be static

    $pp_Amount 	= $total_amount - $coupon_am * 100;
    $DateTime 		= new \DateTime();
    $pp_TxnDateTime = $DateTime->format('YmdHis');
    $ExpiryDateTime = $DateTime;
    $ExpiryDateTime->modify('+' . 1 . ' hours');
    $pp_TxnExpiryDateTime = $ExpiryDateTime->format('YmdHis');
    $pp_TxnRefNo = 'PAK'.$pp_TxnDateTime;

    date_default_timezone_set("Asia/karachi");
    $Amount = 1*round($pp_Amount*100,2); //Last two digits will be considered as Decimal
    $BillReference = "checkoutPay"; //use AlphaNumeric only
    $Description = "Checkout Purpose Payment"; //use AlphaNumeric only
    $IsRegisteredCustomer = "No"; // do not change it
    $Language = "EN"; // do not change it
    $TxnCurrency = "PKR"; // do not change it
    $TxnDateTime = date('YmdHis');
    $TxnExpiryDateTime = date('YmdHis', strtotime('+1 Days'));
    $TxnRefNumber = $pp_TxnRefNo;
    $TxnType = ""; // Leave it empty
    $Version = '2.0';
    $SubMerchantID = ""; // Leave it empty
    $BankID = ""; // Leave it empty
    $ProductID = ""; // Leave it empty
    $ppmpf_1 = ""; // use to store extra details (use AlphaNumeric only)
    $ppmpf_2 = ""; // use to store extra details (use AlphaNumeric only)
    $ppmpf_3 = ""; // use to store extra details (use AlphaNumeric only)
    $ppmpf_4 = ""; // use to store extra details (use AlphaNumeric only)
    $ppmpf_5 = ""; // use to store extra details (use AlphaNumeric only)

    $HashArray = [$Amount, $BankID, $BillReference, $Description, $IsRegisteredCustomer,
    $Language, $MerchantID, $Password, $ProductID, $ReturnURL, $TxnCurrency, $TxnDateTime,
    $TxnExpiryDateTime, $TxnRefNumber, $TxnType, $Version, $ppmpf_1, $ppmpf_2, $ppmpf_3,
    $ppmpf_4, $ppmpf_5];

    $SortedArray = $HashKey;
    for ($i = 0; $i < count($HashArray); $i++) {
        if ($HashArray[$i] != 'undefined' and $HashArray[$i] != null and $HashArray[$i] != "") {
            $SortedArray .= "&" . $HashArray[$i];
        }
    }
    $Securehash = hash_hmac('sha256', $SortedArray, $HashKey);


@endphp

<form id="contactForm" action="{{ $PAYU_BASE_URL }}" class="p-0" method="POST" class="d-none">

    <input type="hidden" name="pp_Amount" value="<?php echo $Amount; ?>">
    <input type="hidden" id="pp_BankID" name="pp_BankID" value="<?php echo $BankID?>">
    <input type="hidden" name="pp_BillReference" value="<?php echo $BillReference ?>" />
    <input type="hidden" name="pp_Description" value="<?php echo $Description; ?>" />
    <input type="hidden" name="pp_Version" value="<?php echo $Version; ?>" >
    <input type="hidden" name="pp_TxnType" placeholder="TxnType" value="<?php echo  $TxnType; ?>" />
    <input type="hidden" name="pp_Language" value="<?php echo $Language; ?>">
    <input type="hidden" name="pp_MerchantID" value="<?php echo $MerchantID; ?>">
    <input type="hidden" name="pp_SubMerchantID" value="<?php echo $SubMerchantID; ?>">
    <input type="hidden" name="pp_Password" value="<?php echo $Password; ?>">
    <input type="hidden" name="pp_TxnRefNo" value="<?php echo $TxnRefNumber; ?>">
    <input type="hidden" name="pp_TxnCurrency" value="<?php echo $TxnCurrency; ?>" />
    <input type="hidden" name="pp_TxnDateTime" value="<?php echo $TxnDateTime; ?>" />
    <input type="hidden" name="pp_IsRegisteredCustomer" value="<?php echo $IsRegisteredCustomer; ?>" />
    <input type="hidden" id="pp_ProductID" name="pp_ProductID" value="<?php echo $ProductID ?>">
    <input type="hidden" name="pp_TxnExpiryDateTime" value="<?php echo $TxnExpiryDateTime; ?>" />
    <input type="hidden" name="pp_ReturnURL" value="<?php echo $ReturnURL; ?>" />
    <input type="hidden" name="pp_SecureHash" value="<?php echo $Securehash; ?>" />
    <input type="hidden" name="ppmpf_1" placeholder="ppmpf_1" value="<?php echo $ppmpf_1; ?>" />
    <input type="hidden" name="ppmpf_2" placeholder="ppmpf_2" value="<?php echo $ppmpf_2; ?>" />
    <input type="hidden" name="ppmpf_3" placeholder="ppmpf_3" value="<?php echo $ppmpf_3; ?>" />
    <input type="hidden" name="ppmpf_4" placeholder="ppmpf_4" value="<?php echo $ppmpf_4; ?>" />
    <input type="hidden" name="ppmpf_5" placeholder="ppmpf_5" value="<?php echo $ppmpf_5; ?>" />

    <button class="btn_1" type="submit" id="jazzcash_btn">{{ __('wallet.continue_to_pay') }}</button>
</form>
