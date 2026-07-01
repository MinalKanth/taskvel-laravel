<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRemarkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        return [
            'task_id' => [
                'required',
                'exists:tasks,id',
            ],

            'remark' => [
                'required',
                'string',
                'min:3',
                'max:2000',
            ],

            'is_pinned' => [
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
            'task_id.required' => 'Please select a task.',
            'task_id.exists' => 'Selected task does not exist.',
            'remark.required' => 'Remark cannot be empty.',
            'remark.min' => 'Remark must contain at least 3 characters.',
            'remark.max' => 'Remark may not exceed 2000 characters.',
            'is_pinned.boolean' => 'Pinned value must be true or false.',
        ];
    }

    /**
     * Prepare the data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'remark' => trim((string) $this->remark),
            'is_pinned' => filter_var(
                $this->is_pinned,
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            ) ?? false,
        ]);
    }
}