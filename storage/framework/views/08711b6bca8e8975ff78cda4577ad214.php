<?php $__env->startSection('title', 'Detail Anggota'); ?>

<?php $__env->startSection('content'); ?>
<div class="relative min-h-screen p-6 lg:p-10 flex flex-col items-center justify-start fade-in">
    
    
    <div class="relative z-20 w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 min-h-[600px] flex flex-col">
        
        
        <div class="px-10 py-8 border-b-2 border-slate-100 bg-white">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Detail Anggota</h2>
        </div>

        
        <div class="flex-1 p-10 flex flex-col items-center">
            
            
            <div class="w-full max-w-2xl bg-white rounded-2xl p-8 shadow-inner border border-slate-200">
                <h3 class="text-xl font-black text-slate-900 mb-8 border-b-2 border-slate-500/30 pb-4">Detail Anggota</h3>
                
                <div class="space-y-4">
                    
                    <div class="flex items-start text-lg">
                        <span class="w-40 font-bold text-slate-800">Nama</span>
                        <span class="mr-4 font-bold text-slate-800">:</span>
                        <span class="flex-1 font-bold text-slate-800"><?php echo e($user->name); ?></span>
                    </div>

                    
                    <div class="flex items-start text-lg">
                        <span class="w-40 font-bold text-slate-800">NIS</span>
                        <span class="mr-4 font-bold text-slate-800">:</span>
                        <span class="flex-1 font-bold text-slate-800 font-mono"><?php echo e($user->member_id); ?></span>
                    </div>

                    
                    <div class="flex items-start text-lg">
                        <span class="w-40 font-bold text-slate-800">No Telepon</span>
                        <span class="mr-4 font-bold text-slate-800">:</span>
                        <span class="flex-1 font-bold text-slate-800"><?php echo e($user->phone ?: '-'); ?></span>
                    </div>

                    
                    <div class="flex items-start text-lg">
                        <span class="w-40 font-bold text-slate-800">Setatus</span>
                        <span class="mr-4 font-bold text-slate-800">:</span>
                        <span class="flex-1 font-black <?php echo e($user->status === 'active' ? 'text-emerald-700' : 'text-red-700'); ?>">
                            <?php echo e($user->status === 'active' ? 'Aktif' : 'Nonaktif'); ?>

                        </span>
                    </div>

                    
                    <div class="flex items-start text-lg">
                        <span class="w-40 font-bold text-slate-800">Jenis Kelamin</span>
                        <span class="mr-4 font-bold text-slate-800">:</span>
                        <span class="flex-1 font-bold text-slate-800"><?php echo e($user->gender ?: ($user->gender_label ?? '-')); ?></span>
                    </div>

                    
                    <div class="flex items-start text-lg">
                        <span class="w-40 font-bold text-slate-800">Alamat</span>
                        <span class="mr-4 font-bold text-slate-800">:</span>
                        <span class="flex-1 font-bold text-slate-800"><?php echo e($user->address ?: '-'); ?></span>
                    </div>
                </div>
            </div>

            
            <div class="mt-12 w-full flex justify-center">
                <a href="<?php echo e(route('admin.users.index')); ?>" 
                   class="bg-[#ff0000] hover:bg-[#cc0000] text-white px-20 py-3 rounded-full font-black text-xl transition-all active:scale-95 shadow-xl uppercase tracking-widest text-center">
                    Batal
                </a>
            </div>
        </div>

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/users/show.blade.php ENDPATH**/ ?>