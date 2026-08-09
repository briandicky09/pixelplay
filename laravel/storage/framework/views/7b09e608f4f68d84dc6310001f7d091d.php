<?php $__env->startSection('body'); ?>
    <div class="admin">
        <aside class="sidebar">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand">
                <img src="<?php echo e(asset('images/logo-icon.png')); ?>" alt="Logo PixelPlay">
                <span>PixelPlay</span>
            </a>

            <nav class="sidebar__nav" aria-label="Navigasi admin">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar__link <?php if(request()->routeIs('admin.dashboard')): ?> is-active <?php endif; ?>" <?php if(request()->routeIs('admin.dashboard')): ?> aria-current="page" <?php endif; ?>>Dasbor</a>
                <a href="<?php echo e(route('admin.games.index')); ?>" class="sidebar__link <?php if(request()->routeIs('admin.games.*')): ?> is-active <?php endif; ?>" <?php if(request()->routeIs('admin.games.*')): ?> aria-current="page" <?php endif; ?>>Game</a>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="sidebar__link <?php if(request()->routeIs('admin.categories.*')): ?> is-active <?php endif; ?>" <?php if(request()->routeIs('admin.categories.*')): ?> aria-current="page" <?php endif; ?>>Kategori</a>
                <a href="<?php echo e(route('admin.platforms.index')); ?>" class="sidebar__link <?php if(request()->routeIs('admin.platforms.*')): ?> is-active <?php endif; ?>" <?php if(request()->routeIs('admin.platforms.*')): ?> aria-current="page" <?php endif; ?>>Platform</a>
            </nav>

            <form method="POST" action="<?php echo e(route('logout')); ?>" class="sidebar__footer">
                <?php echo csrf_field(); ?>
                <p class="small muted">Masuk sebagai <?php echo e(auth()->user()->name); ?></p>
                <button type="submit" class="btn btn--secondary btn--sm btn--block">Keluar</button>
            </form>
        </aside>

        <main class="admin__main">
            <?php if(session('status')): ?>
                <div class="alert alert--success alert--flash" role="status"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert--error alert--flash" role="alert"><?php echo e(session('error')); ?></div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('admin'); ?>
        </main>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pp/src/pixelplay/resources/views/layouts/admin.blade.php ENDPATH**/ ?>