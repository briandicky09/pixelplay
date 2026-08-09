<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Single source of truth for the PixelPlay catalog.
     *
     * Edit descriptions, prices, ratings and platforms here — never in the
     * database. `php artisan migrate:fresh --seed` reproduces this catalog
     * byte for byte on any machine.
     *
     * `cover` refers to a file committed under public/images/games.
     */
    private const GAMES = [
        [
            'title' => 'GTA 6',
            'slug' => 'gta-6',
            'category' => 'Open World',
            'cover' => 'gta-6.jpg',
            'price' => 899000,
            'rating' => 4.9,
            'released_at' => '2026-11-19',
            'is_featured' => true,
            'platforms' => ['PlayStation 5', 'Xbox Series X|S', 'PC'],
            'description' => <<<'TEXT'
            Kembali ke Vice City dalam entri terbesar yang pernah dibuat Rockstar Games. GTA 6 mengikuti Lucia dan pasangannya melintasi negara bagian Leonida — dari gang neon di pusat kota, rawa-rawa yang lembap, hingga jalan tol pesisir tanpa ujung.

            Dunia terbuka yang benar-benar hidup: NPC punya rutinitas harian, cuaca dinamis mengubah cara kota bergerak, dan setiap misi bisa diselesaikan dengan pendekatan yang berbeda. Mode daring menyusul setelah peluncuran dengan progres terpisah.
            TEXT,
        ],
        [
            'title' => 'Cyberpunk 2077',
            'slug' => 'cyberpunk-2077',
            'category' => 'RPG',
            'cover' => 'cyberpunk-2077.jpg',
            'price' => 599000,
            'rating' => 4.6,
            'released_at' => '2020-12-10',
            'is_featured' => true,
            'platforms' => ['PC', 'PlayStation 5', 'Xbox Series X|S'],
            'description' => <<<'TEXT'
            Night City adalah kota megakorporasi tempat tubuh manusia bisa dibeli, dijual, dan ditingkatkan. Sebagai V, seorang tentara bayaran yang mengejar implan legendaris, kamu menavigasi konflik antara korporasi, geng jalanan, dan sisa idealisme yang masih tersisa.

            Versi saat ini mencakup seluruh pembaruan rework: sistem perk yang dirombak, kepolisian yang responsif, dan alur cerita yang bercabang berdasarkan reputasi serta pilihan dialog. Termasuk konten dasar tanpa ekspansi Phantom Liberty.
            TEXT,
        ],
        [
            'title' => 'Forza Horizon 6',
            'slug' => 'forza-horizon-6',
            'category' => 'Racing',
            'cover' => 'forza-horizon-6.jpg',
            'price' => 749000,
            'rating' => 4.8,
            'released_at' => '2026-04-16',
            'is_featured' => true,
            'platforms' => ['Xbox Series X|S', 'PC'],
            'description' => <<<'TEXT'
            Horizon Festival berpindah ke Jepang. Balapan menyusuri jalan pegunungan Hakone, sirkuit kota Tokyo pada malam hari, hingga jalur pesisir Okinawa dengan musim yang berganti setiap minggu untuk seluruh pemain sekaligus.

            Lebih dari 550 mobil dapat dikoleksi dan disetel hingga level suspensi. Mode kariernya bebas urutan — pilih disiplin balap yang kamu sukai, kumpulkan poin, dan buka event Showcase berskala besar.
            TEXT,
        ],
        [
            'title' => 'Osu!',
            'slug' => 'osu',
            'category' => 'Rhythm',
            'cover' => 'osu.png',
            'price' => 0,
            'rating' => 4.7,
            'released_at' => '2007-09-16',
            'is_featured' => false,
            'platforms' => ['PC', 'macOS'],
            'description' => <<<'TEXT'
            Game ritme gratis dan sumber terbuka dengan empat mode permainan: osu!standard, osu!taiko, osu!catch, dan osu!mania. Ketepatan waktu diukur dalam milidetik, dan papan peringkat global memisahkan pemain kasual dari pemain kompetitif.

            Kekuatan utamanya adalah komunitas: jutaan beatmap buatan pemain tersedia gratis, lengkap dengan tingkat kesulitan bertingkat. Ringan, berjalan di perangkat keras lama, dan tidak pernah memungut biaya untuk konten inti.
            TEXT,
        ],
        [
            'title' => 'Warcraft III: Reign of Chaos',
            'slug' => 'warcraft-iii-reign-of-chaos',
            'category' => 'Strategy',
            'cover' => 'warcraft-iii-reign-of-chaos.jpg',
            'price' => 249000,
            'rating' => 4.9,
            'released_at' => '2002-07-03',
            'is_featured' => false,
            'platforms' => ['PC', 'macOS'],
            'description' => <<<'TEXT'
            Strategi real-time klasik yang mendefinisikan satu generasi. Empat ras — Human, Orc, Undead, dan Night Elf — bertemu dalam kampanye yang menceritakan kejatuhan Pangeran Arthas dan kedatangan Burning Legion.

            Unit Hero dengan level dan inventaris mengubah RTS dari sekadar adu ekonomi menjadi pertempuran taktis. Editor peta bawaannya melahirkan seluruh genre baru dan masih aktif digunakan hingga sekarang.
            TEXT,
        ],
        [
            'title' => 'Red Dead Redemption 2',
            'slug' => 'red-dead-redemption-2',
            'category' => 'Action',
            'cover' => 'red-dead-redemption-2.jpg',
            'price' => 549000,
            'rating' => 4.9,
            'released_at' => '2018-10-26',
            'is_featured' => true,
            'platforms' => ['PlayStation 4', 'Xbox One', 'PC'],
            'description' => <<<'TEXT'
            Amerika, 1899. Era koboi sedang sekarat dan geng Van der Linde kehabisan tempat untuk bersembunyi. Sebagai Arthur Morgan, kamu terjepit antara kesetiaan kepada geng dan kesadaran bahwa jalan yang mereka tempuh sudah berakhir.

            Detail dunianya menjadi tolok ukur industri: hewan bereaksi terhadap cuaca, penduduk kota mengingat perbuatanmu, dan perawatan kuda maupun senjata memengaruhi performa. Termasuk akses ke Red Dead Online.
            TEXT,
        ],
    ];

    public function run(): void
    {
        $categories = Category::pluck('id', 'name');
        $platforms = Platform::pluck('id', 'name');

        foreach (self::GAMES as $data) {
            $game = Game::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'category_id' => $categories[$data['category']],
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'cover_image' => $data['cover'],
                    'price' => $data['price'],
                    'rating' => $data['rating'],
                    'released_at' => $data['released_at'],
                    'is_featured' => $data['is_featured'],
                ]
            );

            $game->platforms()->sync(
                collect($data['platforms'])->map(fn (string $name) => $platforms[$name])->all()
            );
        }
    }
}
