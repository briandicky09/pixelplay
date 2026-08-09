<?php $__env->startSection('title', 'Masuk'); ?>

<?php $__env->startSection('body'); ?>
    <main class="auth">
        <div class="auth__panel">
            <div class="brand brand--centered">
                <img src="<?php echo e(asset('images/logo-icon.png')); ?>" alt="Logo PixelPlay">
                <span>PixelPlay</span>
            </div>

            <div class="card">
                <div class="card__body stack">
                    <div>
                        <span class="eyebrow">Panel administrator</span>
                        <h1 class="auth__title">Masuk ke dasbor</h1>
                        <p class="muted small">Kelola katalog game PixelPlay.</p>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert--error" role="alert"><?php echo e($errors->first()); ?></div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('login')); ?>" class="stack">
                        <?php echo csrf_field(); ?>

                        <label class="field">
                            <span class="field__label">Email</span>
                            <input class="input" type="email" name="email" value="<?php echo e(old('email', \Database\Seeders\AdminUserSeeder::EMAIL)); ?>" required autofocus autocomplete="username">
                        </label>

                        <label class="field">
                            <span class="field__label">Kata sandi</span>
                            <input class="input" type="password" name="password" required autocomplete="current-password">
                        </label>

                        <label class="checkline">
                            <input type="checkbox" name="remember" value="1">
                            <span class="muted">Ingat saya</span>
                        </label>

                        <button type="submit" class="btn btn--primary btn--block">Masuk</button>
                    </form>

                    <div class="demo">
                        <span class="eyebrow">Akun demo administrator</span>
                        <div class="demo__row">
                            <span class="muted small">Email</span>
                            <span class="demo__value"><?php echo e(\Database\Seeders\AdminUserSeeder::EMAIL); ?></span>
                        </div>
                        <div class="demo__row">
                            <span class="muted small">Kata sandi</span>
                            <span class="demo__value"><?php echo e(\Database\Seeders\AdminUserSeeder::PASSWORD); ?></span>
                        </div>
                        <p class="small muted demo__note">
                            Akun ini dibuat otomatis oleh <code>php artisan migrate:fresh --seed</code>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /tmp/pp/src/pixelplay/resources/views/auth/login.blade.php ENDPATH**/ ?>