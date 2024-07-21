<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Authorization\Policy;
use Illuminate\Auth\Access\Response;
use HandlesAuthorization;
class CategoryPolicy extends OwnerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('category.read');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->hasPermission('category.show');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('category.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->hasPermission('category.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->hasPermission('delete.update');
    }


}
