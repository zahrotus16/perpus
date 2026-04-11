<a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
    <i class="fas fa-gauge-high w-4"></i> Dashboard
</a>
<div class="mt-3 mb-1 px-4 text-xs text-slate-500 uppercase tracking-wider font-semibold">Kelola</div>
<a href="{{ route('admin.books.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.books*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
    <i class="fas fa-book w-4"></i> Buku
</a>
<a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.categories*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
    <i class="fas fa-tags w-4"></i> Kategori
</a>
<a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.users*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
    <i class="fas fa-users w-4"></i> Anggota
</a>
<a href="{{ route('admin.loans.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.loans*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
    <i class="fas fa-hand-holding-heart w-4"></i> Peminjaman
</a>
<div class="mt-3 mb-1 px-4 text-xs text-slate-500 uppercase tracking-wider font-semibold">Laporan</div>
<a href="{{ route('admin.reports.index') }}" class="sidebar-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.reports*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-slate-700/50' }}">
    <i class="fas fa-chart-bar w-4"></i> Laporan
</a>
