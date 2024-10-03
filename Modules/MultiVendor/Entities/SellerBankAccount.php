<?php

namespace Modules\MultiVendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SellerBankAccount extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
}
