<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Carbon\Carbon;

class DeleteOldDeliveredOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:delete-old-delivered-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'delete order after 3 days frome updating his status to delivered';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('status', 'delivered')
        ->where('updated_at', '<=', Carbon::now()->subDays(3))
        ->get();

    foreach ($orders as $order) {
        $order->delete();
    }

    $this->info('Old delivered orders have been deleted successfully.');
    }
}
