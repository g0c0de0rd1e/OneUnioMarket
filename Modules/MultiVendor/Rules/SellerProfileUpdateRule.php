<?php

namespace Modules\MultiVendor\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use App\Traits\GenerateSlug;

class SellerProfileUpdateRule implements Rule
{
    use GenerateSlug;
   
    public function passes($attribute, $value)
    {
        $slug = $this->productSlug($value);
        $seller_id = getParentSellerId();
        $user = User::where('id', '!=', $seller_id)->first();
        
        if($user){
            return true;
        }
        return false;

    }
    public function message()
    {
        return 'Shop Name Already Taken.';
    }
}
