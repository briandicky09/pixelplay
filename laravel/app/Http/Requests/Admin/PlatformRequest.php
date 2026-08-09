<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlatformRequest extends FormRequest
{
    public function rules(): array
    {
        $platform = $this->route('platform');

        return [
            'name' => [
                'required', 'string', 'max:60',
                Rule::unique('platforms', 'name')->ignore($platform?->id),
            ],
            'slug' => [
                'required', 'string', 'max:80', 'alpha_dash',
                Rule::unique('platforms', 'slug')->ignore($platform?->id),
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
        return ['name' => 'nama platform'];
    }
}
