<article class="card card--lift">
    <a href="<?php echo e(route('catalog.show', $game)); ?>">
        <img class="cover" src="<?php echo e($game->coverUrl()); ?>" alt="Sampul <?php echo e($game->title); ?>" loading="lazy">
    </a>
    <div class="card__body stack">
        <div class="chips">
            <span class="badge badge--accent"><?php echo e($game->category->name); ?></span>
            <?php if($game->is_featured): ?>
                <span class="badge badge--featured">Unggulan</span>
            <?php endif; ?>
        </div>
        <h3><a href="<?php echo e(route('catalog.show', $game)); ?>"><?php echo e($game->title); ?></a></h3>
        <p class="muted small"><?php echo e(Str::limit(strtok($game->description, "\n"), 110)); ?></p>
        <div class="page-head">
            <span class="price"><?php echo e($game->priceLabel()); ?></span>
            <span class="rating">&#9733; <?php echo e(number_format($game->rating, 1)); ?></span>
        </div>
    </div>
</article>
<?php /**PATH /tmp/pixelplay/resources/views/partials/game-card.blade.php ENDPATH**/ ?>