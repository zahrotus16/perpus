<?php $__env->startSection('title', request()->routeIs('admin.loans.returns') ? 'Pengembalian' : 'Peminjaman'); ?>
<?php $__env->startSection('page-title', auth()->user()->role === 'admin' ? 'Laporan Riwayat Sirkulasi' : (request()->routeIs('admin.loans.returns') ? 'Pengembalian' : 'Manajemen Peminjaman')); ?>
<?php $__env->startSection('page-subtitle', auth()->user()->role === 'admin' ? 'Monitoring sirkulasi buku perpustakaan' : 'Pantau dan kelola sirkulasi buku perpustakaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">
                <?php if(auth()->user()->role === 'admin'): ?>
                Laporan Transaksi Perpustakaan
                <?php else: ?>
                <?php echo e(request()->routeIs('admin.loans.returns') ? 'Log Sirkulasi Selesai' : 'Log Sirkulasi Aktif'); ?>

                <?php endif; ?>
            </h2>
        </div>
    </div>

    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <form action="<?php echo e(request()->url()); ?>" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
            <div class="relative w-full md:flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="<?php echo e(request()->routeIs('admin.loans.returns') ? 'Cari data pengembalian...' : 'Cari nama anggota atau judul buku...'); ?>"
                    class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
            </div>
            <button type="submit" class="w-full md:w-auto px-10 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition shadow-lg shadow-emerald-900/20 active:scale-95">
                Cari Transaksi
            </button>
        </form>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Anggota</th>
                        <th class="px-4 py-5">Buku Dipinjam</th>
                        <th class="px-4 py-5 text-center">Tgl Pinjam</th>
                        <th class="px-4 py-5 text-center">Batas Kembali</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium whitespace-nowrap">
                    <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200 overflow-hidden shrink-0">
                                    <?php if($loan->user->avatar): ?>
                                    <img src="<?php echo e(asset('storage/' . $loan->user->avatar)); ?>" alt="" class="w-full h-full object-cover">
                                    <?php else: ?>
                                    <span class="text-xs font-bold"><?php echo e(strtoupper(substr($loan->user->name, 0, 1))); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-slate-800 block leading-none"><?php echo e($loan->user->name); ?></span>
                                    <span class="text-[9px] text-slate-400 font-bold uppercase mt-1 block tracking-wider"><?php echo e($loan->user->member_id); ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="max-w-[200px]">
                                <span class="text-sm text-slate-800 block leading-tight truncate font-bold"><?php echo e($loan->book->title); ?></span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase mt-1 block"><?php echo e($loan->book->author); ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-xs text-slate-600 font-mono"><?php echo e($loan->tgl_pinjam ? $loan->tgl_pinjam->format('d/m/Y') : '-'); ?></span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-xs <?php echo e($loan->tgl_kembali && $loan->tgl_kembali->isPast() && $loan->status !== 'dikembalikan' ? 'text-red-500 font-black' : 'text-slate-600'); ?> font-mono">
                                <?php echo e($loan->tgl_kembali ? $loan->tgl_kembali->format('d/m/Y') : '-'); ?>

                            </span>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <?php if(auth()->user()->role === 'admin'): ?>
                                <a href="<?php echo e(route('admin.loans.show', $loan)); ?>" class="w-8 h-8 flex items-center justify-center rounded-lg text-[#00bcd4] hover:bg-[#00bcd4]/10 transition-all duration-200">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                                <?php else: ?>
                                <?php if($loan->status === 'pending'): ?>
                                <form action="<?php echo e(route('admin.loans.confirm', $loan)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="px-4 py-1.5 bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition shadow-sm hover:shadow-blue-900/10 active:scale-95">
                                        Konfirmasi
                                    </button>
                                </form>
                                <?php elseif($loan->status !== 'dikembalikan'): ?>
                                <?php if(auth()->user()->role === 'petugas'): ?>
                                <form action="<?php echo e(route('admin.loans.return', $loan)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="px-4 py-1.5 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition shadow-sm hover:shadow-emerald-900/10 active:scale-95">
                                        Kembalikan
                                    </button>
                                </form>
                                <?php endif; ?>
                                <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 border border-slate-200 text-[9px] font-black uppercase tracking-tighter">
                                    <span class="w-1 h-1 rounded-full bg-slate-500"></span>
                                    Selesai
                                </span>
                                <?php endif; ?>

                                <button type="button"
                                    data-url="<?php echo e(route('admin.loans.destroy', $loan->id)); ?>"
                                    onclick="openDeleteModal(this.dataset.url)"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition-all duration-200 text-xs">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-400 font-bold italic">Data peminjaman tidak ditemukan...</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if($loans->hasPages()): ?>
        <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
            <?php echo e($loans->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>


<?php if(session('success_loan')): ?>
<div id="successModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 transition-all duration-300">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="this.parentElement.remove()"></div>

    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl p-8 text-center shadow-2xl border border-slate-100 transform transition-all duration-300 scale-100 animate-in fade-in zoom-in duration-300">
        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-500">
            <i class="fas fa-check-circle text-4xl"></i>
        </div>

        <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Berhasil Dikembalikan</h2>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 leading-relaxed">Rincian transaksi pengembalian koleksi</p>

        <div class="bg-slate-50 rounded-2xl p-5 mb-8 space-y-4 text-left border border-slate-100">
            <div class="flex justify-between items-start gap-4 pb-3 border-b border-slate-200/50">
                <span class="text-[10px] font-black text-slate-400 uppercase">Judul Buku</span>
                <span class="text-xs font-bold text-slate-800 text-right"><?php echo e(session('success_loan')->book->title); ?></span>
            </div>
            <div class="flex justify-between items-center gap-4 pb-3 border-b border-slate-200/50">
                <span class="text-[10px] font-black text-slate-400 uppercase">Peminjam</span>
                <span class="text-xs font-bold text-slate-800"><?php echo e(session('success_loan')->user->name); ?></span>
            </div>
            <div class="flex justify-between items-center gap-4">
                <span class="text-[10px] font-black text-slate-400 uppercase">Status</span>
                <?php $isLate = (session('success_loan')->pengembalian->denda ?? 0) > 0; ?>
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg <?php echo e($isLate ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700'); ?> text-[9px] font-black uppercase tracking-tighter">
                    <?php echo e($isLate ? 'Terlambat' : 'Tepat Waktu'); ?>

                </span>
            </div>
            <div class="flex justify-between items-center gap-4 pt-3 border-t border-slate-200/50">
                <span class="text-[10px] font-black text-slate-400 uppercase">Denda</span>
                <span class="text-sm font-black text-emerald-600">Rp <?php echo e(number_format(session('success_loan')->pengembalian->denda ?? 0, 0, ',', '.')); ?></span>
            </div>
        </div>

        <button onclick="this.closest('#successModal').remove()"
            class="w-full px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-emerald-900/20">
            Selesai
        </button>
    </div>
</div>
<?php endif; ?>

<div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300" onclick="closeDeleteModal()"></div>

    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl p-8 text-center shadow-2xl border border-slate-100 transform transition-all duration-300 scale-100">
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
            <i class="fas fa-history text-3xl"></i>
        </div>

        <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Hapus Transaksi?</h2>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-10 leading-relaxed">
            Data peminjaman ini akan dihapus dari sistem secara permanen. <br>Lanjutkan penghapusan?
        </p>

        <div class="flex items-center gap-4">
            <button onclick="closeDeleteModal()"
                class="flex-1 px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-sm">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="flex-1">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit"
                    class="w-full px-6 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-red-900/20">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function openDeleteModal(actionUrl) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = actionUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/loans/index.blade.php ENDPATH**/ ?>