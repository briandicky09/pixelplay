import { useEffect, useState } from "react";
import type { FormEvent } from "react";
import { useNavigate } from "react-router-dom";
import { AnimatePresence, motion } from "framer-motion";
import { Brand } from "./Brand";
import { HashLink } from "./HashLink";
import { CartDrawer } from "./CartDrawer";
import { useCart } from "@/context/CartContext";
import { useToast } from "@/context/ToastContext";

const links = [
  { label: "Beranda", hash: "" },
  { label: "Katalog", hash: "katalog" },
  { label: "Kategori", hash: "kategori" },
  { label: "Tentang", hash: "tentang" },
  { label: "Kontak", hash: "footer" },
] as const;

export function Navbar() {
  const navigate = useNavigate();
  const { count } = useCart();
  const { showToast } = useToast();
  const [scrolled, setScrolled] = useState(false);
  const [open, setOpen] = useState(false);
  const [searchOpen, setSearchOpen] = useState(false);
  const [cartOpen, setCartOpen] = useState(false);
  const [query, setQuery] = useState("");

  const handleLogin = () => {
    setOpen(false);
    showToast("Fitur login akan segera hadir — coming soon!");
  };

  const runSearch = (event: FormEvent) => {
    event.preventDefault();
    const trimmed = query.trim();
    navigate(`/?q=${encodeURIComponent(trimmed)}#katalog`);
    setSearchOpen(false);
    setOpen(false);
    window.setTimeout(() => {
      document.getElementById("katalog")?.scrollIntoView({ behavior: "smooth", block: "start" });
    }, 60);
  };

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 8);
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
    return () => window.removeEventListener("scroll", onScroll);
  }, []);

  // Lock body scroll while the mobile sheet is open.
  useEffect(() => {
    document.body.style.overflow = open ? "hidden" : "";
    return () => {
      document.body.style.overflow = "";
    };
  }, [open]);

  return (
    <header
      className={`fixed inset-x-0 top-0 z-50 border-b bg-charcoal-950/85 backdrop-blur-md transition-all duration-300 ${
        scrolled ? "border-charcoal-700 shadow-card" : "border-transparent"
      }`}
    >
      <nav className="shell flex h-16 items-center justify-between" aria-label="Navigasi utama">
        <Brand />

        <ul className="hidden items-center gap-8 md:flex">
          {links.map((link) => (
            <li key={link.label}>
              <HashLink hash={link.hash} className="nav-link">
                {link.label}
              </HashLink>
            </li>
          ))}
        </ul>

        <div className="hidden items-center gap-3 md:flex">
          <div className="relative flex items-center">
            <AnimatePresence>
              {searchOpen && (
                <motion.form
                  key="navSearch"
                  onSubmit={runSearch}
                  initial={{ width: 0, opacity: 0 }}
                  animate={{ width: 220, opacity: 1 }}
                  exit={{ width: 0, opacity: 0 }}
                  transition={{ duration: 0.25, ease: [0.22, 1, 0.36, 1] }}
                  className="overflow-hidden"
                >
                  <input
                    type="search"
                    value={query}
                    onChange={(event) => setQuery(event.target.value)}
                    placeholder="Cari game..."
                    autoFocus
                    className="field h-11 w-[220px]"
                    onBlur={() => {
                      if (!query) setSearchOpen(false);
                    }}
                  />
                </motion.form>
              )}
            </AnimatePresence>
            <button
              type="button"
              aria-label="Cari game"
              onClick={() => setSearchOpen((value) => !value)}
              className="flex size-11 shrink-0 items-center justify-center text-slate-300 transition-colors hover:text-white"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                className="size-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                strokeWidth={1.8}
                aria-hidden="true"
              >
                <circle cx="11" cy="11" r="7" strokeLinecap="round" />
                <path strokeLinecap="round" d="M20 20l-4-4" />
              </svg>
            </button>
          </div>
          <button type="button" onClick={handleLogin} className="btn-ghost">
            Masuk
          </button>
          <button
            type="button"
            onClick={() => setCartOpen(true)}
            aria-label={`Buka keranjang${count > 0 ? `, ${count} item` : ""}`}
            className="relative flex size-11 items-center justify-center text-slate-300 transition-colors hover:text-white"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="size-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth={1.8}
              aria-hidden="true"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M3 3h2l.4 2M7 13h10l3.6-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 006 17h12M9 21a1 1 0 100-2 1 1 0 000 2zM20 21a1 1 0 100-2 1 1 0 000 2z"
              />
            </svg>
            {count > 0 && (
              <span className="absolute -right-0.5 -top-0.5 flex size-4.5 items-center justify-center bg-violet-500 text-[10px] font-semibold text-white">
                {count > 9 ? "9+" : count}
              </span>
            )}
          </button>
          <HashLink hash="katalog" className="btn-primary">
            Jelajahi Game
          </HashLink>
        </div>

        <div className="flex items-center gap-1 md:hidden">
          <button
            type="button"
            onClick={() => setCartOpen(true)}
            aria-label={`Buka keranjang${count > 0 ? `, ${count} item` : ""}`}
            className="relative flex size-11 items-center justify-center text-slate-300 transition-colors hover:text-white"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="size-5"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth={1.8}
              aria-hidden="true"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d="M3 3h2l.4 2M7 13h10l3.6-8H5.4M7 13L5.4 5M7 13l-2.293 2.293A1 1 0 006 17h12M9 21a1 1 0 100-2 1 1 0 000 2zM20 21a1 1 0 100-2 1 1 0 000 2z"
              />
            </svg>
            {count > 0 && (
              <span className="absolute -right-0.5 -top-0.5 flex size-4.5 items-center justify-center bg-violet-500 text-[10px] font-semibold text-white">
                {count > 9 ? "9+" : count}
              </span>
            )}
          </button>
          <button
            type="button"
            aria-label={open ? "Tutup menu" : "Buka menu"}
            aria-expanded={open}
            aria-controls="mobileMenu"
            onClick={() => setOpen((value) => !value)}
            className="flex size-11 items-center justify-center text-slate-300 transition-colors hover:text-white"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="size-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth={1.8}
              aria-hidden="true"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                d={open ? "M6 18L18 6M6 6l12 12" : "M4 6h16M4 12h16M4 18h16"}
              />
            </svg>
          </button>
        </div>
      </nav>

      <AnimatePresence initial={false}>
        {open && (
          <motion.div
            id="mobileMenu"
            key="mobileMenu"
            initial={{ height: 0, opacity: 0 }}
            animate={{ height: "auto", opacity: 1 }}
            exit={{ height: 0, opacity: 0 }}
            transition={{ duration: 0.25, ease: [0.22, 1, 0.36, 1] }}
            className="overflow-hidden border-t border-charcoal-700 bg-charcoal-950 md:hidden"
          >
            <div className="space-y-4 px-6 py-6">
              <form onSubmit={runSearch} className="relative">
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
                  type="search"
                  value={query}
                  onChange={(event) => setQuery(event.target.value)}
                  placeholder="Cari game..."
                  className="field pl-11"
                />
              </form>
              {links.map((link) => (
                <HashLink
                  key={link.label}
                  hash={link.hash}
                  onClick={() => setOpen(false)}
                  className="nav-link block py-1"
                >
                  {link.label}
                </HashLink>
              ))}
              <div className="flex gap-3 pt-3">
                <button type="button" onClick={handleLogin} className="btn-secondary flex-1">
                  Masuk
                </button>
                <HashLink hash="katalog" onClick={() => setOpen(false)} className="btn-primary flex-1">
                  Jelajahi
                </HashLink>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
      <CartDrawer open={cartOpen} onClose={() => setCartOpen(false)} />
    </header>
  );
}
