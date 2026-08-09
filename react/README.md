# PixelPlay

Marketplace game digital (PC & konsol) — dibangun dengan React + Vite murni,
siap deploy ke Vercel.

## Menjalankan secara lokal

```bash
npm install
npm run dev
```

Buka http://localhost:5173

## Build produksi

```bash
npm run build
npm run preview
```

Hasil build ada di folder `dist/`.

## Deploy ke Vercel

1. Push folder ini ke repository GitHub/GitLab/Bitbucket, **atau**
2. Jalankan `vercel` (Vercel CLI) langsung dari folder ini.

Vercel akan otomatis mendeteksi ini sebagai project Vite:
- Build command: `npm run build`
- Output directory: `dist`

File `vercel.json` sudah disertakan supaya semua route (mis. `/game/gta-6`)
tetap membuka `index.html` (dibutuhkan untuk client-side routing).

## Struktur

- `src/data/games.ts` — sumber data katalog game (judul, harga, diskon, cover, dll).
  Tambah/ubah game cukup dari file ini.
- `src/components/` — komponen UI (navbar, hero slider, kartu game, filter, dll).
- `src/pages/` — halaman: Beranda, Detail Game, 404.
- `src/assets/` — gambar cover. `rdr2.jpg` dan `warcraft3.jpg` berasal dari file
  yang kamu kirim; sisanya adalah artwork bergaya geometris yang dibuat khusus
  (bukan cover asli/berlisensi) supaya bebas hak cipta dan tetap terlihat profesional.

## Catatan revisi

- Proyek ini murni Vite + React + React Router — ringan dan mudah di-deploy.
- Seluruh sudut membulat (rounded corner) diganti kotak/tegas, mengikuti gaya
  referensi storefront yang kamu kirim.
- Cover Red Dead Redemption 2 dan Warcraft III memakai gambar dari `bahan.zip`.
- Ditambahkan bagian "Diskon & Event" bergaya rail horizontal, badge diskon pada
  kartu game & hero, terinspirasi dari referensi — tanpa meniru identik.
