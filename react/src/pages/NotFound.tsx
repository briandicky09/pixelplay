import { useEffect } from "react";
import { HashLink } from "@/components/HashLink";

export default function NotFoundPage() {
  useEffect(() => {
    document.title = "Halaman tidak ditemukan — PixelPlay";
  }, []);

  return (
    <div className="flex min-h-screen items-center justify-center bg-charcoal-950 px-4">
      <div className="max-w-md text-center">
        <span className="eyebrow">404</span>
        <h1 className="section-heading mt-3">Halaman tidak ditemukan</h1>
        <p className="mx-auto mt-3 max-w-md text-slate-400">
          Halaman atau game yang kamu cari tidak ada di PixelPlay.
        </p>
        <HashLink hash="katalog" className="btn-primary mt-8">
          Lihat katalog
        </HashLink>
      </div>
    </div>
  );
}
