<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class InQuery extends Model
{
    use HasFactory,HasTranslations;

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
    public function getTranslateNameAttribute(){
        return $this->attributes['name'];
      }
   
}
