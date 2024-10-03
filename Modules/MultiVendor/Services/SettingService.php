<?php

namespace Modules\MultiVendor\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\MultiVendor\Repositories\SettingRepository;
use App\Traits\ImageStore;

class SettingService{
    use ImageStore;
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getData($id){
        return $this->settingRepository->getData($id);
    }
    public function getSocialLink($id){
        return $this->settingRepository->getSocialLink($id);
    }
    
    public function logoUpdate($data, $id){

        $getData = $this->settingRepository->getData($id);
        
        if(isset($data['logo']) && isset($data['banner'])){
            ImageStore::deleteImage($getData->photo);
            $logo = ImageStore::saveImage($data['logo'],165,165);
            ImageStore::deleteImage($getData->sellerAccount->banner);
            $banner = ImageStore::saveImage($data['banner'],1920,350);
            $newData = [
                'logo' => $logo,
                'banner' => $banner,
            ];
            return $this->settingRepository->logoUpdate($newData, $id);
        }
        if(isset($data['logo']) && !isset($data['banner'])){
            ImageStore::deleteImage($getData->photo);
            $logo = ImageStore::saveImage($data['logo'],165,165);
            $newData = [
                'logo' => $logo,
                'banner' => $getData->sellerAccount->banner,
            ];
            return $this->settingRepository->logoUpdate($newData, $id);
        }
        if(!isset($data['logo']) && isset($data['banner'])){
            ImageStore::deleteImage($getData->sellerAccount->banner);
            $banner = ImageStore::saveImage($data['banner'],1920,350);
            $newData = [
                'logo' => $getData->photo,
                'banner' => $banner,
            ];
            return $this->settingRepository->logoUpdate($newData, $id);
        }else{
            $newData = [
                'logo' => $getData->photo,
                'banner' => $getData->sellerAccount->banner,
            ];
            return $this->settingRepository->logoUpdate($newData, $id);
        }
        
    }

    public function SaveSocilaLink($data){
        return $this->settingRepository->SaveSocilaLink($data);
    }
    public function UpdateSocialLink($data, $id){
        return $this->settingRepository->UpdateSocilaLink($data, $id);
    }

    public function linkById($id){
        return $this->settingRepository->linkById($id);
    }


}
