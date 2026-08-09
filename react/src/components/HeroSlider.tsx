import { useCallback, useEffect, useRef, useState } from "react";
import type { KeyboardEvent } from "react";
import { Link } from "react-router-dom";
import { AnimatePresence, motion, useReducedMotion } from "framer-motion";
import { discountPercent, formatPrice, formatReleaseDate, type Game } from "@/data/games";

const AUTOPLAY_MS = 6000;

type HeroSliderProps = {
  slides: Game[];
};

/** Steam-style review label derived from the catalog rating. */
function reviewLabel(rating: number) {
  if (rating >= 4.8) return "Sangat Positif";
  if (rating >= 4.5) return "Kebanyakan Positif";
  if (rating >= 4) return "Positif";
  return "Beragam";
}

/** Deterministic pseudo review count so the UI is stable between renders. */
function reviewCount(id: string) {
  let hash = 0;
  for (let i = 0; i < id.length; i += 1) hash = (hash * 31 + id.charCodeAt(i)) % 900000;
  return 40000 + hash;
}

function ArrowIcon({ dir }: { dir: "left" | "right" }) {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      className="size-7"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      strokeWidth={1.8}
      aria-hidden="true"
    >
      <path
        strokeLinecap="round"
        strokeLinejoin="round"
        d={dir === "left" ? "M15 19l-7-7 7-7" : "M9 5l7 7-7 7"}
      />
    </svg>
  );
}

/**
 * Steam-inspired featured carousel.
 *
 * Layout: a fixed-height centre stage (cover + info panel) flanked by
 * "peek" previews of the previous/next slide. The stage height is fixed
 * per breakpoint so slides with longer copy never resize the box.
 */
