<?php

// app/Events/OrderListEvent.php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderListEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderList;
    public $orders;

    public function __construct($orderList,$orders)
    {
        $this->orderList = $orderList;
        $this->orders = $orders;
    }
    public function broadcastOn() : array
    {
        return [
            'order-list'
        ];
    }
}
