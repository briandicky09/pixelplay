<?php if($paginator->hasPages()): ?>
    <nav class="pagination" aria-label="Navigasi halaman">
        <?php if($paginator->onFirstPage()): ?>
            <span class="is-disabled">&larr;</span>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev">&larr;</a>
        <?php endif; ?>

        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(is_string($element)): ?>
                <span class="is-disabled"><?php echo e($element); ?></span>
            <?php else: ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span class="is-active" aria-current="page"><?php echo e($page); ?></span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next">&rarr;</a>
        <?php else: ?>
            <span class="is-disabled">&rarr;</span>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH /tmp/pp/src/pixelplay/resources/views/partials/pagination.blade.php ENDPATH**/ ?>