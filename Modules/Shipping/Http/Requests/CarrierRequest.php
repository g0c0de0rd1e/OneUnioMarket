<?php

namespace Modules\Shipping\Http\Requests;

use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarrierRequest extends FormRequest
{
    public function rules()
    {
        if (isModuleActive('FrontendMultiLang')) {
            $code = auth()->user()->lang_code;
            return [
                'name.'. $code  =>  ['required',UniqueTranslationRule::for('carriers', 'name')->where(function($q){
                    $seller_id = getParentSellerId();
                    return $q->where('created_by', $seller_id);
                })->ignore($this->id)],
                'tracking_url'=>'nullable',
                'logo'=>'nullable',
            ];
        }else{
            return [
                'name' =>  ['required',Rule::unique('carriers', 'name')->where(function($q){
                    $seller_id = getParentSellerId();
                    return $q->where('id', '!=', $this->id)->where('created_by', $seller_id);
                })],
                'tracking_url'=>'nullable',
                'logo'=>'nullable',
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'name.*.required' => 'The name field is required',
                'name.*.UniqueTranslationRule' => 'The name field has already been taken',
            ];
        }else{
            return [
                'name.required' => 'The name field is required',
                'name.unique' => 'The name field has already been taken',
            ];
        }
    }
    public function authorize()
    {
        return true;
    }
}
