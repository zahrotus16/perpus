<?php $__env->startSection('title', 'Edit Buku'); ?>
<?php $__env->startSection('page-title', 'Edit Buku'); ?>
<?php $__env->startSection('page-subtitle', $book->title); ?>


<?php $__env->startSection('navbar-actions'); ?>
<a href="<?php echo e(route('admin.books.index')); ?>" class="flex items-center gap-2 text-slate-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 px-4 py-2 rounded-xl text-sm font-bold border border-slate-200 dark:border-dark-border/20 hover:bg-slate-50 dark:hover:bg-white/5 transition uppercase tracking-widest text-[10px]">
    <i class="fas fa-arrow-left"></i> Kembali
</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin.books.create', ['book' => $book], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/books/edit.blade.php ENDPATH**/ ?>