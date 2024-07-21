<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy extends OwnerPolicy
{

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permission): bool
    {
        return $user->hasPermission('update.create');
    }

}
