<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // Recommended later:
        // return auth()->user()->can('client.update');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $clientId = $this->route('client')->id ?? $this->route('client');

        return [

            /*
            |--------------------------------------------------------------------------
            | Basic Information
            |--------------------------------------------------------------------------
            */

            'client_code' => [
                'required',
                'string',
                'max:30',
                Rule::unique('clients', 'client_code')->ignore($clientId),
            ],

            'company_name' => [
                'required',
                'string',
                'max:255',
            ],

            'legal_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'business_type' => [
                'required',
                Rule::in([
                    'Proprietorship',
                    'Partnership',
                    'LLP',
                    'Private Limited',
                    'Public Limited',
                    'OPC',
                    'Trust',
                    'Society',
                    'NGO',
                    'Government',
                    'Other',
                ]),
            ],

            'constitution' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Registration Details
            |--------------------------------------------------------------------------
            */

            'gstin' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('clients', 'gstin')->ignore($clientId),
                'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{3}$/',
            ],

            'pan' => [
                'nullable',
                'string',
                'max:15',
                Rule::unique('clients', 'pan')->ignore($clientId),
                'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            ],

            'tan' => [
                'nullable',
                'string',
                'max:15',
                Rule::unique('clients', 'tan')->ignore($clientId),
            ],

            'cin' => [
                'nullable',
                'string',
                'max:30',
                Rule::unique('clients', 'cin')->ignore($clientId),
            ],

            'udyam_number' => [
                'nullable',
                'string',
                'max:50',
            ],

            'esic_code' => [
                'nullable',
                'string',
                'max:50',
            ],

            'epf_code' => [
                'nullable',
                'string',
                'max:50',
            ],

            /*
            |--------------------------------------------------------------------------
            | Contact
            |--------------------------------------------------------------------------
            */

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'website' => [
                'nullable',
                'url',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:20',
            ],

            'alternate_phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'status' => [
                'required',
                Rule::in([
                    'Lead',
                    'Prospect',
                    'Active',
                    'Inactive',
                    'Suspended',
                    'Closed',
                ]),
            ],

            'priority' => [
                'required',
                Rule::in([
                    'Low',
                    'Medium',
                    'High',
                    'Critical',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Business
            |--------------------------------------------------------------------------
            */

            'incorporation_date' => [
                'nullable',
                'date',
                'before_or_equal:today',
            ],

            /*
            |--------------------------------------------------------------------------
            | Financial
            |--------------------------------------------------------------------------
            */

            'opening_balance' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'credit_limit' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'payment_terms' => [
                'nullable',
                'integer',
                'min:0',
                'max:365',
            ],

            /*
            |--------------------------------------------------------------------------
            | Assignment
            |--------------------------------------------------------------------------
            */

            'assigned_to' => [
                'nullable',
                'exists:users,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Others
            |--------------------------------------------------------------------------
            */

            'notes' => [
                'nullable',
                'string',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [

            'client_code.required' => 'Client code is required.',
            'client_code.unique' => 'This client code already exists.',

            'company_name.required' => 'Company name is required.',

            'phone.required' => 'Primary phone number is required.',

            'gstin.regex' => 'Please enter a valid GSTIN.',

            'pan.regex' => 'Please enter a valid PAN number.',

            'website.url' => 'Please enter a valid website URL.',

            'email.email' => 'Please enter a valid email address.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'client_code' => 'Client Code',
            'company_name' => 'Company Name',
            'legal_name' => 'Legal Name',
            'business_type' => 'Business Type',
            'gstin' => 'GSTIN',
            'pan' => 'PAN',
            'tan' => 'TAN',
            'cin' => 'CIN',
            'udyam_number' => 'UDYAM Number',
            'esic_code' => 'ESIC Code',
            'epf_code' => 'EPF Code',
            'opening_balance' => 'Opening Balance',
            'credit_limit' => 'Credit Limit',
            'payment_terms' => 'Payment Terms',
            'assigned_to' => 'Assigned Executive',
            'is_active' => 'Active Status',

        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'client_code' => strtoupper(trim((string) $this->client_code)),

            'gstin' => $this->gstin ? strtoupper(trim($this->gstin)) : null,

            'pan' => $this->pan ? strtoupper(trim($this->pan)) : null,

            'tan' => $this->tan ? strtoupper(trim($this->tan)) : null,

            'cin' => $this->cin ? strtoupper(trim($this->cin)) : null,

            'email' => $this->email ? strtolower(trim($this->email)) : null,

        ]);
    }
}