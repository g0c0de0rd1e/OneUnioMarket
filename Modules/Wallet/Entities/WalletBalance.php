<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Modules\PaymentGateway\Entities\PaymentMethod;

class WalletBalance extends Model
{
    use HasFactory;
    protected $table = 'wallet_balances';
    protected $guarded = ['id'];

    public function walletable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item_details()
    {
        return $this->morphMany(BankPayment::class, 'itemable');
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method');
    }

    public function getGatewayNameAttribute()
    {
        if ($this->method) {
           $method = $this->method->slug;
        }else{
            $method = $this->payment_method;
        }
        switch ($method) {
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
            case 'BankPayment':
                return __("payment_gatways.bank_payment");
                break;
            default:
                return $this->payment_method;
                break;
        }
    }
}
