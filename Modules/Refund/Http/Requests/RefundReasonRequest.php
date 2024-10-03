<?php

namespace Modules\Refund\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefundReasonRequest extends FormRequest
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
                'reason.'. $code => "required|max:255|unique_translation:refund_reasons,reason,{$this->id}",
            ];
        }else{
            return [
                'reason' => 'required|max:255|unique:refund_reasons,reason,'.$this->id,
            ];
        }
        
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'reason.*.required' => 'The reason field is required',
                'reason.*.unique_translation' => 'The reason field is already be taken',
            ];
        }else{
            return [
                'reason.required' => 'The reason field is required',
                'reason.*.unique' => 'The reason field is already be taken',
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
