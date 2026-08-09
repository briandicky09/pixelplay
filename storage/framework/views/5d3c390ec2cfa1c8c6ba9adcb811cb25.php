<?php $__env->startSection('title', 'Dasbor'); ?>

<?php $__env->startSection('admin'); ?>
    <div class="page-head">
        <div>
            <span class="eyebrow">Ringkasan</span>
            <h1>Dasbor</h1>
        </div>
        <a href="<?php echo e(route('admin.games.create')); ?>" class="btn btn--primary">Tambah Game</a>
    </div>

    <div class="grid grid--4 mt-28">
        <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <div class="card__body">
                    <p class="stat__label"><?php echo e($label); ?></p>
                    <p class="stat__value"><?php echo e($value); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <h2 class="mt-44">Game terbaru</h2>
    <div class="card mt-16">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Game</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Rating</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $latest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <span class="table__title">
                                <img class="table__thumb" src="<?php echo e($game->coverUrl()); ?>" alt="">
                                <?php echo e($game->title); ?>

                            </span>
                        </td>
                        <td class="muted"><?php echo e($game->category->name); ?></td>
                        <td class="price"><?php echo e($game->priceLabel()); ?></td>
                        <td class="rating">&#9733; <?php echo e(number_format($game->rating, 1)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="muted">Belum ada game. Jalankan <code>php artisan migrate:fresh --seed</code>.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pp/src/pixelplay/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>