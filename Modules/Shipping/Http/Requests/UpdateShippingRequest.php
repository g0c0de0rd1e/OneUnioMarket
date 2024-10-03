<?php

namespace Modules\Shipping\Http\Requests;

use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShippingRequest extends FormRequest
{
    public function rules()
    {
        if (isModuleActive('FrontendMultiLang')) {
            $code = auth()->user()->lang_code;
            return [
                'method_name.'. $code => ['required','max:255',UniqueTranslationRule::for('shipping_methods', 'method_name')->where(function($q){
                    $seller_id = getParentSellerId();
                    return $q->where('request_by_user', $seller_id);
                })->ignore($this->id)],
                'carrier_id' => 'nullable',
                'cost_based_on' => 'required',
                'cost' => 'required',
                'shipment_time' => 'required',
            ];
        }else{
            return [
                'method_name' => ['required','max:255',Rule::unique('shipping_methods', 'method_name')->where(function($q){
                    $seller_id = getParentSellerId();
                    return $q->where('id', '!=', $this->id)->where('request_by_user', $seller_id);
                })],
                'carrier_id' => 'nullable',
                'cost_based_on' => 'required',
                'cost' => 'required',
                'method_logo' => 'nullable|mimes:jpg,jpeg,bmp,png'
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'method_name.*.required' => 'The method name field is required',
                'method_name.*.UniqueTranslationRule' => 'The method name field has already been taken',
            ];
        }else{
            return [
                'method_name.required' => 'The method name field is required',
                'method_name.unique' => 'The method name field has already been taken',
            ];
        }
    }

    public function authorize()
    {
        return true;
    }
}
