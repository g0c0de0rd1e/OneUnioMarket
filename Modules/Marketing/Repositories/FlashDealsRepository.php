<?php

namespace Modules\Marketing\Repositories;

use App\Models\UsedMedia;
use Modules\Marketing\Entities\FlashDeal;
use Modules\Marketing\Entities\FlashDealProduct;
use Modules\Seller\Entities\SellerProduct;
use Str;
use Carbon\Carbon;
use App\Traits\ImageStore;

class FlashDealsRepository {
    
    public function getAll(){
        $user = auth()->user();
        if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff'){
            return FlashDeal::all();
        }
        elseif($user->role->type == 'seller'){
            return FlashDeal::where('created_by',$user->id)->get();
        }else{
            return [];
        }
    }
    public function store($data){
        $flash_deal = new FlashDeal();
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = strtolower(str_replace(' ', '-', $data['title'][auth()->user()->lang_code]) . '-' . Str::random(5));
        }else{
            $data['slug'] = strtolower(str_replace(' ', '-', $data['title']) . '-' . Str::random(5));
        }
        $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d');
        $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d');
        $flash_deal->fill($data)->save();
        if (isset($data['flash_deal_banner_image'])) {
            UsedMedia::create([
                'media_id' => $data['flash_deal_banner_image'],
                'usable_id' => $flash_deal->id,
                'usable_type' => get_class($flash_deal),
                'used_for' => 'flash_deal_banner_image'
            ]);
        }
        if($flash_deal && $data['products']){
            foreach($data['products'] as $key => $product){
                FlashDealProduct::create([
                    'flash_deal_id' => $flash_deal->id,
                    'seller_product_id' => $product,
                    'discount' => $data['discount'][$key],
                    'discount_type' => $data['discount_type'][$key]
                ]);
            }
        }
    }
    public function update($data, $id){
        $flash_deal = FlashDeal::findOrFail($id);
        if (isModuleActive('FrontendMultiLang')) {
            $data['slug'] = strtolower(str_replace(' ', '-', $data['title'][auth()->user()->lang_code]) . '-' . Str::random(5));
        }else{
            $data['slug'] = strtolower(str_replace(' ', '-', $data['title']) . '-' . Str::random(5));
        }
        $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d');
        $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d');
        $flash_deal->fill($data)->save();
        if($flash_deal && $data['products']){
            $old_products = FlashDealProduct::where('flash_deal_id',$id)->whereNotIn('seller_product_id',$data['products'])->pluck('id');
            FlashDealProduct::destroy($old_products);
            foreach($data['products'] as $key => $product){
                $deal = FlashDealProduct::where('flash_deal_id',$id)->where('seller_product_id',$product)->first();
                if($deal != null){
                    $deal->update([
                        'flash_deal_id' => $id,
                        'seller_product_id' => $product,
                        'discount' => $data['discount'][$key],
                        'discount_type' => $data['discount_type'][$key]
                    ]);
                }else{
                    FlashDealProduct::create([
                        'flash_deal_id' => $id,
                        'seller_product_id' => $product,
                        'discount' => $data['discount'][$key],
                        'discount_type' => $data['discount_type'][$key]
                    ]);
                }
            }
        }
        return true;
    }
    public function statusChange($data){
        $flashDeals = FlashDeal::where('id','!=',$data['id'])->get();
        foreach($flashDeals as $deal){
            $deal->update([
                'status' => 0
            ]);
        }
        return FlashDeal::findOrFail($data['id'])->update([
            'status' => $data['status']
        ]);
    }
    public function featuredChange($data){
        return FlashDeal::findOrFail($data['id'])->update([
            'is_featured' => $data['is_featured']
        ]);
    }
    public function editById($id){
        return FlashDeal::findOrFail($id);
    }
    public function deleteById($id){
        $flash_deal =  FlashDeal::findOrFail($id);
        ImageStore::deleteImage($flash_deal->banner_image);
        UsedMedia::where('usable_id', $flash_deal->id)->where('usable_type', get_class($flash_deal))->where('used_for', 'flash_deal_banner_image')->delete();
        $products = $flash_deal->products->pluck('id');
        FlashDealProduct::destroy($products);
        $flash_deal->delete();
        return true;
    }
    public function getSellerProduct(){
        $user = auth()->user();
        if($user->role->type == 'superadmin' || $user->role->type == 'admin' || $user->role->type == 'staff'){
            return SellerProduct::with('product', 'seller.role')->activeSeller()->get();
        }
        elseif($user->role->type == 'seller'){
            return SellerProduct::with('product', 'seller.role')->where('user_id',$user->id)->activeSeller()->get();
        }else{
            return [];
        }
    }
    public function getActiveFlashDeal(){
        return FlashDeal::where('status', 1)->first();
    }
}
