<?php

namespace SpondonIt\AmazCartService\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = array();

        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ];

        return $rules;
    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes()
    {
        return [

            'email'                 => trans('amazcart::install.email'),
            'password'              => trans('amazcart::install.password'),
            'password_confirmation' => trans('amazcart::install.password_confirmation'),
        ];
    }

    public function messages()
    {
        return [
            "password.min" => trans('amazcart::install.the_password_must_be_at_least_8_characters')
        ];
    }
}
