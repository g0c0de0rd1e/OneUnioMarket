<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (isModuleActive('FrontendMultiLang')) {
            $code = auth()->user()->lang_code;
            return [
                'mainTitle.'. $code => 'required',
                'subTitle.'. $code => 'required',
                'email' => 'required',
                'description.'. $code => 'required'
            ];
        }else{
            return [
                'mainTitle' => 'required',
                'subTitle' => 'required',
                'email' => 'required',
                'description' => 'required'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'mainTitle.*.required' => 'The Main Title field is required',
                'subTitle.*.required' => 'The Sub Title field is required',
                'description.*.required' => 'The Details field is required',
            ];
        }else{
            return [
                'mainTitle.required' => 'The Main Title field is required',
                'subTitle.required' => 'The Sub Title field is required',
                'description.required' => 'The Details field is required',
            ];
        }
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
