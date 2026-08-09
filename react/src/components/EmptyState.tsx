import { motion } from "framer-motion";

type EmptyStateProps = {
  onReset: () => void;
};

export function EmptyState({ onReset }: EmptyStateProps) {
  return (
    <motion.div
      initial={{ opacity: 0, y: 12 }}
      animate={{ opacity: 1, y: 0 }}
      transition={{ duration: 0.4, ease: [0.22, 1, 0.36, 1] }}
      className="col-span-full flex flex-col items-center gap-5 border border-dashed border-charcoal-700 bg-charcoal-900/40 px-6 py-16 text-center"
    >
      <motion.div
        animate={{ y: [0, -6, 0] }}
        transition={{ duration: 2.4, repeat: Infinity, ease: "easeInOut" }}
        className="flex size-14 items-center justify-center bg-violet-500/15 text-violet-400"
        aria-hidden="true"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          className="size-6"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          strokeWidth={1.6}
        >
          <circle cx="11" cy="11" r="7" strokeLinecap="round" />
          <path strokeLinecap="round" d="M20 20l-4-4" />
        </svg>
      </motion.div>
      <div>
        <h3 className="font-display text-lg font-semibold text-white">Tidak ada game yang cocok</h3>
        <p className="mx-auto mt-2 max-w-sm text-sm text-slate-400">
          Coba kata kunci lain, atau atur ulang filter untuk melihat seluruh katalog.
        </p>
      </div>
      <button type="button" onClick={onReset} className="btn-secondary">
        Atur Ulang Filter
      </button>
    </motion.div>
  );
}
