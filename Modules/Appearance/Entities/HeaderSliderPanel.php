<?php

namespace Modules\Appearance\Entities;
use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Seller\Entities\SellerProduct;
use Modules\Setup\Entities\Tag;
use Spatie\Translatable\HasTranslations;

class HeaderSliderPanel extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = ['id'];
    protected $appends = ['product', 'brand', 'tag'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name'];
        }
    }
    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
        self::updated(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
        self::deleted(function ($model) {
            Cache::forget('HeaderSection');
            Cache::forget('productSectionItems');
        });
    } 
    public function getProductAttribute(){
        return SellerProduct::with(['product'])->where('id',$this->data_id)->first();
    }
    public function category(){
        return $this->hasOne(Category::class,'id','data_id');
    }
    public function getBrandAttribute(){
        return Brand::where('id', $this->data_id)->first();
    }
    public function getTagAttribute(){
        return Tag::where('id', $this->data_id)->first();
    }
    public function slider_image_media(){
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'slider_image');
    }
}
