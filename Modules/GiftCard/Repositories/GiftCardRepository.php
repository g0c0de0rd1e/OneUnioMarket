<?php

namespace Modules\GiftCard\Repositories;

use App\Models\Cart;
use App\Traits\ImageStore;
use Carbon\Carbon;
use App\Models\OrderProductDetail;
use Maatwebsite\Excel\Facades\Excel;
use Modules\GiftCard\Imports\GiftCardImport;
use Modules\GiftCard\Entities\GiftCard;
use Modules\GiftCard\Entities\GiftCardUse;
use Modules\GiftCard\Entities\GiftCardGalaryImage;
use Modules\Shipping\Entities\ShippingMethod;
use Modules\OrderManage\Repositories\OrderManageRepository;
use App\Traits\SendMail;
use Modules\GiftCard\Entities\AddGiftCard;
use Modules\GiftCard\Entities\DigitalGiftCard;
use Modules\GiftCard\Entities\GiftCardTag;
use Modules\GiftCard\Entities\GiftCoupon;
use Modules\GiftCard\Imports\GiftProductImport;
use Modules\Setup\Entities\Tag;

class GiftCardRepository
{
    use ImageStore, SendMail;

    public function getAll(){
        return GiftCard::whereNull('type')->latest();
    }

    public function store($data)
    {
        if ($data['product_type'] == 1) {
            if (!empty($data['thumbnail_image'])) {
                $data['thumbnail_image'] = ImageStore::saveImage($data['thumbnail_image'], 165, 165);
            }
            $card = GiftCard::create([
                'name' => $data['name'],
                'sku' => $data['sku'],
                'selling_price' => $data['selling_price'],
                'discount' => $data['discount'],
                'discount_type' => $data['discount_type'],
                'start_date' => ($data['start_date']) ? Carbon::parse($data['start_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                'end_date' => ($data['end_date']) ? Carbon::parse($data['end_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                'thumbnail_image' => $data['thumbnail_image'] ? $data['thumbnail_image'] : null,
                'status' => $data['status'],
                'description' => $data['description'],
                'shipping_id' => 1
            ]);
            $tags = [];
            $tags = explode(',', $data['tags']);
            foreach ($tags as $key => $tag) {
                $tag = Tag::where('name', $tag)->updateOrCreate([
                    'name' => $tag
                ]);
                GiftCardTag::create([
                    'gift_card_id' => $card->id,
                    'tag_id' => $tag->id,
                ]);
            }
            if (!empty($data['galary_image'])) {
                foreach ($data['galary_image'] as $key => $image) {
                    $image_name = ImageStore::saveImage($image, 1000, 1000);
                    GiftCardGalaryImage::create([
                        'image_name' => $image_name,
                        'gift_card_id' => $card->id
                    ]);
                }
            }

        }else {
            if (!empty($data['thumbnail_image_one'])) {
                $data['thumbnail_image_one'] = ImageStore::saveImage($data['thumbnail_image_one'], 165, 165);
            }

            $card = GiftCard::create([
                'name' => $data['gift_name'],
                'thumbnail_image' => $data['thumbnail_image_one'] ? $data['thumbnail_image_one'] : null,
                'status' => $data['status'],
                'description' => $data['descriptionOne'],
                'sku' => $data['gift_sku'],
                'shipping_id' => 1,
                'type' => 'gift_card',
            ]);

            $tags = [];
            $tags = explode(',', $data['gift_tags']);
            foreach ($tags as $key => $tag) {
                $tag = Tag::where('name', $tag)->updateOrCreate([
                    'name' => $tag
                ]);
                GiftCardTag::create([
                    'gift_card_id' => $card->id,
                    'tag_id' => $tag->id,
                ]);
            }

            if (!empty($data['galary_image_two'])) {
                foreach ($data['galary_image_two'] as $key => $image) {
                    $image_name = ImageStore::saveImage($image, 1000, 1000);
                    GiftCardGalaryImage::create([
                        'image_name' => $image_name,
                        'gift_card_id' => $card->id
                    ]);
                }
            }
            $cart_amount = [];
            foreach ($data['section'] as $v_gift_card){
                $cart_amount[] = (integer)gv($v_gift_card, 'gift_selling_price',null);
                $sections = AddGiftCard::create([
                    'digilat_gift_id' => $card->id,
                    'gift_card_value' => (integer)gv($v_gift_card, 'gift_card_value',null),
                    'gift_selling_price' => (integer)gv($v_gift_card, 'gift_selling_price',null),
                    'gift_discount_type' => gv($v_gift_card, 'gift_discount_type',0),
                    'gift_discount_amount' => (integer)gv($v_gift_card, 'gift_discount_amount', 0),
                    'start_date' => Carbon::now()->format('Y-m-d'),
                    'end_date' =>(gv($v_gift_card, 'gift_expire_date')) ? Carbon::parse(gv($v_gift_card, 'gift_expire_date'))->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                    'number_of_gift_card' => (integer)gv($v_gift_card, 'number_of_gift_card',null),
                ]);
                if(gv($v_gift_card, 'upload_img_file')){
                    Excel::import(new GiftProductImport($sections->id), gv($v_gift_card, 'upload_img_file')->store('temp'));
                }else{
                    foreach($v_gift_card['gift_selling_coupon'] as $giftCoupon){
                        GiftCoupon::create([
                            'gift_selling_coupon' => $giftCoupon,
                            'add_gift_id'=>$sections->id,
                        ]);
                    }
                }
            }
            GiftCard::find($card->id)->update([
                'selling_price' => min($cart_amount),
            ]);
        }
        return true;
    }

    public function statusChange($data){
        return GiftCard::where('id', $data['id'])->update([
            'status' => $data['status']
        ]);
    }

    public function getById($id){
        return GiftCard::findOrFail($id);
    }

    public function update($data, $id)
    {
        $card = GiftCard::findOrFail($id);
        if(!empty($data['thumbnail_image'])){
            ImageStore::deleteImage($card->thumbnail_image);
            $data['thumbnail_image'] = ImageStore::saveImage($data['thumbnail_image'], 300, 300);
        }


        $card->update([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'selling_price' => $data['selling_price'],
            'discount' => $data['discount'],
            'discount_type' => $data['discount_type'],
            'start_date' => isset($data['start_date']) ? Carbon::parse($data['start_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
            'end_date' => isset($data['end_date']) ? Carbon::parse($data['end_date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
            'thumbnail_image' => isset($data['thumbnail_image'])?$data['thumbnail_image']:$card->thumbnail_image,
            'status' => $data['status'],
            'description' => $data['description'],
            'shipping_id' => 1
        ]);

        //for tag start
        $tags = [];
        $tags = explode(',', $data['tags']);
        $oldtags = GiftCardTag::where('gift_card_id', $id)->whereHas('tag', function($q)use($tags){
            $q->whereNotIn('name',$tags);
        })->pluck('id');
        GiftCardTag::destroy($oldtags);

        foreach ($tags as $key => $tag) {
            $tag = Tag::where('name', $tag)->updateOrCreate([
                'name' => $tag
            ]);
            GiftCardTag::where('gift_card_id', $card->id)->where('tag_id', $tag->id)->updateOrCreate([
                'gift_card_id' => $card->id,
                'tag_id' => $tag->id,
            ]);
        }
        // for tag end
        if(!empty($data['galary_image'])){

            $images = GiftCardGalaryImage::where('gift_card_id', $id)->get();
            foreach($images as $img){
                ImageStore::deleteImage($img->image_name);
                $img->delete();
            }
            foreach($data['galary_image'] as $key => $image){
                $image_name = ImageStore::saveImage($image,1000,1000);
                GiftCardGalaryImage::create([
                    'image_name' => $image_name,
                    'gift_card_id' => $card->id
                ]);
            }
        }
        return true;
    }

    public function getGiftCardById($id){
        return GiftCard::findOrFail($id);
    }

    public function digitalCardUpdate($data, $id){
        $card = GiftCard::findOrFail($id);

        if(!empty($data['thumbnail_image_one'])){
            ImageStore::deleteImage($card->thumbnail_image_one);
            $data['thumbnail_image_one'] = ImageStore::saveImage($data['thumbnail_image_one'], 300, 300);
        }

        $card->update([
            'name' => $data['gift_name'],
            'thumbnail_image' => !empty(gv($data, 'thumbnail_image_one')) ? gv($data, 'thumbnail_image_one'):$card->thumbnail_image,
            'status' => $data['status'],
            'description' => $data['descriptionOne'],
            'shipping_id' => 1,
            'sku' => $data['gift_sku'],
            'type' => 'gift_card',
        ]);

        $tags = [];
        $tags = explode(',', $data['gift_tags']);
        foreach ($tags as $key => $tag) {
            $tag = Tag::where('name', $tag)->updateOrCreate([
                'name' => $tag
            ]);
            GiftCardTag::create([
                'gift_card_id' => $card->id,
                'tag_id' => $tag->id,
            ]);
        }

        if(!empty($data['galary_image'])){
            $images = GiftCardGalaryImage::where('gift_card_id', $id)->get();
            foreach($images as $img){
                ImageStore::deleteImage($img->image_name);
                $img->delete();
            }
            foreach($data['galary_image'] as $key => $image){
                $image_name = ImageStore::saveImage($image,1000,1000);
                GiftCardGalaryImage::create([
                    'image_name' => $image_name,
                    'gift_card_id' => $card->id
                ]);
            }
        }
        foreach ($card->addGiftCard as $addGiftCard) {
            $giftcard = AddGiftCard::findOrFail($addGiftCard->id);
            foreach ($giftcard->giftCoupons as $giftcoupon) {
                $couponcode = GiftCoupon::findOrFail($giftcoupon->id);
                if ($couponcode) {
                    $couponcode->delete();
                }
            }
            if ($giftcard) {
                $giftcard->delete();
            }
        }

        foreach ($data['section'] as $v_gift_card){
            $sections = AddGiftCard::create([
                'digilat_gift_id' => $card->id,
                'gift_card_value' => (integer)gv($v_gift_card, 'gift_card_value',null),
                'gift_selling_price' => (integer)gv($v_gift_card, 'gift_selling_price',null),
                'gift_discount_type' => gv($v_gift_card, 'gift_discount_type',0),
                'gift_discount_amount' => (integer)gv($v_gift_card, 'gift_discount_amount', 0),
                'start_date' => Carbon::now()->format('Y-m-d'),
                'end_date' => (gv($v_gift_card, 'gift_expire_date')) ? Carbon::createFromFormat('m-d-Y', gv($v_gift_card, 'gift_expire_date'))->format('Y-m-d') : Carbon::now()->format('Y-m-d'),
                'number_of_gift_card' => (integer)gv($v_gift_card, 'number_of_gift_card',null),
            ]);
            if(gv($v_gift_card, 'upload_img_file')){
                Excel::import(new GiftProductImport($sections->id), gv($v_gift_card, 'upload_img_file')->store('temp'));
            }else{
                foreach($v_gift_card['gift_selling_coupon'] as $giftCoupon){
                    GiftCoupon::create([
                        'gift_selling_coupon' => $giftCoupon,
                        'add_gift_id'=>$sections->id,
                    ]);
                }
            }
        }
        return true;
     }

    public function deleteById($id){
        $card = GiftCard::findOrFail($id);
        $listInCart = Cart::where('product_type','gift_card')->where('product_id', $card->id)->pluck('id')->toArray();
        Cart::destroy($listInCart);
        $existProduct = OrderProductDetail::where('type', 'gift_card')->where('product_sku_id', $card->id)->first();
        if ($existProduct) {
            return "not_possible";
        }
        foreach($card->galaryImages as $image){
            ImageStore::deleteImage($image->image_name);
            $image->delete();
        }
        ImageStore::deleteImage($card->thumbnail_image);
        $card->delete();
        return 'possible';
    }

    public function giftDeleteById($id){
        $giftCardData = GiftCard::findOrFail($id);
        ImageStore::deleteImage($giftCardData->thumbnail_image);
        AddGiftCard::where('digilat_gift_id', $id)->delete();

        $listInCart = Cart::where('product_type','gift_card')->where('product_id', $giftCardData->id)->pluck('id')->toArray();
        Cart::destroy($listInCart);
        $existProduct = OrderProductDetail::where('type', 'gift_card')->where('product_sku_id', $giftCardData->id)->first();
        if ($existProduct) {
            return "not_possible";
        }
        foreach($giftCardData->galaryImages as $image){
            ImageStore::deleteImage($image->image_name);
            $image->delete();
        }
        ImageStore::deleteImage($giftCardData->thumbnail_image);
        $giftCardData->delete();
        return 'possible';
    }


    public function getShipping(){
        return ShippingMethod::where('is_active', 1)->get();
    }
    public function send_code_to_mail($data)
    {
        $orderRepo = new OrderManageRepository;
        $order = $orderRepo->findOrderByID($data['order_id']);
        $gift_card = $this->getById($data['gift_card_id']);
        $secret_code = date('ymd-his').'-'.rand(111,999).$order->id.'-'.$gift_card->id.rand(1111,9999);
        try {
            $this->sendGiftCardSecretCodeMail($order, $data['mail'], $gift_card, $secret_code);
            $this->storeGiftCardData($secret_code, $order->id, $gift_card->id, 1, $data['qty']);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function storeGiftCardData($secret_code, $order_id, $gift_card_id, $is_mail_sent, $qty)
    {
        $existGiftCardInfo = GiftCardUse::where('gift_card_id',$gift_card_id)->where('order_id',$order_id)->first();
        if ($existGiftCardInfo == null) {
            GiftCardUse::create([
                'gift_card_id' => $gift_card_id,
                'order_id' => $order_id,
                'qty' => $qty,
                'secret_code' => $secret_code,
                'is_mail_sent' => $is_mail_sent,
                'mail_sent_date' => Carbon::now()->format('Y-m-d')
            ]);
        }else {
            $existGiftCardInfo->update([
                'secret_code' => $secret_code,
                'mail_sent_date' => Carbon::now()->format('Y-m-d')
            ]);
        }
    }

    public function csvUploadCategory($data)
    {
        Excel::import(new GiftCardImport, $data['file']->store('temp'));
    }

    public function giftCardUseStatus($data){
        $existGiftCardInfo = GiftCardUse::where('gift_card_id',$data['gift_card_id'])->where('order_id',$data['order_id'])->first();
        if($existGiftCardInfo){
            if(!$existGiftCardInfo->is_used){
                return true;
            }
            return false;
        }
        return true;
    }
}
