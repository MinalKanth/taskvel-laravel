<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return auth()->user()->can('client.update');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Client & Service
            |--------------------------------------------------------------------------
            */

            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            'service_id' => [
                'required',
                'exists:services,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Service Period
            |--------------------------------------------------------------------------
            */

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
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
            | Billing
            |--------------------------------------------------------------------------
            */

            'service_fee' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tax_percentage' => [
                'nullable',
                'numeric',
                'between:0,100',
            ],

            'billing_cycle' => [
                'required',
                Rule::in([
                    'One Time',
                    'Monthly',
                    'Quarterly',
                    'Half Yearly',
                    'Yearly',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Compliance
            |--------------------------------------------------------------------------
            */

            'due_day' => [
                'nullable',
                'integer',
                'between:1,31',
            ],

            'auto_generate_tasks' => [
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
                    'Pending',
                    'Active',
                    'On Hold',
                    'Completed',
                    'Cancelled',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Renewal
            |--------------------------------------------------------------------------
            */

            'renewable' => [
                'nullable',
                'boolean',
            ],

            'renewal_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],

            /*
            |--------------------------------------------------------------------------
            | Other
            |--------------------------------------------------------------------------
            */

            'remarks' => [
                'nullable',
                'string',
                'max:5000',
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

            'client_id.required' => 'Please select a client.',
            'client_id.exists' => 'Selected client does not exist.',

            'service_id.required' => 'Please select a service.',
            'service_id.exists' => 'Selected service does not exist.',

            'start_date.required' => 'Start date is required.',

            'end_date.after_or_equal' => 'End date must be after or equal to the start date.',

            'renewal_date.after_or_equal' => 'Renewal date must be after or equal to the start date.',

            'due_day.between' => 'Due day must be between 1 and 31.',

            'tax_percentage.between' => 'Tax percentage must be between 0 and 100.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'client_id' => 'Client',

            'service_id' => 'Service',

            'start_date' => 'Start Date',

            'end_date' => 'End Date',

            'assigned_to' => 'Assigned Executive',

            'service_fee' => 'Service Fee',

            'tax_percentage' => 'Tax Percentage',

            'billing_cycle' => 'Billing Cycle',

            'due_day' => 'Due Day',

            'auto_generate_tasks' => 'Auto Generate Tasks',

            'renewable' => 'Renewable',

            'renewal_date' => 'Renewal Date',

            'is_active' => 'Active Status',

        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'service_fee' => $this->service_fee ?: 0,

            'discount' => $this->discount ?: 0,

            'tax_percentage' => $this->tax_percentage ?: 0,

            'remarks' => $this->remarks
                ? trim($this->remarks)
                : null,

        ]);
    }
}