<?php $__env->startSection('title', 'Laporan Sirkulasi'); ?>
<?php $__env->startSection('page-title', 'Laporan Riwayat Sirkulasi'); ?>
<?php $__env->startSection('page-subtitle', 'Rekapitulasi data peminjaman dan pengembalian koleksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Dashboard Laporan Sirkulasi</h2>
        </div>
        <div class="flex gap-3 no-print">
            <button onclick="window.print()" class="flex items-center justify-center gap-3 bg-slate-800 hover:bg-slate-900 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-xl active:scale-95">
                <i class="fas fa-print text-sm"></i> Cetak Laporan
            </button>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 no-print">
        <form action="<?php echo e(request()->url()); ?>" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
            <div class="relative w-full md:flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       placeholder="Cari laporan berdasarkan nama anggota atau judul buku..."
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:border-[#00bcd4] focus:ring-4 focus:ring-[#00bcd4]/10 transition-all outline-none">
            </div>
            <button type="submit" class="w-full md:w-auto px-10 py-3 bg-[#00bcd4] hover:bg-[#0097a7] text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition shadow-lg active:scale-95">
                Filtrasi Laporan
            </button>
        </form>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Identitas Anggota</th>
                        <th class="px-4 py-5">Koleksi Terkait</th>
                        <th class="px-4 py-5 text-center">Tgl Pinjam</th>
                        <th class="px-4 py-5 text-center">Estimasi Kembali</th>
                        <th class="px-4 py-5 text-center">Tgl Realisasi</th>
                        <th class="px-4 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Denda Terbit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium whitespace-nowrap">
                    <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200 overflow-hidden shrink-0">
                                    <span class="text-[10px] font-bold"><?php echo e(strtoupper(substr($loan->user->name ?? '?', 0, 1))); ?></span>
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-slate-800 block leading-none"><?php echo e($loan->user->name ?? 'Anonim'); ?></span>
                                    <span class="text-[9px] text-slate-400 font-bold uppercase mt-1 block tracking-wider"><?php echo e($loan->user->member_id ?? '-'); ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="max-w-[220px]">
                                <span class="text-xs text-slate-800 block leading-tight truncate font-bold"><?php echo e($loan->book->title ?? 'Buku Tidak Ditemukan'); ?></span>
                                <span class="text-[9px] text-slate-400 font-bold uppercase mt-0.5 block"><?php echo e($loan->book->author ?? '-'); ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-[11px] text-slate-600 font-mono">
                                <?php echo e($loan->tgl_pinjam ? $loan->tgl_pinjam->format('d/m/Y') : '-'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-[11px] text-slate-600 font-mono">
                                <?php echo e($loan->tgl_kembali ? $loan->tgl_kembali->format('d/m/Y') : '-'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-[11px] <?php echo e(($loan->pengembalian && $loan->pengembalian->tgl_dikembalikan) ? 'text-slate-600' : 'text-slate-300 italic'); ?> font-mono">
                                <?php echo e(($loan->pengembalian && $loan->pengembalian->tgl_dikembalikan) ? \Carbon\Carbon::parse($loan->pengembalian->tgl_dikembalikan)->format('d/m/Y') : 'Belum Kembali'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <?php if($loan->status === 'dikembalikan' || $loan->status === 'returned'): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 text-[8px] font-black uppercase tracking-tighter">Selesai</span>
                            <?php elseif($loan->isOverdue()): ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-50 text-red-600 border border-red-100 text-[8px] font-black uppercase tracking-tighter">Terlambat</span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-sky-50 text-sky-600 border border-sky-100 text-[8px] font-black uppercase tracking-tighter">Berjalan</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <span class="text-xs font-black <?php echo e($loan->calculateFine() > 0 ? 'text-red-500' : 'text-slate-400'); ?>">
                                Rp <?php echo e(number_format($loan->calculateFine(), 0, ',', '.')); ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-8 py-20 text-center text-slate-400 font-bold italic text-sm">Laporan tidak tersedia...</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if($loans->hasPages()): ?>
        <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30 no-print">
            <?php echo e($loans->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/loans/reports.blade.php ENDPATH**/ ?>