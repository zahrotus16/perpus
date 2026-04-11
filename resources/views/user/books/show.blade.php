@extends('layouts.app')

@section('title', $book->title)
@section('page-title', 'Detail Koleksi')
@section('page-subtitle', 'Informasi lengkap dan ketersediaan buku')



@section('content')
<div x-data="{ showLoanModal: false }" class="max-w-5xl mx-auto space-y-6">

    <a href="{{ route('user.books.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition font-bold uppercase tracking-widest text-[10px]">
        <i class="fas fa-arrow-left"></i> Kembali ke Katalog Utama
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left: Cover & Actions --}}
        <div class="space-y-6">
            {{-- Cover Card --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl shadow-xl dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden ring-4 ring-white dark:ring-dark shadow-2xl">
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}" alt="{{ $book->title }}" class="w-full object-cover aspect-[3/4]">
                @else
                    <div class="w-full aspect-[3/4] flex flex-col items-center justify-center gap-4" style="background:linear-gradient(135deg,{{ $book->category->color }}33,{{ $book->category->color }}66)">
                        <i class="fas fa-book text-6xl text-white opacity-50"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest text-white opacity-70">Sampul Khas</span>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-3">
                @if($book->pdf_file)
                <a href="{{ route('user.books.read', $book) }}"
                   class="w-full flex items-center justify-center gap-3 bg-[#00b4ff] hover:bg-[#0096d6] text-white px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition shadow-lg active:scale-95">
                    <i class="fas fa-book-open text-lg"></i> Baca Versi Digital
                </a>
                @endif

                @if($userLoan)
                    <div class="w-full flex flex-col items-center justify-center gap-1 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-widest">
                        <div class="flex items-center gap-2"><i class="fas fa-circle-check"></i> Sedang Dipinjam</div>
                        <span class="text-[9px] opacity-70 font-bold italic lowercase italic tracking-normal">Batas Kembali: {{ $userLoan->due_date->format('d M Y') }}</span>
                    </div>
                @elseif(auth()->user()->activeLoans()->count() >= 3)
                    <div class="w-full flex flex-col items-center justify-center gap-1 bg-amber-50 dark:bg-amber-950/20 text-amber-700 dark:text-amber-500 border border-amber-100 dark:border-amber-900/30 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-widest">
                        <div class="flex items-center gap-2"><i class="fas fa-exclamation-triangle"></i> Batas Pinjam Tercapai</div>
                        <span class="text-[9px] opacity-70 font-bold italic lowercase italic tracking-normal">Maksimal 3 buku aktif</span>
                    </div>
                @elseif($book->isAvailable())
                    <div class="relative">
                        <button @click="showLoanModal = true" class="w-full flex items-center justify-center gap-3 bg-slate-900 dark:bg-white dark:text-dark hover:bg-black dark:hover:bg-gray-100 text-white px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition shadow-xl active:scale-95 group overflow-hidden">
                            <span class="relative z-10 flex items-center gap-3">
                                <i class="fas fa-hand-holding group-hover:rotate-12 transition-transform"></i> Ajukan Pinjaman
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-400 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                        </button>

                        {{-- Premium Loan Modal --}}
                        <template x-teleport="body">
                            <div x-show="showLoanModal" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md">
                                
                                <div @click.away="showLoanModal = false" 
                                     x-show="showLoanModal"
                                     x-transition:enter="transition ease-out duration-300 transform"
                                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-200 transform"
                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                                     class="relative bg-white dark:bg-dark-card w-full max-w-md rounded-[2.5rem] shadow-2xl border border-white/20 overflow-hidden">
                                    
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
                                    
                                    <div class="p-10 text-center relative">
                                        <div class="w-20 h-20 bg-primary-50 dark:bg-primary-500/10 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-inner ring-1 ring-primary-100 dark:ring-primary-500/20">
                                            <i class="fas fa-calendar-check text-3xl text-primary-600"></i>
                                        </div>
                                        
                                        <h3 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tight mb-3">Konfirmasi Pinjaman</h3>
                                        <p class="text-xs font-medium text-slate-500 dark:text-gray-400 leading-relaxed mb-10 px-4">
                                            Anda akan meminjam <span class="font-black text-slate-800 dark:text-white">"{{ $book->title }}"</span> dengan durasi standar <span class="font-black text-primary-600">7 Hari</span>. Pastikan Anda merawat koleksi ini dengan baik.
                                        </p>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <button @click="showLoanModal = false" class="px-6 py-4 bg-slate-100 dark:bg-dark/50 hover:bg-slate-200 dark:hover:bg-dark text-slate-600 dark:text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-2xl transition active:scale-95">
                                                Batalkan
                                            </button>
                                            <form action="{{ route('user.books.borrow', $book) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full px-6 py-4 bg-primary-600 hover:bg-primary-700 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-primary-600/30 transition active:scale-95">
                                                    Ya, Pinjam
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="bg-slate-50 dark:bg-dark/30 px-10 py-4 border-t border-slate-100 dark:border-dark-border/10">
                                        <div class="flex items-center justify-center gap-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                            <i class="fas fa-shield-alt text-emerald-500"></i> Pengembalian Aman & Terlindungi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                @else
                    <div class="w-full flex items-center justify-center gap-3 bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/30 px-5 py-4 rounded-2xl text-xs font-black uppercase tracking-widest">
                        <i class="fas fa-ban"></i> Persediaan Habis
                    </div>
                @endif

                {{-- Wishlist Toggle --}}
                <form action="{{ route('user.books.wishlist', $book) }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-3 {{ $isWishlisted ? 'bg-pink-50 dark:bg-pink-950/20 text-pink-600 dark:text-pink-400 border border-pink-200 dark:border-pink-900/30' : 'bg-white dark:bg-dark-card border border-slate-200 dark:border-dark-border/20 text-slate-400 dark:text-gray-600 hover:text-pink-600 dark:hover:text-pink-400 hover:bg-pink-50 dark:hover:bg-pink-950/20 transition' }} px-5 py-3 rounded-2xl text-xs font-black uppercase tracking-widest shadow-sm active:scale-95">
                        <i class="fas fa-heart {{ $isWishlisted ? 'text-pink-500' : '' }}"></i>
                        {{ $isWishlisted ? 'Hapus Wishlist' : 'Tambah Wishlist' }}
                    </button>
                </form>
            </div>

            {{-- Technical Metadata Card --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-6 space-y-4">
                <h4 class="text-[10px] font-black text-slate-400 dark:text-gray-600 uppercase tracking-widest mb-4">Spesifikasi Teknis</h4>
                
                <div class="flex justify-between items-center text-xs pb-3 border-b border-slate-50 dark:border-dark-border/10">
                    <span class="font-bold text-slate-400 dark:text-gray-500 uppercase tracking-tighter">Kategori</span>
                    <span class="font-black text-slate-800 dark:text-white uppercase tracking-tighter">{{ $book->category->name }}</span>
                </div>
                <div class="flex justify-between items-center text-xs pb-3 border-b border-slate-50 dark:border-dark-border/10">
                    <span class="font-bold text-slate-400 dark:text-gray-500 uppercase tracking-tighter">Tahun Rilis</span>
                    <span class="font-black text-slate-800 dark:text-white">{{ $book->year ?: 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center text-xs pb-3 border-b border-slate-50 dark:border-dark-border/10">
                    <span class="font-bold text-slate-400 dark:text-gray-500 uppercase tracking-tighter">Penerbit</span>
                    <span class="font-black text-slate-800 dark:text-white uppercase tracking-tighter">{{ $book->publisher ?: 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center text-xs pb-3 border-b border-slate-50 dark:border-dark-border/10">
                    <span class="font-bold text-slate-400 dark:text-gray-500 uppercase tracking-tighter">Ketebalan</span>
                    <span class="font-black text-slate-800 dark:text-white">{{ $book->pages ?: '0' }} <span class="text-[9px] opacity-50">HAL</span></span>
                </div>
                <div class="flex justify-between items-center text-xs pb-3 border-b border-slate-50 dark:border-dark-border/10">
                    <span class="font-bold text-slate-400 dark:text-gray-500 uppercase tracking-tighter">Ketersediaan</span>
                    <span class="font-black {{ $book->stock > 0 ? 'text-emerald-500' : 'text-red-500' }} uppercase">{{ $book->stock > 0 ? $book->stock . ' Unit' : 'Kosong' }}</span>
                </div>
                <div class="text-center pt-2">
                    <p class="text-[9px] font-black text-slate-300 dark:text-gray-700 uppercase tracking-[0.2em] font-mono">{{ $book->isbn ?: 'No-ISBN-Recorded' }}</p>
                </div>
            </div>
        </div>

        {{-- Right: Primary Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Main Information Card --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-8">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="inline-block px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest ring-1 ring-inset" 
                          style="background:{{ $book->category->color }}15; color:{{ $book->category->color }}; ring-color:{{ $book->category->color }}30">
                        {{ $book->category->name }}
                    </span>
                    <div class="flex items-center gap-1.5 ml-auto">
                        <div class="flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-[10px] {{ $i <= round($book->rating) ? 'text-amber-400' : 'text-slate-200 dark:text-gray-800' }}"></i>
                            @endfor
                        </div>
                        <span class="text-xs font-black text-slate-800 dark:text-white">{{ number_format($book->rating,1) }}</span>
                    </div>
                </div>

                <h1 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight leading-tight mb-2">{{ $book->title }}</h1>
                <p class="text-slate-500 dark:text-gray-400 font-bold italic text-lg opacity-80 mb-6">{{ $book->author }}</p>

                <div class="flex items-center gap-6 py-4 border-y border-slate-50 dark:border-dark-border/10 text-xs font-black uppercase tracking-widest text-slate-400 dark:text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-eye text-primary-500/50"></i>
                        <span>{{ $book->views }} <span class="hidden sm:inline">Pembaca</span></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-comment-alt text-emerald-500/50"></i>
                        <span>{{ $book->rating_count }} <span class="hidden sm:inline">Ulasan</span></span>
                    </div>
                    @if($book->pdf_file)
                    <div class="flex items-center gap-2">
                        <i class="fas fa-file-pdf text-red-500/50"></i>
                        <span>Digital</span>
                    </div>
                    @endif
                </div>

                @if($book->shelf_location)
                <div class="mt-8 p-6 rounded-2xl bg-slate-900 border border-slate-800 shadow-2xl relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-500/10 rounded-full -mr-16 -mt-16 blur-3xl transition-all group-hover:bg-primary-500/20"></div>
                    <div class="relative flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2">Informasi Penempatan Koleksi</p>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#00b4ff] flex items-center justify-center shadow-lg shadow-[#00b4ff]/20">
                                    <i class="fas fa-map-marker-alt text-white text-lg"></i>
                                </div>
                                <div>
                                    <h4 class="text-white text-xl font-black tracking-tight">{{ $book->shelf_location }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic leading-tight mt-1">Silakan cari di rak berkode tersebut</p>
                                </div>
                            </div>
                        </div>
                        <div class="hidden sm:block text-right">
                            <span class="text-[8px] font-black text-slate-700 uppercase tracking-widest border border-slate-800 px-3 py-1.5 rounded-lg mb-2 inline-block">Lokasi Terverifikasi</span>
                        </div>
                    </div>
                </div>
                @endif

                @if($book->description)
                <div class="mt-8">
                    <p class="text-[10px] font-black text-slate-400 dark:text-gray-600 uppercase tracking-widest mb-4">Sinopsis & Ringkasan</p>
                    <p class="text-sm text-slate-600 dark:text-gray-300 leading-loose text-justify italic">"{{ $book->description }}"</p>
                </div>
                @endif
            </div>

            {{-- Review Section --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
                <div class="px-7 py-5 border-b border-slate-100 dark:border-dark-border/10 bg-slate-50/50 dark:bg-dark/30 flex items-center justify-between">
                    <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest">Opini & Ulasan Pembaca</h3>
                </div>

                <div class="p-10">
                    {{-- Statistik Rating - Sleek Row Layout --}}
                    <div class="flex flex-col lg:flex-row gap-12 mb-16 items-center">
                        <div class="w-full lg:w-1/3 text-center lg:border-r border-slate-100 dark:border-dark-border/10 lg:pr-12">
                            <div class="text-7xl font-black text-slate-900 dark:text-white tracking-tighter mb-3">{{ number_format($book->rating, 1) }}</div>
                            <div class="flex justify-center gap-1.5 mb-4">
                                @for($i=1;$i<=5;$i++)
                                <i class="fas fa-star text-[16px] {{ $i <= round($book->rating) ? 'text-amber-400' : 'text-slate-100 dark:text-gray-800' }}"></i>
                                @endfor
                            </div>
                            <p class="text-[10px] font-black text-slate-400 dark:text-gray-500 uppercase tracking-[0.3em] font-mono">{{ $book->rating_count }} TOTAL ULASAN</p>
                        </div>
                        
                        <div class="w-full lg:w-2/3 space-y-4">
                            @foreach($starDistribution as $star => $count)
                            @php 
                                $percentage = $book->rating_count > 0 ? ($count / $book->rating_count) * 100 : 0;
                            @endphp
                            <div class="flex items-center gap-5 group">
                                <div class="flex items-center gap-1.5 w-12 flex-shrink-0">
                                    <span class="text-[10px] font-black text-slate-600 dark:text-gray-400">{{ $star }}</span>
                                    <i class="fas fa-star text-[8px] text-amber-400"></i>
                                </div>
                                <div class="flex-1 h-2.5 bg-slate-100 dark:bg-dark/40 rounded-full overflow-hidden border border-white/50 dark:border-white/5 relative shadow-inner">
                                    <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 rounded-full transition-all duration-[1.5s] ease-out group-hover:brightness-110" 
                                         style="width: {{ $percentage }}%"></div>
                                </div>
                                <div class="w-12 text-right">
                                    <span class="text-[10px] font-black text-slate-400 dark:text-gray-600">{{ number_format($percentage, 0) }}%</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="relative h-px w-full mb-16 px-20">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-slate-200 dark:via-dark-border/20 to-transparent"></div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white dark:bg-dark-card px-4 text-[9px] font-black text-slate-300 dark:text-gray-700 uppercase tracking-[0.5em]">Tulis Ulasan</div>
                    </div>
                    {{-- Form Ulasan --}}
                    @if(!$userReview)
                    <div class="relative overflow-hidden group bg-white/40 dark:bg-dark-card/40 backdrop-blur-xl rounded-3xl p-8 mb-10 border border-white/50 dark:border-white/5 shadow-2xl transition-all hover:shadow-primary-500/10">
                        <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary-500/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="relative">
                            <h4 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest mb-2">Bagaimana pengalaman Anda?</h4>
                            <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-6">Berikan skor dan ulasan untuk koleksi ini</p>
                            
                            <form action="{{ route('user.books.review', $book) }}" method="POST" id="review-form">
                                @csrf
                                <div class="flex items-center gap-6 mb-8">
                                    <div class="flex gap-1" id="star-rating-v2">
                                        @for($i=1;$i<=5;$i++)
                                        <label class="relative cursor-pointer group/star">
                                            <input type="radio" name="rating" value="{{ $i }}" class="hidden" required>
                                            <i class="fas fa-star text-3xl text-slate-100 dark:text-gray-800 hover:scale-125 transition-all duration-300 star-icon-v2" data-val="{{ $i }}"></i>
                                            <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[8px] font-black opacity-0 group-hover/star:opacity-100 transition-opacity text-primary-500">{{ $i }}</span>
                                        </label>
                                        @endfor
                                    </div>
                                    <div class="h-8 w-px bg-slate-100 dark:bg-gray-800"></div>
                                    <div id="rating-label" class="text-[10px] font-black text-primary-500 uppercase tracking-[0.2em] animate-pulse">Pilih Skor</div>
                                </div>

                                <div class="relative">
                                    <textarea name="comment" rows="4" placeholder="Tuliskan pendapat Anda di sini..."
                                        class="w-full px-6 py-5 bg-white/50 dark:bg-dark/50 border border-slate-100 dark:border-dark-border/10 rounded-2xl text-sm text-slate-800 dark:text-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 outline-none transition-all resize-none shadow-sm placeholder:italic placeholder:text-slate-300"></textarea>
                                    <div class="absolute bottom-4 right-4 flex items-center gap-2 text-[8px] font-black text-slate-300 dark:text-gray-600 uppercase tracking-widest">
                                        <i class="fas fa-keyboard"></i> Min. 10 Karakter
                                    </div>
                                </div>

                                <div class="mt-6 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></div>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Publik secara anonim</span>
                                    </div>
                                    <button type="submit" class="group relative px-8 py-4 bg-slate-900 dark:bg-primary-600 hover:bg-black dark:hover:bg-primary-700 text-white rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition-all shadow-xl hover:-translate-y-1 active:scale-95 overflow-hidden">
                                        <span class="relative z-10">Kirim Ulasan</span>
                                        <div class="absolute inset-0 bg-gradient-to-r from-primary-400 to-primary-600 opacity-0 group-hover:opacity-20 transition-opacity"></div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="relative overflow-hidden bg-emerald-500/5 dark:bg-emerald-500/10 border border-emerald-500/20 rounded-3xl p-8 mb-10 group">
                        <div class="flex items-center gap-6">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-500 flex items-center justify-center text-white text-2xl shadow-lg shadow-emerald-500/20 group-hover:rotate-12 transition-transform">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-emerald-800 dark:text-emerald-400 uppercase tracking-widest mb-1">Terima Kasih!</h4>
                                <p class="text-xs font-bold text-emerald-600/70 dark:text-emerald-500/50 uppercase tracking-tight">Ulasan Anda telah kami terima dan sangat berarti bagi pembaca lain.</p>
                            </div>
                            <button onclick="document.getElementById('review-form-edit')?.classList.toggle('hidden')" class="ml-auto text-[9px] font-black text-slate-400 hover:text-primary-500 uppercase tracking-widest transition">
                                Ubah Ulasan <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Form Edit Hidden --}}
                    <div id="review-form-edit" class="hidden animate-fadeIn mb-10">
                         <form action="{{ route('user.books.review', $book) }}" method="POST">
                            @csrf
                            <input type="hidden" name="rating" value="{{ $userReview->rating }}">
                            <textarea name="comment" rows="3" class="w-full px-5 py-4 bg-white dark:bg-dark border border-slate-200 dark:border-dark-border/10 rounded-2xl text-sm" placeholder="Perbarui ulasan Anda...">{{ $userReview->comment }}</textarea>
                            <button type="submit" class="mt-2 px-6 py-2 bg-slate-800 text-white text-[10px] font-black uppercase tracking-widest rounded-xl">Simpan Perubahan</button>
                         </form>
                    </div>
                    @endif

                    {{-- List Ulasan - Clean & Modern List --}}
                    @if($book->reviews->count())
                    <div class="space-y-6">
                        @foreach($book->reviews as $review)
                        <div class="group relative bg-slate-50/30 dark:bg-dark/20 p-6 rounded-3xl border border-transparent hover:border-slate-100 dark:hover:border-white/5 transition-all">
                            <div class="flex items-start gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-white to-slate-100 dark:from-dark-card dark:to-dark shadow-sm border border-slate-200/50 dark:border-dark-border/10 flex items-center justify-center text-slate-400 dark:text-white text-sm font-black flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    {{ strtoupper(substr($review->user->name,0,1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-4 mb-2">
                                        <div>
                                            <h5 class="font-black text-[11px] text-slate-800 dark:text-white uppercase tracking-wider mb-1">{{ $review->user->name }}</h5>
                                            <div class="flex gap-0.5">
                                                @for($i=1;$i<=5;$i++)
                                                <i class="fas fa-star text-[8px] {{ $i <= $review->rating ? 'text-amber-400' : 'text-slate-200 dark:text-gray-800' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <span class="text-[9px] font-bold text-slate-400 dark:text-gray-600 uppercase tracking-widest">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($review->comment)
                                    <div class="relative mt-3">
                                        <i class="fas fa-quote-left absolute -left-2 -top-1 text-slate-100 dark:text-gray-800 text-xs opacity-50"></i>
                                        <p class="text-sm text-slate-600 dark:text-gray-400 leading-relaxed italic text-justify px-3">{{ $review->comment }}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="py-16 text-center">
                        <i class="fas fa-quote-left text-slate-100 dark:text-gray-800 text-5xl mb-4"></i>
                        <p class="text-xs font-black text-slate-400 dark:text-gray-600 uppercase tracking-widest">Belum ada opini publik</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Rekomendasi Sejenis --}}
            @if($relatedBooks->count())
            <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 p-8">
                <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest mb-6">Mungkin Anda Suka Juga</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($relatedBooks as $related)
                    <a href="{{ route('user.books.show', $related) }}" class="group block">
                        <div class="aspect-[3/4] overflow-hidden rounded-xl mb-3 shadow-sm group-hover:shadow-xl transition-all group-hover:-translate-y-1">
                            @if($related->cover)
                                <img src="{{ asset('storage/'.$related->cover) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50 dark:bg-dark/50 border border-slate-100 dark:border-dark-border/10">
                                    <i class="fas fa-book text-slate-200 dark:text-gray-800 text-2xl"></i>
                                </div>
                            @endif
                        </div>
                        <p class="text-[10px] font-black text-slate-800 dark:text-white uppercase tracking-tight line-clamp-2 leading-tight group-hover:text-primary-600 transition-colors">{{ $related->title }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Enhanced Star Rating V2
    const starContainer = document.getElementById('star-rating-v2');
    const starsV2 = document.querySelectorAll('.star-icon-v2');
    const ratingLabel = document.getElementById('rating-label');
    const labels = {
        1: 'Kecewa',
        2: 'Kurang',
        3: 'Lumayan',
        4: 'Sangat Bagus',
        5: 'Luar Biasa!'
    };

    function updateStars(val) {
        starsV2.forEach((s, j) => {
            const starVal = j + 1;
            if (starVal <= val) {
                s.classList.remove('text-slate-100', 'dark:text-gray-800');
                s.classList.add('text-amber-400', 'scale-110');
            } else {
                s.classList.add('text-slate-100', 'dark:text-gray-800');
                s.classList.remove('text-amber-400', 'scale-110');
            }
        });
        ratingLabel.textContent = labels[val] || 'Pilih Skor';
        ratingLabel.classList.toggle('animate-pulse', !val);
    }

    starsV2.forEach((star) => {
        star.addEventListener('mouseenter', () => {
            updateStars(star.dataset.val);
        });

        star.addEventListener('click', () => {
            const val = star.dataset.val;
            const input = document.querySelector(`input[name="rating"][value="${val}"]`);
            if (input) {
                input.checked = true;
                starContainer.dataset.selected = val;
                updateStars(val);
            }
        });
    });

    starContainer?.addEventListener('mouseleave', () => {
        const selected = starContainer.dataset.selected || 0;
        updateStars(selected);
    });
</script>
@endpush
