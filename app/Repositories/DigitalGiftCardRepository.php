<?php
namespace App\Repositories;

use Modules\GiftCard\Entities\AddGiftCard;
use Modules\GiftCard\Entities\DigitalGiftCard;
use Modules\GiftCard\Entities\GiftCard;
use Modules\GiftCard\Entities\GiftCardUse;
use Modules\Review\Entities\ProductReview;
use Modules\Wallet\Entities\WalletBalance;

class DigitalGiftCardRepository{
  public function getAll($sort_by, $paginate){
        $giftCards = DigitalGiftCard::get();
        return $this->sortAndPaginate($giftCards, $sort_by, $paginate);
    }
    public function details($id){
        return DigitalGiftCard::findOrFail($id);
    }
    public function getReviewByPage($data){
        return ProductReview::where('type', 'digital_gift_card')->where('product_id', $data['digital_gift_card_id'])->where('status', 1)->latest()->paginate(10);
    }

    public function getByFilterByType($data, $sort_by, $paginate){
        if (session()->has('filtergiftCard')) {
            session()->forget('filtergiftCard');
        }

        $digitalgiftCard = DigitalGiftCard::query();

        foreach ($data['filterType'] as $key => $filter) {

            if ($filter['filterTypeId'] == "rating" && !empty($filter['filterTypeValue'])) {
                $typeVal = $filter['filterTypeValue'][0];
                $giftCards = $this->productThroughRating($typeVal, $digitalgiftCard);

            }

            if ($filter['filterTypeId'] == "price_range") {
                $filterRepo = new FilterRepository();
                $min_price = round(end($filter['filterTypeValue'])[0])/$filterRepo->getConvertRate();
                $max_price = round(end($filter['filterTypeValue'])[1])/$filterRepo->getConvertRate();
                $giftCards = $this->productThroughPriceRange($min_price, $max_price, $giftCards);

            }

        }
        session()->put('filtergiftCard', $data);
        return $this->sortAndPaginate($giftCards, $sort_by, $paginate);

    }

    private function sortAndPaginate($giftCards, $sort_by, $paginate){
        if($sort_by != null){
            if($sort_by == 'new'){
                return $giftCards->orderBy('id')->paginate(($paginate != null)?$paginate:9);
            }
            if($sort_by == 'old'){
                return DigitalGiftCard::orderByDesc('id')->paginate(($paginate != null)?$paginate:9);
            }
            if($sort_by == 'alpha_asc'){
                return $giftCards->orderBy('name')->paginate(($paginate != null)?$paginate:9);
            }
            if($sort_by == 'alpha_desc'){
                return $giftCards->orderByDesc('name')->paginate(($paginate != null)?$paginate:9);
            }
        }else{
            return $giftCards->paginate(($paginate != null)?$paginate:9);
        }

        return $giftCards->where('status', 1)->latest()->paginate(9);
    }

    private function productThroughPriceRange($min_price, $max_price, $giftCards){
        return $giftCards->where('selling_price', '>=',$min_price)->where('selling_price', '<=', $max_price);
    }

    private function productThroughRating($typeVal, $giftCards){
        
        return $giftCards->where('avg_rating','>=', $typeVal);

    }

 

    public function myPurchasedGiftCard($user)
    {
        return GiftCardUse::with('order','giftCard.galaryImages', 'giftCard.shippingMethod')->whereHas('order', function($q) use($user){
                                $q->where('customer_id', $user->id);
                            })->paginate(6);
    }

    public function myPurchasedGiftCardAll($user)
    {
        return GiftCardUse::with('order','giftCard.galaryImages')->whereHas('order', function($q) use($user){
                                $q->where('customer_id', $user->id);
                            })->get();
    }

    public function myPurchasedGiftCardRedeem($data, $user)
    {
        $digital_giftcard_use_info = GiftCardUse::with('giftCard')->findOrFail($data['digital_giftcard_use_id']);
        if ($digital_giftcard_use_info && $digital_giftcard_use_info->is_used != 1) {
            $this->walletRecharge($digital_giftcard_use_info, $user);
        }

    }

    public function myPurchasedGiftCardRedeemToWalletFromWalletRecharge($data, $user)
    {
        $digital_giftcard_use_info = GiftCardUse::with('giftCard')->where('secret_code', $data['secret_code'])->first();
        if ($digital_giftcard_use_info && $digital_giftcard_use_info->is_used != 1) {
            $this->walletRecharge($digital_giftcard_use_info, $user);
            return 'success';
        }
        elseif($digital_giftcard_use_info && $digital_giftcard_use_info->is_used == 1){
            return 'used';
        }else{
            return 'invalid';
        }

    }

    public function walletRecharge($digital_giftcard_use_info, $user)
    {
        WalletBalance::create([
            'walletable_type' => "Modules\GiftCard\Entities\GiftCardUse",
            'walletable_id' => $digital_giftcard_use_info->id,
            'user_id' => $user->id,
            'type' => "Deposite",
            'status' => 1,
            'amount' => round(($digital_giftcard_use_info->giftCard->sell_price * $digital_giftcard_use_info->qty), 2),
            'payment_method' => "Gift Card Redeem",
        ]);
        $digital_giftcard_use_info->update([
            'is_used' => 1,
            'txn_id' => $digital_giftcard_use_info->secret_code
        ]);
    }

}