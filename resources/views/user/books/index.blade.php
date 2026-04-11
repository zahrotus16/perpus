@extends('layouts.app')

@section('title', 'Katalog Perpustakaan')
@section('page-title', 'Katalog Koleksi')
@section('page-subtitle', 'Eksplorasi literasi berkualitas di perpustakaan kami')



@section('content')
<div class="space-y-8">

    {{-- Premium Search Bar (Admin Style Sync) --}}
    <div class="flex justify-center mb-10 pt-4">
        <form method="GET" action="{{ route('user.books.index') }}" class="flex w-full @if(request('search') || request('category')) max-w-4xl @else max-w-3xl @endif gap-2">
            <div class="flex-1 relative group">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari Judul, Penulis, atau ISBN..."
                       class="w-full bg-[#aab7c4]/90 border-none rounded-lg py-3.5 px-6 text-slate-800 font-bold placeholder-slate-600 focus:outline-none focus:ring-2 focus:ring-[#00b4ff] transition-all">
            </div>
            
            <div class="flex gap-2">
                <input type="hidden" name="category" value="{{ request('category') }}">
                
                <button type="submit" class="bg-[#2e7d32] hover:bg-[#1b5e20] text-white px-10 py-3.5 rounded-lg font-black uppercase tracking-widest text-[11px] shadow-lg transition-all active:scale-95">
                    Cari Koleksi
                </button>

                @if(request('search') || request('category'))
                <a href="{{ route('user.books.index') }}" class="bg-[#d32f2f] hover:bg-[#b71c1c] text-white w-14 flex items-center justify-center rounded-lg shadow-lg active:scale-95 transition-all">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Category Quick Pills --}}
    <div class="flex flex-wrap items-center gap-2.5 pb-2 overflow-x-auto no-scrollbar">
        <a href="{{ route('user.books.index') }}" 
           class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ !request('category') ? 'bg-slate-800 dark:bg-white text-white dark:text-dark' : 'bg-white dark:bg-dark-card border border-slate-100 dark:border-dark-border/10 text-slate-500 dark:text-gray-500 hover:text-primary-600 dark:hover:text-primary-400' }}">
            General
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('user.books.index', ['category' => $cat->id]) }}"
           class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all 
                  {{ request('category') == $cat->id ? 'text-white shadow-lg' : 'bg-white dark:bg-dark-card border border-slate-100 dark:border-dark-border/10 text-slate-500 dark:text-gray-500 hover:border-gray-200 dark:hover:border-gray-800 shadow-sm' }}"
           style="{{ request('category') == $cat->id ? "background:{$cat->color};" : "" }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>

    {{-- Results Metadata --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 py-2 border-b border-slate-50 dark:border-dark-border/10">
        <h2 class="text-[11px] font-black text-slate-400 dark:text-gray-600 uppercase tracking-[0.2em]">Listing {{ $books->total() }} Koleksi Terverifikasi</h2>
        <div class="flex items-center gap-3 text-[10px] font-black text-slate-500 dark:text-gray-500">
            <span>Grid view aktif</span>
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
        </div>
    </div>

    {{-- Books Premium Grid --}}
    @if($books->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($books as $book)
        <a href="{{ route('user.books.show', $book) }}" class="group relative bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
            {{-- Aspect Ratio Cover --}}
            <div class="relative overflow-hidden aspect-[3/4]">
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}"
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center gap-3 transition duration-700 group-hover:scale-110"
                         style="background: linear-gradient(135deg, {{ $book->category->color }}33, {{ $book->category->color }}66)">
                        <i class="fas fa-book text-4xl text-white/50"></i>
                        <span class="text-[8px] font-black text-white/40 uppercase tracking-widest">Sistem Pustaka</span>
                    </div>
                @endif

                {{-- Hover Overlays --}}
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                {{-- Status Badges --}}
                <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                    @if($book->shelf_location)
                        <span class="bg-slate-900/90 text-white text-[8px] font-black px-2 py-0.5 rounded-lg shadow-lg uppercase tracking-widest flex items-center gap-1.5 backdrop-blur-sm ring-1 ring-white/10">
                            <i class="fas fa-map-marker-alt text-primary-400"></i> {{ $book->shelf_location }}
                        </span>
                    @endif
                    @if($book->pdf_file)
                        <span class="bg-primary-600 text-white text-[8px] font-black px-2 py-0.5 rounded-lg shadow-lg uppercase tracking-widest ring-1 ring-white/20">Digital</span>
                    @endif
                    @if($book->stock == 0)
                        <span class="bg-red-600 text-white text-[8px] font-black px-2 py-0.5 rounded-lg shadow-lg uppercase tracking-widest">Out</span>
                    @endif
                </div>
                
                {{-- Quick Actions --}}
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <span class="bg-white text-dark text-[9px] font-black px-4 py-2 rounded-xl uppercase tracking-widest shadow-2xl">Detail Koleksi</span>
                </div>
            </div>

            {{-- Content Section --}}
            <div class="p-4 flex flex-col items-start min-h-[140px]">
                <span class="text-[9px] font-black uppercase tracking-tighter mb-1.5 opacity-60" style="color:{{ $book->category->color }}">
                    {{ $book->category->name }}
                </span>
                <h3 class="text-xs font-black text-slate-800 dark:text-white line-clamp-2 leading-snug tracking-tight mb-1 group-hover:text-primary-600 transition-colors uppercase">
                    {{ $book->title }}
                </h3>
                <p class="text-[10px] font-bold text-slate-400 dark:text-gray-600 italic truncate w-full mb-auto">{{ $book->author }}</p>
                
                <div class="w-full pt-3 mt-4 border-t border-slate-50 dark:border-dark-border/10 flex items-center justify-between">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-[9px] text-amber-500"></i>
                        <span class="text-[10px] font-black text-slate-700 dark:text-gray-300">{{ number_format($book->rating,1) }}</span>
                    </div>
                    <span class="text-[9px] font-black {{ $book->stock > 0 ? 'text-emerald-500' : 'text-red-500' }} uppercase tracking-widest">
                        {{ $book->stock > 0 ? $book->stock . ' Unit' : 'Sold Out' }}
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- Pagination Controls --}}
    <div class="pt-12 pb-6 border-t border-slate-50 dark:border-dark-border/10">
        {{ $books->links() }}
    </div>

    @else
    {{-- Empty State --}}
    <div class="bg-[#aab7c4]/40 rounded-3xl py-32 text-center border-2 border-dashed border-[#aab7c4]">
        <div class="w-24 h-24 bg-white/50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 shadow-inner">
            <i class="fas fa-search-minus text-[#aab7c4] text-4xl"></i>
        </div>
        <h3 class="text-xl font-black text-slate-800 uppercase tracking-[0.25em] mb-4">Tidak Ditemukan</h3>
        <p class="text-[11px] text-slate-600 mb-10 max-w-sm mx-auto font-black leading-relaxed italic uppercase opacity-60">Pencarian Anda tidak membuahkan hasil dalam basis data kami.</p>
        <a href="{{ route('user.books.index') }}" class="inline-flex items-center gap-4 bg-[#00b4ff] hover:bg-[#0096d6] text-white px-10 py-4 rounded-xl text-[11px] font-black uppercase tracking-widest transition shadow-xl active:scale-95">
            <i class="fas fa-undo"></i> Reset Semua Filter
        </a>
    </div>
    @endif

</div>
@endsection
