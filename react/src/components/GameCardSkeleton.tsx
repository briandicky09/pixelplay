export function GameCardSkeleton() {
  return (
    <div className="card-soft h-full animate-pulse" aria-hidden="true">
      <div className="aspect-video w-full bg-charcoal-700/60" />
      <div className="space-y-3 p-5">
        <div className="h-4 w-2/3 bg-charcoal-700/60" />
        <div className="h-3 w-1/3 bg-charcoal-700/50" />
        <div className="flex gap-2 pt-1">
          <div className="h-5 w-16 bg-charcoal-700/40" />
          <div className="h-5 w-20 bg-charcoal-700/40" />
        </div>
        <div className="h-4 w-24 bg-charcoal-700/60" />
      </div>
    </div>
  );
}
