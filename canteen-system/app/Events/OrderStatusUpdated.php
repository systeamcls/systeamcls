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

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $previousStatus;

    public function __construct(Order $order, $previousStatus)
    {
        $this->order = $order;
        $this->previousStatus = $previousStatus;
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

        // Add customer channel if user exists
        if ($this->order->user_id) {
            $channels[] = new PrivateChannel("orders.customer.{$this->order->user_id}");
        }

        return $channels;
    }

    public function broadcastWith()
    {
        return [
            'order' => $this->order->load(['orderItems.menuItem.user', 'user']),
            'previous_status' => $this->previousStatus,
            'message' => "Order #{$this->order->id} status updated to {$this->order->status}",
        ];
    }

    public function broadcastAs()
    {
        return 'order.status.updated';
    }
}