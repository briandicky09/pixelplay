<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = [
            'PC',
            'PlayStation 5',
            'PlayStation 4',
            'Xbox Series X|S',
            'Xbox One',
            'Nintendo Switch',
            'macOS',
        ];

        foreach ($platforms as $name) {
            Platform::updateOrCreate(
                ['slug' => str($name)->slug()->value()],
                ['name' => $name]
            );
        }
    }
}
