<?php

namespace Modules\MultiVendor\Rules;

use App\Models\User;
use App\Traits\GenerateSlug;
use Illuminate\Contracts\Validation\Rule;

class SellerValidateRule implements Rule
{
    use GenerateSlug;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $slug = $this->productSlug($value);
        $user = User::where('slug', $slug)->first();
        if($user){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Shop Name Already Taken.';
    }
}
