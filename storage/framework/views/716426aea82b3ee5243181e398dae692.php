<?php $__env->startSection('title', 'Katalog Game'); ?>

<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="shell stack">
            <span class="eyebrow">Marketplace game digital</span>
            <h1>Katalog PixelPlay</h1>
            <p class="muted" style="max-width:560px">
                Kode digital terverifikasi untuk PC dan konsol. Setiap judul di bawah ini
                berasal langsung dari database dan tersedia melalui REST API.
            </p>

            <form method="GET" action="<?php echo e(route('catalog.index')); ?>" class="filters" style="margin-top:12px">
                <input class="input" type="search" name="q" value="<?php echo e($filters['q'] ?? ''); ?>" placeholder="Cari judul game" aria-label="Cari judul game">

                <select class="select" name="category" aria-label="Filter kategori">
                    <option value="">Semua kategori</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->slug); ?>" <?php if(($filters['category'] ?? null) === $category->slug): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <select class="select" name="platform" aria-label="Filter platform">
                    <option value="">Semua platform</option>
                    <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($platform->slug); ?>" <?php if(($filters['platform'] ?? null) === $platform->slug): echo 'selected'; endif; ?>><?php echo e($platform->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <button type="submit" class="btn btn--primary">Terapkan</button>
                <?php if(array_filter($filters)): ?>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn--ghost">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </section>

    <section class="section">
        <div class="shell">
            <?php if($games->isEmpty()): ?>
                <p class="muted">Tidak ada game yang cocok dengan filter tersebut.</p>
            <?php else: ?>
                <div class="grid grid--3">
                    <?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('partials.game-card', ['game' => $game], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php echo e($games->links('partials.pagination')); ?>

            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pixelplay/resources/views/catalog/index.blade.php ENDPATH**/ ?>