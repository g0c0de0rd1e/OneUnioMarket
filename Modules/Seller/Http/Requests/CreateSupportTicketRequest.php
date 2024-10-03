<?php

namespace Modules\Seller\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupportTicketRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required',
            'description' => 'required',
            'ticket_file.*' => 'nullable|mimes:jpg,jpeg,bmp,png,doc,docx,csv,rtf,xlsx,xls,txt,pdf',
            'priority_id' => 'required',
            'category_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'ticket_file.*.mimes' => 'The ticket file must be a file of type: jpg, jpeg, bmp, png, doc, docx, csv, rtf, xlsx, xls, txt, pdf.',
        ];
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
