<?php

namespace App\Http\Requests\Admin;

use App\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameRequest extends FormRequest
{
    public function rules(): array
    {
        $game = $this->route('game');

        return [
            'title' => ['required', 'string', 'max:120'],
            'slug' => [
                'required', 'string', 'max:140', 'alpha_dash',
                Rule::unique('games', 'slug')->ignore($game?->id),
            ],
            'category_id' => ['required', Rule::exists('categories', 'id')],
            'platforms' => ['required', 'array', 'min:1'],
            'platforms.*' => [Rule::exists('platforms', 'id')],
            'description' => ['required', 'string', 'min:40'],
            'price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'released_at' => ['required', 'date'],
            'is_featured' => ['boolean'],
            'cover' => [
                $game instanceof Game ? 'nullable' : 'required',
                'image', 'mimes:jpg,jpeg,png,webp', 'max:4096',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => str($this->input('slug') ?: $this->input('title'))->slug()->value(),
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'kategori',
            'platforms' => 'platform',
            'cover' => 'gambar sampul',
            'released_at' => 'tanggal rilis',
        ];
    }
}
