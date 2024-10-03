<?php

namespace Modules\FrontendCMS\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class MerchantContent extends Model
{
    use HasFactory , HasTranslations;

    protected $guarded = ['id'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['mainTitle','subTitle','Maindescription','pricing','benifitTitle','benifitDescription','howitworkTitle','howitworkDescription','pricingTitle','pricingDescription','sellerRegistrationTitle','sellerRegistrationDescription','queryTitle','queryDescription','faqTitle','faqDescription'];
        }
    }
}
