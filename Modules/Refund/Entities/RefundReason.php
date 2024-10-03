<?php

namespace Modules\Refund\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class RefundReason extends Model
{
    use HasFactory, HasTranslations;
    protected $table = "refund_reasons";
    protected $guarded = ["id"];
    protected $appends = [];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['reason'];
            $this->appends = ['translateReason'];
        }
    }
    public function getTranslateReasonAttribute(){
        return $this->attributes['reason'];
    }
}
