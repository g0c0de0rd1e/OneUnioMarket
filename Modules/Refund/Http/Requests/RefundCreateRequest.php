<?php

namespace Modules\Refund\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefundCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    
    public function rules()
    {
        return [
            'product_ids' => 'required|present|array',
            'pick_up_address_id' => 'required',
            'bank_name' => 'required_if:money_get_method,bank_transfer',
            'branch_name' => 'required_if:money_get_method,bank_transfer',
            'account_name' => 'required_if:money_get_method,bank_transfer',
            'account_no' => 'required_if:money_get_method,bank_transfer',
        ];
    }
    public function messages()
    {
        return [
            'bank_name.required_if' => 'The bank name field is required',
            'branch_name.required_if' => 'The branch name field is required',
            'account_name.required_if' => 'The account name field is required',
            'account_no.required_if' => 'The account no field is required',
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
