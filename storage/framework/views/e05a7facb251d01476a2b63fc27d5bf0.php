<?php $__env->startSection('title', $game->title); ?>
<?php $__env->startSection('meta_description', Str::limit(strtok($game->description, "\n"), 150)); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <div class="shell">
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn--ghost" style="padding-left:0">&larr; Kembali ke katalog</a>

            <div class="grid grid--2" style="margin-top:20px; align-items:start">
                <img class="card cover" style="aspect-ratio:16/10" src="<?php echo e($game->coverUrl()); ?>" alt="Sampul <?php echo e($game->title); ?>">

                <div class="stack">
                    <div class="chips">
                        <span class="badge badge--accent"><?php echo e($game->category->name); ?></span>
                        <?php if($game->is_featured): ?>
                            <span class="badge badge--featured">Unggulan</span>
                        <?php endif; ?>
                    </div>
                    <h1><?php echo e($game->title); ?></h1>
                    <div class="page-head">
                        <span class="price" style="font-size:1.4rem"><?php echo e($game->priceLabel()); ?></span>
                        <span class="rating">&#9733; <?php echo e(number_format($game->rating, 1)); ?> / 5.0</span>
                    </div>

                    <?php $__currentLoopData = array_filter(explode("\n", $game->description)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paragraph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="muted"><?php echo e($paragraph); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div>
                        <p class="small muted" style="margin-bottom:8px">Platform</p>
                        <div class="chips">
                            <?php $__currentLoopData = $game->platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge"><?php echo e($platform->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <p class="small muted">Rilis <?php echo e($game->released_at->translatedFormat('d F Y')); ?></p>
                </div>
            </div>

            <?php if($related->isNotEmpty()): ?>
                <div style="margin-top:56px">
                    <h2>Game <?php echo e($game->category->name); ?> lainnya</h2>
                    <div class="grid grid--3" style="margin-top:20px">
                        <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo $__env->make('partials.game-card', ['game' => $item], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pixelplay/resources/views/catalog/show.blade.php ENDPATH**/ ?>