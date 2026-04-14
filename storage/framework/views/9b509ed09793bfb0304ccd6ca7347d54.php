<?php $__env->startSection('title', 'Riwayat Pinjaman'); ?>
<?php $__env->startSection('page-title', 'Arsip Sirkulasi'); ?>
<?php $__env->startSection('page-subtitle', 'Rekam jejak aktivitas literasi dan transaksi buku Anda'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">

    
    <div class="flex justify-center mb-8">
        <form method="GET" action="<?php echo e(route('user.loans.index')); ?>" class="flex w-full max-w-3xl gap-2">
            <div class="flex-1 relative group">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                    placeholder="Cari Judul Buku..."
                    class="w-full bg-[#aab7c4]/90 border-none rounded-lg py-3 px-6 text-slate-800 font-bold placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-[#00b4ff] transition-all">
            </div>

            <div class="flex gap-2">
                <select name="status" class="bg-[#aab7c4]/90 border-none rounded-lg py-3 px-6 text-slate-800 font-black uppercase text-[10px] tracking-widest focus:outline-none focus:ring-2 focus:ring-[#00b4ff] cursor-pointer">
                    <option value="">Status</option>
                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                    <option value="dipinjam" <?php echo e(request('status') == 'dipinjam' ? 'selected' : ''); ?>>Dipinjam</option>
                    <option value="dikembalikan" <?php echo e(request('status') == 'dikembalikan' ? 'selected' : ''); ?>>Kembali</option>
                </select>

                <button type="submit" class="bg-[#2e7d32] hover:bg-[#1b5e20] text-white px-10 py-3 rounded-lg font-black uppercase tracking-widest text-[11px] shadow-lg transition-all active:scale-95">
                    Filter
                </button>

                <?php if(request('search') || request('status')): ?>
                <a href="<?php echo e(route('user.loans.index')); ?>" class="bg-[#d32f2f] hover:bg-[#b71c1c] text-white w-12 flex items-center justify-center rounded-lg shadow-lg active:scale-95 transition-all">
                    <i class="fas fa-times"></i>
                </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    
    <div class="bg-white dark:bg-dark-card rounded-3xl shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#00b4ff] text-white uppercase text-[11px] font-black">
                        <th class="px-8 py-4">Koleksi Buku</th>
                        <th class="px-8 py-4 text-center">Tgl Pinjam</th>
                        <th class="px-8 py-4 text-center">Tgl Kembali</th>
                        <th class="px-8 py-4 text-center">Status</th>
                        <th class="px-8 py-4 text-right">Denda</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition">

                        
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-14 bg-slate-100 rounded overflow-hidden">
                                    <?php if($loan->book && $loan->book->cover): ?>
                                    <img src="<?php echo e(asset('storage/'.$loan->book->cover)); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold">
                                        <?php echo e($loan->book->title ?? '-'); ?>

                                    </h4>
                                    <p class="text-[10px] text-gray-400">
                                        <?php echo e($loan->book->author ?? '-'); ?>

                                    </p>
                                </div>
                            </div>
                        </td>

                        
                        <td class="px-8 py-5 text-center">
                            <?php echo e($loan->tgl_pinjam 
                            ? \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d M Y') 
                            : '-'); ?>

                        </td>

                        
                        <td class="px-8 py-5 text-center">
                            <?php echo e(($loan->pengembalian && $loan->pengembalian->tgl_dikembalikan) 
                            ? \Carbon\Carbon::parse($loan->pengembalian->tgl_dikembalikan)->format('d M Y') 
                            : '-'); ?>

                        </td>

                        
                        <td class="px-8 py-5 text-center">
                            <?php if($loan->status === 'pending'): ?>
                            <span class="text-yellow-500">Menunggu</span>
                            <?php elseif($loan->status === 'dipinjam'): ?>
                            <span class="text-blue-500">Dipinjam</span>
                            <?php elseif($loan->status === 'terlambat'): ?>
                            <span class="text-red-500">Terlambat</span>
                            <?php else: ?>
                            <span class="text-green-500">Kembali</span>
                            <?php endif; ?>
                        </td>

                        
                        <td class="px-8 py-5 text-right">
                            <?php echo e(($loan->pengembalian && $loan->pengembalian->denda) 
                            ? 'Rp '.number_format($loan->pengembalian->denda,0,',','.') 
                            : 'Rp 0'); ?>

                        </td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-400">
                            Tidak ada data
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <?php echo e($loans->links()); ?>


</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/user/loans/index.blade.php ENDPATH**/ ?>