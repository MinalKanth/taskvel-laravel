<?php

namespace App\Policies;

use App\Models\ClientAddress;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientAddressPolicy
{
    use HandlesAuthorization;

    /**
     * Grant all permissions to Super Admin.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }

        return null;
    }

    /**
     * View address listing.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client-address.view');
    }

    /**
     * View address.
     */
    public function view(User $user, ClientAddress $clientAddress): bool
    {
        return $user->can('client-address.view');
    }

    /**
     * Create address.
     */
    public function create(User $user): bool
    {
        return $user->can('client-address.create');
    }

    /**
     * Update address.
     */
    public function update(User $user, ClientAddress $clientAddress): bool
    {
        return $user->can('client-address.update');
    }

    /**
     * Delete address.
     */
    public function delete(User $user, ClientAddress $clientAddress): bool
    {
        return $user->can('client-address.delete');
    }

    /**
     * Restore address.
     */
    public function restore(User $user, ClientAddress $clientAddress): bool
    {
        return $user->can('client-address.restore');
    }

    /**
     * Permanently delete address.
     */
    public function forceDelete(User $user, ClientAddress $clientAddress): bool
    {
        return $user->can('client-address.force-delete');
    }

    /**
     * Import addresses.
     */
    public function import(User $user): bool
    {
        return $user->can('client-address.import');
    }

    /**
     * Export addresses.
     */
    public function export(User $user): bool
    {
        return $user->can('client-address.export');
    }

    /**
     * Set default address.
     */
    public function setDefault(User $user, ClientAddress $clientAddress): bool
    {
        return $user->can('client-address.update');
    }

    /**
     * View map location.
     */
    public function viewMap(User $user, ClientAddress $clientAddress): bool
    {
        return $user->can('client-address.map');
    }

    /**
     * Verify address.
     */
    public function verify(User $user, ClientAddress $clientAddress): bool
    {
        return $user->can('client-address.verify');
    }
}