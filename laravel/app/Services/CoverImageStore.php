<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Cover images are written straight into public/images/games and served by
 * the web server as ordinary static files.
 *
 * The alternative — storage/app/public plus `php artisan storage:link` —
 * breaks on a fresh clone because the symlink is not part of the repository,
 * and on Windows it needs Developer Mode or an elevated shell to be created
 * at all. Keeping covers under public/ removes that failure mode entirely.
 */
class CoverImageStore
{
    private const DIRECTORY = 'images/games';

    /** Cover files that ship with the repository and must never be deleted. */
    private const SEEDED = [
        'gta-6.jpg',
        'cyberpunk-2077.jpg',
        'forza-horizon-6.jpg',
        'osu.png',
        'warcraft-iii-reign-of-chaos.jpg',
        'red-dead-redemption-2.jpg',
    ];

    public function store(UploadedFile $file, string $slug): string
    {
        // extension() is resolved from the file contents, not from the name the
        // browser sent, so a renamed upload cannot choose its own extension.
        $name = $slug.'-'.Str::random(8).'.'.$file->extension();

        $file->move(public_path(self::DIRECTORY), $name);

        return $name;
    }

    public function delete(?string $name): void
    {
        if ($name === null || in_array($name, self::SEEDED, true)) {
            return;
        }

        File::delete(public_path(self::DIRECTORY.'/'.$name));
    }
}
