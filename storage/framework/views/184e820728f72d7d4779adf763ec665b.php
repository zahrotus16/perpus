<?php $__env->startSection('title', 'Manajemen Denda'); ?>

<?php $__env->startSection('content'); ?>
<div class="relative min-h-screen p-6 lg:p-10 overflow-hidden">
    
    
    <div class="relative z-20 max-w-full mx-auto flex flex-col md:flex-row justify-between items-center mb-8 gap-4 fade-in">
        <form action="<?php echo e(route('admin.loans.fines')); ?>" method="GET" class="w-full md:max-w-md flex gap-0 shadow-lg rounded-full overflow-hidden border-2 border-slate-300">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari Nama Anggota atau Judul Buku..." 
                   class="w-full px-6 py-2.5 bg-white/90 backdrop-blur-md border-none text-slate-800 placeholder-slate-500 focus:ring-0 font-medium">
            <button type="submit" class="bg-[#4caf50] hover:bg-[#388e3c] text-white px-8 py-2.5 font-bold transition-all active:scale-95 border-l-2 border-slate-300">
                Cari
            </button>
        </form>
    </div>

    
    <div class="relative z-20 max-w-full mx-auto fade-in shadow-2xl rounded-lg overflow-hidden border border-slate-300">
        <div class="overflow-x-auto bg-[#d9d9d9]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#00bcd4] text-slate-900 uppercase text-[12px] font-black tracking-tight border-b-2 border-slate-400">
                        <th class="px-4 py-5 border-r border-slate-400 w-12 text-center">No</th>
                        <th class="px-4 py-5 border-r border-slate-400">Nama (Anggota & Buku)</th>
                        <th class="px-4 py-5 border-r border-slate-400 text-center">Hari Terlambat</th>
                        <th class="px-4 py-5 border-r border-slate-400 text-right">Total Denda</th>
                        <th class="px-4 py-5 border-r border-slate-400 text-center">Tanggal Kembali</th>
                        <th class="px-4 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/40 backdrop-blur-md">
                    <?php if(count($fines) > 0): ?>
                        <?php $__currentLoopData = $fines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="border-b border-slate-300 hover:bg-white/20 transition-colors group">
                            <td class="px-4 py-4 text-center font-bold text-slate-700 text-[13px] border-r border-slate-300">
                                <?php echo e(($fines->currentPage() - 1) * $fines->perPage() + $loop->iteration); ?>

                            </td>
                            <td class="px-4 py-4 border-r border-slate-300">
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-900 text-[13px] uppercase leading-tight"><?php echo e($loan->user->name); ?></span>
                                    <span class="text-slate-500 text-[11px] font-bold italic"><?php echo e($loan->book->title); ?></span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center font-black text-red-600 text-[13px] border-r border-slate-300">
                                <?php echo e($loan->getDaysOverdue()); ?> Hari
                            </td>
                            <td class="px-4 py-4 text-right font-black text-slate-900 text-[13px] border-r border-slate-300 bg-red-50/30">
                                Rp <?php echo e(number_format($loan->pengembalian->denda ?? $loan->calculateFine(), 0, ',', '.')); ?>

                            </td>
                            <td class="px-4 py-4 text-center font-bold text-slate-600 text-[12px] border-r border-slate-300">
                                <?php echo e($loan->pengembalian ? $loan->pengembalian->tgl_dikembalikan->format('d/m/Y') : 'Belum Kembali'); ?>

                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="<?php echo e(route('admin.loans.show', $loan)); ?>" 
                                       class="group bg-sky-400 hover:bg-sky-500 text-white px-3 py-1.5 rounded-lg font-black text-[10px] uppercase transition-all active:scale-95 shadow-md shadow-sky-50 flex items-center gap-2">
                                        <span class="w-4 h-4 rounded-full bg-white flex items-center justify-center text-sky-400">
                                            <i class="fas fa-check text-[8px]"></i>
                                        </span>
                                        Verifikasi
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="px-6 py-20 text-center">
                                <i class="fas fa-hand-holding-usd text-4xl text-slate-300 mb-4 block"></i>
                                <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Belum ada data denda.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    
    <div class="mt-8 flex justify-center fade-in">
        <?php echo e($fines->links()); ?>

    </div>
</div>

<style>
    .fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/loans/fines.blade.php ENDPATH**/ ?>