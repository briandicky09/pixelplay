import gta6 from "@/assets/gta6.jpg";
import cyberpunk from "@/assets/cyberpunk2077.jpg";
import forza from "@/assets/forza6.jpg";
import osu from "@/assets/osu.jpg";
import warcraft from "@/assets/warcraft3.jpg";
import rdr2 from "@/assets/rdr2.jpg";
import gowRagnarok from "@/assets/gow-ragnarok.jpg";

export type Game = {
  /** URL-safe identifier used by the detail route. */
  id: string;
  title: string;
  tagline: string;
  description: string;
  category: string;
  platforms: string[];
  rating: number;
  releaseDate: string; // ISO — sortable, formatted at render time
  price: number; // IDR, current/discounted price
  originalPrice?: number; // IDR, shown struck-through when higher than price
  cover: string;
  featured?: boolean;
};

/**
 * Single source of truth for the whole catalog. Hero slider, featured grid,
 * search, filters and the detail page all read from here — adding a game
 * below is enough to make it appear everywhere.
 */
export const games: Game[] = [
  {
    id: "gta-6",
    title: "Grand Theft Auto VI",
    tagline: "Kembali ke Vice City dengan skala dunia terbuka terbesar Rockstar.",
    description:
      "Grand Theft Auto VI membawa pemain menjelajahi Leonida dan jantung kota Vice City dalam dunia terbuka paling padat yang pernah dibangun Rockstar. Dua protagonis, ekonomi kriminal yang hidup, dan sistem simulasi warga membuat setiap sesi terasa berbeda. Mode daring mendukung kru, properti, dan misi kooperatif berkelanjutan.",
    category: "Aksi Dunia Terbuka",
    platforms: ["PlayStation 5", "Xbox Series X|S", "PC"],
    rating: 4.9,
    releaseDate: "2026-11-19",
    price: 999000,
    cover: gta6,
    featured: true,
  },
  {
    id: "cyberpunk-2077",
    title: "Cyberpunk 2077",
    tagline: "RPG aksi naratif di Night City yang penuh implan dan intrik korporat.",
    description:
      "Cyberpunk 2077 menempatkanmu sebagai V, tentara bayaran yang mengejar satu implan legendaris untuk hidup abadi. Sistem build senjata, cyberware, dan quickhack memberi kebebasan bermain dari infiltrasi senyap hingga serangan frontal. Pembaruan besar memperbaiki AI polisi, pohon perk, dan berkendara.",
    category: "RPG Aksi",
    platforms: ["PC", "PlayStation 5", "Xbox Series X|S"],
    rating: 4.7,
    releaseDate: "2020-12-10",
    price: 274500,
    originalPrice: 549000,
    cover: cyberpunk,
    featured: true,
  },
  {
    id: "forza-horizon-6",
    title: "Forza Horizon 6",
    tagline: "Festival balap dunia terbuka dengan ratusan mobil dan cuaca dinamis.",
    description:
      "Forza Horizon 6 melanjutkan festival balap terbuka dengan peta baru, musim dinamis, dan lebih dari 500 kendaraan berlisensi. Editor tuning mendalam, event komunitas mingguan, serta mode kooperatif membuat progres terasa mulus baik untuk pemain kasual maupun kompetitif.",
    category: "Balap",
    platforms: ["Xbox Series X|S", "PC"],
    rating: 4.8,
    releaseDate: "2026-10-08",
    price: 599200,
    originalPrice: 749000,
    cover: forza,
    featured: true,
  },
  {
    id: "god-of-war-ragnarok",
    title: "God of War Ragnarok",
    tagline: "Perjalanan Kratos dan Atreus menembus badai akhir zaman Nordik.",
    description:
      "God of War Ragnarok melanjutkan kisah Kratos dan Atreus saat Fimbulwinter menyelimuti Sembilan Realm dan ramalan Ragnarok mendekat. Pertarungan Leviathan Axe dan Blades of Chaos terasa makin brutal dengan senjata, rune, dan kemampuan pendamping baru. Eksplorasi realm yang lebih luas dipadu penceritaan sinematik tanpa potongan kamera.",
    category: "Aksi Petualangan",
    platforms: ["PlayStation 5", "PC"],
    rating: 4.9,
    releaseDate: "2022-11-09",
    price: 629300,
    originalPrice: 899000,
    cover: gowRagnarok,
    featured: true,
  },
  {
    id: "osu",
    title: "Osu!",
    tagline: "Ritme presisi tinggi dengan peta komunitas tanpa batas.",
    description:
      "Osu! adalah game ritme kompetitif yang mengandalkan akurasi ketukan, timing, dan kontrol kursor. Katalog beatmap buatan komunitas berjumlah jutaan, lengkap dengan papan peringkat global dan mode multipemain. Ringan dijalankan, namun memiliki kurva penguasaan yang sangat dalam.",
    category: "Ritme",
    platforms: ["PC"],
    rating: 4.6,
    releaseDate: "2007-09-16",
    price: 0,
    cover: osu,
  },
  {
    id: "warcraft-iii-reign-of-chaos",
    title: "Warcraft III: Reign of Chaos",
    tagline: "Strategi real-time klasik yang melahirkan seluruh genre MOBA.",
    description:
      "Warcraft III: Reign of Chaos menggabungkan strategi real-time dengan hero yang naik level, item, dan empat faksi berbeda. Kampanye naratifnya menjadi fondasi dunia Azeroth, sementara editor peta bawaannya melahirkan genre MOBA modern. Pertandingan daring tetap aktif hingga kini.",
    category: "Strategi",
    platforms: ["PC"],
    rating: 4.8,
    releaseDate: "2002-07-03",
    price: 149500,
    originalPrice: 299000,
    cover: warcraft,
  },
  {
    id: "red-dead-redemption-2",
    title: "Red Dead Redemption II",
    tagline: "Epik koboi dengan detail dunia dan penceritaan kelas atas.",
    description:
      "Red Dead Redemption II mengikuti Arthur Morgan dan geng Van der Linde di penghujung era Barat liar Amerika. Dunianya dipenuhi detail — dari perawatan kuda hingga reaksi warga terhadap reputasimu. Mode Red Dead Online menambah perburuan, perdagangan, dan misi kooperatif.",
    category: "Aksi Petualangan",
    platforms: ["PC", "PlayStation 5", "Xbox Series X|S"],
    rating: 4.9,
    releaseDate: "2018-10-26",
    price: 649000,
    cover: rdr2,
    featured: true,
  },
];

export const getGameById = (id: string) => games.find((game) => game.id === id);

export const categories = [...new Set(games.map((game) => game.category))].sort();

export const platforms = [...new Set(games.flatMap((game) => game.platforms))].sort();

export const formatPrice = (price: number) =>
  price === 0
    ? "Gratis"
    : new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumFractionDigits: 0,
      }).format(price);

export const formatReleaseDate = (iso: string) =>
  new Intl.DateTimeFormat("id-ID", { dateStyle: "long" }).format(new Date(iso));

export const discountPercent = (game: Game) =>
  game.originalPrice && game.originalPrice > game.price
    ? Math.round(100 - (game.price / game.originalPrice) * 100)
    : 0;
