<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\EmailTemplate;
use Spatie\Translatable\HasTranslations;

class RefundProcess extends Model
{
    use HasFactory, HasTranslations;
    protected $table = 'refund_processes';
    protected $guarded = ['id'];
    protected $appends = [];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name','description'];
            $this->appends = ['translateName','TranslateDescription'];
        }
    }
    public function getTranslateNameAttribute(){
        return $this->attributes['name'];
    }
    public function getTranslateDescriptionAttribute(){
        return $this->attributes['description'];
    }

    public function email_templates()
    {
        return $this->morphMany(EmailTemplate::class, 'relatable');
    }
}
