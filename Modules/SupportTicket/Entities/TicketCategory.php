<?php

namespace Modules\SupportTicket\Entities;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TicketCategory extends Model
{
    use HasTranslations;
    protected $table  = 'support_ticket_category';
    protected $fillable = ['name','status'];
    public $translatable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name'];
        }
    }
}
