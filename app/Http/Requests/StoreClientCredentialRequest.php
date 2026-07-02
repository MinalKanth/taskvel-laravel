<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientCredentialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return auth()->user()->can('client.manage_credentials');
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
            | Portal
            |--------------------------------------------------------------------------
            */

            'portal' => [
                'required',
                Rule::in([
                    'GST',
                    'EPFO',
                    'ESIC',
                    'TRACES',
                    'Income Tax',
                    'MCA',
                    'ICEGATE',
                    'FSSAI',
                    'UDYAM',
                    'DGFT',
                    'Professional Tax',
                    'Other',
                ]),
            ],

            'portal_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Credentials
            |--------------------------------------------------------------------------
            */

            'username' => [
                'required',
                'string',
                'max:255',
            ],

            'password' => [
                'required',
                'string',
                'min:4',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Contact
            |--------------------------------------------------------------------------
            */

            'registered_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'registered_mobile' => [
                'nullable',
                'digits:10',
            ],

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            'security_question' => [
                'nullable',
                'string',
                'max:255',
            ],

            'security_answer' => [
                'nullable',
                'string',
                'max:500',
            ],

            'client_id_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            /*
            |--------------------------------------------------------------------------
            | Authentication
            |--------------------------------------------------------------------------
            */

            'otp_required' => [
                'nullable',
                'boolean',
            ],

            'dsc_required' => [
                'nullable',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Portal URL
            |--------------------------------------------------------------------------
            */

            'login_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | API
            |--------------------------------------------------------------------------
            */

            'api_key' => [
                'nullable',
                'string',
                'max:500',
            ],

            'api_secret' => [
                'nullable',
                'string',
                'max:500',
            ],

            /*
            |--------------------------------------------------------------------------
            | PIN
            |--------------------------------------------------------------------------
            */

            'pin' => [
                'nullable',
                'string',
                'max:50',
            ],

            /*
            |--------------------------------------------------------------------------
            | DSC
            |--------------------------------------------------------------------------
            */

            'dsc_serial_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'dsc_owner' => [
                'nullable',
                'string',
                'max:255',
            ],

            'dsc_expiry_date' => [
                'nullable',
                'date',
            ],

            /*
            |--------------------------------------------------------------------------
            | Expiry
            |--------------------------------------------------------------------------
            */

            'expiry_date' => [
                'nullable',
                'date',
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
            | Metadata
            |--------------------------------------------------------------------------
            */

            'metadata' => [
                'nullable',
                'array',
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

            'portal.required' => 'Please select a portal.',

            'username.required' => 'Username is required.',

            'password.required' => 'Password is required.',

            'registered_email.email' => 'Please enter a valid email address.',

            'registered_mobile.digits' => 'Registered mobile must contain exactly 10 digits.',

            'login_url.url' => 'Please enter a valid login URL.',

        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'client_id' => 'Client',

            'portal_name' => 'Portal Name',

            'registered_email' => 'Registered Email',

            'registered_mobile' => 'Registered Mobile',

            'security_question' => 'Security Question',

            'security_answer' => 'Security Answer',

            'client_id_number' => 'Portal ID',

            'login_url' => 'Login URL',

            'api_key' => 'API Key',

            'api_secret' => 'API Secret',

            'dsc_serial_number' => 'DSC Serial Number',

            'dsc_owner' => 'DSC Owner',

            'dsc_expiry_date' => 'DSC Expiry Date',

            'expiry_date' => 'Credential Expiry Date',

            'is_active' => 'Active Status',

        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'username' => trim((string) $this->username),

            'registered_email' => $this->registered_email
                ? strtolower(trim($this->registered_email))
                : null,

            'registered_mobile' => $this->registered_mobile
                ? preg_replace('/\D/', '', (string) $this->registered_mobile)
                : null,

            'portal_name' => $this->portal_name
                ? trim($this->portal_name)
                : null,

            'remarks' => $this->remarks
                ? trim($this->remarks)
                : null,

        ]);
    }
}