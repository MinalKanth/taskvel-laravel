<?php

namespace App\Policies;

use App\Models\ClientRemark;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientRemarkPolicy
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
     * View remarks listing.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client-remark.view');
    }

    /**
     * View remark.
     */
    public function view(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.view');
    }

    /**
     * Create remark.
     */
    public function create(User $user): bool
    {
        return $user->can('client-remark.create');
    }

    /**
     * Update remark.
     */
    public function update(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.update');
    }

    /**
     * Delete remark.
     */
    public function delete(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.delete');
    }

    /**
     * Restore remark.
     */
    public function restore(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.restore');
    }

    /**
     * Permanently delete remark.
     */
    public function forceDelete(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.force-delete');
    }

    /**
     * Reply to remark.
     */
    public function reply(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.reply');
    }

    /**
     * Pin remark.
     */
    public function pin(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.pin');
    }

    /**
     * Unpin remark.
     */
    public function unpin(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.pin');
    }

    /**
     * Close remark.
     */
    public function close(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.close');
    }

    /**
     * Reopen remark.
     */
    public function reopen(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.reopen');
    }

    /**
     * Mention users.
     */
    public function mention(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.mention');
    }

    /**
     * View private remarks.
     */
    public function viewPrivate(User $user, ClientRemark $clientRemark): bool
    {
        return $user->can('client-remark.private');
    }

    /**
     * Export remarks.
     */
    public function export(User $user): bool
    {
        return $user->can('client-remark.export');
    }
}