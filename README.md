<<<<<<< HEAD
# PixelPlay — Backend & REST API (Phase 2)

Backend Laravel untuk PixelPlay. Berisi autentikasi administrator, panel admin dengan
CRUD lengkap untuk Game, Kategori, dan Platform, serta REST API publik yang dikonsumsi
oleh halaman landing Phase 1.

Repositori ini murni backend: tidak ada halaman katalog publik dan tidak ada front-end
React. Membuka `/` akan langsung mengarah ke panel admin.

Seluruh isi database dihasilkan oleh seeder. Tidak ada langkah manual di phpMyAdmin,
tidak ada impor SQL, dan tidak ada file gambar yang perlu disalin tangan.

---

## Kebutuhan Sistem

| Kebutuhan | Versi minimum |
| --- | --- |
| PHP | 8.2 (ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `curl`) |
| Composer | 2.x |
| MySQL / MariaDB | 8.0 / 10.6 |

Node.js **tidak diperlukan**. Antarmuka memakai satu berkas CSS statis di
`public/css/pixelplay.css`, sehingga tidak ada langkah build front-end.

---

## Instalasi

```bash
composer install
copy .env.example .env          # Windows (macOS/Linux: cp .env.example .env)
php artisan key:generate
```

Buat database kosong bernama `pixelplay`, lalu sesuaikan `.env` bila kredensial MySQL
Anda berbeda:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pixelplay
DB_USERNAME=root
DB_PASSWORD=
```

Membuat database dari baris perintah:

```bash
mysql -u root -p -e "CREATE DATABASE pixelplay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

Isi skema dan data:

