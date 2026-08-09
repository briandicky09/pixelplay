import gow from "@/assets/gow.jpg";
import { HashLink } from "./HashLink";
import { Reveal } from "./Reveal";

export function CtaSection() {
  return (
    <section className="border-t border-charcoal-700/60 py-20">
      <div className="mx-auto max-w-5xl px-4 sm:px-6 lg:px-10">
        <Reveal>
          <div className="relative overflow-hidden border border-charcoal-700 bg-charcoal-800 px-8 py-14 text-center sm:px-14">
            <img
              src={gow}
              alt=""
              aria-hidden="true"
              loading="lazy"
              decoding="async"
              className="absolute inset-0 size-full object-cover opacity-25"
            />
            <div
              className="absolute inset-0 bg-linear-to-t from-charcoal-800 via-charcoal-800/85 to-charcoal-800/60"
              aria-hidden="true"
            />
            <div className="relative">
              <h2 className="font-display text-3xl font-semibold text-white sm:text-4xl">
                Siap membangun koleksimu?
              </h2>
              <p className="mx-auto mt-4 max-w-xl text-slate-400">
                Jelajahi kode PC dan konsol yang telah diverifikasi, dan langsung main begitu proses
                checkout selesai.
              </p>
              <div className="mt-8 flex flex-col justify-center gap-4 sm:flex-row">
                <HashLink hash="katalog" className="btn-primary">
                  Jelajahi Katalog
                </HashLink>
                <HashLink hash="tentang" className="btn-secondary">
                  Pelajari Lebih Lanjut
                </HashLink>
              </div>
            </div>
          </div>
        </Reveal>
      </div>
    </section>
  );
}
