<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class OwnerPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->Owner) {
            return true;
        }
        return null;
    }
}
