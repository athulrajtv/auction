<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;

class BidPlaced implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function broadcastOn()
    {
        return new Channel('auction-channel');
    }

    public function broadcastWith()
    {
        return [
            'product_id' => $this->product->id,
            'current_price' => $this->product->current_price,
            'username' => $this->product->last_bid_user,
        ];
    }
}
