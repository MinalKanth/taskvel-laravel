<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientAddressRequest extends FormRequest
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
            | Client
            |--------------------------------------------------------------------------
            */

            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Address
            |--------------------------------------------------------------------------
            */

            'address_type' => [
                'required',
                Rule::in([
                    'Registered Office',
                    'Corporate Office',
                    'Branch Office',
                    'Factory',
                    'Warehouse',
                    'Billing',
                    'Shipping',
                    'Other',
                ]),
            ],

            'address_line_1' => [
                'required',
                'string',
                'max:255',
            ],

            'address_line_2' => [
                'nullable',
                'string',
                'max:255',
            ],

            'landmark' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            'city' => [
                'required',
                'string',
                'max:100',
            ],

            'district' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'required',
                'string',
                'max:100',
            ],

            'country' => [
                'required',
                'string',
                'max:100',
            ],

            'postal_code' => [
                'required',
                'digits:6',
            ],

            /*
            |--------------------------------------------------------------------------
            | GPS
            |--------------------------------------------------------------------------
            */

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            'is_default' => [
                'nullable',
                'boolean',
            ],

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

            'address_type.required' => 'Please select an address type.',

            'address_line_1.required' => 'Address Line 1 is required.',

            'city.required' => 'City is required.',

            'state.required' => 'State is required.',

            'country.required' => 'Country is required.',

            'postal_code.required' => 'Postal code is required.',
            'postal_code.digits' => 'Postal code must contain exactly 6 digits.',

            'latitude.between' => 'Latitude must be between -90 and 90.',

            'longitude.between' => 'Longitude must be between -180 and 180.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'client_id' => 'Client',

            'address_type' => 'Address Type',

            'address_line_1' => 'Address Line 1',

            'address_line_2' => 'Address Line 2',

            'postal_code' => 'Postal Code',

            'is_default' => 'Default Address',

            'is_active' => 'Active Status',

        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'address_line_1' => trim((string) $this->address_line_1),

            'address_line_2' => $this->address_line_2
                ? trim($this->address_line_2)
                : null,

            'landmark' => $this->landmark
                ? trim($this->landmark)
                : null,

            'city' => $this->city
                ? ucwords(strtolower(trim($this->city)))
                : null,

            'district' => $this->district
                ? ucwords(strtolower(trim($this->district)))
                : null,

            'state' => $this->state
                ? ucwords(strtolower(trim($this->state)))
                : null,

            'country' => $this->country
                ? ucwords(strtolower(trim($this->country)))
                : 'India',

            'postal_code' => preg_replace('/\D/', '', (string) $this->postal_code),

        ]);
    }
}