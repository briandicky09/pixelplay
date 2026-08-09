<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class GameIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'exists:categories,slug'],
            'platform' => ['nullable', 'string', 'exists:platforms,slug'],
            'featured' => ['nullable', 'boolean'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ];
    }

    public function perPage(): int
    {
        return (int) ($this->validated('per_page') ?? 12);
    }
}
