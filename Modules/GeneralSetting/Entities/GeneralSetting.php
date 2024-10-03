<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Language\Entities\Language;
use Modules\GeneralSetting\Entities\Currency;
use Modules\GeneralSetting\Entities\DateFormat;
use Modules\GeneralSetting\Entities\TimeZone;
use Spatie\Translatable\HasTranslations;

class GeneralSetting extends Model
{
    use HasTranslations;
    protected $casts   = ['country_id' => 'integer','state_id' => 'integer','city_id' => 'integer','zip_code' => 'string','login_user_checkout' => "integer"];
    protected $guarded = ['id'];


    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['footer_copy_right','footer_about_title','footer_about_description','footer_section_one_title','footer_section_two_title','footer_section_three_title','meta_site_title','meta_description','up_sale_product_display_title','cross_sale_product_display_title'];
        }
    }

     public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function dateFormat()
    {
        return $this->belongsTo(DateFormat::class);
    }

    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class);
    }

}
