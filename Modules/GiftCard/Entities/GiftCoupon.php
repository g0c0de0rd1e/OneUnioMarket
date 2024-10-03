<?php

namespace Modules\GiftCard\Entities;
use Modules\GiftCard\Entities\AddGiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GiftCoupon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function addGiftCard(){
        return $this->hasMany(AddGiftCard::class,'add_gift_id','id');
    }

}
