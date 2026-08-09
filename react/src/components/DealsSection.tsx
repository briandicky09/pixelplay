import { Link } from "react-router-dom";
import { discountPercent, formatPrice, games } from "@/data/games";
import { Reveal } from "./Reveal";

const dealTags = ["DEAL AKHIR PEKAN", "EVENT SPESIAL", "DISKON HARI INI", "DISKON HARI INI"];

/**
 * Horizontal "Diskon & Event" strip, styled after classic digital-storefront
 * deal rails: tagged cards, struck-through price, scrollable on small screens.
 */
export function DealsSection() {
  const deals = [...games]
    .filter((game) => discountPercent(game) > 0 || game.price === 0)
    .slice(0, 4);

  if (deals.length === 0) return null;

  return (
    <section className="border-t border-charcoal-700/60 py-20 sm:py-24">
      <div className="shell">
        <Reveal>
          <div className="mb-10 flex flex-wrap items-end justify-between gap-4">
            <div>
              <span className="eyebrow">Diskon &amp; Event</span>
              <h2 className="section-heading mt-2">Jangan sampai kelewatan</h2>
            </div>
            <Link to="/" className="btn-secondary text-sm">
              Lihat Semua
            </Link>
          </div>
        </Reveal>

        <div className="-mx-4 flex snap-x snap-mandatory gap-4 overflow-x-auto px-4 pb-4 sm:mx-0 sm:grid sm:grid-cols-2 sm:overflow-visible sm:px-0 lg:grid-cols-4">
          {deals.map((game, index) => {
            const discount = discountPercent(game);
            return (
              <Reveal key={game.id} index={index} className="w-[78%] shrink-0 snap-start sm:w-auto">
                <Link
                  to={`/game/${game.id}`}
                  className="card-soft group flex h-full flex-col hover:-translate-y-1 hover:border-violet-500/50"
                >
                  <div className="relative aspect-video w-full overflow-hidden">
                    <span className="absolute left-0 top-0 z-10 bg-charcoal-950/85 px-2 py-1 text-[10px] font-semibold tracking-wide text-emerald-400 uppercase">
                      {game.price === 0 ? "Gratis Dimainkan" : dealTags[index % dealTags.length]}
                    </span>
                    <img
                      src={game.cover}
                      alt={`Cover ${game.title}`}
                      loading="lazy"
                      decoding="async"
                      className="size-full object-cover transition-transform duration-500 group-hover:scale-105"
                    />
                  </div>
                  <div className="flex flex-1 flex-col justify-between gap-3 p-4">
                    <p className="font-display font-semibold text-white">{game.title}</p>
                    <div className="flex items-center justify-between">
                      {discount > 0 ? (
                        <>
                          <span className="sale-tag text-xs">-{discount}%</span>
                          <span className="text-right">
                            <span className="block price-strike">
                              {formatPrice(game.originalPrice ?? 0)}
                            </span>
                            <span className="font-semibold text-white">{formatPrice(game.price)}</span>
                          </span>
                        </>
                      ) : (
                        <span className="ml-auto font-semibold text-emerald-400">Gratis</span>
                      )}
                    </div>
                  </div>
                </Link>
              </Reveal>
            );
          })}
        </div>
      </div>
    </section>
  );
}
