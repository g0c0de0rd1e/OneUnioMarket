<?php

namespace Modules\MultiVendor\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MultiVendor\Events\SellerCarrierCreateEvent;
use Modules\Shipping\Entities\Carrier;

class SellerCarrierCreateListener
{

    public function __construct()
    {
        //
    }


    public function handle(SellerCarrierCreateEvent $event)
    {
        Carrier::create([
            'name'=>'Manual',
            'slug'=>'Manual',
            'created_by'=>$event->user_id,
        ]);
    }
}
