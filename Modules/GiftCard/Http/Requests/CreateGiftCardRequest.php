<?php

namespace Modules\GiftCard\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CreateGiftCardRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'nullable|required_if:product_type,redeem_card',
            'gift_tags' => "required_if:product_type,gift_card",
            'tags' => "required_if:product_type,redeem_card",
            'gift_name' => 'nullable|required_if:product_type,gift_card',
            'gift_sku' => 'nullable|required_if:product_type,gift_card',
            'descriptionOne' => 'nullable|required_if:product_type,gift_card',
            'selling_price' => 'nullable|numeric|required_if:product_type,redeem_card',
            'discount' => 'nullable|numeric|nullable',
            'sku' => 'nullable|required_if:product_type,redeem_card|unique:gift_cards,sku',
            'status' => 'nullable|required_if:product_type,redeem_card',
            'thumbnail_image' => 'nullable|required_if:product_type,redeem_card|mimes:jpg,bmp,jpeg,png,webp',
            'thumbnail_image_one' => 'nullable|required_if:product_type,gift_card|mimes:jpg,bmp,jpeg,png,webp',
            'galary_image_two.*' => 'nullable|required_if:product_type,gift_card|mimes:jpg,bmp,jpeg,png,webp',
            'galary_image.*' => 'nullable|mimes:jpg,bmp,jpeg,png,webp'
        ];
    }




    public function authorize()
    {
        return true;
    }
}
