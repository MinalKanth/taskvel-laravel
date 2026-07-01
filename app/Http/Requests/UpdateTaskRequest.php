<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'priority' => [
                'sometimes',
                'required',
                'in:low,medium,high,urgent',
            ],

            'status' => [
                'sometimes',
                'required',
                'in:pending,in_progress,completed,cancelled',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'estimated_minutes' => [
                'nullable',
                'integer',
                'min:1',
            ],

            'actual_minutes' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'completed_at' => [
                'nullable',
                'date',
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
            'priority.in' => 'Please select a valid priority.',
            'status.in' => 'Please select a valid status.',
            'estimated_minutes.min' => 'Estimated time must be at least 1 minute.',
            'actual_minutes.min' => 'Actual time cannot be negative.',
            'tag_id.exists' => 'Selected tag does not exist.',
        ];
    }

    /**
     * Prepare data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'title' => $this->title ? trim($this->title) : null,
            'description' => $this->description ? trim($this->description) : null,
        ]);
    }
}