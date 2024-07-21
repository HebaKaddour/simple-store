<?php

namespace App\Http\Controllers\Api;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\handlepaymentRequest;

class PaymentController extends Controller
{
    public function handle(Request $request)
    {
        // Set API secret key
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $user = auth('sanctum')->user();
        $userIp = $user->user_ip ?? '';

        if (!$user) {
            return $this->errorResponse('user not found', 404);
          }
         $orderIds = collect($request->input('order_ids'));
         $orders = Order::with(['user', 'userByIp'])
         ->where('user_id', $user->id)->orWhere('user_ip', $user->user_ip)
         ->whereIn('id', $orderIds)
         ->get();

        if (!$orders) {
        return $this->errorResponse('Order not found', 404);
      }

      foreach ($orders as $orders) {
        $totalAmountInCents = $orders->sum('quantity') * $orders->product->sum('price');
      }
        // Create PaymentIntent
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => $totalAmountInCents,
            'currency' => 'usd',
            'metadata' => [
                'user_id' => $user->id,
                'user_ip' => $userIp,
                'order_ids' => $orderIds->implode(','),
            ],
        ]);
     //   cache(['order_ids' => $orderIds], 60);
      $client_secret = $paymentIntent->client_secret;
      return view('payment', ['client_secret' => $client_secret]);
     // return $this->successResponse($client_secret,'paymentIntent created successful.', 200);
    }

    public function confirm()
    {
      // Set API secret key
      Stripe::setApiKey(config('services.stripe.secret_key'));
    // get paymentintent id
      $paymentIntentId = request()->query('payment_intent_id');
      DB::transaction(function () use ($paymentIntentId) {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        // Store the successful payment details in the payments table
        if ($paymentIntent->status == 'succeeded') {
            $orderIds = explode(',', $paymentIntent->metadata['order_ids']);
             Payment::forceCreate([
            'amount' => $paymentIntent->amount,
            'currency' => $paymentIntent->currency,
            'order_ids' => $orderIds,
            'transaction_id' => $paymentIntent->id,
        ]);
        Order::whereIn('id', $orderIds)->update(['status' => 'paid']);
        return $this->successResponse('null','Payment successful.', 200);
        }
 });
}
}
