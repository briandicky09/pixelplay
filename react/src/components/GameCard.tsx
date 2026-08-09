import { Link } from "react-router-dom";
import { discountPercent, formatPrice, type Game } from "@/data/games";

type GameCardProps = {
  game: Game;
  /** First rows render eagerly; the rest stay lazy for a faster first paint. */
  priority?: boolean;
};

export function GameCard({ game, priority = false }: GameCardProps) {
  const discount = discountPercent(game);

  return (
    <article className="card-soft group flex h-full flex-col hover:-translate-y-1 hover:border-violet-500/50 hover:shadow-glow">
      <Link
        to={`/game/${game.id}`}
        className="flex h-full flex-col focus-visible:outline-offset-4"
        aria-label={`Lihat detail ${game.title}`}
      >
        <div className="relative aspect-video w-full overflow-hidden">
          <img
            src={game.cover}
            alt={`Cover ${game.title}`}
            loading={priority ? "eager" : "lazy"}
            decoding="async"
            className="size-full object-cover transition-transform duration-500 group-hover:scale-105"
          />
          {discount > 0 && (
            <span className="sale-tag absolute left-0 top-0">-{discount}%</span>
          )}
        </div>

        <div className="flex flex-1 flex-col p-5">
          <div className="flex items-start justify-between gap-3">
            <h3 className="font-display font-semibold text-white">{game.title}</h3>
            <span className="shrink-0 text-sm text-emerald-400">★ {game.rating.toFixed(1)}</span>
          </div>

          <p className="mt-1 text-sm text-slate-500">{game.category}</p>

          <ul className="mt-3 flex flex-wrap gap-2">
            {game.platforms.map((platform) => (
              <li key={platform} className="chip">
                {platform}
              </li>
            ))}
          </ul>

          <div className="mt-auto flex items-end justify-between pt-5">
            <div>
              {game.originalPrice && (
                <p className="price-strike">{formatPrice(game.originalPrice)}</p>
              )}
              <span className="font-semibold text-white">{formatPrice(game.price)}</span>
            </div>
            <span className="text-sm text-slate-400 transition-colors group-hover:text-violet-400">
              Detail →
            </span>
          </div>
        </div>
      </Link>
    </article>
  );
}
