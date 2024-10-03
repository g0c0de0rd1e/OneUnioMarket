<?php

namespace Modules\MultiVendor\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\MultiVendor\Events\SellerPickupLocationCreated;
use Modules\Shipping\Entities\PickupLocation;

class SellerPickupLocationCreatedListener
{

    public function __construct()
    {
        //
    }


    public function handle(SellerPickupLocationCreated $event)
    {
        $location = PickupLocation::where('created_by',1)->first();
        if($location){
            $newLocation = $location->replicate();
            $newLocation->created_by = $event->user_id;
            $newLocation->is_set = 1;
            $newLocation->is_default = 1;
            $newLocation->status = 1;
            $newLocation->save();
        }else{
            $newLocation = new PickupLocation();
            $newLocation->pickup_location = 'Pickup Location 1';
            $newLocation->name = app('general_setting')->company_name;
            $newLocation->email = app('general_setting')->email;
            $newLocation->phone = app('general_setting')->phone;
            $newLocation->address = app('general_setting')->address;
            $newLocation->country_id = app('general_setting')->country_id;
            $newLocation->state_id = app('general_setting')->state_id;
            $newLocation->city_id = app('general_setting')->city_id;
            $newLocation->pin_code = app('general_setting')->zip_code;
            $newLocation->pin_code = 1;
            $newLocation->status = 1;
            $newLocation->created_by = $event->user_id;
            $newLocation->is_default = 1;
            $newLocation->save();
        }
        return $newLocation;
    }
}
