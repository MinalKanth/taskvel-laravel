<?php

namespace App\Policies;

use App\Models\ClientTag;
use App\Models\User;

class ClientTagPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client-tag.view')
            || $user->can('client-tag.list');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClientTag $clientTag): bool
    {
        return $user->can('client-tag.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('client-tag.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClientTag $clientTag): bool
    {
        return $user->can('client-tag.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClientTag $clientTag): bool
    {
        return $user->can('client-tag.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ?ClientTag $clientTag = null): bool
{
    return $user->can('client-tag.restore');
}

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClientTag $clientTag): bool
    {
        return $user->can('client-tag.force-delete');
    }
}