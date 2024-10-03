<?php

namespace Modules\MultiVendor\Entities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class SellerCommssionType extends Model
{
    use HasFactory , HasTranslations;
    protected $table = "seller_commissions";
    protected $guarded = ["id"];
    public $translatable = [];
    protected $appends = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name','description'];
            $this->appends = ['translateName','TranslateDescripton'];
        }
    }
    public static function boot()
    {
        parent::boot();
        static::created(function ($brand) {
            $brand->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($brand) {
            $brand->updated_by = Auth::user()->id ?? null;
        });
    }
    public function getTranslateNameAttribute(){
        return $this->attributes['name'];
    }
    public function getTranslateDescriptonAttribute(){
        return $this->attributes['description'];
    }
}
