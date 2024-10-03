<?php

namespace Modules\MultiVendor\Services;

use App\Traits\ImageStore;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Modules\MultiVendor\Repositories\ProfileRepository;

class ProfileService{
    use ImageStore;
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getData($id){
        return $this->profileRepository->getData($id);
    }
    public function sellerAccountUpdate($data, $id){
        return $this->profileRepository->sellerAccountUpdate($data, $id);
    }
    public function businessInformationUpdate($data, $id){


        $getData = $this->profileRepository->editBusiness($id);

        if(isset($data['business_document'])){
            ImageStore::deleteImage($getData->business_document);
            $imagename = ImageStore::saveImage($data['business_document']);
            $newData = [
                'business_owner_name' => $data['business_owner_name'],
                'business_address1' => $data['business_address1'],
                'business_address2' => $data['business_address2']?$data['business_address2']:null,
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'business_postcode' => $data['business_postcode'],
                'business_person_incharge_name' => $data['business_person_incharge_name'],
                'business_registration_number' => $data['business_registration_number'],
                'seller_tin' => isset($data['seller_tin'])?$data['seller_tin']:null,
                'business_document' => $imagename
                ];
        }else{
            $newData = [
                'business_owner_name' => $data['business_owner_name'],
                'business_address1' => $data['business_address1'],
                'business_address2' => $data['business_address2']?$data['business_address2']:null,
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'business_postcode' => $data['business_postcode'],
                'business_person_incharge_name' => $data['business_person_incharge_name'],
                'business_registration_number' => $data['business_registration_number'],
                'seller_tin' => isset($data['seller_tin'])?$data['seller_tin']:null,
                'business_document' =>$getData->business_document
                ];
        }
        return $this->profileRepository->businessInformationUpdate($newData, $id);
    }
    public function bankAccountUpdate($data, $id){

        $getData = $this->profileRepository->editBank($id);
        if(isset($data['cheque_copy'])){
            ImageStore::deleteImage($getData->bank_cheque);
            $imagename = ImageStore::saveImage($data['cheque_copy']);
            $newData = [
                'payment' => $data['payment'],
                'bank_title' => $data['bank_title'],
                'bank_account_number' => $data['bank_account_number'],
                'bank_name' => $data['bank_name'],
                'branch_name' => $data['branch_name'],
                'routing_number' => $data['routing_number'],
                'ibn' => $data['ibn'],
                'cheque_copy' => $imagename
            ];
        }else{
            $newData = [
                'payment' => $data['payment'],
                'bank_title' => $data['bank_title'],
                'bank_account_number' => $data['bank_account_number'],
                'bank_name' => $data['bank_name'],
                'branch_name' => $data['branch_name'],
                'routing_number' => $data['routing_number'],
                'ibn' => $data['ibn'],
                'cheque_copy' => $getData->bank_cheque
            ];
        }
        return $this->profileRepository->bankAccountUpdate($newData, $id);
    }

    public function warehouseAddressUpdate($data, $id){

        return $this->profileRepository->warehouseAddressUpdate($data, $id);
    }
    public function returnAddressUpdate($data, $id){
        return $this->profileRepository->returnAddressUpdate($data, $id);
    }
    public function returnAddressChange($data){
        return $this-> profileRepository->returnAddressChange($data);
    }

    public function businessImgDelete($id){
        $getData = $this->profileRepository->editBusinessInformation($id);
        ImageStore::deleteImage($getData->business_document);
        return $this->profileRepository->businessImgDelete($id);

    }
    public function bankImgDelete($id){
        $getData = $this->profileRepository->editBankAccount($id);
        ImageStore::deleteImage($getData->business_document);
        return $this->profileRepository->bankImgDelete($id);

    }

    public function sellerChangePassword($data){
        $userData = $this->getData(gv($data, 'seller_user_id'));
        return $userData->update(['password' => Hash::make(gv($data, 'seller_new_password'))]);
    }
}
