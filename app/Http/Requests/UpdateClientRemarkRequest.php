<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRemarkRequest extends FormRequest
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
            | Parent Reply
            |--------------------------------------------------------------------------
            */

            'parent_id' => [
                'nullable',
                'exists:client_remarks,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            'user_id' => [
                'required',
                'exists:users,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Remark
            |--------------------------------------------------------------------------
            */

            'remark' => [
                'required',
                'string',
                'min:3',
                'max:10000',
            ],

            /*
            |--------------------------------------------------------------------------
            | Type
            |--------------------------------------------------------------------------
            */

            'type' => [
                'required',
                Rule::in([
                    'General',
                    'Follow Up',
                    'Important',
                    'Payment',
                    'Compliance',
                    'Registration',
                    'Document',
                    'Meeting',
                    'Phone Call',
                    'Email',
                    'WhatsApp',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */

            'is_private' => [
                'nullable',
                'boolean',
            ],

            'is_pinned' => [
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
                    'Open',
                    'In Progress',
                    'Resolved',
                    'Closed',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Attachment
            |--------------------------------------------------------------------------
            */

            'attachment' => [
                'nullable',
                'file',
                'max:10240',
                'mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx,csv,zip',
            ],

            /*
            |--------------------------------------------------------------------------
            | Mention
            |--------------------------------------------------------------------------
            */

            'mentioned_user_id' => [
                'nullable',
                'exists:users,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Read
            |--------------------------------------------------------------------------
            */

            'read_at' => [
                'nullable',
                'date',
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

            'remark.required' => 'Remark is required.',
            'remark.min' => 'Remark must contain at least 3 characters.',

            'attachment.max' => 'Maximum attachment size is 10 MB.',

            'attachment.mimes' => 'Only PDF, Image, Word, Excel, CSV and ZIP files are allowed.',

            'mentioned_user_id.exists' => 'Selected mentioned user does not exist.',

        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'client_id' => 'Client',

            'parent_id' => 'Reply To',

            'user_id' => 'User',

            'mentioned_user_id' => 'Mentioned User',

            'is_private' => 'Private',

            'is_pinned' => 'Pinned',

            'read_at' => 'Read Time',

        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'remark' => trim((string) $this->remark),

        ]);
    }
}