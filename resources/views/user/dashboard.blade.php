@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Pusat Kendali')
@section('page-subtitle', 'Ikhtisar aktivitas dan status literasi Anda')



@section('content')
<div class="space-y-8">

    {{-- Modern White Welcome Banner (Sycnronized with Admin) --}}
    <div class="group relative overflow-hidden bg-white rounded-[32px] p-10 shadow-sm border border-slate-100 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 mb-2">
        <div class="absolute top-0 right-0 w-96 h-96 bg-[#00bcd4]/5 rounded-full -mr-32 -mt-32 blur-3xl group-hover:bg-[#00bcd4]/10 transition-colors duration-1000"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-3 py-1 bg-[#00bcd4]/10 text-[#00bcd4] text-[10px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#00bcd4]/10">Profil Terverifikasi</span>
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                </div>
                <h2 class="text-4xl font-black tracking-tight text-slate-800 mb-2 leading-tight">
                    Salam Literasi, <br class="md:hidden">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-[#00bcd4]">{{ explode(' ', auth()->user()->name)[0] }}</span>!
                </h2>
                <div class="flex flex-wrap items-center gap-4 mt-4">
                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-100 px-4 py-2.5 rounded-2xl shadow-inner group-hover:border-[#00bcd4]/30 transition-all">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">ID Anggota</span>
                        <span class="font-mono font-black text-xs text-[#00bcd4] tracking-tighter">{{ auth()->user()->member_id }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex items-center gap-6">
                <div class="text-right">
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] mb-1">Versi Sistem</p>
                    <p class="text-sm font-black text-slate-800 uppercase tracking-tight">DigiLib <span class="text-[#00bcd4]">v4.0</span></p>
                </div>
                <div class="w-16 h-16 rounded-[24px] bg-slate-50 flex items-center justify-center border border-slate-100 shadow-inner group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                    <i class="fas fa-shield-alt text-2xl text-[#00bcd4]"></i>
                </div>
            </div>
        </div>
        <i class="fas fa-book-open absolute right-[-40px] bottom-[-40px] text-slate-100 opacity-20 text-[200px] rotate-[-15deg] group-hover:rotate-0 transition-all duration-1000 select-none"></i>
    </div>

    {{-- Metric Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="group bg-white dark:bg-dark-card rounded-[28px] shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-6 hover:border-[#00bcd4]/50 transition-all duration-300">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-sky-900/20 flex items-center justify-center mb-4 border border-sky-100 dark:border-sky-800/30 group-hover:scale-110 transition-transform">
                <i class="fas fa-book-reader text-[#00bcd4] dark:text-sky-400 text-lg"></i>
            </div>
            <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter">{{ sprintf("%02d", $stats['active_loans']) }}</p>
            <p class="text-[10px] font-black text-slate-400 dark:text-gray-600 mt-1 uppercase tracking-widest">Pinjaman Aktif</p>
        </div>
        
        <div class="group bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-6 hover:border-emerald-500/50 transition-all duration-300">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center mb-4 border border-emerald-100 dark:border-emerald-800/30 group-hover:scale-110 transition-transform">
                <i class="fas fa-check-double text-emerald-600 dark:text-emerald-400 text-lg"></i>
            </div>
            <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter">{{ sprintf("%02d", $stats['returned']) }}</p>
            <p class="text-[10px] font-black text-slate-400 dark:text-gray-600 mt-1 uppercase tracking-widest">Koleksi Kembali</p>
        </div>

        <div class="group bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-6 hover:border-purple-500/50 transition-all duration-300">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center mb-4 border border-purple-100 dark:border-purple-800/30 group-hover:scale-110 transition-transform">
                <i class="fas fa-layer-group text-purple-600 dark:text-purple-400 text-lg"></i>
            </div>
            <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter">{{ sprintf("%02d", $stats['total_loans']) }}</p>
            <p class="text-[10px] font-black text-slate-400 dark:text-gray-600 mt-1 uppercase tracking-widest">Total Sirkulasi</p>
        </div>

        <div class="group bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-6 hover:border-pink-500/50 transition-all duration-300">
            <div class="w-12 h-12 rounded-2xl bg-pink-50 dark:bg-pink-900/20 flex items-center justify-center mb-4 border border-pink-100 dark:border-pink-800/30 group-hover:scale-110 transition-transform">
                <i class="fas fa-heart text-pink-600 dark:text-pink-400 text-lg"></i>
            </div>
            <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tighter">{{ sprintf("%02d", $stats['wishlist']) }}</p>
            <p class="text-[10px] font-black text-slate-400 dark:text-gray-600 mt-1 uppercase tracking-widest">Wishlist Koleksi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        {{-- Left: Active Engagement --}}
        <div class="xl:col-span-2 space-y-8">
            {{-- Active Loans Card --}}
            @if($activeLoans->count())
            <div class="bg-white dark:bg-dark-card rounded-3xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-50 dark:border-dark-border/10 flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest flex items-center gap-3">
                        <i class="fas fa-stream text-[#00bcd4]"></i> Aliran Pinjaman Aktif
                    </h3>
                    <a href="{{ route('user.loans.index') }}" class="text-[10px] font-black text-[#00bcd4] dark:text-sky-400 uppercase tracking-widest hover:underline transition-all">Manajemen →</a>
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
                                    {{ $loan->isOverdue() ? 'Melewati Batas' : 'Batas: ' . $loan->due_date->format('d M') }}
                                </span>
                            </div>
                        </div>
                        @if($loan->book->pdf_file)
                        <a href="{{ route('user.books.read', $loan->book) }}" class="flex-shrink-0 w-11 h-11 bg-[#00bcd4] hover:bg-[#0097a7] text-white rounded-xl flex items-center justify-center shadow-lg shadow-[#00bcd4]/20 active:scale-90 transition-all">
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
                    <a href="{{ route('user.books.index') }}" class="text-[10px] font-black text-slate-500 dark:text-gray-500 uppercase tracking-widest hover:text-[#00bcd4] transition-colors">Lihat Katalog →</a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                    @foreach($recentBooks as $book)
                    <a href="{{ route('user.books.show', $book) }}" class="group block bg-white dark:bg-dark-card rounded-2xl shadow-sm border border-slate-100 dark:border-dark-border/20 overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl">
                        <div class="aspect-[3/4] relative overflow-hidden">
                            @if($book->cover)
                                <img src="{{ asset('storage/'.$book->cover) }}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center" style="background:linear-gradient(135deg, {{ $book->category->color }}22, {{ $book->category->color }}44)">
                                    <i class="fas fa-book text-3xl text-white/50"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                                <span class="bg-white text-dark text-[9px] font-black px-4 py-2 rounded-xl uppercase tracking-widest">Detail</span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h4 class="text-[11px] font-black text-slate-800 dark:text-white line-clamp-1 uppercase tracking-tighter group-hover:text-[#00bcd4] transition-colors">{{ $book->title }}</h4>
                            <p class="text-[9px] font-bold text-slate-400 dark:text-gray-600 italic truncate">{{ $book->author }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Personal Engagement --}}
        <div class="space-y-8">
            {{-- Quick Insights / Information (Cyan Theme) --}}
            <div class="bg-white rounded-[32px] p-8 text-slate-800 shadow-sm relative overflow-hidden border border-slate-100 transition-all hover:shadow-lg group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-[#00bcd4]/5 rounded-full -mr-10 -mt-10 blur-2xl"></div>
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black uppercase tracking-widest mb-6 text-slate-300">Insight Literasi</h3>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-[#00bcd4]/10 flex items-center justify-center text-[#00bcd4] border border-[#00bcd4]/10">
                                <i class="fas fa-fire-flame-curved"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-black uppercase tracking-tight text-slate-700">Eksplorasi Aktif</p>
                                <p class="text-[10px] text-slate-400 leading-relaxed mt-1 font-medium">Anda memiliki <span class="text-[#00bcd4] font-black">{{ $stats['active_loans'] }}</span> buku aktif. Terus tingkatkan intensitas baca harian.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 border border-amber-500/10">
                                <i class="fas fa-award"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-black uppercase tracking-tight text-slate-700">Status Anggota</p>
                                <p class="text-[10px] text-slate-400 leading-relaxed mt-1 font-medium">Terverifikasi sejak <span class="text-slate-900 font-black">{{ auth()->user()->created_at->format('M Y') }}</span>. Kontribusi signifikan terdeteksi.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <i class="fas fa-chart-line absolute right-[-20px] bottom-[-20px] text-slate-50 opacity-40 text-[100px] select-none"></i>
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
