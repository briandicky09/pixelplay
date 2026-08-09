import { createPortal } from "react-dom";
import { AnimatePresence, motion } from "framer-motion";
import { formatPrice } from "@/data/games";
import { useCart } from "@/context/CartContext";
import { useToast } from "@/context/ToastContext";

type CartDrawerProps = {
  open: boolean;
  onClose: () => void;
};

export function CartDrawer({ open, onClose }: CartDrawerProps) {
  const { items, removeItem, incrementItem, decrementItem, clear, total } = useCart();
  const { showToast } = useToast();

  const handleCheckout = () => {
    if (items.length === 0) return;
    showToast("Checkout demo — pesanan belum benar-benar diproses.");
    clear();
    onClose();
  };

  // Rendered via a portal straight into <body>. The navbar's header uses
  // backdrop-blur (backdrop-filter), which — like transform/filter —
  // creates a new containing block for any `position: fixed` descendant.
  // Without the portal, this panel would be positioned relative to the
  // header's own (small) box instead of the viewport, which is what
  // caused the squashed/overlapping layout.
  return createPortal(
    <AnimatePresence>
      {open && (
        <>
          <motion.div
            key="cart-backdrop"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            exit={{ opacity: 0 }}
            onClick={onClose}
            className="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm"
            aria-hidden="true"
          />
          <motion.aside
            key="cart-panel"
            role="dialog"
            aria-label="Keranjang belanja"
            initial={{ x: "100%" }}
            animate={{ x: 0 }}
            exit={{ x: "100%" }}
            transition={{ duration: 0.3, ease: [0.22, 1, 0.36, 1] }}
            className="fixed inset-y-0 right-0 z-50 flex w-full max-w-md flex-col border-l border-charcoal-700 bg-charcoal-900 shadow-card"
          >
            <div className="flex items-center justify-between border-b border-charcoal-700 px-6 py-5">
              <h2 className="font-display text-lg font-semibold text-white">
                Keranjang{items.length > 0 ? ` (${items.length})` : ""}
              </h2>
              <button
                type="button"
                onClick={onClose}
                aria-label="Tutup keranjang"
                className="flex size-9 items-center justify-center text-slate-400 transition-colors hover:text-white"
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
                  <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <div className="flex-1 overflow-y-auto px-6 py-5">
              {items.length === 0 ? (
                <div className="flex h-full flex-col items-center justify-center gap-3 text-center">
                  <p className="text-sm text-slate-500">Keranjangmu masih kosong.</p>
                  <button type="button" onClick={onClose} className="btn-secondary">
                    Jelajahi Katalog
                  </button>
                </div>
              ) : (
                <ul className="space-y-4">
                  {items.map((item) => (
                    <li
                      key={item.game.id}
                      className="flex gap-3 border border-charcoal-700 bg-charcoal-800/60 p-3"
                    >
                      <img
                        src={item.game.cover}
                        alt={`Cover ${item.game.title}`}
                        className="size-16 shrink-0 object-cover"
                      />
                      <div className="flex flex-1 flex-col">
                        <div className="flex items-start justify-between gap-2">
                          <p className="text-sm font-medium text-white">{item.game.title}</p>
                          <button
                            type="button"
                            onClick={() => removeItem(item.game.id)}
                            aria-label={`Hapus ${item.game.title} dari keranjang`}
                            className="shrink-0 text-xs text-slate-500 transition-colors hover:text-sale-500"
                          >
                            Hapus
                          </button>
                        </div>
                        <p className="mt-0.5 text-xs text-slate-500">
                          {formatPrice(item.game.price)}
                        </p>
                        <div className="mt-auto flex items-center gap-2 pt-2">
                          <button
                            type="button"
                            onClick={() => decrementItem(item.game.id)}
                            aria-label={`Kurangi jumlah ${item.game.title}`}
                            className="flex size-7 items-center justify-center border border-charcoal-600 text-slate-300 transition-colors hover:border-violet-500/60 hover:text-white"
                          >
                            −
                          </button>
                          <span className="min-w-6 text-center text-sm text-slate-300">
                            {item.qty}
                          </span>
                          <button
                            type="button"
                            onClick={() => incrementItem(item.game.id)}
                            aria-label={`Tambah jumlah ${item.game.title}`}
                            className="flex size-7 items-center justify-center border border-charcoal-600 text-slate-300 transition-colors hover:border-violet-500/60 hover:text-white"
                          >
                            +
                          </button>
                        </div>
                      </div>
                    </li>
                  ))}
                </ul>
              )}
            </div>

            {items.length > 0 && (
              <div className="border-t border-charcoal-700 px-6 py-5">
                <div className="flex items-center justify-between text-sm">
                  <span className="text-slate-400">Total</span>
                  <span className="text-lg font-semibold text-white">{formatPrice(total)}</span>
                </div>
                <button
                  type="button"
                  onClick={handleCheckout}
                  className="btn-primary mt-4 w-full justify-center"
                >
                  Checkout
                </button>
              </div>
            )}
          </motion.aside>
        </>
      )}
    </AnimatePresence>,
    document.body,
  );
}
