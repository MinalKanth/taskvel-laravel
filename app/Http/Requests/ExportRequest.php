<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules.
     */
    public function rules(): array
    {
        return [
            'format' => [
                'required',
                'in:pdf,csv,xlsx,json',
            ],

            'status' => [
                'nullable',
                'in:pending,in_progress,completed,cancelled',
            ],

            'priority' => [
                'nullable',
                'in:low,medium,high,urgent',
            ],

            'from_date' => [
                'nullable',
                'date',
            ],

            'to_date' => [
                'nullable',
                'date',
                'after_or_equal:from_date',
            ],

            'include_remarks' => [
                'nullable',
                'boolean',
            ],

            'include_focus_sessions' => [
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
            'format.required' => 'Please select an export format.',
            'format.in' => 'Supported formats are PDF, CSV, XLSX, and JSON.',

            'status.in' => 'Invalid task status selected.',
            'priority.in' => 'Invalid task priority selected.',

            'from_date.date' => 'From date must be a valid date.',
            'to_date.date' => 'To date must be a valid date.',
            'to_date.after_or_equal' => 'To date must be after or equal to the From date.',

            'include_remarks.boolean' => 'Include Remarks must be true or false.',
            'include_focus_sessions.boolean' => 'Include Focus Sessions must be true or false.',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'format' => strtolower((string) $this->format),

            'include_remarks' => filter_var(
                $this->include_remarks,
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            ) ?? false,

            'include_focus_sessions' => filter_var(
                $this->include_focus_sessions,
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            ) ?? false,
        ]);
    }
}