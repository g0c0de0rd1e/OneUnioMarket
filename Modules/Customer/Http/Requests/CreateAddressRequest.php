<?php

namespace Modules\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CreateAddressRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        	'name' => 'required',
        	'email'=> 'required|email',
            'address' => 'required',
            'phone' => 'required|min:'.app('general_setting')->min_digit.'|max:'.app('general_setting')->max_digit,
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'nullable',
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
