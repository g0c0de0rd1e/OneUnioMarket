<?php

namespace Modules\OrderManage\Entities;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    use HasFactory;
    protected $guarded = ['id'];



    protected $hidden = [
        'order_id',
        'customer_id',
        'seller_id',
        'url',
        'description',
        'read_status',
        'super_admin_read_status',
        'updated_at',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id','id');
    }
}
