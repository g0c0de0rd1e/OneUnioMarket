<?php

namespace Modules\GiftCard\Entities;
use Modules\GiftCard\Entities\DigitalGiftCard;
use Modules\GiftCard\Entities\GiftCoupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AddGiftCard extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'add_gift_cards';
    
    public function digitalGiftCard(){
        return $this->belongsTo(DigitalGiftCard::class, 'digilat_gift_id','id');
    }

    public function giftCoupons(){
        return $this->hasMany(GiftCoupon::class,'add_gift_id');
    }

    public function hasDiscount(){
        if($this->start_date <= date('Y-m-d') && $this->end_date >= date('Y-m-d') && $this->gift_discount_amount > 0){
            return true;
        }else{
            return false;
        }
    }
}
