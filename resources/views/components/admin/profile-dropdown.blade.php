<div class="relative" id="profileDropdown">
    <button onclick="toggleDropdown(event)" class="flex items-center gap-3 p-1 rounded-xl hover:bg-slate-50 dark:hover:bg-white/5 transition-all focus:outline-none group">
        <div class="w-9 h-9 rounded-xl bg-primary-600 flex items-center justify-center text-white text-xs font-black shadow-lg shadow-primary-900/20 group-hover:scale-110 transition-transform overflow-hidden">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="" class="w-full h-full object-cover">
            @else
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            @endif
        </div>
        <div class="hidden lg:flex flex-col items-start leading-tight">
            <span class="text-xs font-black text-slate-800 dark:text-white line-clamp-1 truncate max-w-[120px]">{{ auth()->user()->name }}</span>
            <span class="text-[9px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest">{{ auth()->user()->role_label }}</span>
        </div>
        <i class="fas fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600 dark:group-hover:text-white transition-transform duration-300 ml-1" id="dropdownIcon"></i>
    </button>

    {{-- Dropdown Menu --}}
    <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-dark-card rounded-2xl shadow-xl dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/30 p-2 z-[60] dropdown-animate">
        <div class="px-3 py-2 mb-2 border-b border-slate-50 dark:border-dark-border/20">
            <p class="text-xs font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
            <p class="text-[10px] font-medium text-slate-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
        </div>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
            <i class="far fa-user w-4"></i> Profil Saya
        </a>
        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">
            <i class="far fa-gear w-4"></i> Pengaturan
        </a>
        <div class="my-2 border-t border-slate-50 dark:border-dark-border/20"></div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-black text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                <i class="fas fa-arrow-right-from-bracket w-4"></i> Keluar
            </button>
        </form>
    </div>
</div>

<script>
    function toggleDropdown(event) {
        if (event) event.stopPropagation();
        closeAllDropdowns(document.getElementById('dropdownMenu'));
        document.getElementById('dropdownMenu').classList.toggle('hidden');
        document.getElementById('dropdownIcon').classList.toggle('rotate-180');
    }
</script>
