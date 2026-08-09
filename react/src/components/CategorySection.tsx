import { Link } from "react-router-dom";
import { games } from "@/data/games";
import { Reveal } from "./Reveal";

/**
 * Category tiles derived from the catalog — counts stay accurate automatically
 * as games are added to src/data/games.ts.
 */
const SHIELD_ICON = "M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z";

export function CategorySection() {
  const grouped = games.reduce<Record<string, number>>((accumulator, game) => {
    accumulator[game.category] = (accumulator[game.category] ?? 0) + 1;
    return accumulator;
  }, {});

  const entries = Object.entries(grouped).sort((a, b) => b[1] - a[1] || a[0].localeCompare(b[0]));

  return (
    <section
      id="kategori"
      className="border-t border-charcoal-700/60 bg-charcoal-900/40 py-20 sm:py-24"
    >
      <div className="shell">
        <Reveal>
          <div className="mb-10 max-w-xl">
            <span className="eyebrow">Jelajahi berdasarkan kategori</span>
            <h2 className="section-heading mt-2">Temukan genre favoritmu</h2>
            <p className="mt-3 text-slate-400">
              Setiap game diberi label genre, jadi kamu bisa langsung menuju jenis permainan yang
              sedang kamu cari.
            </p>
          </div>
        </Reveal>

        <ul className="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
          {entries.map(([category, count], index) => (
            <li key={category}>
              <Reveal index={index} className="h-full">
                <Link
                  to={`/?category=${encodeURIComponent(category)}#katalog`}
                  aria-label={`Lihat semua game kategori ${category}`}
                  className="card group flex h-full flex-col gap-4 p-6 transition-all hover:-translate-y-1 hover:border-violet-500/50"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className="size-6 text-emerald-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    strokeWidth={1.5}
                    aria-hidden="true"
                  >
                    <path strokeLinecap="round" strokeLinejoin="round" d={SHIELD_ICON} />
                  </svg>
                  <h3 className="font-medium text-white group-hover:text-violet-300">{category}</h3>
                  <span className="mt-auto flex items-center justify-between text-xs text-slate-500">
                    {count} game
                    <span className="text-slate-600 transition-colors group-hover:text-violet-400">→</span>
                  </span>
                </Link>
              </Reveal>
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
