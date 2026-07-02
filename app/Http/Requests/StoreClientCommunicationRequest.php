<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientCommunicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return auth()->user()->can('client.manage_communications');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Client
            |--------------------------------------------------------------------------
            */

            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Communication
            |--------------------------------------------------------------------------
            */

            'channel' => [
                'required',
                Rule::in([
                    'Email',
                    'WhatsApp',
                    'SMS',
                    'Phone Call',
                    'Meeting',
                    'Internal Chat',
                    'Push Notification',
                    'Other',
                ]),
            ],

            'direction' => [
                'required',
                Rule::in([
                    'Incoming',
                    'Outgoing',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Message
            |--------------------------------------------------------------------------
            */

            'subject' => [
                'nullable',
                'string',
                'max:255',
            ],

            'message' => [
                'required',
                'string',
                'max:50000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Sender
            |--------------------------------------------------------------------------
            */

            'sender_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'sender_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'sender_phone' => [
                'nullable',
                'digits:10',
            ],

            /*
            |--------------------------------------------------------------------------
            | Receiver
            |--------------------------------------------------------------------------
            */

            'receiver_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'receiver_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'receiver_phone' => [
                'nullable',
                'digits:10',
            ],

            /*
            |--------------------------------------------------------------------------
            | Thread
            |--------------------------------------------------------------------------
            */

            'thread_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'message_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Attachment
            |--------------------------------------------------------------------------
            */

            'has_attachment' => [
                'nullable',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                Rule::in([
                    'Draft',
                    'Queued',
                    'Sending',
                    'Sent',
                    'Delivered',
                    'Read',
                    'Replied',
                    'Failed',
                    'Cancelled',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            'user_id' => [
                'nullable',
                'exists:users,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Date
            |--------------------------------------------------------------------------
            */

            'communication_at' => [
                'required',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            'metadata' => [
                'nullable',
                'array',
            ],

        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'client_id.required' => 'Please select a client.',
            'client_id.exists' => 'Selected client does not exist.',

            'channel.required' => 'Please select a communication channel.',

            'direction.required' => 'Please select the communication direction.',

            'message.required' => 'Message is required.',

            'sender_email.email' => 'Sender email must be valid.',

            'receiver_email.email' => 'Receiver email must be valid.',

            'sender_phone.digits' => 'Sender phone number must contain exactly 10 digits.',

            'receiver_phone.digits' => 'Receiver phone number must contain exactly 10 digits.',

        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'client_id' => 'Client',

            'thread_id' => 'Thread',

            'message_id' => 'Message ID',

            'sender_name' => 'Sender Name',

            'sender_email' => 'Sender Email',

            'sender_phone' => 'Sender Phone',

            'receiver_name' => 'Receiver Name',

            'receiver_email' => 'Receiver Email',

            'receiver_phone' => 'Receiver Phone',

            'communication_at' => 'Communication Date',

            'has_attachment' => 'Attachment',

        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'subject' => $this->subject
                ? trim($this->subject)
                : null,

            'message' => trim((string) $this->message),

            'sender_email' => $this->sender_email
                ? strtolower(trim($this->sender_email))
                : null,

            'receiver_email' => $this->receiver_email
                ? strtolower(trim($this->receiver_email))
                : null,

            'sender_phone' => $this->sender_phone
                ? preg_replace('/\D/', '', (string) $this->sender_phone)
                : null,

            'receiver_phone' => $this->receiver_phone
                ? preg_replace('/\D/', '', (string) $this->receiver_phone)
                : null,

        ]);
    }
}