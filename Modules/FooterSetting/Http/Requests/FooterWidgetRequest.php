<?php

namespace Modules\FooterSetting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FooterWidgetRequest extends FormRequest
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
                'name.'. $code => 'required',
                'page' => 'required',
            ];
        }else{
            return [
                'name' => 'required',
                'page' => 'required',
            ];
        }
        
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'name.*.required' => 'The page name field is required',
            ];
        }else{
            return [
                'name.required' => 'The page name field is required',
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
