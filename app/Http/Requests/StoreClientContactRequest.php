<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // Recommended later:
        // return auth()->user()->can('client.create');
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
            | Personal Information
            |--------------------------------------------------------------------------
            */

            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'nullable',
                'string',
                'max:100',
            ],

            'designation' => [
                'nullable',
                'string',
                'max:150',
            ],

            'department' => [
                'nullable',
                'string',
                'max:150',
            ],

            /*
            |--------------------------------------------------------------------------
            | Contact Information
            |--------------------------------------------------------------------------
            */

            'mobile' => [
                'required',
                'digits:10',
            ],

            'alternate_mobile' => [
                'nullable',
                'digits:10',
                'different:mobile',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'whatsapp_number' => [
                'nullable',
                'digits:10',
            ],

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            'date_of_birth' => [
                'nullable',
                'date',
                'before:today',
            ],

            'anniversary' => [
                'nullable',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | Communication
            |--------------------------------------------------------------------------
            */

            'is_primary' => [
                'nullable',
                'boolean',
            ],

            'receive_email' => [
                'nullable',
                'boolean',
            ],

            'receive_whatsapp' => [
                'nullable',
                'boolean',
            ],

            'receive_sms' => [
                'nullable',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'is_active' => [
                'nullable',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Remarks
            |--------------------------------------------------------------------------
            */

            'remarks' => [
                'nullable',
                'string',
                'max:5000',
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

            'first_name.required' => 'First name is required.',

            'mobile.required' => 'Mobile number is required.',
            'mobile.digits' => 'Mobile number must be exactly 10 digits.',

            'alternate_mobile.different' => 'Alternate mobile cannot be the same as the primary mobile.',

            'email.email' => 'Please enter a valid email address.',

            'whatsapp_number.digits' => 'WhatsApp number must be exactly 10 digits.',

            'date_of_birth.before' => 'Date of birth must be before today.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'client_id' => 'Client',

            'first_name' => 'First Name',

            'last_name' => 'Last Name',

            'date_of_birth' => 'Date of Birth',

            'alternate_mobile' => 'Alternate Mobile',

            'whatsapp_number' => 'WhatsApp Number',

            'is_primary' => 'Primary Contact',

            'receive_email' => 'Email Notifications',

            'receive_whatsapp' => 'WhatsApp Notifications',

            'receive_sms' => 'SMS Notifications',

            'is_active' => 'Active Status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'first_name' => trim((string) $this->first_name),

            'last_name' => $this->last_name
                ? trim($this->last_name)
                : null,

            'designation' => $this->designation
                ? trim($this->designation)
                : null,

            'department' => $this->department
                ? trim($this->department)
                : null,

            'email' => $this->email
                ? strtolower(trim($this->email))
                : null,

            'mobile' => preg_replace('/\D/', '', (string) $this->mobile),

            'alternate_mobile' => $this->alternate_mobile
                ? preg_replace('/\D/', '', $this->alternate_mobile)
                : null,

            'whatsapp_number' => $this->whatsapp_number
                ? preg_replace('/\D/', '', $this->whatsapp_number)
                : null,
        ]);
    }
}