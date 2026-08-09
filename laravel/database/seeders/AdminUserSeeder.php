<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * These credentials are shown on the login page and documented in the
     * README. Change all three places together if they ever change.
     */
    public const EMAIL = 'admin@pixelplay.com';

    public const PASSWORD = 'PixelPlay@2026';

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => self::EMAIL],
            [
                'name' => 'PixelPlay Administrator',
                'password' => self::PASSWORD,
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
