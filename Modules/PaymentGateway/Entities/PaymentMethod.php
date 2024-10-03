<?php

namespace Modules\PaymentGateway\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'integer',
        'method' => 'string',
        'slug' => 'string',
        'type' => 'string',
        'active_status' => 'integer',
        'module_status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function sellerPaymentMethod()
    {
        return $this->hasOne(SellerWisePaymentGateway::class, 'payment_method_id', 'id');
    }

    public function ActivePaymentWithoutCheckout()
    {
        return $this->hasOne(SellerWisePaymentGateway::class, 'payment_method_id', 'id')->where('user_id', 1);
    }

    public function getLogoAttribute($value)
    {
        return (string) $value;
    }
}
