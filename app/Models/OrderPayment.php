<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PaymentGateway\Entities\PaymentMethod;
use Modules\Wallet\Entities\BankPayment;

class OrderPayment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function item_details()
    {
        return $this->morphOne(BankPayment::class, 'itemable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method');
    }

    public function order(){
        return $this->hasOne(Order::class, 'order_payment_id', 'id');
    }

    public function getGatewayNameAttribute()
    {
        switch ($this->method->slug) {
            case 'cash-on-delivery':
                return __("payment_gatways.cash_on_delivery");
                break;
            case 'wallet':
                return __("payment_gatways.wallet");
                break;
            case 'paypal':
                return __("payment_gatways.paypal");
                break;
            case 'stripe':
                return __("payment_gatways.stripe");
                break;
            case 'paystack':
                return __("payment_gatways.paystack");
                break;
            case 'razorpay':
                return __("payment_gatways.razorpay");
                break;
            case 'bank-payment':
                return __("payment_gatways.bank_payment");
                break;
            case 'instamojo':
                return __("payment_gatways.instamojo");
                break;
            case 'paytm':
                return __("payment_gatways.paytm");
                break;
            case 'midtrans':
                return __("payment_gatways.midtrans");
                break;
            case 'payumoney':
                return __("payment_gatways.payumoney");
                break;
            case 'jazzcash':
                return __("payment_gatways.jazzcash");
                break;
            case 'google-pay':
                return __("payment_gatways.google_pay");
                break;
            case 'flutterwave':
                return __("payment_gatways.flutter_wave_payment");
                break;
            case 'bkash':
                return __("payment_gatways.bkash");
                break;
            case 'sslcommerz':
                return __("payment_gatways.ssl_commerz");
                break;
            case 'mercado-pago':
                return __("payment_gatways.mercado_pago");
                break;
            case 'tabby':
                return __("payment_gatways.tabby");
                break;
            case 'ccavenue':
                return __("payment_gatways.ccavenue");
                break;
            default:
                return $this->payment_method;
                break;
        }
    }
}
