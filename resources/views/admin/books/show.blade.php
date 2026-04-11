@extends('layouts.app')

@section('title', $book->title)
@section('page-title', 'Detail Koleksi')
@section('page-subtitle', 'Informasi mendalam mengenai ketersediaan dan performa buku')



@section('navbar-actions')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.books.edit', $book) }}" class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-primary-900/20 active:scale-95">
            <i class="fas fa-edit"></i> Edit Buku
        </a>
    </div>
@endsection

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <a href="{{ route('admin.books.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition font-bold uppercase tracking-widest text-[10px]">
        <i class="fas fa-arrow-left"></i> Kembali ke Katalog Utama
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Left: Cover & Quick Actions --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-dark-card rounded-2xl shadow-xl dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden ring-4 ring-white dark:ring-dark shadow-2xl">
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}" class="w-full object-cover aspect-[3/4]">
                @else
                    <div class="w-full aspect-[3/4] bg-gradient-to-br from-slate-100 to-slate-200 dark:from-dark dark:to-dark-card flex flex-col items-center justify-center gap-4">
                        <i class="fas fa-book text-slate-300 dark:text-gray-700 text-6xl"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-gray-600">Sampul Kosong</span>
                    </div>
                @endif
            </div>

            <div class="space-y-3">
                @if($book->pdf_file)
                <a href="{{ asset('storage/'.$book->pdf_file) }}" target="_blank"
                   class="w-full flex items-center justify-center gap-3 bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-900/30 px-4 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition hover:bg-red-100 dark:hover:bg-red-900/30 shadow-sm active:scale-95">
                    <i class="fas fa-file-pdf text-lg"></i> Akses Berkas Digital
                </a>
                @endif

                <form action="{{ route('admin.books.destroy', $book) }}" method="POST"
                      onsubmit="return confirm('Tindakan ini permanen. Hapus buku ini dari sistem?')">
                    @csrf @method('DELETE')
                    <button class="w-full flex items-center justify-center gap-3 bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 border border-red-200 dark:border-red-900/30 px-4 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition shadow-sm active:scale-95">
                        <i class="fas fa-trash-alt"></i> Hapus dari Koleksi
                    </button>
                </form>
            </div>
        </div>

        {{-- Center/Right: Detailed Info --}}
        <div class="lg:col-span-3 space-y-6">
            {{-- Main Metadata --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-8">
                <div class="flex flex-col md:flex-row items-start justify-between gap-6 mb-8 border-b border-slate-100 dark:border-dark-border/10 pb-6">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="inline-block px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest ring-1 ring-inset"
                                  style="background:{{ $book->category->color }}15; color:{{ $book->category->color }}; ring-color:{{ $book->category->color }}30">
                                {{ $book->category->name }}
                            </span>
                            <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $book->stock > 0 ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 ring-1 ring-emerald-500/20' : 'bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 ring-1 ring-red-500/20' }}">
                                {{ $book->stock > 0 ? 'Stok Tersedia' : 'Out of Stock' }}
                            </span>
                        </div>
                        <h2 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-tight mb-2">{{ $book->title }}</h2>
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm">
                            <p class="text-slate-500 dark:text-gray-400 font-bold italic flex items-center gap-2">
                                <i class="fas fa-user-edit text-primary-500 opacity-50"></i> {{ $book->author }}
                            </p>
                            <p class="text-slate-400 dark:text-gray-500 flex items-center gap-2">
                                <i class="fas fa-building text-slate-300 dark:text-gray-700"></i> {{ $book->publisher ?: 'Penerbit N/A' }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-row md:flex-col items-center gap-4 bg-slate-50 dark:bg-dark p-4 rounded-2xl border border-slate-100 dark:border-dark-border/10">
                        <div class="text-center md:border-b border-slate-200 dark:border-dark-border/20 pb-0 md:pb-2 w-full">
                            <p class="text-2xl font-black text-slate-800 dark:text-white leading-none mb-1">{{ number_format($book->rating, 1) }}</p>
                            <div class="flex justify-center gap-0.5 mb-1">
                                @for($i=1;$i<=5;$i++)
                                <i class="fas fa-star text-[8px] {{ $i <= round($book->rating) ? 'text-amber-400' : 'text-slate-300 dark:text-gray-700' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="text-center pt-0 md:pt-2 w-full">
                            <p class="text-sm font-black text-slate-800 dark:text-white leading-none mb-1">{{ $book->views }}</p>
                            <p class="text-[8px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-widest leading-none">Views</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-y-8 gap-x-4">
                    <div>
                        <p class="text-[10px] text-slate-400 dark:text-gray-500 font-black uppercase tracking-widest mb-1.5">Tahun Rilis</p>
                        <p class="text-sm font-bold text-slate-700 dark:text-white">{{ $book->year ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 dark:text-gray-500 font-black uppercase tracking-widest mb-1.5">Standar ISBN</p>
                        <p class="text-sm font-bold text-slate-700 dark:text-white font-mono uppercase tracking-tight">{{ $book->isbn ?: 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 dark:text-gray-500 font-black uppercase tracking-widest mb-1.5">Ketebalan</p>
                        <p class="text-sm font-bold text-slate-700 dark:text-white">{{ $book->pages ? $book->pages . ' Halaman' : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 dark:text-gray-500 font-black uppercase tracking-widest mb-1.5">Inventori Stok</p>
                        <p class="text-sm font-bold text-slate-700 dark:text-white">sisa {{ $book->stock }} <span class="text-slate-400 dark:text-gray-600 font-normal">/ total {{ $book->total_stock }} ekspl</span></p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 dark:text-gray-500 font-black uppercase tracking-widest mb-1.5 underline decoration-primary-500 decoration-2 underline-offset-4">Lokasi Rak Fisik</p>
                        <p class="text-sm font-black text-primary-600 dark:text-primary-400 flex items-center gap-2">
                            <i class="fas fa-map-marker-alt"></i> {{ $book->shelf_location ?: 'Belum Diatur' }}
                        </p>
                    </div>
                </div>

                @if($book->description)
                <div class="mt-10 border-t border-slate-100 dark:border-dark-border/10 pt-8">
                    <p class="text-[10px] text-slate-400 dark:text-gray-500 font-black uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="fas fa-align-left text-primary-500/50"></i> Ikhtisar & Sinopsis
                    </p>
                    <p class="text-sm text-slate-600 dark:text-gray-400 leading-loose text-justify italic">"{{ $book->description }}"</p>
                </div>
                @endif
            </div>

            {{-- Activity Tabs --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Loans History Card --}}
                <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-dark-border/10 bg-slate-50/50 dark:bg-dark/30">
                        <h3 class="font-black text-slate-800 dark:text-white uppercase tracking-widest text-[10px]">Riwayat Peminjaman Terakhir</h3>
                    </div>
                    <div class="p-0">
                        @if($book->loans->count())
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50 dark:bg-dark text-[9px] text-slate-400 dark:text-gray-500 font-black uppercase tracking-widest border-b border-slate-100 dark:border-dark-border/10">
                                    <tr>
                                        <th class="px-6 py-3">Nama Anggota</th>
                                        <th class="px-6 py-3 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-dark-border/10">
                                @foreach($book->loans->take(6) as $loan)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors group text-xs">
                                    <td class="px-6 py-3">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800 dark:text-white">{{ $loan->user->name }}</span>
                                            <span class="text-[9px] text-slate-400 dark:text-gray-600 uppercase font-bold">{{ $loan->loan_date->format('d/m/y') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 text-center">
                                        <span class="px-2 py-0.5 rounded-lg text-[8px] font-black uppercase tracking-tighter
                                            {{ $loan->status === 'borrowed' ? 'text-blue-600 dark:text-blue-400' :
                                              ($loan->status === 'returned' ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400') }}">
                                            {{ $loan->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="py-12 text-center text-[10px] font-bold text-slate-400 dark:text-gray-600 uppercase tracking-widest">Tidak ada record pinjaman</div>
                        @endif
                    </div>
                </div>

                {{-- Recent Reviews Card --}}
                <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-dark-border/10 bg-slate-50/50 dark:bg-dark/30">
                        <h3 class="font-black text-slate-800 dark:text-white uppercase tracking-widest text-[10px]">Ulasan Pembaca Terbaru</h3>
                    </div>
                    <div class="p-6">
                        @if($book->reviews->count())
                        <div class="space-y-6">
                            @foreach($book->reviews->take(4) as $review)
                            <div class="relative group">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-dark flex items-center justify-center text-primary-600 dark:text-primary-400 text-xs font-black ring-1 ring-slate-200 dark:ring-dark-border/10">
                                        {{ strtoupper(substr($review->user->name,0,1)) }}
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs font-black text-slate-800 dark:text-white flex items-center justify-between">
                                            {{ $review->user->name }}
                                            <span class="text-[8px] text-slate-400 dark:text-gray-700 font-bold uppercase">{{ $review->created_at->diffForHumans() }}</span>
                                        </p>
                                        <div class="flex gap-0.5 mt-0.5">
                                            @for($i=1;$i<=5;$i++)
                                            <i class="fas fa-star text-[8px] {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200 dark:text-gray-800' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                @if($review->comment)
                                <p class="text-xs text-slate-600 dark:text-gray-500 pl-11 leading-normal italic">"{{ \Illuminate\Support\Str::limit($review->comment, 80) }}"</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="py-12 text-center text-[10px] font-bold text-slate-400 dark:text-gray-600 uppercase tracking-widest">Belum ada ulasan</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
