<?php
namespace Modules\Setup\Services;

use Illuminate\Support\Facades\Validator;
use Modules\Setup\Repositories\SetupRepository;

class SetupService
{
    protected $setupRepository;

    public function __construct(SetupRepository  $setupRepository)
    {
        $this->setupRepository = $setupRepository;
    }

    public function updateAlgoliaSearchConfig($status){
        return $this->setupRepository->updateAlgoliaSearchConfig($status);
    }
    
    public function updatePartialPaymentConfig($status){
        return $this->setupRepository->updatePartialPaymentConfig($status);
    }
    
}
