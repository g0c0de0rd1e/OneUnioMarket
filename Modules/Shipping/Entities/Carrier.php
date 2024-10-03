<?php

namespace Modules\Shipping\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Carrier extends Model
{
    use HasFactory , HasTranslations;
    protected $fillable = [
        'name',
        'logo',
        'status',
        'type',
        'slug',
        'tracking_url',
        'created_by',
    ];

    protected $casts = ['status' => "integer"];

    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name'];
        }
    }
    public function shippingMethods(){
        return $this->hasMany(ShippingMethod::class,'carrier_id', 'id');
    }
    public function carrierConfig()
    {
        $user_id = getParentSellerId();
        return $this->hasOne(SellerWiseCarrierConfig::class,'carrier_id')->where('seller_id',$user_id);
    }
    public function carrierConfigFrontend(){
        return $this->hasOne(SellerWiseCarrierConfig::class,'carrier_id');
    }
}
