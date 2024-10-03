<?php

namespace Modules\Marketing\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class BulkSMSRequest extends FormRequest
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
                'title.'. $code => 'required',
                'message.'. $code => 'required',
                'send_to' => 'required',
                'publish_date' => 'required'
            ];
        }else{
            return [
                'title' => 'required',
                'message' => 'required',
                'send_to' => 'required',
                'publish_date' => 'required'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'title.*.required' => 'The title field is required',
                'message.*.required' => 'The message field is required',
            ];
        }else{
            return [
                'title.required' => 'The title is field required',
                'message.required' => 'The message is field required',
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
