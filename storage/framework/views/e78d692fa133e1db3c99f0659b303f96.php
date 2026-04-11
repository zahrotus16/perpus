<header class="h-16 bg-white border-b border-slate-200/60 flex items-center justify-between px-6 lg:px-10 z-40 flex-shrink-0 transition-all duration-300">
    <div class="flex items-center gap-4 flex-1">
        <button onclick="toggleSidebar()" class="md:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 transition-colors">
            <i class="fas fa-bars-staggered text-sm"></i>
        </button>
        
        
        <div class="hidden md:flex items-center max-w-md w-full relative group" id="globalSearchContainer">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#00bcd4] transition-colors">
                <i class="fas fa-search text-[11px]" id="searchIcon"></i>
                <i class="fas fa-spinner fa-spin text-[11px] hidden" id="searchLoader"></i>
            </div>
            <input type="text" id="globalSearchInput" placeholder="Search anything..." 
                class="block w-full pl-11 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-full text-[13px] font-medium text-slate-700 placeholder:text-slate-400 focus:bg-white focus:border-[#00bcd4] focus:ring-4 focus:ring-[#00bcd4]/10 transition-all outline-none">
            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                <kbd class="hidden lg:inline-block px-1.5 py-0.5 text-[9px] font-black text-slate-400 bg-white border border-slate-200 rounded shadow-sm">⌘ K</kbd>
            </div>

            
            <div id="searchResults" class="hidden absolute top-full left-0 mt-2 w-full bg-white rounded-2xl shadow-2xl border border-slate-100 p-2 z-[60] max-h-[400px] overflow-y-auto custom-scrollbar dropdown-animate">
                <div id="searchContent"></div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4">
        
        <div class="relative" id="notificationDropdown">
            <button onclick="toggleNotifications(event)" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-500 hover:bg-slate-100 hover:text-[#00bcd4] transition-all relative group">
                <i class="far fa-bell text-[15px]"></i>
                <span id="notifBadge" class="hidden absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
            </button>

            <div id="notifMenu" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden dropdown-animate z-[60]">
                <div class="px-5 py-4 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                    <h4 class="text-[11px] font-bold text-slate-900 uppercase tracking-widest">Notifications</h4>
                    <span id="notifCountText" class="text-[9px] font-bold bg-[#00bcd4]/10 text-[#00bcd4] px-2 py-0.5 rounded-full">0 New</span>
                </div>
                <div id="notifList" class="max-h-80 overflow-y-auto custom-scrollbar divide-y divide-slate-50"></div>
                <a href="<?php echo e(route('admin.loans.index')); ?>" class="block py-3 text-center text-[10px] font-bold text-[#00bcd4] hover:bg-[#00bcd4]/5 transition-colors uppercase tracking-widest border-t border-slate-50">
                    View All Activities
                </a>
            </div>
        </div>

        
        <div class="relative group">
            <button onclick="toggleQuickAction(event)" class="w-10 h-10 flex items-center justify-center rounded-full bg-[#00bcd4] text-white shadow-lg shadow-[#00bcd4]/30 hover:bg-[#0097a7] transition-all">
                <i class="fas fa-plus text-xs" id="quickActionIcon"></i>
            </button>
            <div id="quickActionMenu" class="hidden absolute right-0 mt-3 w-52 bg-white rounded-2xl shadow-2xl border border-slate-100 p-2 z-[60] dropdown-animate">
                <p class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Quick Create</p>
                <a href="<?php echo e(route('admin.books.create')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-[13px] font-medium text-slate-600 hover:bg-slate-50 hover:text-[#00bcd4] transition-colors">
                    <i class="fas fa-book w-5 opacity-50"></i> New Book
                </a>
                <a href="<?php echo e(route('admin.users.create')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-[13px] font-medium text-slate-600 hover:bg-slate-50 hover:text-[#00bcd4] transition-colors">
                    <i class="fas fa-user-plus w-5 opacity-50"></i> Anggota Baru
                </a>
                <a href="<?php echo e(route('admin.loans.index')); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-[13px] font-medium text-slate-600 hover:bg-slate-50 hover:text-[#00bcd4] transition-colors">
                    <i class="fas fa-clipboard-list w-5 opacity-50"></i> New Loan
                </a>
            </div>
        </div>

        <div class="w-px h-6 bg-slate-200 mx-2"></div>

        
        <?php if (isset($component)) { $__componentOriginal6ad0a9f99ecaacb726fd54337c366c8b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6ad0a9f99ecaacb726fd54337c366c8b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.profile-dropdown','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.profile-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6ad0a9f99ecaacb726fd54337c366c8b)): ?>
<?php $attributes = $__attributesOriginal6ad0a9f99ecaacb726fd54337c366c8b; ?>
<?php unset($__attributesOriginal6ad0a9f99ecaacb726fd54337c366c8b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6ad0a9f99ecaacb726fd54337c366c8b)): ?>
<?php $component = $__componentOriginal6ad0a9f99ecaacb726fd54337c366c8b; ?>
<?php unset($__componentOriginal6ad0a9f99ecaacb726fd54337c366c8b); ?>
<?php endif; ?>
    </div>
</header>

