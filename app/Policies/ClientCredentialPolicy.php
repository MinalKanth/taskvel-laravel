<?php

namespace App\Policies;

use App\Models\ClientCredential;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientCredentialPolicy
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
     * View credential listing.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client-credential.view');
    }

    /**
     * View credential.
     */
    public function view(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.view');
    }

    /**
     * Create credential.
     */
    public function create(User $user): bool
    {
        return $user->can('client-credential.create');
    }

    /**
     * Update credential.
     */
    public function update(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.update');
    }

    /**
     * Delete credential.
     */
    public function delete(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.delete');
    }

    /**
     * Restore credential.
     */
    public function restore(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.restore');
    }

    /**
     * Permanently delete credential.
     */
    public function forceDelete(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.force-delete');
    }

    /**
     * Reveal password.
     */
    public function revealPassword(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.reveal-password');
    }

    /**
     * Change password.
     */
    public function changePassword(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.change-password');
    }

    /**
     * Download credentials.
     */
    public function export(User $user): bool
    {
        return $user->can('client-credential.export');
    }

    /**
     * Import credentials.
     */
    public function import(User $user): bool
    {
        return $user->can('client-credential.import');
    }

    /**
     * View API credentials.
     */
    public function viewApi(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.view-api');
    }

    /**
     * Update API credentials.
     */
    public function updateApi(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.update-api');
    }

    /**
     * Manage DSC.
     */
    public function manageDsc(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.manage-dsc');
    }

    /**
     * Manage OTP settings.
     */
    public function manageOtp(User $user, ClientCredential $clientCredential): bool
    {
        return $user->can('client-credential.manage-otp');
    }
}