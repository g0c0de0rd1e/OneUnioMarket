<?php

namespace Modules\SupportTicket\Entities;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TicketStatus extends Model
{
    use HasTranslations;
    protected $guarded = ['id'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name'];
        }
    }
}
