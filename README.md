# PixelPlay

Marketplace game digital (PC & konsol) — dengan pengiriman instan dan pembayaran aman. Repositori ini berisi tiga implementasi/bagian dari proyek PixelPlay yang dikembangkan secara terpisah.

## Struktur Repo

| Folder | Deskripsi | Stack |
| --- | --- | --- |
| [`tailwind/`](./tailwind) | Landing page statis (marketing page) | Vite + Tailwind CSS v4 + Vanilla JS |
| [`react/`](./react) | Storefront/katalog game interaktif (data statis, siap deploy ke Vercel) | React 18 + Vite + React Router + Tailwind CSS v4 |
| [`laravel/`](./laravel) | Backend & REST API — autentikasi admin, panel admin CRUD, API publik | Laravel 8.2+ / PHP + MySQL |

Setiap folder adalah proyek yang berdiri sendiri (punya `package.json`/`composer.json`, dependency, dan cara menjalankan masing-masing). Lihat README di tiap folder untuk instruksi instalasi dan detail teknis lengkap:

- [README — react](./react/README.md)
- [README — tailwind](./tailwind/README.md)

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
php artisan migrate:fresh --seed
php artisan serve
```

## Status & Alur Pengembangan

Proyek ini dikembangkan bertahap:

1. **Landing page** (`pixelplay-tailwind`) — tahap awal, memperkenalkan produk.
2. **Storefront front-end** (`pixelplay-react`) — katalog & UX belanja, masih dengan data dummy.
3. **Backend & REST API** (`pixelplay-laravel`) — menyediakan data sungguhan dan panel admin; dirancang agar bisa menggantikan data statis di `pixelplay-react` pada tahap integrasi berikutnya.

Ketiga bagian saat ini belum terhubung satu sama lain secara otomatis (front-end React masih memakai data statisnya sendiri, belum memanggil API dari `pixelplay-laravel`). Integrasi penuh (React mengonsumsi REST API Laravel) merupakan langkah pengembangan selanjutnya.
