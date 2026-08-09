<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Action',
            'Open World',
            'RPG',
            'Racing',
            'Rhythm',
            'Strategy',
        ];

        foreach ($categories as $name) {
            Category::updateOrCreate(
                ['slug' => str($name)->slug()->value()],
                ['name' => $name]
            );
        }
    }
}
