<?php

namespace Modules\Marketing\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CreateNewUserZoneRequest extends FormRequest
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
                'sub_title.'. $code => 'required',
                'background_color' =>'nullable',
                'text_color' =>'nullable',
                'new_user_zone_banner_image' =>'nullable',
                'product_navigation_label.'. $code => 'required',
                'coupon_navigation_label.'. $code => 'required',
                'category_navigation_label.'. $code => 'required',
                'product' => 'required',
                'category' => 'required',
                'coupon_category' => 'required'
            ];
        }else{
            return [
                'title' => 'required|max:255',
                'sub_title' => 'required|max:255',
                'background_color' =>'nullable',
                'text_color' =>'nullable',
                'new_user_zone_banner_image' =>'nullable',
                'product_navigation_label' => 'required',
                'coupon_navigation_label' => 'required',
                'category_navigation_label' => 'required',
                'product' => 'required',
                'category' => 'required',
                'coupon_category' => 'required'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'title.*.required' => 'The tilte field is required',
                'sub_title.*.required' => 'The sub title field is required',
                'product_navigation_label.*.required' => 'The product navigation label field is required',
                'category_navigation_label.*.required' => 'The category navigation label field is required',
                'coupon_navigation_label.*.required' => 'The coupon navigation label field is required',
            ];
        }else{
            return [
                'title.required' => 'The tilte field is required',
                'sub_title.required' => 'The sub title field is required',
                'product_navigation_label.required' => 'The product navigation label field is required',
                'category_navigation_label.required' => 'The category navigation label field is required',
                'coupon_navigation_label.required' => 'The coupon navigation label field is required',
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
