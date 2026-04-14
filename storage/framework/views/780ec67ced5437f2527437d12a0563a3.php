<?php $__env->startSection('title', 'Pinjaman Saya'); ?>
<?php $__env->startSection('page-title', 'Koleksi Aktif'); ?>
<?php $__env->startSection('page-subtitle', 'Daftar buku yang sedang Anda pinjam saat ini'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">

    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-200 pb-8 mb-8">
        <div>
            <div class="flex items-center gap-2 text-[#00bcd4] font-bold text-[10px] uppercase tracking-[0.3em] mb-2">
                <span class="w-8 h-[2px] bg-[#00bcd4] rounded-full"></span>
                Sirkulasi Aktif
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Pinjaman Saya</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium italic">Anda sedang mengelola <?php echo e($loans->total()); ?> koleksi aktif.</p>
        </div>
    </div>

    <?php if($loans->count()): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-slate-100 dark:border-dark-border/20 p-6 flex gap-6 transition-all hover:shadow-xl group">
            <div class="w-24 h-32 flex-shrink-0 rounded-xl overflow-hidden shadow-lg transform group-hover:scale-105 transition-transform">
                <?php if($loan->book->cover): ?>
                    <img src="<?php echo e(asset('storage/'.$loan->book->cover)); ?>" alt="" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="w-full h-full bg-slate-100 dark:bg-dark flex items-center justify-center text-slate-300">
                        <i class="fas fa-book text-3xl"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="flex-1 flex flex-col">
                <div class="mb-auto">
                    <span class="text-[9px] font-black uppercase tracking-widest mb-1 block" style="color: <?php echo e($loan->book->category->color); ?>">
                        <?php echo e($loan->book->category->name); ?>

                    </span>
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-tight line-clamp-2 leading-tight mb-1"><?php echo e($loan->book->title); ?></h3>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 italic"><?php echo e($loan->book->author); ?></p>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-50 dark:border-dark-border/10 space-y-2">
                    <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                        <span class="text-slate-400">Pinjam:</span>
                        <span class="text-slate-700 dark:text-gray-300"><?php echo e($loan->tgl_pinjam->format('d M Y')); ?></span>
                    </div>
                    <div class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest">
                        <span class="text-slate-400">Batas:</span>
                        <span class="<?php echo e($loan->isOverdue() ? 'text-red-500 animate-pulse' : 'text-primary-500'); ?>">
                            <?php echo e($loan->tgl_kembali->format('d M Y')); ?>

                        </span>
                    </div>
                    
                    <?php if($loan->status === 'pending'): ?>
                    <div class="mt-2 bg-amber-50 text-amber-600 py-1.5 px-3 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-2 border border-amber-100">
                        <i class="fas fa-hourglass-half"></i> Menunggu Konfirmasi Petugas
                    </div>
                    <?php elseif($loan->isOverdue()): ?>
                    <div class="mt-2 bg-rose-50 text-rose-600 py-1.5 px-3 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-2 border border-rose-100">
                        <i class="fas fa-clock"></i> Terlambat <?php echo e($loan->getDaysOverdue()); ?> Hari
                    </div>
                    <?php else: ?>
                    <div class="mt-2 bg-emerald-50 text-emerald-600 py-1.5 px-3 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-2 border border-emerald-100">
                        <i class="fas fa-calendar-check"></i> Sisa <?php echo e(\Carbon\Carbon::today()->diffInDays($loan->tgl_kembali)); ?> Hari
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-8">
        <?php echo e($loans->links()); ?>

    </div>
    <?php else: ?>
    <div class="bg-white dark:bg-dark-card rounded-3xl py-24 text-center border border-slate-100 dark:border-dark-border/20 shadow-sm">
        <div class="w-20 h-20 bg-slate-50 dark:bg-dark rounded-3xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-clipboard-check text-slate-200 text-4xl"></i>
        </div>
        <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-2">Zero Active Loans</h3>
        <p class="text-[10px] font-bold text-slate-400 italic mb-8">Anda tidak memiliki buku yang sedang dipinjam saat ini.</p>
        <a href="<?php echo e(route('user.books.index')); ?>" class="inline-flex items-center gap-3 bg-primary-600 hover:bg-primary-700 text-white px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition shadow-lg shadow-primary-900/40 active:scale-95">
            <i class="fas fa-search"></i> Telusuri Katalog
        </a>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/user/loans/active.blade.php ENDPATH**/ ?>