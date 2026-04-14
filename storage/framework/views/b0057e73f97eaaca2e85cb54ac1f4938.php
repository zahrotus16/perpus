<aside class="fixed inset-y-0 left-0 z-50 w-80 bg-[#00bcd4] text-white shadow-2xl transition-all duration-300 overflow-y-auto custom-scrollbar md:relative md:translate-x-0" id="adminSidebar">
    <div class="flex flex-col p-6 min-h-screen">
        
        <div class="flex items-center gap-3 mb-10 px-2 group cursor-default">
            <div class="bg-white rounded-xl p-2 w-10 h-10 flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                <?php if(isset($appSettings['app_logo']) && $appSettings['app_logo']): ?>
                    <img src="<?php echo e(asset('storage/' . $appSettings['app_logo']) . '?v=' . time()); ?>" alt="Logo" class="w-full h-full object-cover rounded-sm">
                <?php else: ?>
                    <i class="fas fa-book-reader text-[#00bcd4] text-lg"></i>
                <?php endif; ?>
            </div>
            <div class="leading-none">
                <h1 class="text-[11px] font-black uppercase tracking-tight text-white leading-tight drop-shadow-sm">
                    <?php echo str_replace(' ', '<br>', $appSettings['app_name'] ?? 'Perpustakaan<br>Digital'); ?>

                </h1>
            </div>
        </div>

        
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 mb-10 border border-white/20 shadow-xl group transition-all hover:bg-white/15">
            <div class="flex items-center gap-4">
                <div class="relative w-12 h-12 rounded-xl border-2 border-white/40 bg-white/20 shadow-inner flex items-center justify-center text-white font-black text-lg overflow-hidden group-hover:scale-105 transition-transform">
                    <?php if(auth()->user()->avatar): ?>
                        <img src="<?php echo e(asset('storage/' . auth()->user()->avatar) . '?v=' . time()); ?>" alt="" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-xs font-black tracking-tight text-white capitalize truncate"><?php echo e(auth()->user()->name); ?></h2>
                    <div class="flex items-center gap-1.5 mt-1">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                        <p class="text-[8px] font-black text-white/70 uppercase tracking-[0.2em]"><?php echo e(auth()->user()->role_label); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col flex-1 gap-6">
            
            <div class="space-y-4">
                <div class="space-y-1">
                    <?php $isActive = request()->routeIs('user.dashboard'); ?>
                    <a href="<?php echo e(route('user.dashboard')); ?>" 
                       class="flex items-center gap-4 px-4 py-3 transition-all duration-300 group relative
                       <?php echo e($isActive ? 'bg-white text-slate-900 rounded-2xl shadow-xl' : 'text-white hover:bg-white/10 rounded-2xl'); ?>">
                        <i class="fas fa-th-large text-xs w-5 text-center <?php echo e($isActive ? 'text-slate-900' : 'text-white/60 group-hover:text-white'); ?>"></i>
                        <span class="text-[11px] font-black uppercase tracking-wider">Beranda</span>
                        <?php if($isActive): ?>
                            <div class="absolute right-4 w-1.5 h-1.5 rounded-full bg-[#00bcd4]"></div>
                        <?php endif; ?>
                    </a>
                </div>

                <div class="space-y-1">
                    <?php
                        $libMenus = [
                            ['name' => 'Katalog', 'route' => 'user.books.index', 'icon' => 'fa-book'],
                            ['name' => 'Peminjaman', 'route' => 'user.loans.active', 'icon' => 'fa-book-reader'],
                            ['name' => 'Pengembalian', 'route' => 'user.loans.returns', 'icon' => 'fa-undo-alt'],
                            ['name' => 'Denda', 'route' => 'user.loans.fines', 'icon' => 'fa-wallet'],
                            ['name' => 'Wishlist', 'route' => 'user.wishlist', 'icon' => 'fa-heart'],
                        ];
                    ?>

                    <?php $__currentLoopData = $libMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $isActive = request()->routeIs($menu['route'].'*'); ?>
                        <a href="<?php echo e(route($menu['route'])); ?>" 
                           class="flex items-center gap-4 px-4 py-3 transition-all duration-300 group relative
                           <?php echo e($isActive ? 'bg-white text-slate-900 rounded-2xl shadow-xl' : 'text-white hover:bg-white/10 rounded-2xl'); ?>">
                            <i class="fas <?php echo e($menu['icon']); ?> text-xs w-5 text-center <?php echo e($isActive ? 'text-slate-900' : 'text-white/60 group-hover:text-white'); ?>"></i>
                            <span class="text-[11px] font-black uppercase tracking-wider"><?php echo e($menu['name']); ?></span>
                            <?php if($isActive): ?>
                                <div class="absolute right-4 w-1.5 h-1.5 rounded-full bg-[#00bcd4]"></div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <div class="mt-auto pt-6 space-y-3">
                <?php $isActive = request()->routeIs('user.profile.*'); ?>
                <a href="<?php echo e(route('user.profile.edit')); ?>" 
                   class="flex items-center gap-4 px-4 py-3 transition-all duration-300 group
                   <?php echo e($isActive ? 'bg-white text-slate-900 rounded-2xl shadow-xl' : 'text-white bg-white/5 hover:bg-white/15 rounded-2xl'); ?>">
                    <i class="fas fa-user-circle text-xs w-5 text-center <?php echo e($isActive ? 'text-slate-900' : 'text-white/40 group-hover:text-white'); ?>"></i>
                    <span class="text-[11px] font-black uppercase tracking-wider">Profil Anda</span>
                </a>

                <form action="<?php echo e(route('logout')); ?>" method="POST" class="w-full">
                    <?php echo csrf_field(); ?>
                    <button type="submit" 
                        class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-red-500/90 hover:bg-red-600 text-white rounded-2xl transition-all duration-300 shadow-lg shadow-red-900/40 active:scale-95 group">
                        <i class="fas fa-sign-out-alt text-xs group-hover:-translate-x-1 transition-transform"></i>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
<?php /**PATH D:\perpustakaan-digital\resources\views/components/user/sidebar.blade.php ENDPATH**/ ?>