<?php

namespace Modules\Setup\Repositories;

use Modules\Setup\Entities\AlgoliaSearchConfiguration;
use Modules\Setup\Entities\PartialPaymentConfiguration;

class SetupRepository{

    public function updateAlgoliaSearchConfig($status){
        $algoliaSearch = AlgoliaSearchConfiguration::findOrFail(1);
        $algoliaSearch->status = $status;
        $algoliaSearch->save();
        return true;
    }
    
    public function updatePartialPaymentConfig($status){
        $algoliaSearch = PartialPaymentConfiguration::findOrFail(1);
        $algoliaSearch->status = $status;
        $algoliaSearch->save();
        return true;
    }
    
}

