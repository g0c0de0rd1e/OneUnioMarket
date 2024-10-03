<?php

namespace Modules\MultiVendor\Services;

use Illuminate\Support\Facades\Validator;
use \Modules\MultiVendor\Repositories\MerchantRepository;
use App\Traits\ImageStore;

class MerchantService{
    use ImageStore;

    protected $merchantRepository;

    public function __construct(MerchantRepository $merchantRepository)
    {
        $this->merchantRepository = $merchantRepository;
    }

    public function getAll()
    {
        return $this->merchantRepository->getAll();
    }

    public function getActive()
    {
        return $this->merchantRepository->getActive();
    }

    public function getInactive()
    {
        return $this->merchantRepository->getInactive();
    }

    public function getAllSeller()
    {
        return $this->merchantRepository->getAllSeller();
    }

    public function findUserByID($id)
    {
        return $this->merchantRepository->findUserByID($id);
    }

    public function create($data)
    {
        return $this->merchantRepository->create($data);
    }

    public function update_commission($data)
    {
        return $this->merchantRepository->update_commission($data);
    }

    public function changeTrustedStatus($id)
    {
        return $this->merchantRepository->changeTrustedStatus($id);
    }

    public function gstStatusUpdate($data)
    {
        return $this->merchantRepository->gstStatusUpdate($data);
    }

    public function getSellerConfiguration()
    {
        return $this->merchantRepository->getSellerConfiguration();
    }


    public function sellerConfigurationUpdate($request)
    {
        return $this->merchantRepository->sellerConfigurationUpdate($request);
    }

    public function update_status($userId)
    {
        return $this->merchantRepository->update_status($userId);
    }
    public function csvDownloadCategory()
    {
        return $this->merchantRepository->csvDownloadCategory();
    }
    public function csvDownloadBrand()
    {
        return $this->merchantRepository->csvDownloadBrand();
    }
    public function csvDownloadUnit()
    {
        return $this->merchantRepository->csvDownloadUnit();
    }
    public function csvDownloadMediaIds()
    {
        return $this->merchantRepository->csvDownloadMediaIds();
    }
}
