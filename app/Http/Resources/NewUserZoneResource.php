<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewUserZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" =>  !empty($this->id) ? (int)$this->id:null,
            "title" => (string)$this->title,
            "background_color" => (string)$this->background_color,
            "slug" => (string)$this->slug,
            "banner_image" => $this->banner_image ? (string) $this->banner_image : (string) $this->banner_image,
            "product_navigation_label" => (string)$this->product_navigation_label,
            "category_navigation_label" => (string)$this->category_navigation_label,
            "coupon_navigation_label" => (string)$this->coupon_navigation_label,
            "product_slogan" => (string)$this->product_slogan,
            "category_slogan" => (string)$this->category_slogan,
            "coupon_slogan" => (string)$this->coupon_slogan,
            "coupon" => [
                "id" => !empty($this->coupon) && !empty($this->coupon->coupon) ? (int)$this->coupon->coupon->id:null,
                "title" => (string)$this->coupon->coupon->title,
                "coupon_code" => (string)$this->coupon->coupon->coupon_code,
                "start_date" => (string)$this->coupon->coupon->start_date,
                "end_date" => (string)$this->coupon->coupon->end_date,
                "discount" => $this->coupon->coupon->discount,
                "discount_type" => $this->coupon->coupon->discount_type,
                "minimum_shopping" => $this->coupon->coupon->minimum_shopping,
                "maximum_discount" => $this->coupon->coupon->maximum_discount
            ],
            'AllProducts' => $this->ProductForAPIHomePage
        ];
    }
}
