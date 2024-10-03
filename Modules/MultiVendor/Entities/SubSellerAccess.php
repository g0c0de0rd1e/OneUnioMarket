<?php

namespace Modules\MultiVendor\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSellerAccess extends Model
{
    use HasFactory;
    protected $table = "sub_seller_accesses";
    protected $guarded = ['id'];

}
