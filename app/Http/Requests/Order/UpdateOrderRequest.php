<?php

namespace App\Http\Requests\Order;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $order = $this->route('order');
        $user = $this->user();

        if ($user->hasPermission('order.update') || $user->id === $order->user_id) {
            return true;
        } else {
            return false;
        }

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
             'quantity' => 'required|integer|min:1',
        ];
    }
}
