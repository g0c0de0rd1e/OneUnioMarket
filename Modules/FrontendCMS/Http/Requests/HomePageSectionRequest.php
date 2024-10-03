<?php

namespace Modules\FrontendCMS\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class HomePageSectionRequest extends FormRequest
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
                'type' => 'required',
                'column_size' => 'required',
                'status' =>'required',
                'banner_image' => 'nullable|mimes:jpg,jpeg,png,bmp,gif',
                'banner_image_1' => 'nullable|mimes:jpg,jpeg,png,bmp,gif',
                'banner_image_2' => 'nullable|mimes:jpg,jpeg,png,bmp,gif',
                'banner_image_3' => 'nullable|mimes:jpg,jpeg,png,bmp,gif'
            ];
        }else{
            return [
                'title' => 'required',
                'type' => 'required',
                'column_size' => 'required',
                'status' =>'required',
                'banner_image' => 'nullable|mimes:jpg,jpeg,png,bmp,gif',
                'banner_image_1' => 'nullable|mimes:jpg,jpeg,png,bmp,gif',
                'banner_image_2' => 'nullable|mimes:jpg,jpeg,png,bmp,gif',
                'banner_image_3' => 'nullable|mimes:jpg,jpeg,png,bmp,gif'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'title.*.required' => 'The Home page section title field is required',
            ];
        }else{
            return [
                'title.required' => 'The Home page section title field is required',
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
