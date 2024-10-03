<?php

namespace Modules\Marketing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seller\Entities\SellerProduct;

class FlashDealProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'flash_deal_id' => 'integer',
        'seller_product_id' => 'integer',
        'discount' => 'double',
        'discount_type' => 'integer',
        'status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function flashDeal(){
        return $this->belongsTo(FlashDeal::class,'flash_deal_id','id');
    }

    public function product(){
        return $this->belongsTo(SellerProduct::class,'seller_product_id','id')->activeSeller();
    }
    public function productAll(){
        return $this->belongsTo(SellerProduct::class,'seller_product_id','id');
    }
}
