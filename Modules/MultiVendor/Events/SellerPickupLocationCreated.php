<?php

namespace Modules\MultiVendor\Events;

use Illuminate\Queue\SerializesModels;

class SellerPickupLocationCreated
{
    use SerializesModels;



    public $user_id;
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
