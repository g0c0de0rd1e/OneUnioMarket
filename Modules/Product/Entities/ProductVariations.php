<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductVariations extends Model
{
    protected $table = "product_variations";
    protected $guarded = ["id"];
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'product_sku_id' => 'integer',
        'attribute_id' => 'integer',
        'attribute_value_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public static function boot()
    {
        parent::boot();
        static::created(function ($model) {
            $model->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });


    }
    public function product_sku()
    {
        return $this->belongsTo(ProductSku::class, "product_sku_id");
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attribute_value()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
