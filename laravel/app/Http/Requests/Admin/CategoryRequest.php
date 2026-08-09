<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'name' => [
                'required', 'string', 'max:60',
                Rule::unique('categories', 'name')->ignore($category?->id),
            ],
            'slug' => [
                'required', 'string', 'max:80', 'alpha_dash',
                Rule::unique('categories', 'slug')->ignore($category?->id),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => str($this->input('slug') ?: $this->input('name'))->slug()->value(),
        ]);
    }

    public function attributes(): array
    {
        return ['name' => 'nama kategori'];
    }
}
