<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBenifitRequest extends FormRequest
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
                'title.'. $code =>'required',
                'description.'. $code =>'required',
                'image' =>'required|mimes:jpg,jpeg,png,bmp,gif',
                'status' =>'required'
            ];
        }else{
            return [
                'title' =>'required',
                'image' =>'required',
                'description' =>'required',
                'status' =>'required'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'title.*.required' => 'The title field is required',
                'description.*.required' => 'The description field is required',
            ];
        }else{
            return [
                'title.required' => 'The title field is required',
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
