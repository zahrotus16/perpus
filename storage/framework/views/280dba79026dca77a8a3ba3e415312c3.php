<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Sistem Pustaka'); ?> — Perpustakaan</title>

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        },
                        slate: {
                            850: '#1e293b',
                            950: '#0f172a',
                        },
                        dark: {
                            DEFAULT: '#121212',
                            card: '#1e1e1e',
                            border: '#B0B0B0',
                            hover: '#E0E0E0'
                        }
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'dark-soft': '0 4px 20px -5px rgba(0, 0, 0, 0.5)',
                    }
                },
            },
        }
    </script>

    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link.active { 
            background-color: #312e81; 
            color: white !important; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 40px -1px rgba(0, 0, 0, 0.06);
        }
        .sidebar-link:not(.active):hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: white;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #475569; }

        .dropdown-animate {
            animation: dropdownFade 0.2s ease-out;
        }
        @keyframes dropdownFade {
            from { opacity: 0; transform: scale(0.95) translateY(-10px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .badge-pulse { animation: pulse 2s cubic-bezier(.4,0,.6,1) infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.5} }
        
        main { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from{opacity:0; transform: translateY(5px);} to{opacity:1; transform: none;} }

        /* Print Styles */
        @media print {
            aside, header, footer, .navbar-actions, button, .no-print {
                display: none !important;
            }
            .flex { display: block !important; }
            main {
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
            .shadow-sm, .shadow-md, .shadow-lg, .shadow-xl, .shadow-2xl {
                shadow: none !important;
                box-shadow: none !important;
            }
            .border {
                border-color: #eee !important;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="h-full text-slate-800 bg-[#f5f7fa] dark:text-white dark:bg-dark font-sans transition-colors duration-300 antialiased selection:bg-indigo-100 selection:text-indigo-900">
    <script>
        // Sidebar State Check (Prevent Flicker)
        if (localStorage.getItem('sidebar-collapsed') === 'true' && window.innerWidth >= 768) {
            document.body.classList.add('sidebar-collapsed');
        }
    </script>
    
    <div class="flex min-h-screen bg-[#f8fafc] overflow-hidden">
        
        
        <?php if(auth()->check()): ?>
            <?php if(auth()->user()->role !== 'anggota'): ?>
                <?php if (isset($component)) { $__componentOriginalbebe114f3ccde4b38d7462a3136be045 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbebe114f3ccde4b38d7462a3136be045 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbebe114f3ccde4b38d7462a3136be045)): ?>
<?php $attributes = $__attributesOriginalbebe114f3ccde4b38d7462a3136be045; ?>
<?php unset($__attributesOriginalbebe114f3ccde4b38d7462a3136be045); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbebe114f3ccde4b38d7462a3136be045)): ?>
<?php $component = $__componentOriginalbebe114f3ccde4b38d7462a3136be045; ?>
<?php unset($__componentOriginalbebe114f3ccde4b38d7462a3136be045); ?>
<?php endif; ?>
            <?php else: ?>
                <?php if (isset($component)) { $__componentOriginal42505c54f83dcbb6aeebf7efa5510ee0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal42505c54f83dcbb6aeebf7efa5510ee0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42505c54f83dcbb6aeebf7efa5510ee0)): ?>
<?php $attributes = $__attributesOriginal42505c54f83dcbb6aeebf7efa5510ee0; ?>
<?php unset($__attributesOriginal42505c54f83dcbb6aeebf7efa5510ee0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42505c54f83dcbb6aeebf7efa5510ee0)): ?>
<?php $component = $__componentOriginal42505c54f83dcbb6aeebf7efa5510ee0; ?>
<?php unset($__componentOriginal42505c54f83dcbb6aeebf7efa5510ee0); ?>
<?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        
        <div class="flex-1 flex flex-col min-w-0 min-h-screen">
            
            
            <?php if(auth()->check()): ?>
                <?php if(auth()->user()->role !== 'anggota'): ?>
                    <?php if (isset($component)) { $__componentOriginal232f012cda936a4eb249de3234ccfddd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal232f012cda936a4eb249de3234ccfddd = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.topbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.topbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal232f012cda936a4eb249de3234ccfddd)): ?>
<?php $attributes = $__attributesOriginal232f012cda936a4eb249de3234ccfddd; ?>
<?php unset($__attributesOriginal232f012cda936a4eb249de3234ccfddd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal232f012cda936a4eb249de3234ccfddd)): ?>
<?php $component = $__componentOriginal232f012cda936a4eb249de3234ccfddd; ?>
<?php unset($__componentOriginal232f012cda936a4eb249de3234ccfddd); ?>
<?php endif; ?>
                <?php else: ?>
                    <header class="h-16 bg-white border-b border-slate-200/60 flex items-center justify-between px-6 lg:px-10 z-40 flex-shrink-0">
                        <div class="flex items-center gap-4">
                            <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
                                <i class="fas fa-bars-staggered text-sm"></i>
                            </button>
                            <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-end leading-none hidden sm:flex">
                                <span class="text-[11px] font-black text-slate-800 uppercase"><?php echo e(auth()->user()->name); ?></span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1"><?php echo e(auth()->user()->role_label); ?></span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200 overflow-hidden">
                                <?php if(auth()->user()->avatar): ?>
                                    <img src="<?php echo e(asset('storage/' . auth()->user()->avatar)); ?>" alt="" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="fas fa-user-circle text-lg"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </header>
                <?php endif; ?>
            <?php endif; ?>

            
            <main class="flex-1 overflow-y-auto p-4 md:p-8 lg:p-10 custom-scrollbar bg-slate-50/50">
                <div class="max-w-[1600px] mx-auto w-full">
                    <?php if(session('success')): ?>
                        <div class="alert mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                            <i class="fas fa-check-circle text-emerald-500"></i>
                            <span class="text-xs font-black uppercase tracking-widest"><?php echo e(session('success')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl flex items-center gap-3 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                            <i class="fas fa-exclamation-circle text-rose-500"></i>
                            <span class="text-xs font-black uppercase tracking-widest"><?php echo e(session('error')); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>

            
            <footer class="h-12 bg-white border-t border-slate-200 flex items-center justify-between px-8 text-slate-400">
                <span class="text-[10px] font-bold uppercase tracking-widest">&copy; <?php echo e(date('Y')); ?> <?php echo e($appSettings['app_name'] ?? 'DigiLib'); ?></span>
            </footer>
        </div>
    </div>

    
    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

    <script>
        // Theme Toggle Logic
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            // Dispatch event for other components if needed
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: isDark ? 'dark' : 'light' } }));
        }

        // Sidebar Toggle
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        
        function toggleSidebar() {
            if (sidebar) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        // Dropdown Toggle
        function toggleDropdown(event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById('dropdownMenu');
            const icon = document.getElementById('dropdownIcon');
            if (menu && icon) {
                menu.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            }
        }

        // Close dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profileDropdown');
            const menu = document.getElementById('dropdownMenu');
            const icon = document.getElementById('dropdownIcon');
            if (dropdown && !dropdown.contains(e.target) && menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                if (icon) icon.classList.remove('rotate-180');
            }
        });

        // Auto-dismiss alerts
        document.querySelectorAll('.alert').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'all 0.4s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateY(-10px)';
                setTimeout(() => el.remove(), 400);
            }, 6000);
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\perpustakaan-digital\resources\views/layouts/app.blade.php ENDPATH**/ ?>