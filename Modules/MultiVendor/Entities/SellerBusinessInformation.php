<?php

namespace Modules\MultiVendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Setup\Entities\City;
use Modules\Setup\Entities\Country;
use Modules\Setup\Entities\State;

class SellerBusinessInformation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function country(){
        return $this->belongsTo(Country::class,'business_country','id');
    }
    public function state(){
        return $this->belongsTo(State::class,'business_state', 'id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'business_city', 'id');
    }
}
