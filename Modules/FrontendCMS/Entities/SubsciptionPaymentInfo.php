<?php

namespace Modules\FrontendCMS\Entities;


use Illuminate\Database\Eloquent\Model;
use Modules\Wallet\Entities\BankPayment;
use Modules\Account\Entities\Transaction;
use Modules\MultiVendor\Entities\SellerSubcription;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubsciptionPaymentInfo extends Model
{
    use HasFactory;
    protected $table = 'subscription_payment_info';
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id')->withDefault();
    }

    public function item_details()
    {
        return $this->morphOne(BankPayment::class, 'itemable');
    }

    public function sellerSubscription()
    {
        return $this->belongsTo(SellerSubcription::class,'seller_id');
    }
}
