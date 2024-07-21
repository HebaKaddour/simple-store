<?php
namespace App\Helpers;

use App\Models\Order;
use App\Models\Product;

class OrderHelper
{
    public static function restoreProductQuantity(Order $order): void
    {
        $product = Product::find($order->product_id);
        $product->increment('quantity', $order->quantity);
        $order->delete();
        $product->save();
    }
}
