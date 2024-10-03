<?php

namespace Modules\Marketing\Entities;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class Coupon extends Model
{
    use HasTranslations;


    protected $casts = ['minimum_shopping' => "integer", 'maximum_discount' => 'double', 'discount' => 'integer', 'discount_type' => 'integer' ];


    protected $guarded = ['id'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['title'];
        }
    }
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            if ($model->created_by == null) {
                $seller_id = getParentSellerId();
                $model->created_by = $seller_id;
            }
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }
    public function products(){
        return $this->hasMany(CouponProduct::class,'coupon_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function coupon_uses(){
        return $this->hasMany(CouponUse::class,'coupon_id','id');
    }
}