<style>
    .dropdown-animate { animation: dropDown 0.25s cubic-bezier(0.16, 1, 0.3, 1); transform-origin: top right; }
    @keyframes dropDown { from { opacity: 0; transform: translateY(-10px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
</style>

<script>
    // --- SEARCH & NOTIF LOGIC (Minified/Preserved) ---
    // Perform search
    const performSearch = debounce(async (q) => {
        if (q.length < 2) { searchResults.classList.add('hidden'); return; }
        searchIcon.classList.add('hidden'); searchLoader.classList.remove('hidden');
        try {
            const response = await fetch(`<?php echo e(route('admin.search')); ?>?q=${encodeURIComponent(q)}`);
            const data = await response.json();
            let html = ''; let hasResults = false;
            [{t: 'Books', d: data.books, i: 'fa-book'}, {t: 'Anggota', d: data.users, i: 'fa-users'}, {t: 'Activities', d: data.loans, i: 'fa-history'}].forEach(s => {
                if (s.d.length > 0) {
                    hasResults = true;
                    html += `<div class="mb-2"><p class="px-4 py-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">${s.t}</p>` +
                        s.d.map(item => `<a href="${item.url}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-slate-50 group transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-[#00bcd4]/10 group-hover:text-[#00bcd4] transition-colors border border-slate-100"><i class="fas ${s.i} text-[10px]"></i></div>
                            <div class="flex-1 min-w-0"><p class="text-[13px] font-semibold text-slate-700 truncate">${item.title}</p><p class="text-[10px] text-slate-400 truncate uppercase mt-0.5">${item.sub}</p></div></a>`).join('') + `</div>`;
                }
            });
            searchContent.innerHTML = hasResults ? html : `<div class="p-10 text-center text-slate-400"><i class="fas fa-search text-3xl mb-3 opacity-20"></i><p class="text-[11px] font-bold uppercase tracking-widest">No results found</p></div>`;
            searchResults.classList.remove('hidden');
        } catch (e) { console.error(e); } finally { searchIcon.classList.remove('hidden'); searchLoader.classList.add('hidden'); }
    }, 300);

    const searchInput = document.getElementById('globalSearchInput');
    const searchResults = document.getElementById('searchResults');
    const searchContent = document.getElementById('searchContent');
    const searchIcon = document.getElementById('searchIcon');
    const searchLoader = document.getElementById('searchLoader');
    searchInput.addEventListener('input', (e) => performSearch(e.target.value));

    // Notifications
    async function fetchNotifications() {
        try {
            const response = await fetch(`<?php echo e(route('admin.notifications')); ?>`);
            const data = await response.json();
            const badge = document.getElementById('notifBadge');
            badge.classList.toggle('hidden', data.total_unread === 0);
            document.getElementById('notifCountText').innerText = `${data.total_unread} New`;
            const list = document.getElementById('notifList');
            list.innerHTML = data.notifications.length > 0 ? data.notifications.map(n => `
                <a href="${n.url}" class="flex items-start gap-4 px-5 py-4 hover:bg-slate-50 transition-colors group ${n.is_overdue ? 'bg-red-50/30' : ''}">
                    <div class="w-9 h-9 rounded-full flex-shrink-0 flex items-center justify-center ${n.is_overdue ? 'bg-red-100 text-red-600' : 'bg-[#00bcd4]/10 text-[#00bcd4]'} border border-white shadow-sm"><i class="fas ${n.is_overdue ? 'fa-clock' : 'fa-history'} text-[11px]"></i></div>
                    <div class="flex-1 min-w-0"><p class="text-[13px] font-medium text-slate-700 leading-snug"><span class="font-bold text-slate-900">${n.user_name}</span> ${n.is_overdue ? 'is overdue' : 'borrowed'} <span class="text-[#00bcd4] font-bold">${n.book_title}</span></p><div class="flex items-center gap-2 mt-1.5"><span class="text-[10px] font-bold uppercase ${n.is_overdue ? 'text-red-500' : 'text-slate-400'} tracking-tighter">${n.time}</span></div></div></a>`).join('') : `<div class="p-10 text-center opacity-40"><i class="fas fa-bell-slash text-2xl mb-2 text-slate-300"></i><p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">No notifications</p></div>`;
        } catch (e) { console.error(e); }
    }
    document.addEventListener('DOMContentLoaded', fetchNotifications);
    setInterval(fetchNotifications, 30000);

    function toggleNotifications(e) { e.stopPropagation(); document.getElementById('notifMenu').classList.toggle('hidden'); closeAllDropdowns(document.getElementById('notifMenu')); }
    function toggleQuickAction(e) { e.stopPropagation(); document.getElementById('quickActionMenu').classList.toggle('hidden'); document.getElementById('quickActionIcon').classList.toggle('rotate-45'); closeAllDropdowns(document.getElementById('quickActionMenu')); }
    function closeAllDropdowns(except = null) {
        ['notifMenu', 'quickActionMenu', 'searchResults', 'dropdownMenu'].forEach(id => {
            const el = document.getElementById(id);
            if (el && el !== except) { el.classList.add('hidden'); if (id === 'quickActionMenu') document.getElementById('quickActionIcon').classList.remove('rotate-45'); }
        });
    }
    window.addEventListener('click', () => closeAllDropdowns());
    window.addEventListener('keydown', (e) => { if (e.metaKey && e.key === 'k') { e.preventDefault(); searchInput.focus(); } });
    function debounce(f, w) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => f(...a), w); }; }
</script>
<?php /**PATH D:\perpustakaan-digital\resources\views/components/admin/topbar.blade.php ENDPATH**/ ?>