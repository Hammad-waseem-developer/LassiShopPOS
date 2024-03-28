<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderList implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function broadcastOn()
    {
        return ['order-list'];
    }

    public function broadcastAs()
    {
        return 'order-list';
    }
}
