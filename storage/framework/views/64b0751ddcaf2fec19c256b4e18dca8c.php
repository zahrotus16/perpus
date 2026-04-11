<?php $__env->startSection('title', 'Pengaturan Kepala Perpustakaan'); ?>
<?php $__env->startSection('page-title', 'Pengaturan'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-8">
    
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Pengaturan Sistem</h2>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-1">Konfigurasi identitas aplikasi dan aturan perpustakaan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div>
            <h3 class="text-sm font-extrabold text-slate-900 mb-2">Identitas & Aturan</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Kelola nama aplikasi, logo, serta kebijakan peminjaman seperti batas buku per anggota dan denda keterlambatan harian.</p>
        </div>

        
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <form action="<?php echo e(route('admin.settings.updateApp')); ?>" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="app_name" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Nama Aplikasi</label>
                            <input type="text" name="app_name" id="app_name" value="<?php echo e(old('app_name', $settings['app_name'] ?? '')); ?>" required
                                class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                            <?php $__errorArgs = ['app_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label for="app_logo" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Logo Aplikasi</label>
                            <div class="flex items-center gap-4">
                                <?php if(isset($settings['app_logo']) && $settings['app_logo']): ?>
                                    <img src="<?php echo e(asset('storage/' . $settings['app_logo']) . '?v=' . time()); ?>" id="logo-preview" alt="Logo" class="w-10 h-10 rounded-lg object-cover border border-slate-200">
                                <?php else: ?>
                                    <div id="logo-placeholder" class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center border border-slate-200 text-slate-400">
                                        <i class="fas fa-image text-xs"></i>
                                    </div>
                                    <img id="logo-preview" src="#" alt="Preview" class="hidden w-10 h-10 rounded-lg object-cover border border-slate-200">
                                <?php endif; ?>
                                <input type="file" name="app_logo" id="app_logo" onchange="previewImage(this, 'logo-preview', 'logo-placeholder')" 
                                    class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all">
                            </div>
                            <?php $__errorArgs = ['app_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label for="loan_limit" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Batas Pinjam (Buku)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                    <i class="fas fa-layer-group text-xs"></i>
                                </div>
                                <input type="number" name="loan_limit" id="loan_limit" value="<?php echo e(old('loan_limit', $settings['loan_limit'] ?? 3)); ?>" required
                                    class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                            </div>
                            <?php $__errorArgs = ['loan_limit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label for="fine_per_day" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Denda per Hari (Rp)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                    <i class="fas fa-money-bill-wave text-xs"></i>
                                </div>
                                <input type="number" name="fine_per_day" id="fine_per_day" value="<?php echo e(old('fine_per_day', $settings['fine_per_day'] ?? 1000)); ?>" required
                                    class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                            </div>
                            <?php $__errorArgs = ['fine_per_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-emerald-900/20 transition-all active:scale-95">
                            <i class="fas fa-save"></i> Perbarui Sistem
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="h-[1px] bg-slate-200 my-8"></div>

    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Pengaturan Akun</h2>
            <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mt-1">Kelola profil dan keamanan akun Kepala Perpustakaan Anda</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        
        <div>
            <h3 class="text-sm font-extrabold text-slate-900 mb-2">Profil Kepala Perpustakaan</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Perbarui informasi dasar akun Anda. Pastikan alamat email tetap aktif untuk keperluan notifikasi sistem.</p>
        </div>

        
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <form action="<?php echo e(route('admin.settings.profile')); ?>" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    
                    <div class="flex flex-col md:flex-row items-center gap-8 pb-6 border-b border-slate-100">
                        <div class="relative group">
                            <div class="w-24 h-24 rounded-2xl bg-emerald-50 flex items-center justify-center border-2 border-dashed border-emerald-200 overflow-hidden">
                                <?php if(auth()->user()->avatar): ?>
                                    <img src="<?php echo e(asset('storage/' . auth()->user()->avatar) . '?v=' . time()); ?>" alt="Avatar" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="fas fa-camera text-2xl text-emerald-300"></i>
                                <?php endif; ?>
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-lg bg-white shadow-lg border border-slate-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-pencil-alt text-[10px]"></i>
                            </div>
                        </div>
                        <div class="flex-1 space-y-2 text-center md:text-left">
                            <label for="avatar" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Foto Profil Kepala Perpustakaan</label>
                            <input type="file" name="avatar" id="avatar" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all cursor-pointer">
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider italic">JPG, JPEG atau PNG (Max. 2MB)</p>
                            <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-[10px] mt-2 font-bold uppercase"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Nama Lengkap</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                    <i class="far fa-user text-xs"></i>
                                </div>
                                <input type="text" name="name" id="name" value="<?php echo e(old('name', $user->name)); ?>" required
                                    class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                            </div>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Alamat Email</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                    <i class="far fa-envelope text-xs"></i>
                                </div>
                                <input type="email" name="email" id="email" value="<?php echo e(old('email', $user->email)); ?>" required
                                    class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-emerald-900/20 transition-all active:scale-95">
                            <i class="fas fa-check-circle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="h-[1px] bg-slate-200 my-8"></div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        
        
        <div>
            <h3 class="text-sm font-extrabold text-slate-900 mb-2">Keamanan Akun</h3>
            <p class="text-xs text-slate-500 leading-relaxed">Gunakan kombinasi password yang kuat untuk menjaga keamanan akses ke panel Kepala Perpustakaan. Terdiri dari minimal 8 karakter.</p>
        </div>

        
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <form action="<?php echo e(route('admin.settings.password')); ?>" method="POST" class="p-6 md:p-8 space-y-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div class="space-y-2">
                        <label for="current_password" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Password Saat Ini</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                <i class="fas fa-shield-alt text-xs"></i>
                            </div>
                            <input type="password" name="current_password" id="current_password" required
                                class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                        </div>
                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="password" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Password Baru</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                    <i class="fas fa-key text-xs"></i>
                                </div>
                                <input type="password" name="password" id="password" required
                                    class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation" class="text-[11px] font-black text-slate-500 uppercase tracking-widest">Konfirmasi Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                    <i class="fas fa-lock text-xs"></i>
                                </div>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                    class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-emerald-900/20 transition-all active:scale-95">
                            <i class="fas fa-shield-halved"></i> Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script>
    function previewImage(input, previewId, placeholderId) {
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Avatar specific preview
    document.getElementById('avatar').onchange = function() {
        const [file] = this.files;
        if (file) {
            const container = this.closest('.flex').querySelector('img');
            const icon = this.closest('.flex').querySelector('.fa-camera');
            
            const reader = new FileReader();
            reader.onload = function(e) {
                if (container) {
                    container.src = e.target.result;
                } else if (icon) {
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'w-full h-full object-cover';
                    icon.parentNode.innerHTML = '';
                    icon.parentNode.appendChild(newImg);
                }
            }
            reader.readAsDataURL(file);
        }
    };
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>