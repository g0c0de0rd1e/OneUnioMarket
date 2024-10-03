<?php

namespace Modules\MultiVendor\Services;

use Illuminate\Support\Facades\Validator;
use Modules\MultiVendor\Repositories\SellerRepository;

class SellerService{

    protected $sellerRepository;

    public function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }

    public function orderCommissionForAdmin($data){
        return $this->sellerRepository->orderCommissionForAdmin($data);
    }

    public function orderCommissionForAdminViaFilter($data){
        return $this->sellerRepository->orderCommissionForAdminViaFilter($data);
    }

}
