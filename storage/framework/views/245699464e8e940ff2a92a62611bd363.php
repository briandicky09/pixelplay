<?php $__env->startSection('title', 'Game'); ?>

<?php $__env->startSection('admin'); ?>
    <div class="page-head">
        <div>
            <span class="eyebrow">Katalog</span>
            <h1>Game</h1>
        </div>
        <div class="filters">
            <form method="GET" action="<?php echo e(route('admin.games.index')); ?>" class="filters">
                <input class="input" type="search" name="q" value="<?php echo e($q); ?>" placeholder="Cari judul" aria-label="Cari judul game">
                <button type="submit" class="btn btn--secondary">Cari</button>
            </form>
            <a href="<?php echo e(route('admin.games.create')); ?>" class="btn btn--primary">Tambah Game</a>
        </div>
    </div>

    <div class="card mt-28">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Game</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Platform</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Rating</th>
                    <th scope="col"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <span class="table__title">
                                <img class="table__thumb" src="<?php echo e($game->coverUrl()); ?>" alt="">
                                <?php echo e($game->title); ?>

                            </span>
                        </td>
                        <td class="muted"><?php echo e($game->category->name); ?></td>
                        <td class="muted"><?php echo e($game->platforms->pluck('name')->join(', ')); ?></td>
                        <td class="price"><?php echo e($game->priceLabel()); ?></td>
                        <td class="rating">&#9733; <?php echo e(number_format($game->rating, 1)); ?></td>
                        <td>
                            <div class="table__actions">
                                <a href="<?php echo e(route('admin.games.edit', $game)); ?>" class="btn btn--secondary btn--sm">Ubah</a>
                                <form method="POST" action="<?php echo e(route('admin.games.destroy', $game)); ?>" onsubmit="return confirm('Hapus <?php echo e($game->title); ?>?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn--danger btn--sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="muted">Belum ada game yang cocok.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo e($games->links('partials.pagination')); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pp/src/pixelplay/resources/views/admin/games/index.blade.php ENDPATH**/ ?>