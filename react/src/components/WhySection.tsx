import { Reveal } from "./Reveal";

const benefits = [
  {
    title: "Pengiriman Instan",
    body: "Kode game langsung masuk ke akunmu begitu pembayaran selesai — tanpa menunggu email konfirmasi atau verifikasi manual.",
    tone: "violet",
    path: "M13 10V3L4 14h7v7l9-11h-7z",
  },
  {
    title: "Pembayaran Aman",
    body: "Setiap transaksi diproses lewat sistem pembayaran terenkripsi, dan setiap kode bersumber dari publisher serta distributor resmi.",
    tone: "emerald",
    path: "M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z",
  },
  {
    title: "Koleksi Terkurasi",
    body: "Setiap listing ditinjau sebelum ditambahkan — tanpa shovelware atau duplikat, hanya game yang layak menghuni koleksimu.",
    tone: "violet",
    path: "M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10",
  },
] as const;

export function WhySection() {
  return (
    <section id="tentang" className="border-t border-charcoal-700/60 py-20 sm:py-24">
      <div className="shell">
        <Reveal>
          <div className="mb-10 max-w-2xl">
            <span className="eyebrow">Mengapa PixelPlay</span>
            <h2 className="section-heading mt-2">Dibuat untuk kamu yang cuma ingin main</h2>
          </div>
        </Reveal>

        <ul className="grid gap-6 sm:grid-cols-3">
          {benefits.map((benefit, index) => (
            <li key={benefit.title}>
              <Reveal index={index} className="h-full">
                <div className="card h-full p-8">
                  <div
                    className={`mb-5 flex size-11 items-center justify-center ${
                      benefit.tone === "emerald"
                        ? "bg-emerald-500/15 text-emerald-400"
                        : "bg-violet-500/15 text-violet-400"
                    }`}
                    aria-hidden="true"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="size-5"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      strokeWidth={1.8}
                    >
                      <path strokeLinecap="round" strokeLinejoin="round" d={benefit.path} />
                    </svg>
                  </div>
                  <h3 className="font-display text-lg font-semibold text-white">{benefit.title}</h3>
                  <p className="mt-2 text-sm leading-relaxed text-slate-400">{benefit.body}</p>
                </div>
              </Reveal>
            </li>
          ))}
        </ul>
      </div>
    </section>
  );
}
