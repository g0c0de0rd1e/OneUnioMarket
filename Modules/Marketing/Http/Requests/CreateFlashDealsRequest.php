<?php

namespace Modules\Marketing\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CreateFlashDealsRequest extends FormRequest
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
                'background_color' =>'required',
                'text_color' =>'required',
                'flash_deal_banner_image' =>'required',
                'date' =>'required',
                'products' =>'required'
            ];
        }else{
            return [
                'title' => 'required|max:255',
                'background_color' =>'required',
                'text_color' =>'required',
                'flash_deal_banner_image' =>'required',
                'date' =>'required',
                'products' =>'required'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'title.*.required' => 'The tilte field is required',
                'flash_deal_banner_image.required' => 'The banner image field is required',
            ];
        }else{
            return [
                'title.required' => 'The tilte field is required',
                'flash_deal_banner_image.required' => 'The banner image field is required',
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
