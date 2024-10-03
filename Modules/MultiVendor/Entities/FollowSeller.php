<?php

namespace Modules\MultiVendor\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;



class FollowSeller extends Model
{
   protected $table = 'follow_seller';
    protected $fillable = ['customer_id','seller_id']; 
    
    public function seller()
    {
        return $this->belongsTo(User::class,'seller_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class,'customer_id','id');
    }
}

