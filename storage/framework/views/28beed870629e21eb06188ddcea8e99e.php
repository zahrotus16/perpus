<?php $__env->startSection('title', 'Manajemen Buku'); ?>
<?php $__env->startSection('page-title', 'Koleksi Perpustakaan'); ?>
<?php $__env->startSection('page-subtitle', 'Daftar buku dan ketersediaan stok koleksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Inventaris Pustaka</h2>
        </div>
        <a href="<?php echo e(route('admin.books.create')); ?>" class="flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-xl shadow-emerald-900/20 active:scale-95">
            <i class="fas fa-plus text-sm"></i> Tambah Buku Baru
        </a>
    </div>

    
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <form action="<?php echo e(route('admin.books.index')); ?>" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
            <div class="relative w-full md:flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                    <i class="fas fa-search text-xs"></i>
                </div>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       placeholder="Cari koleksi berdasarkan judul, penulis, atau penerbit..." 
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 placeholder-slate-400 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
            </div>
            <button type="submit" class="w-full md:w-auto px-10 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition shadow-lg shadow-emerald-900/20 active:scale-95">
                Cari Koleksi
            </button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.books.index')); ?>" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-red-500 transition-colors">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">Koleksi Buku</th>
                        <th class="px-4 py-5">Identitas</th>
                        <th class="px-4 py-5 text-center">Stok</th>
                        <th class="px-4 py-5 text-center">Status</th>
                        <th class="px-4 py-5 text-center">Lokasi</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-medium whitespace-nowrap">
                    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-14 overflow-hidden rounded shadow-sm bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100">
                                    <?php if($book->cover): ?>
                                        <img src="<?php echo e(asset('storage/'.$book->cover)); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <i class="fas fa-book text-slate-200 text-xs"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="max-w-[240px]">
                                    <span class="text-sm font-bold text-slate-800 block leading-tight truncate"><?php echo e($book->title); ?></span>
                                    <?php echo e($book->cover); ?>

                                    <span class="text-[10px] text-slate-400 font-bold uppercase mt-1 block"><?php echo e($book->author); ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <span class="text-[10px] text-slate-500 block font-bold uppercase tracking-tight"><?php echo e($book->publisher); ?></span>
                            <span class="text-[9px] text-slate-400 font-bold font-mono"><?php echo e($book->year); ?></span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-xs font-black text-slate-800"><?php echo e($book->stock); ?></span>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <?php if($book->stock > 0): ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100 text-[9px] font-black uppercase tracking-tighter">
                                    <span class="w-1 h-1 rounded-full bg-emerald-600"></span>
                                    Tersedia
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-600 border border-red-100 text-[9px] font-black uppercase tracking-tighter">
                                    <span class="w-1 h-1 rounded-full bg-red-600"></span>
                                    Kosong
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <span class="text-[10px] font-bold text-slate-600 bg-slate-50 border border-slate-200 px-2 py-1 rounded-lg">
                                <?php echo e($book->shelf_location ?? '-'); ?>

                            </span>
                        </td>
                        <td class="px-8 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?php echo e(route('admin.books.edit', $book)); ?>" 
                                   class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200 text-xs">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        onclick="openDeleteModal('<?php echo e(route('admin.books.destroy', $book)); ?>')"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition-all duration-200 text-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-slate-400 font-bold italic">Buku tidak ditemukan...</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <?php if($books->hasPages()): ?>
        <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
            <?php echo e($books->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>


<div id="deleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity duration-300" onclick="closeDeleteModal()"></div>
    
    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl p-8 text-center shadow-2xl border border-slate-100 transform transition-all duration-300 scale-100">
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500">
            <i class="fas fa-book-dead text-3xl"></i>
        </div>
        
        <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Hapus Koleksi?</h2>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-10 leading-relaxed">
            Koleksi buku ini akan dihapus dari sistem secara permanen. <br>Lanjutkan penghapusan?
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/books/index.blade.php ENDPATH**/ ?>