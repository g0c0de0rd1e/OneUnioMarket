<?php

namespace Modules\Refund\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefundProcessRequest extends FormRequest
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
                'name.'. $code => "required|max:255|unique_translation:refund_processes,name,{$this->id}",
                'description.'. $code => 'required'
            ];
        }else{
            return [
                'name' => 'required|max:255|unique:refund_processes,name,'.$this->id,
                'description' => 'required'
            ];
        }
        
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'name.*.required' => 'The name field is required',
                'name.*.unique_translation' => 'The name field is already be taken',
                'description.*.required' => 'The description field is required',
            ];
        }else{
            return [
                'name.required' => 'The name field is required',
                'name.*.unique' => 'The name field is already be taken',
                'description.required' => 'The description field is required',
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
