<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy extends OwnerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('order.read');
    }


    public function update(User $user, Order $order): bool
    {
        return $user->hasPermission('update.read');
    }

    public function delete(User $user, Order $order): bool
    {
            return $user->hasPermission('order.delete');
    }
}
