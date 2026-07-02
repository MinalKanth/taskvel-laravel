<?php

namespace App\Policies;

use App\Models\ClientContact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientContactPolicy
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
     * View contact listing.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client-contact.view');
    }

    /**
     * View contact.
     */
    public function view(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.view');
    }

    /**
     * Create contact.
     */
    public function create(User $user): bool
    {
        return $user->can('client-contact.create');
    }

    /**
     * Update contact.
     */
    public function update(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.update');
    }

    /**
     * Delete contact.
     */
    public function delete(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.delete');
    }

    /**
     * Restore contact.
     */
    public function restore(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.restore');
    }

    /**
     * Permanently delete contact.
     */
    public function forceDelete(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.force-delete');
    }

    /**
     * Export contacts.
     */
    public function export(User $user): bool
    {
        return $user->can('client-contact.export');
    }

    /**
     * Import contacts.
     */
    public function import(User $user): bool
    {
        return $user->can('client-contact.import');
    }

    /**
     * Mark as primary contact.
     */
    public function markPrimary(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.update');
    }

    /**
     * Send Email.
     */
    public function sendEmail(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.email');
    }

    /**
     * Send WhatsApp.
     */
    public function sendWhatsapp(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.whatsapp');
    }

    /**
     * Call Contact.
     */
    public function call(User $user, ClientContact $clientContact): bool
    {
        return $user->can('client-contact.call');
    }
}