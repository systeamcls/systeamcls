<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function broadcastOn()
    {
        $channels = [
            new Channel('orders'), // Public channel for all orders
        ];

        // Add private channels for each tenant involved in the order
        $tenantIds = $this->order->orderItems->pluck('menuItem.user_id')->unique();
        foreach ($tenantIds as $tenantId) {
            $channels[] = new PrivateChannel("orders.tenant.{$tenantId}");
        }

        return $channels;
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order->load(['orderItems.menuItem.user', 'user']),
            'message' => 'New order placed: #' . $this->order->id,
        ];
    }

    public function broadcastAs()
    {
        return 'order.placed';
    }
}