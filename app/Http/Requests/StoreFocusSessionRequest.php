<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFocusSessionRequest extends FormRequest
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
            'task_id' => [
                'nullable',
                'exists:tasks,id',
            ],

            'session_type' => [
                'required',
                'in:focus,short_break,long_break',
            ],

            'duration_minutes' => [
                'required',
                'integer',
                'min:1',
                'max:180',
            ],

            'started_at' => [
                'required',
                'date',
            ],

            'ended_at' => [
                'nullable',
                'date',
                'after:started_at',
            ],

            'completed' => [
                'nullable',
                'boolean',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'task_id.exists' => 'The selected task does not exist.',
            'session_type.required' => 'Please select a session type.',
            'session_type.in' => 'Invalid session type selected.',
            'duration_minutes.required' => 'Session duration is required.',
            'duration_minutes.integer' => 'Duration must be a whole number.',
            'duration_minutes.min' => 'Duration must be at least 1 minute.',
            'duration_minutes.max' => 'Duration cannot exceed 180 minutes.',
            'started_at.required' => 'Session start time is required.',
            'ended_at.after' => 'End time must be after the start time.',
            'completed.boolean' => 'Completed must be true or false.',
            'notes.max' => 'Notes may not exceed 1000 characters.',
        ];
    }

    /**
     * Prepare the data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'notes' => $this->notes
                ? trim((string) $this->notes)
                : null,

            'completed' => filter_var(
                $this->completed,
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            ) ?? false,
        ]);
    }
}