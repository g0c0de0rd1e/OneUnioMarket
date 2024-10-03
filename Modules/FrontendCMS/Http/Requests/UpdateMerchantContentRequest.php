<?php

namespace Modules\FrontendCMS\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchantContentRequest extends FormRequest
{

    public function rules()
    {
        if (isModuleActive('FrontendMultiLang')) {
            $code = auth()->user()->lang_code;
            return [
                'mainTitle.'. $code => 'required',
                'subTitle.'. $code => 'required',
                'slug.'. $code => 'required|unique_translation:merchant_contents,slug,{$this->id}',
                'Maindescription.'. $code => 'required',
                'pricing.'. $code => 'required',
                'benifitTitle.'. $code => 'required',
                'benifitDescription.'. $code => 'required',
                'howitworkTitle.'. $code => 'required',
                'howitworkDescription.'. $code => 'required',
                'pricingTitle.'. $code => 'required',
                'pricingDescription.'. $code => 'required',
                'sellerRegistrationTitle.'. $code => 'required',
                'sellerRegistrationDescription.'. $code => 'required',
                'faqTitle.'. $code => 'required',
                'faqDescription.'. $code => 'required',
                'queryTitle.'. $code => 'required',
                'queryDescription.'. $code => 'required',
            ];
        }else{
            return [
                'mainTitle' => 'required',
                'subTitle' => 'required',
                'slug' => 'required|unique:merchant_contents,slug,'.$this->id,
                'Maindescription' => 'required',
                'pricing' => 'required',
                'benifitTitle' => 'required',
                'benifitDescription' => 'required',
                'howitworkTitle' => 'required',
                'howitworkDescription' => 'required',
                'pricingTitle' => 'required',
                'pricingDescription' => 'required',
                'sellerRegistrationTitle' => 'required',
                'sellerRegistrationDescription' => 'required',
                'faqTitle' => 'required',
                'faqDescription' => 'required',
                'queryTitle' => 'required',
                'queryDescription' => 'required',
            ];
        }
    }
    public function messages()
    {
        if (isModuleActive('FrontendMultiLang')) {
            return [
                'mainTitle.*.required' => 'The Main Title field is required',
                'slug.*.required' => 'The Slug field is required',
                'subTitle.*.required' => 'The Sub Title field is required',
                'Maindescription.*.required' => 'The Main Details field is required',
                'pricing.*.required' => 'The Pricing Slogan field is required',
                'benifitTitle.*.required' => 'The benifit Title field is required',
                'benifitDescription.*.required' => 'The benifit Details field is required',
                'howitworkTitle.*.required' => 'The How It Work Title field is required',
                'howitworkDescription.*.required' => 'The How It Work Details field is required',
                'pricingTitle.*.required' => 'The Pricing Title field is required',
                'pricingDescription.*.required' => 'The Pricing Details field is required',
                'sellerRegistrationTitle.*.required' => 'The Seller Registration Title For First Page field is required',
                'sellerRegistrationDescription.*.required' => 'The Seller Registration Description field is required',
                'faqTitle.*.required' => 'The FAQ Title field is required',
                'faqDescription.*.required' => 'The FAQ Details field is required',
                'queryTitle.*.required' => 'The Query Title field is required',
                'queryDescription.*.required' => 'The Query Details field is required',
            ];
        }else{
            return [
                'mainTitle.required' => 'The Main Title field is required',
                'subTitle.required' => 'The Sub Title field is required',
                'slug.required' => 'The Slug field is required',
                'Maindescription.required' => 'The Main Details field is required',
                'pricing.required' => 'The Pricing Slogan field is required',
                'benifitTitle.required' => 'The benifit Title field is required',
                'benifitDescription.required' => 'The benifit Details field is required',
                'howitworkTitle.required' => 'The How It Work Title field is required',
                'howitworkDescription.required' => 'The How It Work Details field is required',
                'pricingTitle.required' => 'The Pricing Title field is required',
                'pricingDescription.required' => 'The Pricing Details field is required',
                'sellerRegistrationTitle.required' => 'The Seller Registration Title For First Page field is required',
                'sellerRegistrationDescription.required' => 'The Seller Registration Description field is required',
                'faqTitle.required' => 'The FAQ Title field is required',
                'faqDescription.required' => 'The FAQ Details field is required',
                'queryTitle.required' => 'The Query Title field is required',
                'queryDescription.required' => 'The Query Details field is required',
            ];
        }
    }

    public function authorize()
    {
        return true;
    }
}
