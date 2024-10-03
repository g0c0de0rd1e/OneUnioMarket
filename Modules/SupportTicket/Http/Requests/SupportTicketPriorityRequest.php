<?php

namespace Modules\SupportTicket\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupportTicketPriorityRequest extends FormRequest
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
                'name.'. $code => "required|unique_translation:support_ticket_pirority,name,{$this->id}",
            ];
        }else{
            return [
                'name' => 'required|string|unique:support_ticket_pirority,name,'.$this->id,
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'name.*.required' => 'The name field is required.',
                'name.*.unique_translation' => 'The name has already been taken.',
            ];
        }else{
            return [
                'name.required' => 'The name field is required.',
                'name.unique' => 'The name has already been taken.',
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
