<?php

namespace Modules\Product\Entities;

use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class CategoryImage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
        self::updated(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
        self::deleted(function ($model) {
            Cache::forget('MegaMenu');
            Cache::forget('HeaderSection');
        });
    }
    public function category_image_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'category_image');
    }

    public function getImageAttribute($value): string
    {
        return (string) $value ;
    }
}
