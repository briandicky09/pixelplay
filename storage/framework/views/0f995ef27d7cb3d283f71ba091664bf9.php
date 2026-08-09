<?php $__env->startSection('body'); ?>
    <header class="navbar">
        <div class="shell navbar__inner">
            <a href="<?php echo e(route('catalog.index')); ?>" class="brand">
                <img src="<?php echo e(asset('images/logo-icon.png')); ?>" alt="Logo PixelPlay">
                <span>PixelPlay</span>
            </a>
            <nav class="navlinks" aria-label="Navigasi utama">
                <a href="<?php echo e(route('catalog.index')); ?>" class="navlink" <?php if(request()->routeIs('catalog.*')): ?> aria-current="page" <?php endif; ?>>Katalog</a>
                <a href="<?php echo e(url('/api/games')); ?>" class="navlink">API</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn--secondary btn--sm">Dasbor</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn--primary btn--sm">Masuk</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <?php echo $__env->yieldContent('content'); ?>

    <footer class="footer">
        <div class="shell footer__inner">
            <span>&copy; <?php echo e(now()->year); ?> PixelPlay. Marketplace game digital.</span>
            <span>REST API tersedia di <code>/api/games</code></span>
        </div>
    </footer>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pixelplay/resources/views/layouts/app.blade.php ENDPATH**/ ?>