<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'priority' => [
                'required',
                'in:low,medium,high,urgent',
            ],

            'status' => [
                'nullable',
                'in:pending,in_progress,completed,cancelled',
            ],

            'due_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],

            'estimated_minutes' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'tag_id' => [
                'nullable',
                'exists:tags,id',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Task title is required.',
            'priority.required' => 'Please select a priority.',
            'priority.in' => 'Invalid priority selected.',
            'status.in' => 'Invalid task status.',
            'due_date.after_or_equal' => 'Due date cannot be in the past.',
            'estimated_minutes.min' => 'Estimated time must be at least 1 minute.',
            'tag_id.exists' => 'Selected tag does not exist.',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => trim((string) $this->title),
            'description' => $this->description
                ? trim((string) $this->description)
                : null,
        ]);
    }
}