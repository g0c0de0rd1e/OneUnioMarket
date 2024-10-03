<?php

namespace Modules\Marketing\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
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
                'coupon_code' => 'required|max:255|unique:coupons',
                'coupon_type' =>'required',
                'date' => 'required',
                'coupon_title.'. $code => 'required'
            ];
        }else{
            return [
                'coupon_code' => 'required|max:255|unique:coupons',
                'coupon_type' =>'required',
                'date' => 'required',
                'coupon_title' => 'required'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'coupon_title.*.required' => 'The coupon title field is required',
            ];
        }else{
            return [
                'coupon_title.required' => 'The coupon title is field required',
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
