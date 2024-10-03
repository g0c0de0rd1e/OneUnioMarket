<?php

namespace Modules\MultiVendor\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MultiVendor\Events\SellerShippingRateEvent;
use Modules\Shipping\Entities\Carrier;
use Modules\Shipping\Entities\ShippingMethod;

class SellerShippingRateListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SellerShippingRateEvent $event)
    {

        $carrier = Carrier::where('created_by',$event->user_id)->first();
        $shipping = [
            'method_name' => 'Flat Rate',
            'logo' => null,
            'phone' => null,
            'shipment_time' => '0-3 days',
            'cost' => 20,
            'is_active' => 1,
            'request_by_user' => $event->user_id,
            'is_approved' => 1,
            'carrier_id' => $carrier->id
        ];
        return ShippingMethod::create($shipping);
    }
}
