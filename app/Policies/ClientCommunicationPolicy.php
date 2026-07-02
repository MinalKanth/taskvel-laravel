<?php

namespace App\Policies;

use App\Models\ClientCommunication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientCommunicationPolicy
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
     * View communication listing.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('client-communication.view');
    }

    /**
     * View communication.
     */
    public function view(User $user, ClientCommunication $clientCommunication): bool
    {
        return $user->can('client-communication.view');
    }

    /**
     * Create communication.
     */
    public function create(User $user): bool
    {
        return $user->can('client-communication.create');
    }

    /**
     * Update communication.
     */
    public function update(User $user, ClientCommunication $clientCommunication): bool
    {
        return $user->can('client-communication.update');
    }

    /**
     * Delete communication.
     */
    public function delete(User $user, ClientCommunication $clientCommunication): bool
    {
        return $user->can('client-communication.delete');
    }

    /**
     * Restore communication.
     */
    public function restore(User $user, ClientCommunication $clientCommunication): bool
    {
        return $user->can('client-communication.restore');
    }

    /**
     * Permanently delete communication.
     */
    public function forceDelete(User $user, ClientCommunication $clientCommunication): bool
    {
        return $user->can('client-communication.force-delete');
    }

    /**
     * Send email.
     */
    public function sendEmail(User $user): bool
    {
        return $user->can('client-communication.email');
    }

    /**
     * Send WhatsApp message.
     */
    public function sendWhatsapp(User $user): bool
    {
        return $user->can('client-communication.whatsapp');
    }

    /**
     * Send SMS.
     */
    public function sendSms(User $user): bool
    {
        return $user->can('client-communication.sms');
    }

    /**
     * Make phone call.
     */
    public function makeCall(User $user): bool
    {
        return $user->can('client-communication.call');
    }

    /**
     * Schedule meeting.
     */
    public function scheduleMeeting(User $user): bool
    {
        return $user->can('client-communication.meeting');
    }

    /**
     * Send push notification.
     */
    public function sendPush(User $user): bool
    {
        return $user->can('client-communication.push');
    }

    /**
     * Resend communication.
     */
    public function resend(User $user, ClientCommunication $clientCommunication): bool
    {
        return $user->can('client-communication.resend');
    }

    /**
     * Export communications.
     */
    public function export(User $user): bool
    {
        return $user->can('client-communication.export');
    }

    /**
     * Import communications.
     */
    public function import(User $user): bool
    {
        return $user->can('client-communication.import');
    }
}