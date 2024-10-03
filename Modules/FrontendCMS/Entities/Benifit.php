<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Benifit extends Model
{
    use HasFactory , HasTranslations;

    protected $guarded = ['id'];
    protected $appends = [];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['title','description'];
            $this->appends = ['translateName','TranslateDescription'];
        }
    }
    public function getTranslateNameAttribute(){
        return $this->attributes['title'];
    }
    public function getTranslateDescriptionAttribute(){
        return $this->attributes['description'];
    }
}
