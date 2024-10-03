<?php

namespace Modules\FrontendCMS\Entities;
use App\Models\UsedMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class SubscribeContent extends Model
{
    use HasFactory , HasTranslations;
    protected $guarded = ['id'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['title','subtitle','description'];
        }
    }
    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('popupContent');
            Cache::forget('suscriptionContent');
        });
        self::updated(function ($model) {
            Cache::forget('popupContent');
            Cache::forget('suscriptionContent');
        });
    } 
    public function popup_image_media(){
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'popup_image');
    }
}
