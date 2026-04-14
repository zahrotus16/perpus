<?php $__env->startSection('title', 'Detail Pinjaman'); ?>
<?php $__env->startSection('page-title', 'Informasi Transaksi'); ?>
<?php $__env->startSection('page-subtitle', 'Rincian administratif peminjaman buku'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto space-y-6">

    <a href="<?php echo e(route('user.loans.index')); ?>" class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition font-bold uppercase tracking-widest text-[10px]">
        <i class="fas fa-arrow-left"></i> Kembali ke Pusat Pinjaman
    </a>

    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-xl dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
        
        <div class="p-8 border-b border-slate-100 bg-[#aab7c4]/10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1.5">ID Transaksi / Kode</p>
                    <p class="font-mono font-black text-slate-800 text-2xl tracking-tighter"><?php echo e($loan->kode_peminjaman); ?></p>
                </div>
                <div class="flex flex-col items-center md:items-end">
                    <span class="px-5 py-2 whitespace-nowrap rounded-lg text-[11px] font-black uppercase tracking-widest shadow-sm ring-1 ring-inset
                        <?php echo e($loan->status === 'dipinjam' ? 'bg-[#00b4ff] text-white ring-[#00b4ff]/20' :
                          ($loan->status === 'dikembalikan' ? 'bg-[#2e7d32] text-white ring-[#2e7d32]/20' : 'bg-[#d32f2f] text-white ring-[#d32f2f]/20')); ?>">
                        <?php echo e($loan->status === 'dipinjam' ? 'Aktif' : ($loan->status === 'dikembalikan' ? 'Arsip' : 'Terlambat')); ?>

                    </span>
                    <span class="text-[9px] font-bold text-slate-400 mt-2 uppercase tracking-widest">Status Terkini</span>
                </div>
            </div>
        </div>

        
        <div class="p-8 flex gap-8 items-center border-b border-slate-50 dark:border-dark-border/10">
            <div class="flex-shrink-0 w-20 shadow-lg dark:shadow-dark-soft rounded-xl overflow-hidden ring-1 ring-slate-100 dark:ring-dark-border/10">
                <?php if($loan->book->cover): ?>
                    <img src="<?php echo e(asset('storage/'.$loan->book->cover)); ?>" alt="" class="w-full aspect-[3/4] object-cover">
                <?php else: ?>
                    <div class="w-full aspect-[3/4] flex items-center justify-center bg-slate-100 dark:bg-dark">
                        <i class="fas fa-book text-slate-300 dark:text-gray-700 text-3xl"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="min-w-0">
                <span class="inline-block px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest mb-2" style="background:<?php echo e($loan->book->category->color); ?>15; color:<?php echo e($loan->book->category->color); ?>">
                    <?php echo e($loan->book->category->name); ?>

                </span>
                <h3 class="text-xl font-black text-slate-800 dark:text-white truncate leading-tight mb-1"><?php echo e($loan->book->title); ?></h3>
                <p class="text-slate-500 dark:text-gray-400 font-bold italic text-sm"><?php echo e($loan->book->author); ?></p>
            </div>
        </div>

        
        <div class="p-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-gray-600 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i class="fas fa-calendar-check text-primary-500/50"></i> Terbit Pinjam
                    </p>
                    <p class="text-sm font-black text-slate-800 dark:text-white"><?php echo e($loan->tgl_pinjam->translatedFormat('d F Y')); ?></p>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-gray-600 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i class="fas fa-calendar-times text-red-500/50"></i> Jatuh Tempo
                    </p>
                    <p class="text-sm font-black <?php echo e($loan->isOverdue() ? 'text-red-600 dark:text-red-400' : 'text-slate-800 dark:text-white'); ?>">
                        <?php echo e($loan->tgl_kembali->translatedFormat('d F Y')); ?>

                    </p>
                </div>
                <?php if($loan->pengembalian): ?>
                <div>
                    <p class="text-[10px] font-black text-slate-400 dark:text-gray-600 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <i class="fas fa-calendar-day text-emerald-500/50"></i> Waktu Pengembalian
                    </p>
                    <p class="text-sm font-black text-emerald-600 dark:text-emerald-400"><?php echo e($loan->pengembalian->tgl_dikembalikan->translatedFormat('d F Y')); ?></p>
                </div>
                <?php endif; ?>
            </div>

            
            <?php if($loan->isOverdue()): ?>
            <div class="p-5 bg-red-50 dark:bg-red-950/20 rounded-2xl border border-red-100 dark:border-red-900/30 flex items-start gap-4">
                <i class="fas fa-triangle-exclamation text-red-600 dark:text-red-400 text-xl mt-1"></i>
                <div class="flex-1">
                    <p class="text-[11px] font-black text-red-700 dark:text-red-400 uppercase tracking-widest mb-1">Peringatan Keterlambatan</p>
                    <p class="text-xs text-red-600 dark:text-red-400 font-bold leading-relaxed">
                        Masa pinjaman telah terlampaui selama <span class="bg-red-600 text-white px-2 py-0.5 rounded-lg mx-1"><?php echo e($loan->getDaysOverdue()); ?> hari</span>. Mohon segera mengembalikan koleksi ini ke perpustakaan pusat untuk menghindari penalti tambahan.
                    </p>
                </div>
            </div>
            <?php endif; ?>

            <?php $fine = $loan->pengembalian->denda ?? $loan->calculateFine(); ?>
            <?php if($fine > 0): ?>
            <div class="p-5 bg-slate-900 dark:bg-dark border border-slate-800 rounded-2xl flex items-center justify-between shadow-xl">
                <div class="flex items-center gap-4">
                    <i class="fas fa-receipt text-amber-500 text-2xl"></i>
                    <div>
                        <p class="text-[9px] font-black text-slate-500 dark:text-gray-500 uppercase tracking-widest mb-0.5 font-mono">Total Penalty Unpaid</p>
                        <p class="text-lg font-black text-white leading-none">Rp <?php echo e(number_format($fine,0,',','.')); ?></p>
                    </div>
                </div>
                <div class="flex flex-col items-end">
                    <span class="text-[9px] font-black text-amber-500 uppercase tracking-widest italic">Fine Issued</span>
                </div>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="px-8 pb-8 pt-4 flex gap-4">
            <?php if($loan->book->pdf_file && $loan->status !== 'dikembalikan'): ?>
            <a href="<?php echo e(route('user.books.read', $loan->book)); ?>"
               class="flex-1 flex items-center justify-center gap-3 bg-[#00b4ff] hover:bg-[#0096d6] text-white py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition shadow-lg active:scale-95">
                <i class="fas fa-book-reader text-lg"></i> Mulai Membaca
            </a>
            <?php endif; ?>
            <a href="<?php echo e(route('user.books.show', $loan->book)); ?>"
               class="flex-1 flex items-center justify-center gap-3 bg-slate-50 dark:bg-white/5 border border-slate-100 dark:border-dark-border/10 hover:bg-slate-100 dark:hover:bg-white/10 text-slate-800 dark:text-white py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition active:scale-95">
                <i class="fas fa-search-plus"></i> Profil Buku
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/user/loans/show.blade.php ENDPATH**/ ?>