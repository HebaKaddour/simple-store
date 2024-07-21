<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Events\CreateOrder;
use App\Helpers\OrderHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\AllOrderRequest;
use App\Http\Requests\Order\ShowOrderRequest;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AllOrderRequest $request)
    {
        $this->authorize('viewAny',Order::class);
        $status = $request->query('status');
        $orders = Order::query();
        $user = auth('sanctum')->user();
        if ($user) {
            $orders->where('user_id', $user->id);
        }
        else{
            $orders->where('user_ip',$request->ip());
        }
        if ($status) {
          $orders->where('status', $status);
        }

        $orders = $orders->orderBy('status')->get()->groupBy('status');
        return $this->successResponse($orders,'success.', 200);

    }

    public function show(ShowOrderRequest $request)
    {
        //using custom request for check
        $orderId = $request->route('order');
        if (!$order = Order::find($orderId)) {
            return $this->errorResponse('Order not found', 404);
        }
        return $this->successResponse($order, 'Order retrieved successfully.', 200);
    }

    public function create()
    {
        //
    }

    public function store(StoreOrderRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $user = auth('sanctum')->user();

        return DB::transaction(function () use ($product, $user,$request) {
            $existOrder = Order::where('product_id', $request->product_id)
                ->where('user_id', $user->id)
                ->first();

            if ($existOrder && $product->quantity >= $request->quantity) {
                $existOrder->increment('quantity', $request->quantity);
                $product->decrement('quantity', $request->quantity);
                $existOrder->save();
                return $this->successResponse('Order updated successfully!', null, 201);

            } elseif ($product->quantity >= $request->quantity) {
                event(new CreateOrder($user, $request));
            } else {
                return $this->errorResponse('The quantity of product is not enough', 400);
            }
        });
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        //using custom request for check
        $id = $order->id;
        DB::transaction(function () use ($request, $id) {
            $order = Order::lockForUpdate()->findOrFail($id);
            $data = $request->validated();

            $delta = $data['quantity'] - $order->quantity;
            $product = Product::find($order->product_id);
            if ($order->status === 'waiting') {
                $order->increment('quantity',$delta);
                $product->decrement('quantity', $delta);
            }
            $order->status = $request->input('status');
            $order->save();

                return $this->errorResponse('Order cannot be updated as it is not in waiting state!', 400);

        });

        return $this->successResponse('success','Order updated successfully!', 200);
    }


    public function destroy(User $user, Order $order)
    {
        $this->authorize('delete',[$user, $order]);
        $id = $order->id;
        DB::transaction(function () use ($id) {
            $order = Order::lockForUpdate()->findOrFail($id);

            if ($order->status === 'waiting') {
                OrderHelper::restoreProductQuantity($order);
            } else {
                return $this->errorResponse('Order cannot be deleted as it is not in waiting state!', 400);
            }
        });

        return $this->successResponse('Order deleted successfully!', null, 200);
    }
}
