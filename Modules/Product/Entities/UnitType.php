<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Translatable\HasTranslations;

class UnitType extends Model
{
    use HasTranslations;
    protected $table = "unit_types";
    protected $guarded = ["id"];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'status' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    public $translatable = [];
    protected $appends = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (isModuleActive('FrontendMultiLang')) {
            $this->translatable = ['name'];
            $this->appends = ['translateName'];
        }
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($unit_type) {
            $unit_type->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($unit_type) {
            $unit_type->updated_by = Auth::user()->id ?? null;
        });
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function products()
    {
        return $this->hasMany(Product::class,'unit_type_id','id');
    }

    protected static function factory(){
        return \Modules\Product\Database\factories\UnitFactory::new();
    }
    public function getTranslateNameAttribute(){
        return $this->attributes['name'];
      }
}
