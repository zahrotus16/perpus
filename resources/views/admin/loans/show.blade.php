@extends('layouts.app')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')
@section('page-subtitle', $loan->kode_peminjaman)

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <a href="{{ route('admin.loans.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition font-bold uppercase tracking-wider text-[11px]">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Peminjaman
    </a>

    <div class="bg-white dark:bg-dark-card rounded-2xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
        {{-- Header Section --}}
        <div class="p-6 border-b border-slate-100 dark:border-dark-border/10 flex items-center justify-between bg-slate-50/50 dark:bg-dark/30">
            <div>
                <p class="text-[10px] text-slate-400 dark:text-gray-500 font-bold uppercase tracking-widest mb-1">Kode Transaksi</p>
                <h2 class="text-2xl font-black text-slate-800 dark:text-white font-mono tracking-tighter">{{ $loan->kode_peminjaman }}</h2>
            </div>
            <div class="flex flex-col items-end gap-2">
                @if($loan->status === 'dipinjam')
                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 px-4 py-2 rounded-xl ring-1 ring-inset ring-blue-600/20 dark:ring-blue-400/20">
                    <span class="w-2 h-2 rounded-full bg-blue-500 badge-pulse"></span> Dipinjam
                </span>
                @elseif($loan->status === 'dikembalikan')
                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-xl ring-1 ring-inset ring-emerald-600/20 dark:ring-emerald-400/20">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Dikembalikan
                </span>
                @elseif($loan->status === 'pending')
                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 px-4 py-2 rounded-xl ring-1 ring-inset ring-amber-600/20 dark:ring-amber-400/20">
                    <span class="w-2 h-2 rounded-full bg-amber-500 badge-pulse"></span> Menunggu Konfirmasi
                </span>
                @else
                <span class="inline-flex items-center gap-1.5 text-xs font-bold bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400 px-4 py-2 rounded-xl ring-1 ring-inset ring-red-600/20 dark:ring-red-400/20">
                    <span class="w-2 h-2 rounded-full bg-red-500 badge-pulse"></span> Terlambat
                </span>
                @endif
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                {{-- Anggota --}}
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-user-circle text-primary-500"></i> Informasi Anggota
                    </h3>
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-dark border border-slate-100 dark:border-dark-border/10">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-primary-400 to-purple-600 flex items-center justify-center text-white text-lg font-bold shadow-sm">
                            {{ strtoupper(substr($loan->user->name,0,1)) }}
                        </div>
                        <div>
                            <p class="text-base font-bold text-slate-800 dark:text-white leading-none">{{ $loan->user->name }}</p>
                            <p class="text-xs text-slate-400 dark:text-gray-500 mt-1.5 font-mono">{{ $loan->user->member_id }}</p>
                        </div>
                    </div>
                </div>

                {{-- Buku --}}
                <div class="space-y-4">
                    <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-book text-primary-500"></i> Informasi Buku
                    </h3>
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-dark border border-slate-100 dark:border-dark-border/10">
                        <p class="text-base font-bold text-slate-800 dark:text-white leading-tight mb-1">{{ $loan->book->title }}</p>
                        <p class="text-xs text-slate-400 dark:text-gray-500 italic">{{ $loan->book->author }}</p>
                        <div class="mt-2 flex items-center gap-2">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full ring-1 ring-inset ring-slate-200 dark:ring-dark-border/20 bg-white dark:bg-dark-card text-slate-500 dark:text-gray-400">
                                {{ optional($loan->book->category)->name ?? '-' }} </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 py-6 border-t border-slate-100 dark:border-dark-border/10">
                <div>
                    <p class="text-[10px] text-slate-400 dark:text-gray-500 font-bold uppercase tracking-wider mb-1.5">Tanggal Pinjam</p>
                    <p class="text-sm font-bold text-slate-700 dark:text-white">{{ $loan->tgl_pinjam ? $loan->tgl_pinjam->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 dark:text-gray-500 font-bold uppercase tracking-wider mb-1.5">Batas Kembali</p>
                    <p class="text-sm font-bold {{ $loan->isOverdue() ? 'text-red-600 dark:text-red-400 underline underline-offset-4 decoration-red-500/30' : 'text-slate-700 dark:text-white' }}">{{ $loan->tgl_kembali ? $loan->tgl_kembali->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 dark:text-gray-500 font-bold uppercase tracking-wider mb-1.5">Dikembalikan</p>
                    <p class="text-sm font-bold text-slate-700 dark:text-white">{{ $loan->pengembalian ? $loan->pengembalian->tgl_dikembalikan->format('d M Y') : '-' }}</p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 dark:text-gray-500 font-bold uppercase tracking-wider mb-1.5">Status Denda</p>
                    <p class="text-sm font-bold {{ ($loan->pengembalian->denda ?? 0) > 0 ? 'text-red-600 dark:text-red-400' : 'text-slate-400 dark:text-gray-600' }}">
                        {{ ($loan->pengembalian->denda ?? 0) > 0 ? 'Rp '.number_format($loan->pengembalian->denda,0,',','.') : 'Nihil' }}
                    </p>
                </div>
            </div>

            @php $fine = $loan->pengembalian->denda ?? $loan->calculateFine(); @endphp
            @if($fine > 0)
            <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 rounded-2xl border border-red-100 dark:border-red-900/30 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center text-red-600 dark:text-red-400 shadow-sm flex-shrink-0">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                <div>
                    <p class="text-xs text-red-500 dark:text-red-400 font-bold uppercase tracking-tight">Keterlambatan Terdeteksi</p>
                    <p class="text-sm text-red-700 dark:text-red-300 font-bold">Total denda sebesar Rp {{ number_format($fine,0,',','.') }} telah diakumulasikan.</p>
                </div>
            </div>
            @endif

            @if($loan->catatan)
            <div class="mt-8">
                <p class="text-[10px] text-slate-400 dark:text-gray-500 font-bold uppercase tracking-widest mb-2">Catatan Peminjaman</p>
                <div class="text-sm text-slate-600 dark:text-gray-400 bg-slate-50 dark:bg-dark rounded-2xl p-4 border border-slate-100 dark:border-dark-border/10 italic leading-relaxed">
                    {{ $loan->catatan }}
                </div>
            </div>
            @endif

            @if($loan->status !== 'dikembalikan' && $loan->status !== 'pending')
            <div class="mt-10 pt-8 border-t border-slate-100 dark:border-dark-border/10">
                <button type="button" onclick="openReturnModal()"
                    class="w-full flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-6 py-4 rounded-2xl font-bold transition shadow-xl shadow-primary-900/20 active:scale-[0.98]">
                    <i class="fas fa-check-circle"></i> Selesaikan Transaksi & Kembalikan Buku
                </button>
                <p class="text-center text-[10px] text-slate-400 dark:text-gray-600 mt-4 uppercase tracking-widest">Aksi ini akan mencatat tanggal pengembalian hari ini.</p>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Return Confirmation Modal --}}
<div id="returnModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onclick="closeReturnModal()"></div>

    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl p-8 text-center shadow-2xl border border-slate-100 transform scale-95 transition-all duration-300" id="returnModalContent">
        <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-500 shadow-inner">
            <i class="fas fa-clipboard-check text-4xl"></i>
        </div>

        <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-2">Konfirmasi Pengembalian</h2>
        <p class="text-xs font-bold text-slate-500 leading-relaxed mb-8">
            Apakah Anda yakin ingin memproses pengembalian buku
            <span class="text-slate-800">{{ $loan->book->title }}</span> oleh <span class="text-slate-800">{{ $loan->user->name }}</span>?
        </p>

        <div class="flex items-center gap-4">
            <button onclick="closeReturnModal()" type="button"
                class="flex-1 px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-sm">
                Batal
            </button>
            <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="flex-1 m-0">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="w-full px-6 py-3.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-primary-900/20">
                    Ya, Kembalikan
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openReturnModal() {
        const modal = document.getElementById('returnModal');
        const content = document.getElementById('returnModalContent');
        modal.classList.remove('hidden');
        // Small delay to allow display flex to apply before opacity transition
        setTimeout(() => {
            modal.classList.add('flex', 'opacity-100');
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeReturnModal() {
        const modal = document.getElementById('returnModal');
        const content = document.getElementById('returnModalContent');

        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
</script>
@endpush
@endsection