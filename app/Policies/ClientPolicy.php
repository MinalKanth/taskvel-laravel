<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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
     * Display client listing.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client.view');
    }

    /**
     * View client details.
     */
    public function view(User $user, Client $client): bool
    {
        return $user->can('client.view');
    }

    /**
     * Create client.
     */
    public function create(User $user): bool
    {
        return $user->can('client.create');
    }

    /**
     * Update client.
     */
    public function update(User $user, Client $client): bool
    {
        return $user->can('client.update');
    }

    /**
     * Soft delete client.
     */
    public function delete(User $user, Client $client): bool
    {
        return $user->can('client.delete');
    }

    /**
     * Restore client.
     */
    public function restore(User $user, Client $client): bool
    {
        return $user->can('client.restore');
    }

    /**
     * Permanently delete client.
     */
    public function forceDelete(User $user, Client $client): bool
    {
        return $user->can('client.force-delete');
    }

    /**
     * Import clients.
     */
    public function import(User $user): bool
    {
        return $user->can('client.import');
    }

    /**
     * Export clients.
     */
    public function export(User $user): bool
    {
        return $user->can('client.export');
    }

    /**
     * Assign client to employee.
     */
    public function assign(User $user, Client $client): bool
    {
        return $user->can('client.assign');
    }

    /**
     * View client credentials.
     */
    public function viewCredentials(User $user, Client $client): bool
    {
        return $user->can('client-credential.view');
    }

    /**
     * Manage client credentials.
     */
    public function manageCredentials(User $user, Client $client): bool
    {
        return $user->can('client-credential.update');
    }

    /**
     * Manage client documents.
     */
    public function manageDocuments(User $user, Client $client): bool
    {
        return $user->can('client-document.create');
    }

    /**
     * Download client documents.
     */
    public function downloadDocuments(User $user, Client $client): bool
    {
        return $user->can('client-document.download');
    }

    /**
     * Manage client services.
     */
    public function manageServices(User $user, Client $client): bool
    {
        return $user->can('client-service.update');
    }

    /**
     * Manage client remarks.
     */
    public function manageRemarks(User $user, Client $client): bool
    {
        return $user->can('client-remark.update');
    }

    /**
     * Manage client communications.
     */
    public function manageCommunications(User $user, Client $client): bool
    {
        return $user->can('client-communication.update');
    }
}