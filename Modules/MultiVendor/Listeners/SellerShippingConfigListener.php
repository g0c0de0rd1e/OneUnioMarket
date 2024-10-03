<?php

namespace Modules\MultiVendor\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MultiVendor\Events\SellerShippingConfigEvent;
use Modules\Shipping\Entities\ShippingConfiguration;

class SellerShippingConfigListener
{

    public function __construct()
    {
        //
    }


    public function handle(SellerShippingConfigEvent $event)
    {
        $row = ShippingConfiguration::where('seller_id',1)->first();
        $newRow = $row->replicate();
        $newRow->seller_id = $event->user_id;
        $newRow->order_confirm_and_sync = 'Manual';
        $newRow->save();
        return $newRow;
    }
}
