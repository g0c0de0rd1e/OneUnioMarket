<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReturnExchangeRequest extends FormRequest
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
                'mainTitle.'. $code => 'required',
                'returnTitle.'. $code => 'required',
                'exchangeTitle.'. $code => 'required',
                'returnDescription.'. $code => 'required',
                'exchangeDescription.'. $code => 'required',
            ];
        }else{
            return [
                'mainTitle' => 'required',
                'returnTitle' => 'required',
                'exchangeTitle' => 'required',
                'returnDescription' => 'required',
                'exchangeDescription' => 'required',
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'mainTitle.*.required' => 'The Main Title field is required',
                'returnTitle.*.required' => 'The Return Title field is required',
                'exchangeTitle.*.required' => 'The Exchange Title field is required',
                'returnDescription.*.required' => 'The Return Description field is required',
                'exchangeDescription.*.required' => 'The Exchange Description field is required',
            ];
        }else{
            return [
                'mainTitle.required' => 'The Main Title field is required',
                'returnTitle.required' => 'The Return Title field is required',
                'exchangeTitle.required' => 'The Exchange Title field is required',
                'returnDescription.required' => 'The Return Description field is required',
                'exchangeDescription.required' => 'The Exchange Description field is required',
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
