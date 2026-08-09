import { categories, platforms } from "@/data/games";

export type SortKey = "rating" | "newest" | "price-asc" | "price-desc";

export type CatalogFilters = {
  query: string;
  category: string;
  platform: string;
  sort: SortKey;
};

export const defaultFilters: CatalogFilters = {
  query: "",
  category: "all",
  platform: "all",
  sort: "rating",
};

type FilterBarProps = {
  filters: CatalogFilters;
  onChange: (next: Partial<CatalogFilters>) => void;
  resultCount: number;
};

const sortOptions: { value: SortKey; label: string }[] = [
  { value: "rating", label: "Rating tertinggi" },
  { value: "newest", label: "Terbaru" },
  { value: "price-asc", label: "Harga terendah" },
  { value: "price-desc", label: "Harga tertinggi" },
];

export function FilterBar({ filters, onChange, resultCount }: FilterBarProps) {
  return (
    <div className="border border-charcoal-700 bg-charcoal-900/60 p-5 sm:p-6">
      <div className="grid gap-4 lg:grid-cols-[minmax(0,2fr)_repeat(3,minmax(0,1fr))]">
        <div>
          <label htmlFor="search" className="mb-2 block text-xs tracking-wide text-slate-500">
            Cari game
          </label>
          <div className="relative">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="pointer-events-none absolute top-1/2 left-4 size-4 -translate-y-1/2 text-slate-500"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth={1.8}
              aria-hidden="true"
            >
              <circle cx="11" cy="11" r="7" strokeLinecap="round" />
              <path strokeLinecap="round" d="M20 20l-4-4" />
            </svg>
            <input
              id="search"
              type="search"
              value={filters.query}
              onChange={(event) => onChange({ query: event.target.value })}
              placeholder="Ketik judul, misalnya Grand Theft Auto VI"
              className="field pl-11"
              autoComplete="off"
            />
          </div>
        </div>

        <div>
          <label htmlFor="category" className="mb-2 block text-xs tracking-wide text-slate-500">
            Kategori
          </label>
          <select
            id="category"
            value={filters.category}
            onChange={(event) => onChange({ category: event.target.value })}
            className="field"
          >
            <option value="all">Semua kategori</option>
            {categories.map((category) => (
              <option key={category} value={category}>
                {category}
              </option>
            ))}
          </select>
        </div>

        <div>
          <label htmlFor="platform" className="mb-2 block text-xs tracking-wide text-slate-500">
            Platform
          </label>
          <select
            id="platform"
            value={filters.platform}
            onChange={(event) => onChange({ platform: event.target.value })}
            className="field"
          >
            <option value="all">Semua platform</option>
            {platforms.map((platform) => (
              <option key={platform} value={platform}>
                {platform}
              </option>
            ))}
          </select>
        </div>

        <div>
          <label htmlFor="sort" className="mb-2 block text-xs tracking-wide text-slate-500">
            Urutkan
          </label>
          <select
            id="sort"
            value={filters.sort}
            onChange={(event) => onChange({ sort: event.target.value as SortKey })}
            className="field"
          >
            {sortOptions.map((option) => (
              <option key={option.value} value={option.value}>
                {option.label}
              </option>
            ))}
          </select>
        </div>
      </div>

      <p className="mt-4 text-xs text-slate-500" aria-live="polite">
        Menampilkan {resultCount} game
      </p>
    </div>
  );
}
