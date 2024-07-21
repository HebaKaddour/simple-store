<?php

namespace App\Listeners;

use App\Events\UpdateOrder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateOrderListener
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
    public function handle(UpdateOrder $event): void
    {
        $order = $event->order;
        $user = $event->user;
        $request = $event->request;

        $existOrder->increment('quantity', $request->quantity);
                $product->decrement('quantity', $request->quantity);
                $existOrder->save();
    }
}
