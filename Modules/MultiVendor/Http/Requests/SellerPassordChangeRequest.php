<?php

namespace Modules\MultiVendor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerPassordChangeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'seller_new_password' => 'required|min:8'
        ];
    }

    public function attributes()
    {
        return [
            'seller_new_password' =>__('seller.new_password')
        ];
    }

    public function authorize()
    {
        return true;
    }
}