export function HeroSlider({ slides }: HeroSliderProps) {
  const [index, setIndex] = useState(0);
  const [progress, setProgress] = useState(0);
  const [isDragging, setIsDragging] = useState(false);
  const [isTabHidden, setIsTabHidden] = useState(false);
  const touchStartX = useRef<number | null>(null);
  const reduceMotion = useReducedMotion();

  // Elapsed time (ms) banked for the current slide's cycle. This is the
  // single source of truth for autoplay timing — the progress bar and the
  // slide-advance both derive from it instead of running independent timers.
  const elapsedRef = useRef(0);
  const rafRef = useRef<number | null>(null);

  const total = slides.length;
  const goTo = useCallback((next: number) => {
    elapsedRef.current = 0;
    setProgress(0);
    setIndex(((next % total) + total) % total);
  }, [total]);
  const next = useCallback(() => goTo(index + 1), [goTo, index]);
  const prev = useCallback(() => goTo(index - 1), [goTo, index]);

  // Autoplay only pauses for intentional interaction (dragging/swiping the
  // slider) or when the tab is backgrounded — simply hovering the Hero must
  // never freeze the slideshow or its progress indicator.
  const isPaused = isDragging || isTabHidden;

  // Single rAF loop: advances progress every frame and triggers the slide
  // change exactly once, at exactly 100%. Pausing (hover / hidden tab) just
  // stops the loop without losing the banked elapsed time, so resuming
  // continues smoothly instead of restarting or jumping.
  useEffect(() => {
    if (reduceMotion || total < 2 || isPaused) return undefined;

    let cancelled = false;
    let lastTimestamp: number | null = null;

    const tick = (timestamp: number) => {
      if (cancelled) return;
      if (lastTimestamp === null) lastTimestamp = timestamp;
      const delta = timestamp - lastTimestamp;
      lastTimestamp = timestamp;

      elapsedRef.current = Math.min(elapsedRef.current + delta, AUTOPLAY_MS);
      const pct = (elapsedRef.current / AUTOPLAY_MS) * 100;
      setProgress(pct);

      if (elapsedRef.current >= AUTOPLAY_MS) {
        next();
        return;
      }
      rafRef.current = window.requestAnimationFrame(tick);
    };

    rafRef.current = window.requestAnimationFrame(tick);

    return () => {
      cancelled = true;
      if (rafRef.current !== null) window.cancelAnimationFrame(rafRef.current);
      rafRef.current = null;
    };
  }, [index, isPaused, reduceMotion, total, next]);

  // Pause both autoplay and the progress bar while the tab is in the
  // background so a throttled/frozen timer can never "catch up" and jump.
  useEffect(() => {
    const handleVisibilityChange = () => setIsTabHidden(document.hidden);
    document.addEventListener("visibilitychange", handleVisibilityChange);
    return () => document.removeEventListener("visibilitychange", handleVisibilityChange);
  }, []);

  const onKeyDown = (event: KeyboardEvent) => {
    if (event.key === "ArrowRight") {
      event.preventDefault();
      next();
    }
    if (event.key === "ArrowLeft") {
      event.preventDefault();
      prev();
    }
  };

  const slide = slides[index];
  if (!slide) return null;

  const prevSlide = slides[(index - 1 + total) % total] ?? slide;
  const nextSlide = slides[(index + 1) % total] ?? slide;
  const discount = discountPercent(slide);

  return (
    <section
      id="home"
      aria-roledescription="carousel"
      aria-label="Game unggulan PixelPlay"
      tabIndex={0}
      onKeyDown={onKeyDown}
      onTouchStart={(event) => {
        touchStartX.current = event.touches[0]?.clientX ?? null;
        setIsDragging(true);
      }}
      onTouchEnd={(event) => {
        const start = touchStartX.current;
        const end = event.changedTouches[0]?.clientX;
        if (start != null && end != null) {
          const delta = end - start;
          if (Math.abs(delta) > 48) (delta < 0 ? next : prev)();
        }
        touchStartX.current = null;
        setIsDragging(false);
      }}
      onTouchCancel={() => {
        touchStartX.current = null;
        setIsDragging(false);
      }}
      className="relative overflow-hidden bg-grid-fade pt-28 pb-14 lg:pt-32 lg:pb-20"
    >
      <div className="shell">
        <div className="mb-5 flex items-end justify-between gap-4">
          <h1 className="font-display text-2xl font-bold text-white sm:text-3xl">
            Unggulan &amp; Rekomendasi
          </h1>
          <span className="hidden text-xs text-slate-500 tabular-nums sm:block">
            {String(index + 1).padStart(2, "0")} / {String(total).padStart(2, "0")}
          </span>
        </div>

        {/* Peek + stage row */}
        <div className="flex items-stretch gap-3">
          {/* Left peek */}
          <button
            type="button"
            onClick={prev}
            aria-label={`Slide sebelumnya: ${prevSlide.title}`}
            className="group relative hidden h-[470px] w-[110px] shrink-0 overflow-hidden border border-charcoal-700 lg:block xl:w-[150px]"
          >
            <img
              src={prevSlide.cover}
              alt=""
              aria-hidden="true"
              loading="lazy"
              decoding="async"
              className="size-full object-cover opacity-35 grayscale transition duration-500 group-hover:opacity-60 group-hover:grayscale-0"
            />
            <span className="pointer-events-none absolute inset-0 flex items-center justify-center bg-charcoal-950/40 text-slate-300 transition-colors group-hover:text-white">
              <ArrowIcon dir="left" />
            </span>
          </button>

          {/* Stage */}
          <div className="relative min-w-0 flex-1 overflow-hidden border border-charcoal-700 bg-charcoal-900 shadow-card">
            <div className="grid h-[560px] grid-rows-[220px_1fr] sm:h-[600px] sm:grid-rows-[300px_1fr] lg:h-[470px] lg:grid-cols-[1fr_360px] lg:grid-rows-1 xl:grid-cols-[1fr_400px]">
              {/* Cover */}
              <div className="relative overflow-hidden">
                <AnimatePresence mode="sync">
                  <motion.img
                    key={slide.id}
                    src={slide.cover}
                    alt={`Cover ${slide.title}`}
                    loading={index === 0 ? "eager" : "lazy"}
                    decoding="async"
                    initial={reduceMotion ? false : { opacity: 0, scale: 1.05 }}
                    animate={{ opacity: 1, scale: 1 }}
                    exit={reduceMotion ? { opacity: 1 } : { opacity: 0 }}
                    transition={{ duration: 0.7, ease: [0.22, 1, 0.36, 1] }}
                    className="absolute inset-0 size-full object-cover"
                  />
                </AnimatePresence>
                <div
                  className="pointer-events-none absolute inset-0 bg-linear-to-t from-charcoal-950/70 via-transparent to-transparent lg:bg-linear-to-r lg:from-transparent lg:via-transparent lg:to-charcoal-900/80"
                  aria-hidden="true"
                />
                {discount > 0 && (
                  <span className="sale-tag absolute left-0 top-0 z-10">DISKON {discount}%</span>
                )}

                {/* Overlay arrows (mobile / tablet, where peeks are hidden) */}
                <button
                  type="button"
                  onClick={prev}
                  aria-label="Slide sebelumnya"
                  className="absolute left-0 top-1/2 z-10 flex h-16 w-10 -translate-y-1/2 items-center justify-center bg-charcoal-950/60 text-slate-200 transition-colors hover:bg-charcoal-950/85 hover:text-white lg:hidden"
                >
                  <ArrowIcon dir="left" />
                </button>
                <button
                  type="button"
                  onClick={next}
                  aria-label="Slide berikutnya"
                  className="absolute right-0 top-1/2 z-10 flex h-16 w-10 -translate-y-1/2 items-center justify-center bg-charcoal-950/60 text-slate-200 transition-colors hover:bg-charcoal-950/85 hover:text-white lg:hidden"
                >
                  <ArrowIcon dir="right" />
                </button>
              </div>

              {/* Info panel */}
              <div className="relative flex min-h-0 flex-col gap-3 overflow-hidden bg-charcoal-900 px-5 py-5 sm:px-6">
                <AnimatePresence mode="wait">
                  <motion.div
                    key={slide.id}
                    initial={reduceMotion ? false : { opacity: 0, y: 12 }}
                    animate={{ opacity: 1, y: 0 }}
                    exit={reduceMotion ? { opacity: 1 } : { opacity: 0, y: -8 }}
                    transition={{ duration: 0.4, ease: [0.22, 1, 0.36, 1] }}
                    className="flex min-h-0 flex-1 flex-col"
                  >
                    <h2 className="font-display text-xl font-bold text-white sm:text-2xl">
                      {slide.title}
                    </h2>
                    <p className="mt-1 text-sm">
                      <span className="text-emerald-400">{reviewLabel(slide.rating)}</span>{" "}
                      <span className="text-slate-500">
                        ({reviewCount(slide.id).toLocaleString("id-ID")} ulasan)
                      </span>
                    </p>

                    <p className="mt-4 shrink-0 text-sm leading-relaxed text-slate-300">
                      {slide.tagline}
                    </p>
                    <p className="mt-2 overflow-hidden text-sm leading-relaxed text-slate-500">
                      {slide.description}
                    </p>

                    <dl className="mt-3 shrink-0 space-y-1 text-xs text-slate-500">
                      <div className="flex gap-2">
                        <dt>Rilis</dt>
                        <dd className="text-slate-300">{formatReleaseDate(slide.releaseDate)}</dd>
                      </div>
                      <div className="flex gap-2">
                        <dt>Platform</dt>
                        <dd className="truncate text-slate-300">{slide.platforms.join(" · ")}</dd>
                      </div>
                    </dl>

                    <div className="mt-auto flex flex-wrap items-center gap-3 pt-4">
                      <Link to={`/game/${slide.id}`} className="btn-primary px-5 py-2.5 text-sm">
                        Lihat Detail
                      </Link>
                      <span className="text-sm text-slate-500">
                        {slide.originalPrice && (
                          <span className="price-strike mr-2">
                            {formatPrice(slide.originalPrice)}
                          </span>
                        )}
                        <span className="font-semibold text-white">{formatPrice(slide.price)}</span>
                      </span>
                    </div>
                  </motion.div>
                </AnimatePresence>
              </div>
            </div>

            {/* Autoplay progress — width mirrors `progress` state directly,
                the same single timing source that drives slide advance. */}
            <div
              className="absolute inset-x-0 bottom-0 h-0.5 w-full bg-charcoal-700"
              aria-hidden="true"
            >
              <div
                className="h-full bg-violet-500"
                style={{
                  width: `${reduceMotion ? 0 : progress}%`,
                  transition: isPaused ? "none" : undefined,
                }}
              />
            </div>
          </div>

          {/* Right peek */}
          <button
            type="button"
            onClick={next}
            aria-label={`Slide berikutnya: ${nextSlide.title}`}
            className="group relative hidden h-[470px] w-[110px] shrink-0 overflow-hidden border border-charcoal-700 lg:block xl:w-[150px]"
          >
            <img
              src={nextSlide.cover}
              alt=""
              aria-hidden="true"
              loading="lazy"
              decoding="async"
              className="size-full object-cover opacity-35 grayscale transition duration-500 group-hover:opacity-60 group-hover:grayscale-0"
            />
            <span className="pointer-events-none absolute inset-0 flex items-center justify-center bg-charcoal-950/40 text-slate-300 transition-colors group-hover:text-white">
              <ArrowIcon dir="right" />
            </span>
          </button>
        </div>

        {/* Dots */}
        <ul className="mt-5 flex items-center justify-center gap-2" role="tablist" aria-label="Pilih slide">
          {slides.map((item, itemIndex) => (
            <li key={item.id}>
              <button
                type="button"
                role="tab"
                aria-selected={itemIndex === index}
                aria-label={`Slide ${itemIndex + 1}: ${item.title}`}
                onClick={() => goTo(itemIndex)}
                className={`h-2 transition-all duration-300 ${
                  itemIndex === index
                    ? "w-8 bg-violet-500"
                    : "w-2.5 bg-charcoal-600 hover:bg-slate-500"
                }`}
              />
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
