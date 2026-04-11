@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Pusat Kendali')
@section('page-subtitle', 'Ikhtisar aktivitas dan status literasi Anda')



@section('content')
<div class="space-y-8">

    {{-- Synchronized Header Section (Admin Style) --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-slate-200 pb-8 mb-8">
        <div>
            <div class="flex items-center gap-2 text-[#00bcd4] font-bold text-[10px] uppercase tracking-[0.3em] mb-2">
                <span class="w-8 h-[2px] bg-[#00bcd4] rounded-full"></span>
                Portal Keanggotaan
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Halo, {{ explode(' ', auth()->user()->name)[0] }}!</h1>
            <p class="text-slate-500 text-sm mt-1 font-medium italic">Status: {{ auth()->user()->role_label }} • ID: {{ auth()->user()->member_id }}</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center gap-3">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-widest">Sesi Aktif</span>
            </div>
        </div>
    </div>

    {{-- Metric Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="group relative bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-5 border border-blue-100/50 shadow-inner">
                    <i class="fas fa-book-reader text-lg"></i>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Pinjaman Aktif</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ sprintf("%02d", $stats['active_loans']) }}</h3>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Buku</span>
                </div>
            </div>
        </div>

        <div class="group relative bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-5 border border-emerald-100/50 shadow-inner">
                    <i class="fas fa-history text-lg"></i>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Riwayat Pinjam</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ sprintf("%02d", $stats['total_loans']) }}</h3>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Total</span>
                </div>
            </div>
        </div>

        <div class="group relative bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-5 border border-amber-100/50 shadow-inner">
                    <i class="fas fa-wallet text-lg"></i>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Status Denda</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Rp {{ number_format($stats['total_fine'], 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="group relative bg-white p-6 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-rose-50 rounded-bl-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-5 border border-rose-100/50 shadow-inner">
                    <i class="fas fa-heart text-lg"></i>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] mb-1">Favorit</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">{{ sprintf("%02d", auth()->user()->wishlists()->count()) }}</h3>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Item</span>
                </div>
            </div>
        </div>
    </div>

    @if($dueSoonLoans->count())
    <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-900/20 rounded-2xl p-4 flex items-center gap-4 animate-pulse">
        <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-900/20">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="flex-1">
            <p class="text-xs font-black text-amber-800 dark:text-amber-400 uppercase tracking-widest">Peringatan Jatuh Tempo</p>
            <p class="text-[10px] text-amber-700 dark:text-amber-500/80 font-bold">Anda memiliki {{ $dueSoonLoans->count() }} buku yang hampir jatuh tempo. Segera lakukan pengembalian!</p>
        </div>
        <a href="{{ route('user.loans.active') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-[9px] font-black rounded-lg uppercase tracking-widest transition-all shadow-lg shadow-amber-900/20">Cek Sekarang</a>
    </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        {{-- Left: Active Engagement --}}
        <div class="xl:col-span-2 space-y-8">
            {{-- Active Loans Card --}}
            @if($activeLoans->count())
            <div class="bg-white dark:bg-dark-card rounded-3xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-50 dark:border-dark-border/10 flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest flex items-center gap-3">
                        <i class="fas fa-stream text-primary-500"></i> Aliran Pinjaman Aktif
                    </h3>
                    <a href="{{ route('user.loans.index') }}" class="text-[10px] font-black text-primary-600 dark:text-primary-400 uppercase tracking-widest hover:underline transition-all">Manajemen →</a>
                </div>
                <div class="p-4 space-y-4">
                    @foreach($activeLoans as $loan)
                    <div class="group flex items-center gap-6 p-4 rounded-2xl border border-slate-50 dark:border-dark-border/10 hover:bg-slate-50 dark:hover:bg-white/5 transition-all duration-300">
                        <div class="relative flex-shrink-0 w-12 h-16 shadow-lg rounded-lg overflow-hidden ring-1 ring-slate-100 dark:ring-dark-border/20">
                            @if($loan->book->cover)
                            <img src="{{ asset('storage/'.$loan->book->cover) }}" alt="" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full bg-slate-100 dark:bg-dark flex items-center justify-center text-slate-300 dark:text-gray-700">
                                <i class="fas fa-book text-xl"></i>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-black text-slate-800 dark:text-white truncate uppercase tracking-tight mb-1">{{ $loan->book->title }}</h4>
                            <div class="flex items-center gap-3">
                                <span class="bg-slate-100 dark:bg-dark px-2 py-0.5 rounded text-[9px] font-black text-slate-500 dark:text-gray-500 uppercase tracking-widest border border-slate-200 dark:border-dark-border/10">{{ $loan->book->category->name }}</span>
                                <span class="text-[10px] font-black {{ $loan->isOverdue() ? 'text-red-500 animate-pulse' : 'text-slate-400 dark:text-gray-600' }} uppercase">
                                    <i class="fas fa-clock mr-1.5 opacity-50"></i>
                                    {{ $loan->tgl_kembali ? $loan->tgl_kembali->format('d M') : '-' }} </span>
                            </div>
                        </div>
                        @if($loan->book->pdf_file)
                        <a href="{{ route('user.books.read', $loan->book) }}" class="flex-shrink-0 w-11 h-11 bg-primary-600 hover:bg-primary-700 text-white rounded-xl flex items-center justify-center shadow-lg shadow-primary-900/20 active:scale-90 transition-all">
                            <i class="fas fa-glasses"></i>
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Recent Additions / Catalog --}}
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest flex items-center gap-3">
                        <i class="fas fa-star text-amber-500"></i> Rekomendasi Teranyar
                    </h3>
                    <a href="{{ route('user.books.index') }}" class="text-[10px] font-black text-slate-500 dark:text-gray-500 uppercase tracking-widest hover:text-primary-600 transition-colors">Lihat Katalog →</a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                    @foreach($recentBooks as $book)
                    <a href="{{ route('user.books.show', $book) }}" class="group block bg-white dark:bg-dark-card rounded-2xl shadow-sm border overflow-hidden transition hover:-translate-y-2 hover:shadow-xl">

                        <div class="aspect-[3/4] relative overflow-hidden">
                            @if(!empty($book->cover))
                            <img src="{{ asset('storage/'.$book->cover) }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center"
                                style="background: linear-gradient(135deg, <?= optional($book->category)->color ?? '#999' ?>22, <?= optional($book->category)->color ?? '#999' ?>44);">
                                <i class="fas fa-book text-3xl text-white/50"></i>
                            </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h4 class="text-xs font-bold">
                                {{ $book->title ?? '-' }}
                            </h4>
                            <p class="text-[10px] text-gray-400">
                                {{ $book->author ?? '-' }}
                            </p>
                        </div>

                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Personal Engagement --}}
        <div class="space-y-8">
            {{-- Quick Insights / Information --}}
            <div class="bg-slate-900 rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden border border-white/5">
                <div class="relative z-10">
                    <h3 class="text-xs font-black uppercase tracking-widest mb-6 opacity-60">Insight Literasi</h3>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary-500/20 flex items-center justify-center text-primary-400 border border-primary-500/20">
                                <i class="fas fa-fire-flame-curved"></i>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-tight">Eksplorasi Aktif</p>
                                <p class="text-[10px] text-slate-400 leading-relaxed mt-1">Anda memiliki {{ $stats['active_loans'] }} buku aktif. Terus tingkatkan intensitas baca harian.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-400 border border-amber-500/20">
                                <i class="fas fa-award"></i>
                            </div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-tight">Status Anggota</p>
                                <p class="text-[10px] text-slate-400 leading-relaxed mt-1">Terverifikasi sejak {{ auth()->user()->created_at->format('M Y') }}. Kontribusi signifikan terdeteksi.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <i class="fas fa-chart-line absolute right-[-20px] bottom-[-20px] text-white opacity-[0.02] text-[120px]"></i>
            </div>

            {{-- Support & Help --}}
            <div class="bg-white dark:bg-dark-card rounded-3xl p-8 border border-slate-100 dark:border-dark-border/20 shadow-sm">
                <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest mb-4">Bantuan Teknis</h3>
                <p class="text-[11px] text-slate-500 dark:text-gray-500 leading-loose mb-6 font-medium italic">"Kesulitan dalam mengakses PDF atau sirkulasi buku? Tim pustakawan kami siap membantu."</p>
                <a href="mailto:support@digilib.id" class="flex items-center justify-center gap-3 bg-slate-50 dark:bg-dark border border-slate-200 dark:border-dark-border/10 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest text-slate-600 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-white/10 transition-all">
                    <i class="fas fa-envelope-open"></i> Hubungi Support
                </a>
            </div>
        </div>
    </div>

</div>
@endsection