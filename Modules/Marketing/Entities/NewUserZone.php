<?php

namespace Modules\Marketing\Entities;

use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class NewUserZone extends Model
{
    use HasFactory, HasTranslations;
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['title','sub_title','product_navigation_label','category_navigation_label','product_slogan','category_slogan','coupon_slogan','coupon_navigation_label'];
        }
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
    protected $guarded = ['id'];
    
    public function products(){
        return $this->hasMany(NewUserZoneProduct::class,'new_user_zone_id','id')->with('product.product');
    }

    public function categories(){
        return $this->hasMany(NewUserZoneCategory::class,'new_user_zone_id','id')->orderBy('position');
    }

    public function coupon(){
        return $this->hasOne(NewUserZoneCoupon::class,'new_user_zone_id','id');
    }
    public function couponCategories(){
        return $this->hasMany(NewUserZoneCouponCategory::class,'new_user_zone_id', 'id')->orderBy('position');
    }

    public function getAllProductsAttribute(){
        return NewUserZoneProduct::with('product.product')->where('new_user_zone_id', $this->id)->latest()->paginate(10);
    }

    public function getProductForAPIHomePageAttribute(){
        return NewUserZoneProduct::with('product.product')->where('new_user_zone_id', $this->id)->latest()->take(2)->get();
    }
    public function banner_image_media(){
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'banner_image');
    }
}
