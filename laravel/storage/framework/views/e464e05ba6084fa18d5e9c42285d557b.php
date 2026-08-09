<?php ($isEdit = $game->exists); ?>

<form method="POST" action="<?php echo e($isEdit ? route('admin.games.update', $game) : route('admin.games.store')); ?>" enctype="multipart/form-data" class="stack" style="margin-top:28px">
    <?php echo csrf_field(); ?>
    <?php if($isEdit): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="grid grid--2">
        <div class="card">
            <div class="card__body stack">
                <label class="field">
                    <span class="field__label">Judul</span>
                    <input class="input" type="text" name="title" value="<?php echo e(old('title', $game->title)); ?>" required>
                    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="field">
                    <span class="field__label">Slug <span class="muted">(kosongkan untuk dibuat dari judul)</span></span>
                    <input class="input" type="text" name="slug" value="<?php echo e(old('slug', $game->slug)); ?>">
                    <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="field">
                    <span class="field__label">Kategori</span>
                    <select class="select" name="category_id" required>
                        <option value="">Pilih kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php if((int) old('category_id', $game->category_id) === $category->id): echo 'selected'; endif; ?>><?php echo e($category->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <div class="field">
                    <span class="field__label">Platform</span>
                    <div class="checkgrid">
                        <?php ($selected = collect(old('platforms', $game->platforms->pluck('id')->all()))->map('intval')); ?>
                        <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="checkline">
                                <input type="checkbox" name="platforms[]" value="<?php echo e($platform->id); ?>" <?php if($selected->contains($platform->id)): echo 'checked'; endif; ?>>
                                <span><?php echo e($platform->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['platforms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="grid grid--2" style="gap:16px">
                    <label class="field">
                        <span class="field__label">Harga (Rp)</span>
                        <input class="input" type="number" name="price" min="0" step="1000" value="<?php echo e(old('price', $game->price ?? 0)); ?>" required>
                        <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                    <label class="field">
                        <span class="field__label">Rating</span>
                        <input class="input" type="number" name="rating" min="0" max="5" step="0.1" value="<?php echo e(old('rating', $game->rating ?? 0)); ?>" required>
                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Tanggal rilis</span>
                    <input class="input" type="date" name="released_at" value="<?php echo e(old('released_at', $game->released_at?->toDateString())); ?>" required>
                    <?php $__errorArgs = ['released_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </label>

                <label class="checkline">
                    <input type="checkbox" name="is_featured" value="1" <?php if(old('is_featured', $game->is_featured)): echo 'checked'; endif; ?>>
                    <span>Tampilkan sebagai game unggulan</span>
                </label>
            </div>
        </div>

        <div class="stack">
            <div class="card">
                <div class="card__body stack">
                    <label class="field">
                        <span class="field__label">Deskripsi</span>
                        <textarea class="textarea" name="description" required><?php echo e(old('description', $game->description)); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </label>
                </div>
            </div>

            <div class="card">
                <div class="card__body stack">
                    <span class="field__label">Gambar sampul</span>
                    <?php if($isEdit): ?>
                        <img class="cover" style="border-radius:8px" src="<?php echo e($game->coverUrl()); ?>" alt="Sampul <?php echo e($game->title); ?>">
                    <?php endif; ?>
                    <input class="input" type="file" name="cover" accept="image/jpeg,image/png,image/webp" <?php if(! $isEdit): echo 'required'; endif; ?>>
                    <p class="small muted">JPG, PNG, atau WEBP. Maksimal 4 MB. Disimpan di <code>public/images/games</code>.</p>
                    <?php $__errorArgs = ['cover'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="field__error"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="filters">
        <button type="submit" class="btn btn--primary"><?php echo e($isEdit ? 'Simpan perubahan' : 'Tambah game'); ?></button>
        <a href="<?php echo e(route('admin.games.index')); ?>" class="btn btn--ghost">Batal</a>
    </div>
</form>
<?php /**PATH /tmp/pixelplay/resources/views/admin/games/form.blade.php ENDPATH**/ ?>