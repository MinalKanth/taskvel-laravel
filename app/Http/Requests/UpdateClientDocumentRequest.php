<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // Recommended later:
        // return auth()->user()->can('client.manage_documents');
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
            | Document Details
            |--------------------------------------------------------------------------
            */

            'category' => [
                'required',
                Rule::in([
                    'GST',
                    'EPF',
                    'ESIC',
                    'Payroll',
                    'Registration',
                    'Invoice',
                    'Agreement',
                    'Employee',
                    'Bank',
                    'Tax',
                    'ROC',
                    'License',
                    'Certificate',
                    'Identity',
                    'Other',
                ]),
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'document_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            /*
            |--------------------------------------------------------------------------
            | File Upload
            |--------------------------------------------------------------------------
            */

            'document' => [
                'nullable',
                'file',
                'max:10240',
                'mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx,csv,zip,rar',
            ],

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            'issue_date' => [
                'nullable',
                'date',
            ],

            'expiry_date' => [
                'nullable',
                'date',
                'after_or_equal:issue_date',
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
                    'Approved',
                    'Rejected',
                    'Expired',
                    'Archived',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */

            'is_confidential' => [
                'nullable',
                'boolean',
            ],

            'is_downloadable' => [
                'nullable',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            'approved_by' => [
                'nullable',
                'exists:users,id',
            ],

            'approved_at' => [
                'nullable',
                'date',
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

            'title.required' => 'Document title is required.',

            'category.required' => 'Please select a document category.',

            'document.file' => 'Uploaded file is invalid.',

            'document.max' => 'Maximum file size is 10 MB.',

            'document.mimes' => 'Only PDF, Images, Word, Excel, CSV, ZIP and RAR files are allowed.',

            'expiry_date.after_or_equal' => 'Expiry date must be after or equal to issue date.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [

            'client_id' => 'Client',

            'document' => 'Document',

            'document_number' => 'Document Number',

            'issue_date' => 'Issue Date',

            'expiry_date' => 'Expiry Date',

            'approved_by' => 'Approved By',

            'approved_at' => 'Approval Date',

            'is_confidential' => 'Confidential',

            'is_downloadable' => 'Download Permission',

            'is_active' => 'Active Status',

        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([

            'title' => trim((string) $this->title),

            'document_number' => $this->document_number
                ? trim($this->document_number)
                : null,

            'description' => $this->description
                ? trim($this->description)
                : null,

            'remarks' => $this->remarks
                ? trim($this->remarks)
                : null,

        ]);
    }
}