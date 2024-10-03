<?php

namespace Modules\GiftCard\Entities;
use App\Models\User;
use App\Models\Wishlist;
use Modules\GiftCard\Entities\AddGiftCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Review\Entities\ProductReview;

class DigitalGiftCard extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function addGiftCard(){
        return $this->hasMany(AddGiftCard::class,'digilat_gift_id','id');
    }
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->created_by == null) {
                $model->created_by = Auth::user()->id ?? null;
            }
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }

    public function hasDiscount(){
        if($this->start_date <= date('Y-m-d') && $this->end_date >= date('Y-m-d') && $this->discount > 0){
            return true;
        }else{
            return false;
        }
    }

    public function seller(){
        return $this->belongsTo(User::class,'created_by', 'id');
    }

    public function reviews(){
        return $this->hasMany(ProductReview::class,'product_id','id');
    }

    public function getActiveReviewsAttribute(){
        return ProductReview::where('type', 'digital_gift_card')->where('product_id', $this->id)->latest()->paginate(10);
    }
    public function shippingMethod(){
        return $this->belongsTo(ShippingMethod::class,'shipping_id','id');
    }

    public function getIsWishlistAttribute(){
        if(auth()->check()){
            $wishlist = Wishlist::where('seller_product_id',$this->id)->where('type','digital_gift_card')->where('user_id',auth()->user()->id)->first();
            if($wishlist){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function getProductTypeAttribute(){
        return 'digital_gift_card';
    }
   
}
