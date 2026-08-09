import { createContext, useContext, useEffect, useMemo, useState } from "react";
import type { ReactNode } from "react";
import { games, type Game } from "@/data/games";

export type CartItem = {
  game: Game;
  qty: number;
};

type CartContextValue = {
  items: CartItem[];
  addItem: (game: Game) => void;
  removeItem: (gameId: string) => void;
  incrementItem: (gameId: string) => void;
  decrementItem: (gameId: string) => void;
  clear: () => void;
  count: number;
  total: number;
};

const CartContext = createContext<CartContextValue | null>(null);
const STORAGE_KEY = "pixelplay-cart";

type StoredItem = { id: string; qty: number };

/**
 * Only ids + quantities are persisted. The game object itself (including
 * its bundled cover URL, which is content-hashed at build time) is always
 * re-read from the catalog, so a new deploy can never leave the cart with
 * broken images or stale prices. Unknown ids are dropped.
 */
function readInitialCart(): CartItem[] {
  if (typeof window === "undefined") return [];
  try {
    const raw = window.localStorage.getItem(STORAGE_KEY);
    if (!raw) return [];
    const parsed: unknown = JSON.parse(raw);
    if (!Array.isArray(parsed)) return [];
    return parsed
      .map((entry) => {
        const stored = entry as Partial<StoredItem> & { game?: { id?: string } };
        const id = stored.id ?? stored.game?.id;
        const game = games.find((item) => item.id === id);
        const qty = Number(stored.qty);
        if (!game || !Number.isFinite(qty) || qty < 1) return null;
        return { game, qty: Math.floor(qty) } as CartItem;
      })
      .filter((item): item is CartItem => item !== null);
  } catch {
    return [];
  }
}

/**
 * Cart state, persisted to localStorage so it survives a refresh. Kept
 * intentionally simple (no checkout/payment integration) — this powers
 * the "Tambah ke Keranjang" button and the cart drawer in the navbar.
 */
export function CartProvider({ children }: { children: ReactNode }) {
  const [items, setItems] = useState<CartItem[]>(readInitialCart);

  useEffect(() => {
    const stored: StoredItem[] = items.map((item) => ({ id: item.game.id, qty: item.qty }));
    try {
      window.localStorage.setItem(STORAGE_KEY, JSON.stringify(stored));
    } catch {
      /* storage full or blocked (private mode) — cart just won't persist */
    }
  }, [items]);

  const addItem = (game: Game) => {
    setItems((current) => {
      const existing = current.find((item) => item.game.id === game.id);
      if (existing) {
        return current.map((item) =>
          item.game.id === game.id ? { ...item, qty: item.qty + 1 } : item,
        );
      }
      return [...current, { game, qty: 1 }];
    });
  };

  const removeItem = (gameId: string) => {
    setItems((current) => current.filter((item) => item.game.id !== gameId));
  };

  const incrementItem = (gameId: string) => {
    setItems((current) =>
      current.map((item) => (item.game.id === gameId ? { ...item, qty: item.qty + 1 } : item)),
    );
  };

  const decrementItem = (gameId: string) => {
    setItems((current) =>
      current
        .map((item) => (item.game.id === gameId ? { ...item, qty: item.qty - 1 } : item))
        .filter((item) => item.qty > 0),
    );
  };

  const clear = () => setItems([]);

  const count = useMemo(() => items.reduce((sum, item) => sum + item.qty, 0), [items]);
  const total = useMemo(
    () => items.reduce((sum, item) => sum + item.game.price * item.qty, 0),
    [items],
  );

  const value: CartContextValue = {
    items,
    addItem,
    removeItem,
    incrementItem,
    decrementItem,
    clear,
    count,
    total,
  };

  return <CartContext.Provider value={value}>{children}</CartContext.Provider>;
}

export function useCart() {
  const context = useContext(CartContext);
  if (!context) throw new Error("useCart must be used within a CartProvider");
  return context;
}
