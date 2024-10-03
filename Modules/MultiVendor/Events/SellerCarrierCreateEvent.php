<?php

namespace Modules\MultiVendor\Events;

use Illuminate\Queue\SerializesModels;

class SellerCarrierCreateEvent
{
    use SerializesModels;

    public $user_id;
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }


    public function broadcastOn()
    {
        return [];
    }
}
