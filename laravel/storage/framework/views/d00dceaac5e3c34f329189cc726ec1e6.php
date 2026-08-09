<?php $__env->startSection('title', 'Platform'); ?>

<?php $__env->startSection('admin'); ?>
    <div class="page-head">
        <div>
            <span class="eyebrow">Referensi</span>
            <h1>Platform</h1>
        </div>
        <a href="<?php echo e(route('admin.platforms.create')); ?>" class="btn btn--primary">Tambah Platform</a>
    </div>

    <div class="card mt-28">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Jumlah Game</th>
                    <th scope="col"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="table__title"><?php echo e($platform->name); ?></td>
                        <td class="muted"><code><?php echo e($platform->slug); ?></code></td>
                        <td class="muted"><?php echo e($platform->games_count); ?></td>
                        <td>
                            <div class="table__actions">
                                <a href="<?php echo e(route('admin.platforms.edit', $platform)); ?>" class="btn btn--secondary btn--sm">Ubah</a>
                                <form method="POST" action="<?php echo e(route('admin.platforms.destroy', $platform)); ?>" onsubmit="return confirm('Hapus <?php echo e($platform->name); ?>?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn--danger btn--sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4" class="muted">Belum ada data.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php echo e($platforms->links('partials.pagination')); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pp/src/pixelplay/resources/views/admin/platforms/index.blade.php ENDPATH**/ ?>