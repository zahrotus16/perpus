@php
$role = auth()->user()->role;
$sections = [];
$bottomItems = [];

// Dashboard section for both Admin and Petugas
$sections[] = [
'title' => 'MENU',
'items' => [
['name' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'fa-th-large'],
]
];

// Data section for both
$sections[] = [
'title' => 'DATA',
'items' => [
['name' => 'Buku', 'route' => 'admin.books.index', 'icon' => 'fa-book-open'],
['name' => 'Kategori', 'route' => 'admin.categories.index', 'icon' => 'fa-tags'],
['name' => 'Anggota', 'route' => 'admin.users.index', 'icon' => 'fa-user-friends'],
]
];

// Transaction section for Petugas vs Admin
$transactionItems = [];

if ($role === 'petugas') {
$transactionItems[] = ['name' => 'Peminjaman', 'route' => 'admin.loans.index', 'icon' => 'fa-file-invoice'];
$transactionItems[] = ['name' => 'Pengembalian', 'route' => 'admin.loans.returns', 'icon' => 'fa-shopping-cart'];
} elseif ($role === 'admin') {
$transactionItems[] = ['name' => 'Laporan Peminjaman', 'route' => 'admin.loans.index', 'icon' => 'fa-file-invoice'];
$transactionItems[] = ['name' => 'Laporan Pengembalian', 'route' => 'admin.loans.returns', 'icon' => 'fa-history'];
}

$transactionItems[] = ['name' => 'Denda', 'route' => 'admin.loans.fines', 'icon' => 'fa-university'];

$sections[] = [
'title' => 'TRANSAKSI',
'items' => $transactionItems
];

// Reports and Settings for Admin (Kepala) only
if ($role === 'admin') {
$sections[] = [
'title' => 'ADMINISTRASI',
'items' => [
['name' => 'Laporan', 'route' => 'admin.reports.index', 'icon' => 'fa-file-alt'],
['name' => 'Pengaturan', 'route' => 'admin.settings.index', 'icon' => 'fa-cog'],
]
];
}
@endphp

<aside class="fixed inset-y-0 left-0 z-50 w-80 bg-[#00bcd4] text-white shadow-2xl transition-all duration-300 overflow-y-auto custom-scrollbar md:relative md:translate-x-0" id="adminSidebar">
    <div class="flex flex-col p-6 min-h-screen">
        {{-- Brand Identity --}}
        <div class="flex items-center gap-3 mb-10 px-2 group cursor-default">
            <div class="bg-white rounded-xl p-2 w-10 h-10 flex items-center justify-center shadow-lg group-hover:rotate-12 transition-transform duration-300">
                @if(isset($appSettings['app_logo']) && $appSettings['app_logo'])
                <img src="{{ asset('storage/logo/pCwchhx4rSPGKHs7DyZjYSCMxjRBpMLn217MhNbY.png') }}"> @else
                <i class="fas fa-book-reader text-[#00bcd4] text-lg"></i>
                @endif
            </div>
            <div class="leading-none">
                <h1 class="text-[11px] font-black uppercase tracking-tight text-white leading-tight drop-shadow-sm">
                    {!! str_replace(' ', '<br>', $appSettings['app_name'] ?? 'Perpustakaan<br>Digital') !!}
                </h1>
            </div>
        </div>

        {{-- Premium Admin Card --}}
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 mb-10 border border-white/20 shadow-xl group transition-all hover:bg-white/15">
            <div class="flex items-center gap-4">
                <div class="relative w-12 h-12 rounded-xl border-2 border-white/40 bg-white/20 shadow-inner flex items-center justify-center text-white font-black text-lg overflow-hidden group-hover:scale-105 transition-transform">
                    @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) . '?v=' . time() }}" alt="" class="w-full h-full object-cover">
                    @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-xs font-black tracking-tight text-white capitalize truncate">{{ auth()->user()->name }}</h2>
                    <div class="flex items-center gap-1.5 mt-1">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></div>
                        <p class="text-[8px] font-black text-white/70 uppercase tracking-[0.2em]">{{ auth()->user()->role_label }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Section --}}
        <nav class="flex-1 flex flex-col gap-6">
            @foreach($sections as $section)
            <div class="space-y-1">
                @foreach($section['items'] as $item)
                @php $isActive = request()->routeIs($item['route'].'*'); @endphp
                <a href="{{ route($item['route']) }}"
                    class="flex items-center gap-4 px-4 py-3 transition-all duration-300 group relative
                           {{ $isActive ? 'bg-white text-slate-900 rounded-2xl shadow-xl' : 'text-white hover:bg-white/10 rounded-2xl' }}">
                    <i class="fas {{ $item['icon'] }} text-xs w-5 text-center {{ $isActive ? 'text-slate-900' : 'text-white/60 group-hover:text-white' }}"></i>
                    <span class="text-[11px] font-black uppercase tracking-wider">{{ $item['name'] }}</span>
                    @if($isActive)
                    <div class="absolute right-4 w-1.5 h-1.5 rounded-full bg-[#00bcd4]"></div>
                    @endif
                </a>
                @endforeach
            </div>
            @endforeach

            {{-- Logout & Actions (Bottom) --}}
            <div class="mt-auto space-y-3 pt-6">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 px-4 py-3 bg-red-500/90 hover:bg-red-600 text-white rounded-2xl transition-all duration-300 shadow-lg shadow-red-900/40 active:scale-95 group">
                        <i class="fas fa-sign-out-alt text-xs group-hover:-translate-x-1 transition-transform"></i>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </div>
</aside>

<style>
    /* Custom Scrollbar for Sidebar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.2);
    }
</style>