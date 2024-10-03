<?php

namespace Modules\FooterSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Modules\FrontendCMS\Entities\DynamicPage;
use Spatie\Translatable\HasTranslations;

class FooterWidget extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id'];
    protected $appends = [];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name'];
            $this->appends = ['translateName'];
        }
    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('footerWidget');
        });
        self::updated(function ($model) {
            Cache::forget('footerWidget');
        });
        self::deleted(function($model){
            Cache::forget('footerWidget');
        });
    }
    
    public function pageData(){
        return $this->belongsTo(DynamicPage::class,'page', 'id');
    }
    public function getTranslateNameAttribute(){
        return $this->attributes['name'];
    }
}
