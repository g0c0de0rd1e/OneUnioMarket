<?php

namespace Modules\GeneralSetting\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationSettingRequest extends FormRequest
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
                'event.'. $code => 'required',
                'message.'. $code => 'required',
                'admin_msg.'. $code => 'required',
                'type' => 'required',
            ];
        }else{
            return [
                'event' => 'required',         
                'message' => 'required',         
                'admin_msg' => 'required',         
                'type' => 'required',         
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'event.*.required' => 'The event field is required',
                'message.*.required' => 'The message field is required',
                'admin_msg.*.required' => 'The admin message field is required',
                'type' => 'The type field is required',
            ];
        }else{
            return [
                'event.required' => 'The event field is required',
                'message.required' => 'The message field is required',
                'admin_msg.required' => 'The admin message field is required',
                'type' => 'The type field is required',
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
