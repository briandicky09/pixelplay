import { useEffect, useMemo, useState } from "react";
import { useSearchParams } from "react-router-dom";
import { AnimatePresence, motion } from "framer-motion";
import { categories, games } from "@/data/games";
import { CatalogFilters, FilterBar, defaultFilters } from "./FilterBar";
import { GameCard } from "./GameCard";
import { GameCardSkeleton } from "./GameCardSkeleton";
import { EmptyState } from "./EmptyState";
import { Reveal } from "./Reveal";

const SKELETON_MS = 320;

/**
 * Catalog with instant search, category/platform filters and sorting.
 * All derivations are memoized, so typing never re-sorts the full list twice.
 */
export function GameCatalog() {
  const [searchParams, setSearchParams] = useSearchParams();
  const [filters, setFilters] = useState<CatalogFilters>(defaultFilters);
  const [loading, setLoading] = useState(true);

  // One short skeleton pass on mount, mirroring a real fetch.
  useEffect(() => {
    const timer = window.setTimeout(() => setLoading(false), SKELETON_MS);
    return () => window.clearTimeout(timer);
  }, []);

  // Pick up ?category=… (from category tiles) and ?q=… (from the navbar
  // search) whenever they change, so both stay in sync with the catalog
  // filters and the URL is shareable/bookmarkable.
  useEffect(() => {
    const urlCategory = searchParams.get("category");
    const urlQuery = searchParams.get("q");
    if (urlCategory === null && urlQuery === null) return;

    setFilters((current) => ({
      ...current,
      category:
        urlCategory && categories.includes(urlCategory) ? urlCategory : current.category,
      query: urlQuery ?? current.query,
    }));

    // Clear the params once applied so manual filter changes afterwards
    // aren't overridden by a stale URL on re-render.
    setSearchParams(
      (params) => {
        params.delete("category");
        params.delete("q");
        return params;
      },
      { replace: true },
    );
  }, [searchParams, setSearchParams]);

  const results = useMemo(() => {
    const query = filters.query.trim().toLowerCase();

    const filtered = games.filter((game) => {
      const matchesQuery =
        !query ||
        game.title.toLowerCase().includes(query) ||
        game.category.toLowerCase().includes(query) ||
        game.platforms.some((platform) => platform.toLowerCase().includes(query));
      const matchesCategory = filters.category === "all" || game.category === filters.category;
      const matchesPlatform =
        filters.platform === "all" || game.platforms.includes(filters.platform);
      return matchesQuery && matchesCategory && matchesPlatform;
    });

    return [...filtered].sort((a, b) => {
      switch (filters.sort) {
        case "newest":
          return b.releaseDate.localeCompare(a.releaseDate);
        case "price-asc":
          return a.price - b.price;
        case "price-desc":
          return b.price - a.price;
        default:
          return b.rating - a.rating;
      }
    });
  }, [filters]);

  const updateFilters = (next: Partial<CatalogFilters>) =>
    setFilters((current) => ({ ...current, ...next }));

  return (
    <section id="katalog" className="border-t border-charcoal-700/60 py-20 sm:py-24">
      <div className="shell">
        <Reveal>
          <div className="mb-10 max-w-xl">
            <span className="eyebrow">Katalog</span>
            <h2 className="section-heading mt-2">Semua game di PixelPlay</h2>
            <p className="mt-3 text-slate-400">
              Cari, filter berdasarkan kategori dan platform, lalu urutkan sesuai rating, tanggal
              rilis, atau harga — semuanya langsung tanpa memuat ulang halaman.
            </p>
          </div>
        </Reveal>

        <Reveal>
          <FilterBar filters={filters} onChange={updateFilters} resultCount={results.length} />
        </Reveal>

        <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {loading ? (
            Array.from({ length: 6 }, (_, index) => <GameCardSkeleton key={index} />)
          ) : (
            <AnimatePresence mode="popLayout">
              {results.length === 0 ? (
                <EmptyState key="empty" onReset={() => setFilters(defaultFilters)} />
              ) : (
                results.map((game, index) => (
                  <motion.div
                    key={game.id}
                    layout
                    initial={{ opacity: 0, y: 14 }}
                    animate={{ opacity: 1, y: 0 }}
                    exit={{ opacity: 0, scale: 0.97 }}
                    transition={{ duration: 0.32, ease: [0.22, 1, 0.36, 1] }}
                  >
                    <GameCard game={game} priority={index < 3} />
                  </motion.div>
                ))
              )}
            </AnimatePresence>
          )}
        </div>
      </div>
    </section>
  );
}
