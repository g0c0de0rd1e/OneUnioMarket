<?php

namespace Modules\Marketing\Entities;

use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class FlashDeal extends Model
{
    use HasTranslations;
    protected $guarded = ['id'];
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'background_color' => 'string',
        'text_color' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'slug' => 'string',
        'banner_image' => 'string',
        'status' => 'integer',
        'is_featured' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
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
                $model->created_by = Auth::user()->id ?? null;
            }
        });
        static::updating(function ($model) {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }
    public function products()
    {
        return $this->hasMany(FlashDealProduct::class, 'flash_deal_id', 'id');
    }
    public function getAllProductsAttribute()
    {
        return FlashDealProduct::with('product.product')->where('flash_deal_id', $this->id)->latest()->paginate(10);
    }
    public function getProductForHomePageAppAttribute()
    {
        return FlashDealProduct::with('product.product')->where('flash_deal_id', $this->id)->latest()->take(10)->get();
    }
    public function flash_deal_banner_image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'flash_deal_banner_image');
    }
    public function getBannerImageAttribute($value)
    {
        return  (string) $value ;
    }
}
