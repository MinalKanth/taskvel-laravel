<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientTagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    $tagId = $this->route('clientTag')?->id
    ?? $this->route('client_tag')?->id;

    return [

        'name' => [
            'required',
            'string',
            'max:255',
        ],

        'slug' => [
            'nullable',
            'string',
            'max:255',
            Rule::unique('client_tags', 'slug')->ignore($tagId),
        ],

        'color' => [
            'nullable',
            'string',
            'max:20',
        ],

        'icon' => [
            'nullable',
            'string',
            'max:100',
        ],

        'description' => [
            'nullable',
            'string',
        ],

        'sort_order' => [
            'nullable',
            'integer',
        ],

        'is_active' => [
            'nullable',
            'boolean',
        ],
    ];
}
}