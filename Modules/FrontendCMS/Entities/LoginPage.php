<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class LoginPage extends Model
{
    use HasFactory , HasTranslations;
    protected $table = "login_pages";
    public $timestamps=true;
    protected $guarded = ['id'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['title','sub_title'];
        }
    }
}
