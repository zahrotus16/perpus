<?php $__env->startSection('title', 'Wishlist Personal'); ?>
<?php $__env->startSection('page-title', 'Rencana Baca'); ?>
<?php $__env->startSection('page-subtitle', 'Kurasi koleksi favorit yang ingin Anda eksplorasi'); ?>



<?php $__env->startSection('content'); ?>
<div class="space-y-8">

    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-4 border-b border-slate-50 dark:border-dark-border/10">
        <h2 class="text-[11px] font-black text-slate-400 dark:text-gray-600 uppercase tracking-[0.25em]">Personal Kurasi: <?php echo e($books->count()); ?> Koleksi Terpilih</h2>
        <div class="flex items-center gap-3 text-[10px] font-black text-slate-500 dark:text-gray-500 italic">
            <span>Sinkronisasi Otomatis</span>
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
        </div>
    </div>

    <?php if($books->count()): ?>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="group relative bg-white dark:bg-dark-card rounded-3xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
            
            <form action="<?php echo e(route('user.books.wishlist', $book)); ?>" method="POST" class="absolute top-4 right-4 z-20 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-10 h-10 rounded-2xl bg-white/90 dark:bg-dark/95 backdrop-blur-md flex items-center justify-center text-red-500 shadow-2xl border border-transparent hover:border-red-500/30 transition-all active:scale-90" title="Keluarkan dari Kurasi">
                    <i class="fas fa-heart text-sm"></i>
                </button>
            </form>

            <a href="<?php echo e(route('user.books.show', $book)); ?>" class="block">
                
                <div class="aspect-[3/4] relative overflow-hidden">
                    <?php if($book->cover): ?>
                        <img src="<?php echo e(asset('storage/'.$book->cover)); ?>" alt="<?php echo e($book->title); ?>"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <?php else: ?>
                        <div class="w-full h-full flex flex-col items-center justify-center gap-3 bg-slate-50 dark:bg-dark border-b border-white/5 transition-transform duration-700 group-hover:scale-110"
                             style="background: linear-gradient(135deg, <?php echo e($book->category->color); ?>22, <?php echo e($book->category->color); ?>55)">
                            <i class="fas fa-book text-4xl text-white opacity-40"></i>
                            <span class="text-[8px] font-black text-white opacity-30 uppercase tracking-[0.2em]">DigiLib Master</span>
                        </div>
                    <?php endif; ?>
                    
                    
                    <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <span class="px-5 py-2.5 bg-white text-dark text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-2xl border border-white/10">Buka Koleksi</span>
                    </div>
                </div>

                
                <div class="p-6">
                    <span class="inline-block px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-[0.1em] mb-2 shadow-sm ring-1 ring-inset" 
                          style="background:<?php echo e($book->category->color); ?>15; color:<?php echo e($book->category->color); ?>; ring-color:<?php echo e($book->category->color); ?>30">
                        <?php echo e($book->category->name); ?>

                    </span>
                    <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-tight leading-snug line-clamp-2 truncate mb-1 group-hover:text-primary-600 transition-colors">
                        <?php echo e($book->title); ?>

                    </h3>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-gray-600 italic truncate mb-6"><?php echo e($book->author); ?></p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-slate-50 dark:border-dark-border/10">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-star text-[9px] text-amber-500"></i>
                            <span class="text-[10px] font-black text-slate-700 dark:text-gray-300"><?php echo e(number_format($book->rating,1)); ?></span>
                        </div>
                        <span class="text-[9px] font-black <?php echo e($book->stock > 0 ? 'text-emerald-500' : 'text-red-500'); ?> uppercase tracking-widest italic">
                            <?php echo e($book->stock > 0 ? 'Unit Available' : 'On Loan'); ?>

                        </span>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php else: ?>
    
    <div class="bg-white dark:bg-dark-card rounded-[3rem] shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 py-32 text-center transition-all duration-500 hover:shadow-2xl">
        <div class="group w-28 h-28 bg-pink-50 dark:bg-pink-900/10 rounded-[2.5rem] flex items-center justify-center mx-auto mb-10 border border-pink-100 dark:border-pink-900/20 shadow-inner relative overflow-hidden">
            <i class="fas fa-heart text-pink-500 text-4xl relative z-10 transition-transform duration-500 group-hover:scale-125"></i>
            <div class="absolute inset-0 bg-gradient-to-br from-pink-400/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>
        <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-[0.3em] mb-4">Kurasi Masih Kosong</h3>
        <p class="text-[11px] text-slate-400 dark:text-gray-500 mb-12 max-w-sm mx-auto font-bold leading-relaxed italic uppercase tracking-widest px-6">Mulailah menandai mahakarya literasi favorit Anda untuk akses prioritas di masa mendatang.</p>
        <a href="<?php echo e(route('user.books.index')); ?>" class="inline-flex items-center gap-4 bg-primary-600 hover:bg-primary-700 text-white px-12 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition shadow-2xl shadow-primary-900/40 active:scale-95">
            <i class="fas fa-compass"></i> Buka Gerbang Katalog
        </a>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/user/wishlist.blade.php ENDPATH**/ ?>