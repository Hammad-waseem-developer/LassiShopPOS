<?php

// app/Events/OrderListEvent.php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderListEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderList;

    public function __construct($orderList)
    {
        $this->orderList = $orderList;
    }
}
