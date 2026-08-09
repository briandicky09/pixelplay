<?php $__env->startSection('title', 'Ubah Game'); ?>

<?php $__env->startSection('admin'); ?>
    <div>
        <span class="eyebrow">Katalog</span>
        <h1>Ubah <?php echo e($game->title); ?></h1>
    </div>

    <?php echo $__env->make('admin.games.form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pp/src/pixelplay/resources/views/admin/games/edit.blade.php ENDPATH**/ ?>