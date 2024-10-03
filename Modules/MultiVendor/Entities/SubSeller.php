<?php

namespace Modules\MultiVendor\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SubSeller extends Model
{
    use HasFactory;
    protected $table = "sub_sellers";
    protected $guarded = ['id'];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id')->withDefault();
    }

    public function sub_seller()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
}
