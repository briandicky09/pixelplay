import { Link } from "react-router-dom";
import { formatPrice, games } from "@/data/games";
import { Reveal } from "./Reveal";

/** Compact trending strip, derived from the highest-rated titles. */
export function TrendingSection() {
  const trending = [...games].sort((a, b) => b.rating - a.rating).slice(0, 4);

  return (
    <section className="border-t border-charcoal-700/60 bg-charcoal-900/40 py-20 sm:py-24">
      <div className="shell">
        <Reveal>
          <div className="mb-10">
            <span className="eyebrow">Sedang tren</span>
            <h2 className="section-heading mt-2">Populer di komunitas</h2>
          </div>
        </Reveal>

        <ul className="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          {trending.map((game, index) => (
            <li key={game.id}>
              <Reveal index={index} className="h-full">
                <Link
                  to={`/game/${game.id}`}
                  className="flex h-full items-center gap-4 border border-charcoal-700 bg-charcoal-800 p-4 transition-colors hover:border-violet-500/50"
                >
                  <img
                    src={game.cover}
                    alt={`Thumbnail ${game.title}`}
                    loading="lazy"
                    decoding="async"
                    className="size-16 shrink-0 object-cover"
                  />
                  <div className="min-w-0">
                    <p className="truncate font-medium text-white">{game.title}</p>
                    <p className="truncate text-xs text-slate-500">{game.category}</p>
                    <p className="mt-1 text-sm text-emerald-400">{formatPrice(game.price)}</p>
                  </div>
                </Link>
              </Reveal>
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
