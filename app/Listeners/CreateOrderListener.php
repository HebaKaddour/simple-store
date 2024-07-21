<?php

namespace App\Listeners;

use App\Models\Order;
use App\Events\CreateOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateOrderListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreateOrder $event): void
    {
        $user = $event->user;
        $request = $event->request;

        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['user_ip'] = $user->user_ip;
        $data['status'] = 'waiting';

        $order = Order::create($data);
        $product = $order->product;
        $product->decrement('quantity', $request->quantity);


    }
}
