<?php
namespace Modules\MultiVendor\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\FrontendCMS\Entities\SellerSocialLink;

class SettingRepository {

    protected $seller;
    protected $sellerAccount;
    protected $socialLink;

    public function __construct(User $seller, SellerAccount $sellerAccount, SellerSocialLink $socialLink)
    {
        $this->seller = $seller;
        $this->sellerAccount = $sellerAccount;
        $this->socialLink = $socialLink;
    }

    public function getData($id){

        return $this->seller::with('SellerAccount')->where('id',$id)->firstOrFail();
    }
    public function getSocialLink($id){
        return $this->socialLink::where('user_id',$id)->get();
    }

    public function logoUpdate($data, $id){
        $seller_data = $this->seller::where('id',$id)->firstOrFail();
        $seller_data->photo = $data['logo'];
        $seller_data->save();
        $seller_account = $this->sellerAccount::where('user_id',$id)->firstOrFail();
        $seller_account->update([
            'banner' => $data['banner']
        ]);
        return 'Done';
    }

    public function SaveSocilaLink($data){
        return $this->socialLink::create([
            'url' => $data['url'],
            'icon' => $data['icon'],
            'status' => $data['status'],
            'user_id' => Auth::user()->id
        ]);
    }

    public function UpdateSocilaLink($data, $id){

        return $this->socialLink::where('id',$id)->update([
            'url' => $data['url'],
            'icon' => $data['icon'],
            'status' => $data['status']
        ]);
    }
    public function linkById($id){
        $data =  $this->socialLink::where('id',$id)->firstOrFail();
        return $data->delete();
    }

}
