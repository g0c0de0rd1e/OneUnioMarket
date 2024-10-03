<?php

namespace Modules\MultiVendor\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\MultiVendor\Events\SellerPickupLocationCreated;
use Modules\MultiVendor\Listeners\SellerPickupLocationCreatedListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SellerPickupLocationCreated::class => [
            SellerPickupLocationCreatedListener::class
        ]
    ];
    
}
