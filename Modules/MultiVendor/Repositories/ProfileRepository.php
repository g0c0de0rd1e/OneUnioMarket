<?php
namespace Modules\MultiVendor\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\MultiVendor\Entities\SellerAccount;
use Modules\MultiVendor\Entities\SellerBankAccount;
use Modules\MultiVendor\Entities\SellerSubcription;
use Modules\MultiVendor\Entities\SellerReturnAddress;
use Modules\MultiVendor\Entities\SellerWarehouseAddress;
use Modules\MultiVendor\Entities\SellerBusinessInformation;

class ProfileRepository {

    protected $seller;
    protected $sellerAccount;

    public function __construct(User $seller, SellerAccount $sellerAccount)
    {
        $this->seller = $seller;
        $this->sellerAccount = $sellerAccount;
    }

    public function getData($id){

        return $this->seller::with('SellerAccount','SellerBankAccount','SellerBusinessInformation', 'SellerWarehouseAddress','SellerReturnAddress')->where('id',$id)->firstOrFail();
    }

    public function sellerAccountUpdate($data, $id){
        $seller_data = $this->sellerAccount::where('user_id',$id)->firstOrFail();
        $user_data = $this->seller::where('id',$id)->firstOrFail();

        $user_data->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'username' => $data['seller_phone']
        ]);
        $seller_data->update([
            'seller_phone' => $data['seller_phone'],
            'seller_shop_display_name' => $data['shop_display_name'],
            'seller_commission_id' => isset($data['commission_type'])?$data['commission_type']:$seller_data->seller_commission_id,
            'holiday_mode' => $data['holiday_mode'],
            'holiday_type' => $data['holiday_mode'] == 1?$data['holiday_type']:null,
            'holiday_date' => $data['holiday_mode'] == 1 && $data['holiday_type'] == 1?$data['holiday_date']:null,
            'holiday_date_start' => $data['holiday_mode'] == 1 && $data['holiday_type'] == 2?$data['holiday_date_start']:null,
            'holiday_date_end' => $data['holiday_mode'] == 1 && $data['holiday_type'] == 2?$data['holiday_date_end']:null,
            'about_seller' => $data['about_seller'],
            'subscription_type' => isset($data['subscription_type'])?$data['subscription_type']:$seller_data->subscription_type
        ]);

        if(isset($data['commission_type']) && $data['commission_type'] == 3){
            if (!empty($data['pricing_id'])) {
                $sellerSubscription = SellerSubcription::where('seller_id', $user_data['id'])->first();
                if($sellerSubscription){
                    if($sellerSubscription->pricing_id != $data['pricing_id']){
                        $sellerSubscription->update([
                            'pricing_id' => $data['pricing_id'],
                            'expiry_date' => date('Y-m-d',strtotime("-1 days"))
                        ]);
                    }
                }else{
                    SellerSubcription::create([
                        'seller_id' => $user_data['id'],
                        'pricing_id' => $data['pricing_id']
                    ]);
                }
            }
        }

        return true;

    }

    public function businessInformationUpdate($data, $id){

        $seller_data = SellerBusinessInformation::where('user_id',$id)->firstOrFail();

        return $seller_data->update([
            'business_owner_name' => $data['business_owner_name'],
            'business_address1' => $data['business_address1'],
            'business_address2' => $data['business_address2'],
            'business_country' => $data['country'],
            'business_state' => $data['state'],
            'business_city' => $data['city'],
            'business_postcode' => $data['business_postcode'],
            'business_person_in_charge_name' => $data['business_person_incharge_name'],
            'business_registration_number' => $data['business_registration_number'],
            'business_seller_tin' => $data['seller_tin'],
            'business_document' =>$data['business_document']
        ]);
    }
    public function bankAccountUpdate($data, $id){
        $seller_data = SellerBankAccount::where('user_id',$id)->firstOrFail();

        return $seller_data->update([
            'payment' => $data['payment'],
            'bank_title' => $data['bank_title'],
            'bank_account_number' => $data['bank_account_number'],
            'bank_name' => $data['bank_name'],
            'bank_branch_name' => $data['branch_name'],
            'bank_routing_number' => $data['routing_number'],
            'bank_ibn' => $data['ibn'],
            'bank_cheque' => $data['cheque_copy']
        ]);
    }
    public function warehouseAddressUpdate($data, $id){

        $seller_data = SellerWarehouseAddress::where('user_id',$id)->firstOrFail();
        return $seller_data->update([
            'warehouse_name' => $data['warehouse_name'],
            'warehouse_address' => $data['warehouse_address'],
            'warehouse_phone' => $data['warehouse_phone'],
            'warehouse_country' => $data['country'],
            'warehouse_state' => $data['state'],
            'warehouse_city' => $data['city'],
            'warehouse_postcode' => $data['warehouse_postcode'],

        ]);

    }
    public function returnAddressUpdate($data, $id){
        $seller_data = SellerReturnAddress::where('user_id',$id)->firstOrFail();
        return $seller_data->update([
            'return_name' => $data['name'],
            'return_address' => $data['address'],
            'return_phone' => $data['phone'],
            'return_country' => $data['country'],
            'return_state' => $data['state'],
            'return_city' => $data['city'],
            'return_postcode' => $data['postcode'],
            'same_as_warehouse' => $data['same_as_warehouse'],

        ]);

    }
    public function returnAddressChange($data){
        $id = $data['id'];
        $same_as_warehouse = $data['same_as_warehouse'];
        $seller_data = SellerReturnAddress::where('user_id',$id)->firstOrFail();

        $seller_data->same_as_warehouse = $same_as_warehouse;
        $seller_data->save();
        return 'done';
    }

    public function editBank($id){
        return SellerBankAccount::where('user_id',$id)->firstOrFail();
    }

    public function editBusiness($id){
        return SellerBusinessInformation::where('user_id',$id)->firstOrFail();
    }

    public function editBusinessInformation($id){
        return SellerBusinessInformation::where('id',$id)->firstOrFail();
    }
    public function editBankAccount($id){
        return SellerBankAccount::where('id',$id)->firstOrFail();
    }

    public function businessImgDelete($id){
        $seller = SellerBusinessInformation::where('id',$id)->firstOrFail();
        $seller->business_document = null;
        $seller->save();
        return 1;

    }

    public function bankImgDelete($id){
        $seller = SellerBankAccount::where('id',$id)->firstOrFail();
        $seller->bank_cheque = null;
        $seller->save();
        return 1;
    }

    public function sellerChangePassword($data){
        $userData = $this->getData(gv($data, 'seller_user_id'));
        return $userData->update(['password'=> Hash::make(gv($data, 'seller_new_password'))]);
    }
}
