<?php

namespace Modules\Product\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReport extends Model
{
    use HasFactory;

    protected $table = 'product_reports';

    protected $guarded = [];


    public function reason()
    {
       return $this->belongsTo(ProductReportReason::class,'reason_id');
    }


    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
