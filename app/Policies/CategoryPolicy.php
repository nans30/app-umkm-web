<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('admin.category.index');
    }

    public function view(User $user, Category $model): bool
    {
        return $user->can('admin.category.index');
    }

    public function create(User $user): bool
    {
        return $user->can('admin.category.create');
    }

    public function update(User $user, Category $model): bool
    {
        return $user->can('admin.category.edit');
    }

    public function delete(User $user, Category $model): bool
    {
        return $user->can('admin.category.destroy');
    }

    public function restore(User $user, Category $model): bool
    {
        return $user->can('admin.category.restore');
    }

    public function forceDelete(User $user, Category $model): bool
    {
        return $user->can('admin.category.forceDelete');
    }
}
