<?php

namespace Modules\GeneralSetting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailTemplateRequest extends FormRequest
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
                "type_id" => 'required',
                "subject.". $code => 'required',
                "template" => 'required',
                "delivery_process_id" => "required_if:type_id,7",
                "refund_process_id" => "required_if:type_id,8",
            ];
        }else{
            return [
                "type_id" => 'required',
                "subject" => 'required',
                "template" => 'required',
                "delivery_process_id" => "required_if:type_id,7",
                "refund_process_id" => "required_if:type_id,8",
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'subject.*.required' => 'The subject field is required',
            ];
        }else{
            return [
                'subject.required' => 'The subject field is required',
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
