import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { motion } from "framer-motion";
import {
  discountPercent,
  formatPrice,
  formatReleaseDate,
  games,
  getGameById,
} from "@/data/games";
import { GameCard } from "@/components/GameCard";
import { HashLink } from "@/components/HashLink";
import { Reveal } from "@/components/Reveal";
import { useCart } from "@/context/CartContext";
import { useToast } from "@/context/ToastContext";
import NotFoundPage from "./NotFound";

export default function GameDetailPage() {
  const { gameId } = useParams<{ gameId: string }>();
  const game = gameId ? getGameById(gameId) : undefined;
  const { addItem } = useCart();
  const { showToast } = useToast();
  const [justAdded, setJustAdded] = useState(false);

  useEffect(() => {
    document.title = game ? `${game.title} — PixelPlay` : "Game tidak ditemukan — PixelPlay";
  }, [game]);

  if (!game) return <NotFoundPage />;

  const related = games.filter((item) => item.id !== game.id).slice(0, 3);
  const discount = discountPercent(game);

  const handleAddToCart = () => {
    addItem(game);
    showToast(`${game.title} ditambahkan ke keranjang.`);
    setJustAdded(true);
    window.setTimeout(() => setJustAdded(false), 1800);
  };

  return (
    <div className="pt-28 pb-20 sm:pt-32">
      <div className="shell">
        <HashLink hash="katalog" className="btn-ghost -ml-4 text-sm">
          ← Kembali ke katalog
        </HashLink>

        <motion.div
          initial={{ opacity: 0, y: 16 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.45, ease: [0.22, 1, 0.36, 1] }}
          className="mt-6 grid gap-10 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)] lg:gap-14"
        >
          <div className="relative aspect-video w-full self-start overflow-hidden border border-charcoal-700 bg-charcoal-800 shadow-card">
            {discount > 0 && (
              <span className="sale-tag absolute left-0 top-0 z-10">-{discount}%</span>
            )}
            <img
              src={game.cover}
              alt={`Cover ${game.title}`}
              loading="eager"
              decoding="async"
              className="absolute inset-0 h-full w-full object-cover"
            />
          </div>

          <div>
            <span className="eyebrow">{game.category}</span>
            <h1 className="mt-3 font-display text-3xl font-bold tracking-tight text-white sm:text-4xl lg:text-5xl">
              {game.title}
            </h1>
            <p className="mt-4 leading-relaxed text-slate-400">{game.tagline}</p>

            <dl className="mt-8 grid grid-cols-2 gap-x-6 gap-y-5 border-t border-charcoal-700 pt-6 text-sm">
              <div>
                <dt className="text-xs tracking-wide text-slate-500">Rating</dt>
                <dd className="mt-1 text-emerald-400">★ {game.rating.toFixed(1)} / 5.0</dd>
              </div>
              <div>
                <dt className="text-xs tracking-wide text-slate-500">Tanggal rilis</dt>
                <dd className="mt-1 text-slate-300">{formatReleaseDate(game.releaseDate)}</dd>
              </div>
              <div className="col-span-2">
                <dt className="text-xs tracking-wide text-slate-500">Platform</dt>
                <dd className="mt-2 flex flex-wrap gap-2">
                  {game.platforms.map((platform) => (
                    <span key={platform} className="chip">
                      {platform}
                    </span>
                  ))}
                </dd>
              </div>
            </dl>

            <div className="mt-8 flex flex-col gap-4 border-t border-charcoal-700 pt-6 sm:flex-row sm:items-center sm:justify-between">
              <div>
                <p className="text-xs tracking-wide text-slate-500">Harga</p>
                {game.originalPrice && (
                  <p className="price-strike text-sm">{formatPrice(game.originalPrice)}</p>
                )}
                <p className="mt-1 text-2xl font-semibold text-white">{formatPrice(game.price)}</p>
              </div>
              <button type="button" onClick={handleAddToCart} className="btn-primary">
                {justAdded ? "Ditambahkan ✓" : "Tambah ke Keranjang"}
              </button>
            </div>
          </div>
        </motion.div>

        <Reveal>
          <div className="mt-16 max-w-3xl">
            <h2 className="font-display text-xl font-semibold text-white">Tentang game ini</h2>
            <p className="mt-4 leading-relaxed text-slate-400">{game.description}</p>
          </div>
        </Reveal>

        <section className="mt-20 border-t border-charcoal-700/60 pt-12">
          <Reveal>
            <h2 className="section-heading">Game lainnya</h2>
          </Reveal>
          <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {related.map((item, index) => (
              <Reveal key={item.id} index={index} className="h-full">
                <GameCard game={item} />
              </Reveal>
            ))}
          </div>
        </section>
      </div>
    </div>
  );
}
