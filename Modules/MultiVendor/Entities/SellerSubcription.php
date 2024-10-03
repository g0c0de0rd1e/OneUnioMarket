<?php

namespace Modules\MultiVendor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FrontendCMS\Entities\Pricing;
use Modules\Account\Entities\Transaction;
use App\Models\User;

class SellerSubcription extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'seller_id')->withDefault();
    }

    public function pricing()
    {
        return $this->belongsTo(Pricing::class, 'pricing_id')->withDefault();
    }

    public function payments()
    {
        return $this->morphMany(Transaction::class, 'morphable');
    }
}