```bash
=======
# PixelPlay

Marketplace game digital (PC & konsol) — dengan pengiriman instan dan pembayaran aman. Repositori ini berisi tiga implementasi/bagian dari proyek PixelPlay yang dikembangkan secara terpisah.

## Struktur Repo

| Folder | Deskripsi | Stack |
| --- | --- | --- |
| [`pixelplay-tailwind/`](./pixelplay-tailwind) | Landing page statis (marketing page) | Vite + Tailwind CSS v4 + Vanilla JS |
| [`pixelplay-react/`](./pixelplay-react) | Storefront/katalog game interaktif (data statis, siap deploy ke Vercel) | React 18 + Vite + React Router + Tailwind CSS v4 |
| [`pixelplay-laravel/`](./pixelplay-laravel) | Backend & REST API — autentikasi admin, panel admin CRUD, API publik | Laravel 8.2+ / PHP + MySQL |

Setiap folder adalah proyek yang berdiri sendiri (punya `package.json`/`composer.json`, dependency, dan cara menjalankan masing-masing). Lihat README di tiap folder untuk instruksi instalasi dan detail teknis lengkap:

- [README — pixelplay-laravel](./pixelplay-laravel/README.md)
- [README — pixelplay-react](./pixelplay-react/README.md)
- [README — pixelplay-tailwind](./pixelplay-tailwind/README.md)

## Ringkasan Tiap Bagian

### `pixelplay-tailwind` — Landing Page
Halaman landing/marketing statis PixelPlay: hero, alasan memilih PixelPlay, genre, game unggulan, game terbaru, dan ajakan komunitas. Tanpa backend, cocok untuk showcase awal produk.

```bash
cd pixelplay-tailwind
npm install
npm run dev
```

### `pixelplay-react` — Storefront/Katalog
Versi interaktif dengan katalog game, filter, halaman detail per game, dan keranjang belanja — namun data game masih statis di dalam kode (`src/data/games.ts`), belum terhubung ke backend. Siap deploy langsung ke Vercel.

```bash
cd pixelplay-react
npm install
npm run dev
```

### `pixelplay-laravel` — Backend & REST API
Backend penuh dengan panel admin (CRUD Game, Kategori, Platform) dan REST API publik (`/api/games`, `/api/categories`, `/api/platforms`) yang dirancang untuk dikonsumsi oleh front-end seperti `pixelplay-react`. Database & data awal dihasilkan otomatis lewat seeder.

```bash
cd pixelplay-laravel
composer install
cp .env.example .env
php artisan key:generate
>>>>>>> fcb53f271450a8794437f3a94d03e6419501b965
php artisan migrate:fresh --seed
php artisan serve
```

<<<<<<< HEAD
Buka <http://127.0.0.1:8000> — akan diarahkan ke halaman login administrator.

> `php artisan storage:link` **tidak diperlukan**. Alasannya dijelaskan pada bagian
> [Penanganan Gambar](#penanganan-gambar).

---

## Akun Administrator

Dibuat otomatis oleh `AdminUserSeeder` dan juga ditampilkan pada halaman login.

| Field | Nilai |
| --- | --- |
| Email | `admin@pixelplay.com` |
| Kata sandi | `PixelPlay@2026` |

Login: <http://127.0.0.1:8000/login> — panel admin: <http://127.0.0.1:8000/admin>

Kredensial hanya didefinisikan di satu tempat, yaitu konstanta
`Database\Seeders\AdminUserSeeder::EMAIL` dan `::PASSWORD`. Halaman login membaca
konstanta yang sama, sehingga seeder, layar login, dan README tidak bisa saling
menyimpang.

---

## Katalog Bawaan

`GameSeeder` selalu menghasilkan enam judul berikut, lengkap dengan deskripsi, harga,
rating, tanggal rilis, kategori, dan platform:

| Game | Kategori | Harga | Rating | Rilis |
| --- | --- | --- | --- | --- |
| GTA 6 | Open World | Rp 899.000 | 4.9 | 19 Nov 2026 |
| Cyberpunk 2077 | RPG | Rp 599.000 | 4.6 | 10 Des 2020 |
| Forza Horizon 6 | Racing | Rp 749.000 | 4.8 | 16 Apr 2026 |
| Osu! | Rhythm | Gratis | 4.7 | 16 Sep 2007 |
| Warcraft III: Reign of Chaos | Strategy | Rp 249.000 | 4.9 | 3 Jul 2002 |
| Red Dead Redemption 2 | Action | Rp 549.000 | 4.9 | 26 Okt 2018 |

**Deskripsi game diedit di `database/seeders/GameSeeder.php`**, bukan di database.
Ubah teks pada konstanta `GAMES`, jalankan `php artisan db:seed --class=GameSeeder`,
dan perubahan langsung tercermin di katalog maupun API. Seeder bersifat idempoten
(`updateOrCreate` + `sync`), jadi aman dijalankan berulang kali.

---

## Penanganan Gambar

Sampul game disimpan sebagai berkas statis di `public/images/games/` dan ikut
dalam repositori.

Pendekatan Laravel yang umum — `storage/app/public` ditambah
`php artisan storage:link` — adalah penyebab gambar hilang di komputer lain:

1. Symlink `public/storage` tidak ikut tersimpan di repositori, sehingga setiap klon
   baru kehilangan tautan tersebut sampai perintahnya dijalankan ulang.
2. Di Windows, pembuatan symlink membutuhkan Developer Mode atau terminal
   Administrator. Tanpa itu perintah gagal dan seluruh `/storage/...` menghasilkan 404.
3. Berkas yang diunggah lewat panel admin berada di luar Git, jadi tidak pernah ikut
   berpindah komputer.

Karena sampul enam game bawaan adalah aset produk (bukan unggahan pengguna),
menyimpannya di `public/` menghapus ketiga masalah tersebut sekaligus. URL dibentuk
oleh `Game::coverUrl()` melalui helper `asset()`, sehingga tetap benar pada host
maupun port apa pun.

Unggahan sampul baru dari panel admin ditangani `App\Services\CoverImageStore` dan
ditulis ke direktori yang sama. Enam berkas bawaan dilindungi dari penghapusan agar
`migrate:fresh --seed` selalu menemukan sampulnya kembali.

---

## REST API

Semua endpoint bersifat publik dan hanya-baca.

| Method | Endpoint | Keterangan |
| --- | --- | --- |
| GET | `/api/games` | Daftar game, terpaginasi |
| GET | `/api/games/{slug}` | Detail satu game |
| GET | `/api/categories` | Kategori beserta jumlah game |
| GET | `/api/platforms` | Platform beserta jumlah game |

Parameter query untuk `/api/games`:

| Parameter | Contoh | Keterangan |
| --- | --- | --- |
| `q` | `?q=red` | Cari berdasarkan judul |
| `category` | `?category=racing` | Filter berdasarkan slug kategori |
| `platform` | `?platform=pc` | Filter berdasarkan slug platform |
| `featured` | `?featured=1` | Hanya game unggulan |
| `per_page` | `?per_page=6` | Jumlah item per halaman, 1–48 (default 12) |

Parameter divalidasi oleh `App\Http\Requests\Api\GameIndexRequest`; nilai `category`
dan `platform` harus berupa slug yang benar-benar ada. Parameter tidak valid menghasilkan
`422` beserta rincian galat, rute API yang tidak dikenal menghasilkan `404` dalam bentuk
JSON, dan tiap alamat IP dibatasi 60 permintaan per menit.

Contoh respons `GET /api/games/osu`:

```json
{
  "data": {
    "id": 4,
    "title": "Osu!",
    "slug": "osu",
    "description": "Game ritme gratis dan sumber terbuka ...",
    "cover_url": "http://127.0.0.1:8000/images/games/osu.png",
    "price": 0,
    "price_label": "Gratis",
    "rating": 4.7,
    "released_at": "2007-09-16",
    "is_featured": false,
    "category": { "id": 5, "name": "Rhythm", "slug": "rhythm" },
    "platforms": [
      { "id": 7, "name": "macOS", "slug": "macos" },
      { "id": 1, "name": "PC", "slug": "pc" }
    ]
  }
}
```

---

## Rute Aplikasi

| Rute | Akses | Keterangan |
| --- | --- | --- |
| `/` | Publik | Pengalihan ke `/admin` |
| `/login` | Tamu | Login administrator |
| `/admin` | Admin | Dasbor ringkasan |
| `/admin/games` | Admin | Daftar, tambah, ubah, hapus game |
| `/admin/categories` | Admin | CRUD kategori |
| `/admin/platforms` | Admin | CRUD platform |

Kategori atau platform yang masih dipakai oleh game tidak bisa dihapus; panel
menampilkan pesan penolakan alih-alih melanggar batasan kunci asing.

Rute `/admin/*` dilindungi middleware `auth` dan `admin`
(`App\Http\Middleware\EnsureUserIsAdmin`), yang memeriksa kolom `users.is_admin`.
Percobaan login dibatasi lima kali per kombinasi email dan alamat IP.

---

## Struktur Data

```
categories ──< games >── game_platform ──< platforms
```

- `categories` — nama dan slug unik
- `platforms` — nama dan slug unik
- `games` — `category_id`, judul, slug unik, deskripsi, `cover_image`, harga (integer
  rupiah), rating, tanggal rilis, penanda unggulan
- `game_platform` — pivot dengan indeks unik `(game_id, platform_id)`
- `users` — kolom `is_admin` sebagai penanda hak akses

Harga disimpan sebagai integer rupiah untuk menghindari galat pembulatan desimal;
pemformatan dilakukan di `Game::priceLabel()`.

---

## Pengujian

```bash
php artisan test
```

Dua puluh enam pengujian fitur mencakup keluaran seeder, keberadaan berkas sampul,
idempotensi seeder, login administrator, kendali akses admin, CRUD game (termasuk
unggah sampul), CRUD kategori dan platform beserta perlindungan penghapusan, serta
validasi dan penanganan galat REST API. Pengujian berjalan di atas SQLite in-memory
sehingga tidak menyentuh database pengembangan.

Pemeriksaan gaya kode memakai Laravel Pint:

```bash
vendor/bin/pint --test
```

---

## Pemecahan Masalah

| Gejala | Penyebab dan solusi |
| --- | --- |
| `SQLSTATE[HY000] [1049] Unknown database` | Database `pixelplay` belum dibuat. Jalankan perintah `CREATE DATABASE` di atas. |
| `No application encryption key has been specified` | Jalankan `php artisan key:generate`. |
| Sampul tidak muncul | Pastikan `public/images/games/` berisi enam berkas bawaan, lalu jalankan `php artisan optimize:clear`. |
| Perubahan pada `.env` tidak terbaca | Jalankan `php artisan config:clear`. |
| Katalog kosong setelah instalasi | Jalankan `php artisan migrate:fresh --seed`. |
=======
## Status & Alur Pengembangan

Proyek ini dikembangkan bertahap:

1. **Landing page** (`pixelplay-tailwind`) — tahap awal, memperkenalkan produk.
2. **Storefront front-end** (`pixelplay-react`) — katalog & UX belanja, masih dengan data dummy.
3. **Backend & REST API** (`pixelplay-laravel`) — menyediakan data sungguhan dan panel admin; dirancang agar bisa menggantikan data statis di `pixelplay-react` pada tahap integrasi berikutnya.

Ketiga bagian saat ini belum terhubung satu sama lain secara otomatis (front-end React masih memakai data statisnya sendiri, belum memanggil API dari `pixelplay-laravel`). Integrasi penuh (React mengonsumsi REST API Laravel) merupakan langkah pengembangan selanjutnya.
>>>>>>> fcb53f271450a8794437f3a94d03e6419501b965
