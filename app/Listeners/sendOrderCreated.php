<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\OrderCreatedNotification;

class sendOrderCreated
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
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $admin = User::where('admin', 1)->first();

        if ($admin) {
            $admin->notify(new OrderCreatedNotification($order));
        }
    }

}
