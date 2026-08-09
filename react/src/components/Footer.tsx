import { motion } from "framer-motion";
import { Brand } from "./Brand";
import { HashLink } from "./HashLink";
import { Reveal } from "./Reveal";

const socials = [
  {
    label: "LinkedIn Brian Dicky",
    href: "https://www.linkedin.com/in/briandicky/",
    path: "M4.98 3.5a2.5 2.5 0 11-.02 5 2.5 2.5 0 01.02-5zM3 9h4v12H3zM10 9h3.8v1.71h.05A4.2 4.2 0 0117.6 8.7c3 0 3.9 1.94 3.9 5.05V21h-4v-6.4c0-1.53-.55-2.57-1.9-2.57-1.05 0-1.67.71-1.94 1.4-.1.24-.13.58-.13.92V21h-4z",
  },
  {
    label: "GitHub Brian Dicky",
    href: "https://github.com/briandicky09",
    path: "M12 2a10 10 0 00-3.16 19.49c.5.09.68-.22.68-.48v-1.7c-2.78.6-3.37-1.34-3.37-1.34-.45-1.16-1.11-1.47-1.11-1.47-.91-.62.07-.6.07-.6 1 .07 1.53 1.03 1.53 1.03.89 1.53 2.34 1.09 2.91.83.09-.65.35-1.09.63-1.34-2.22-.25-4.56-1.11-4.56-4.95 0-1.09.39-1.98 1.03-2.68-.1-.25-.45-1.27.1-2.65 0 0 .84-.27 2.75 1.02a9.5 9.5 0 015 0c1.91-1.29 2.75-1.02 2.75-1.02.55 1.38.2 2.4.1 2.65.64.7 1.03 1.59 1.03 2.68 0 3.85-2.35 4.7-4.57 4.95.36.31.68.92.68 1.85v2.74c0 .27.18.58.69.48A10 10 0 0012 2z",
  },
];

const columns = [
  {
    title: "Toko",
    links: [
      { label: "Katalog", hash: "katalog" },
      { label: "Kategori", hash: "kategori" },
      { label: "Diskon & Event", hash: "katalog" },
    ],
  },
  {
    title: "Perusahaan",
    links: [
      { label: "Tentang Kami", hash: "tentang" },
      { label: "Kontak", hash: "footer" },
    ],
  },
];

export function Footer() {
  return (
    <footer id="footer" className="border-t border-charcoal-700/60 bg-charcoal-900/40">
      <Reveal>
        <div className="shell py-14 sm:py-16">
          <div className="flex flex-col gap-10 sm:flex-row sm:items-start sm:justify-between">
            <div className="max-w-sm">
              <Brand size="sm" />
              <p className="mt-4 text-sm leading-relaxed text-slate-500">
                Marketplace digital terkurasi untuk game PC dan konsol — koleksi yang rapi,
                checkout yang cepat.
              </p>
              <ul className="mt-5 flex gap-3">
                {socials.map((social) => (
                  <li key={social.label}>
                    <motion.a
                      href={social.href}
                      target="_blank"
                      rel="noopener noreferrer"
                      aria-label={social.label}
                      whileHover={{ y: -3 }}
                      whileTap={{ scale: 0.94 }}
                      transition={{ type: "spring", stiffness: 400, damping: 24 }}
                      className="flex size-11 items-center justify-center border border-charcoal-600 text-slate-400 transition-colors hover:border-violet-500/60 hover:text-white"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        className="size-5"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        aria-hidden="true"
                      >
                        <path d={social.path} />
                      </svg>
                    </motion.a>
                  </li>
                ))}
              </ul>
            </div>

            <div className="grid grid-cols-2 gap-10 sm:flex sm:gap-16">
              {columns.map((column) => (
                <nav key={column.title} aria-label={column.title}>
                  <h2 className="text-sm font-semibold text-white">{column.title}</h2>
                  <ul className="mt-4 space-y-3">
                    {column.links.map((link) => (
                      <li key={link.label}>
                        <HashLink hash={link.hash} className="text-sm text-slate-500 hover:text-white">
                          {link.label}
                        </HashLink>
                      </li>
                    ))}
                  </ul>
                </nav>
              ))}
            </div>
          </div>

          <div className="mt-12 flex flex-col items-center justify-between gap-4 border-t border-charcoal-700 pt-8 sm:flex-row">
            <p className="text-xs text-slate-600">
              © {new Date().getFullYear()} PixelPlay. Seluruh hak cipta dilindungi.
            </p>
            <HashLink hash="katalog" className="text-xs text-slate-500 hover:text-white">
              Jelajahi katalog →
            </HashLink>
          </div>
        </div>
      </Reveal>
    </footer>
  );
}
