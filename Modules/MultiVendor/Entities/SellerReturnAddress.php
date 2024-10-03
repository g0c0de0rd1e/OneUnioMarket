<?php

namespace Modules\MultiVendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Setup\Entities\City;
use Modules\Setup\Entities\Country;
use Modules\Setup\Entities\State;

class SellerReturnAddress extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function country(){
        return $this->belongsTo(Country::class,'return_country','id');
    }
    public function state(){
        return $this->belongsTo(State::class,'return_state', 'id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'return_city', 'id');
    }
}
