<?php

namespace Modules\MultiVendor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerBankAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_title' => 'required|max:255',
            'bank_account_number' => 'required|max:255',
            'bank_name' => 'required|max:255',
            'branch_name' => 'required|max:255',
            'routing_number' => 'required|max:255',
            'ibn' => 'required|max:255'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
