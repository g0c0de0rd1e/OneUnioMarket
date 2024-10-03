<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Entities\WalletBalance;
use Modules\Customer\Entities\CustomerAddress;
use Modules\Marketing\Entities\CouponUse;
use Modules\GST\Entities\OrderPackageGST;
use Modules\GiftCard\Entities\GiftCardUse;
use Modules\OrderManage\Entities\CancelReason;
use Carbon\Carbon;
use Modules\Affiliate\Entities\AffiliateReferralPayment;
use Modules\PaymentGateway\Entities\PaymentMethod;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        "grand_total" => "double",
        "sub_total" => "double",
        "tax_amount" => "double",
        "is_paid" => "integer",
        "is_confirmed" => "integer",
        "is_completed" => "integer",
        "is_cancelled" => "integer",
        "customer_id" => "integer",
        "order_payment_id" => "integer",
        "order_status" => "string",
        "shipping_total" => "double"
    ];

    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(User::class,'customer_id','id');
    }

    public function cancel_reason(){
        return $this->belongsTo(CancelReason::class,'cancel_reason_id','id');
    }

    public function packages(){
        return $this->hasMany(OrderPackageDetail::class,'order_id','id');
    }

    public function gift_card_uses(){
        return $this->hasMany(GiftCardUse::class,'order_id','id');
    }

    public function guest_info()
    {
        return $this->hasOne(GuestOrderDetail::class,'order_id','id');
    }

    public function order_payment(){
        return $this->belongsTo(OrderPayment::class,'order_payment_id', 'id');
    }

    public function shipping_address(){
        return $this->belongsTo(CustomerAddress::class, 'customer_shipping_address','id');
    }

    public function billing_address(){
        return $this->belongsTo(CustomerAddress::class, 'customer_billing_address','id');
    }
    public function address(){
        return $this->hasOne(OrderAddressDetail::class,'order_id', 'id');
    }

    public function wallets()
    {
        return $this->morphMany(WalletBalance::class, 'walletable');
    }
    public function coupon(){
        return $this->hasOne(CouponUse::class,'order_id','id');
    }
    public function method()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_type');
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

    public function getTotalGstAmountAttribute()
    {
        $order_id = $this->id;
        return OrderPackageGST::whereHas('order_package', function($q) use($order_id){
            $q->where('order_id', $order_id);
        })->get()->sum('amount');
    }

    public function scopeTotalSaleCount($query, $type)
    {
        $year = Carbon::now()->year;
        if ($type == "today") {
            return $query->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->where('is_confirmed',1)->sum('grand_total');
        }
        if ($type == "week") {
            return $query->whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"])->where('is_confirmed',1)->sum('grand_total');
        }
        if ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->where('is_confirmed',1)->sum('grand_total');
        }
        if ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            return $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"])->where('is_confirmed',1)->sum('grand_total');
        }

    }

    public function scopeOrderInfo($query, $type, $state)
    {
        $year = Carbon::now()->year;
        if ($type == "today") {
            $query->whereBetween('created_at', [Carbon::now()->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        elseif ($type == "week") {
            $query->whereBetween('created_at', [Carbon::now()->subDays(7)->format('y-m-d')." 00:00:00", Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        elseif ($type == "month") {
            $month = Carbon::now()->month;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"]);
        }
        elseif ($type == "year") {
            $date_1 = Carbon::create($year, 1)->startOfMonth()->format('Y-m-d')." 00:00:00";
            $query->whereBetween('created_at', [$date_1, Carbon::now()->format('y-m-d')." 23:59:59"]);
        }

        if ($state === "all") {
            return $query->count();
        }
        elseif ($state === 0) {
            return $query->where('is_confirmed', 0)->count();
        }
        elseif ($state === 1) {
            return $query->where('is_completed', 1)->count();
        }

    }

    public function affiliateUser(){
        return $this->hasOne(AffiliateReferralPayment::class,'order_id','id');
    }
    public function affiliatePayments(){
        return $this->hasMany(AffiliateReferralPayment::class,'order_id','id');
    }
}
