<?php

namespace App\Policies;

use App\Models\ClientDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientDocumentPolicy
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
     * View document listing.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client-document.view');
    }

    /**
     * View document.
     */
    public function view(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.view');
    }

    /**
     * Upload document.
     */
    public function create(User $user): bool
    {
        return $user->can('client-document.create');
    }

    /**
     * Update document.
     */
    public function update(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.update');
    }

    /**
     * Delete document.
     */
    public function delete(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.delete');
    }

    /**
     * Restore document.
     */
    public function restore(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.restore');
    }

    /**
     * Permanently delete document.
     */
    public function forceDelete(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.force-delete');
    }

    /**
     * Download document.
     */
    public function download(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.download');
    }

    /**
     * Approve document.
     */
    public function approve(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.approve');
    }

    /**
     * Reject document.
     */
    public function reject(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.reject');
    }

    /**
     * Archive document.
     */
    public function archive(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.archive');
    }

    /**
     * Share document.
     */
    public function share(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.share');
    }

    /**
     * Verify document.
     */
    public function verify(User $user, ClientDocument $clientDocument): bool
    {
        return $user->can('client-document.verify');
    }

    /**
     * Export document data.
     */
    public function export(User $user): bool
    {
        return $user->can('client-document.export');
    }

    /**
     * Import document data.
     */
    public function import(User $user): bool
    {
        return $user->can('client-document.import');
    }
}