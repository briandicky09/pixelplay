# PixelPlay

Marketplace game digital (PC & konsol) — dengan pengiriman instan dan pembayaran aman. Repositori ini berisi tiga implementasi/bagian dari proyek PixelPlay yang dikembangkan secara terpisah.

## Struktur Repo

| Folder | Deskripsi | Stack |
| --- | --- | --- |
| [`tailwind/`](./tailwind) | Landing page statis (marketing page) | Vite + Tailwind CSS v4 + Vanilla JS |
| [`react/`](./react) | Storefront/katalog game interaktif (data statis, siap deploy ke Vercel) | React 18 + Vite + React Router + Tailwind CSS v4 |
| [`laravel/`](./laravel) | Backend & REST API — autentikasi admin, panel admin CRUD, API publik | Laravel + PHP + MySQL |

Setiap folder adalah proyek yang berdiri sendiri dan memiliki dependency serta cara menjalankan masing-masing. Lihat README di tiap folder untuk instruksi instalasi dan detail teknis lengkap:

- [README — React](./react/README.md)
- [README — Tailwind](./tailwind/README.md)

## Ringkasan Tiap Bagian

### `tailwind` — Landing Page

Halaman landing/marketing statis PixelPlay: hero, alasan memilih PixelPlay, genre, game unggulan, game terbaru, dan ajakan komunitas. Tanpa backend, cocok untuk showcase awal produk.

```bash
cd tailwind
npm install
npm run dev
````

### `react` — Storefront/Katalog

Versi interaktif dengan katalog game, filter, halaman detail per game, dan keranjang belanja. Data game masih statis di dalam kode (`src/data/games.ts`) dan belum terhubung ke backend. Siap deploy langsung ke Vercel.

```bash
cd react
npm install
npm run dev
```

### `laravel` — Backend & REST API

Backend dengan panel admin (CRUD Game, Kategori, Platform) dan REST API publik (`/api/games`, `/api/categories`, `/api/platforms`) yang dirancang untuk dikonsumsi oleh front-end seperti `react`. Database dan data awal dihasilkan melalui seeder.

```bash
cd laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

## Status & Alur Pengembangan

Proyek ini dikembangkan bertahap:

1. **Landing page** (`tailwind`) — tahap awal, memperkenalkan produk.
2. **Storefront front-end** (`react`) — katalog dan UX belanja, masih menggunakan data dummy.
3. **Backend & REST API** (`laravel`) — menyediakan data sungguhan dan panel admin; dirancang agar dapat menggantikan data statis di `react` pada tahap integrasi berikutnya.

Ketiga bagian saat ini belum terhubung satu sama lain secara otomatis. Front-end React masih menggunakan data statisnya sendiri dan belum memanggil API dari Laravel. Integrasi penuh (React mengonsumsi REST API Laravel) merupakan langkah pengembangan selanjutnya.

```
