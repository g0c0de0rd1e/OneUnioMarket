<?php

namespace Modules\Product\Entities;
use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\WholeSale\Entities\WholesalePrice;

class ProductSku extends Model
{
    protected $guarded = ["id"];
    protected $table = "product_sku";
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'product_id' => 'integer',
        'product_sku_id' => 'string',
        'product_stock' => 'integer',
        'purchase_price' => 'double',
        'selling_price' => 'double',
        'status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function product_variations()
    {
        return $this->hasMany(ProductVariations::class);
    }

    public function digital_file()
    {
        return $this->hasOne(DigitalFile::class);
    }
    public function variant_image_media(){
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'variant_image');
    }

    public function sellerProductSku(){
        return $this->hasOne(SellerProductSKU::class,'product_sku_id','id');
    }
   public function getSellPriceAttribute(){
        if (app('general_setting')->price_with_vat) {
            return $this->attributes['selling_price'] + ($this->product->tax ?? 0);
        }else{
            return $this->attributes['selling_price'];
        }
    }
}
