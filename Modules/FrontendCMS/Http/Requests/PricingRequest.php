<?php

namespace Modules\FrontendCMS\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class PricingRequest extends FormRequest
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
                'name.'. $code => "required|unique_translation:pricings,name,{$this->id}",

                'status' =>'required'
            ];
        }else{
            return [
                'name' =>'required|unique:pricings,name,'.$this->id,

                'status' =>'required'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'name.*.required' => 'The name field is required',
                'name.*.unique_translation' => 'The name field has already been taken',
            ];
        }else{
            return [
                'name.required' => 'The name field is required',
                'name.unique' => 'The name field has already been taken',
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
