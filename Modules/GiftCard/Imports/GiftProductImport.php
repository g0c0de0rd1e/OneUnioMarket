<?php

namespace Modules\GiftCard\Imports;

use Illuminate\Support\Collection;
use Modules\GiftCard\Entities\GiftCoupon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GiftProductImport implements ToCollection, WithHeadingRow
{
    Public $section_id;

    public function  __construct($section_id)
    {
        $this->section_id= $section_id;
    }

    public function collection(Collection $giftCouponDatas)
    {
        foreach($giftCouponDatas as $giftCouponData){
            if(gv($giftCouponData, 'coupon_code') != null){
                GiftCoupon::create([                       
                    'gift_selling_coupon' => gv($giftCouponData, 'coupon_code'),
                    'add_gift_id' => $this->section_id,                   
                ]);
            }
        }
    }
}