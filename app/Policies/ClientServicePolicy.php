<?php

namespace App\Policies;

use App\Models\ClientService;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientServicePolicy
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
     * View service listing.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client-service.view');
    }

    /**
     * View service.
     */
    public function view(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.view');
    }

    /**
     * Assign service to client.
     */
    public function create(User $user): bool
    {
        return $user->can('client-service.create');
    }

    /**
     * Update assigned service.
     */
    public function update(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.update');
    }

    /**
     * Remove assigned service.
     */
    public function delete(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.delete');
    }

    /**
     * Restore deleted service.
     */
    public function restore(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.restore');
    }

    /**
     * Permanently delete service assignment.
     */
    public function forceDelete(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.force-delete');
    }

    /**
     * Import client services.
     */
    public function import(User $user): bool
    {
        return $user->can('client-service.import');
    }

    /**
     * Export client services.
     */
    public function export(User $user): bool
    {
        return $user->can('client-service.export');
    }

    /**
     * Renew service.
     */
    public function renew(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.renew');
    }

    /**
     * Suspend service.
     */
    public function suspend(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.suspend');
    }

    /**
     * Activate service.
     */
    public function activate(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.activate');
    }

    /**
     * Assign employee.
     */
    public function assign(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.assign');
    }

    /**
     * Change billing.
     */
    public function changeBilling(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.billing');
    }

    /**
     * Generate recurring tasks.
     */
    public function generateTasks(User $user, ClientService $clientService): bool
    {
        return $user->can('client-service.generate-tasks');
    }
}