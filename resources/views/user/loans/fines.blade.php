@extends('layouts.app')

@section('title', 'Denda Layanan')
@section('page-title', 'Informasi Denda')
@section('page-subtitle', 'Pantau status kewajiban administrasi sirkulasi Anda')

@section('content')
<div class="space-y-8">

    {{-- Fine Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="group relative bg-white p-8 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#00b4ff]/5 rounded-bl-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-[#00b4ff]/10 text-[#00b4ff] flex items-center justify-center mb-6 border border-[#00b4ff]/20 shadow-inner">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Kewajiban</p>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($totalFine, 0, ',', '.') }}</h2>
            </div>
        </div>

        <div class="group relative bg-white p-8 rounded-2xl shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-12 -mt-12 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6 border border-amber-100/50 shadow-inner">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Estimasi Berjalan</p>
                <h2 class="text-4xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($potentialFine, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>

    {{-- Fines Table --}}
    <div class="bg-white dark:bg-dark-card rounded-3xl shadow-sm dark:shadow-dark-soft border border-slate-100 dark:border-dark-border/20 overflow-hidden">
        <div class="px-8 py-5 border-b border-slate-50 dark:border-dark-border/10">
            <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest flex items-center gap-3">
                <i class="fas fa-list-ul text-[#00b4ff]"></i> Rincian Kewajiban & Denda
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#00b4ff] text-white uppercase text-[11px] font-black tracking-tight">
                        <th class="px-8 py-4">Nama (Judul Buku)</th>
                        <th class="px-8 py-4 border-l border-white/10 text-center">Hari Terlambat</th>
                        <th class="px-8 py-4 border-l border-white/10 text-right">Total Denda</th>
                        <th class="px-8 py-4 border-l border-white/10 text-center">Tanggal Kembali</th>
                        <th class="px-8 py-4 border-l border-white/10 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-dark-border/10">
                    @forelse($fines as $loan)
                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-white/5 transition-colors">
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black text-slate-800 dark:text-white uppercase block leading-tight mb-0.5">{{ $loan->book->title }}</span>
                            <span class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">{{ $loan->book->category->name }}</span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="bg-red-50 dark:bg-red-900/20 text-red-600 text-[10px] font-black px-2.5 py-1 rounded-lg border border-red-100 dark:border-red-900/30">
                                {{ $loan->getDaysOverdue() }} Hari
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right font-black text-slate-800 dark:text-white text-xs">
                            Rp {{ number_format($loan->pengembalian->denda ?? $loan->calculateFine(), 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-5 text-center text-[10px] font-bold text-slate-500 uppercase italic">
                            {{ $loan->pengembalian ? $loan->pengembalian->tgl_dikembalikan->format('d/m/Y') : 'Belum Kembali' }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('user.loans.show', $loan) }}" 
                               class="group bg-sky-400 hover:bg-sky-500 text-white px-4 py-1.5 rounded-full text-[9px] font-black uppercase transition-all active:scale-95 flex items-center justify-center gap-2 mx-auto w-fit shadow-md shadow-sky-100">
                                <span class="w-4 h-4 rounded-full bg-white flex items-center justify-center text-sky-400">
                                    <i class="fas fa-check text-[8px]"></i>
                                </span>
                                Verifikasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="fas fa-check-shield text-emerald-500/20 text-6xl mb-2"></i>
                                <h3 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-widest">Semua Bersih!</h3>
                                <p class="text-[10px] font-bold text-slate-400 italic">Anda tidak memiliki riwayat atau tagihan denda saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Help Card --}}
    <div class="bg-blue-50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-2xl p-6 flex gap-6 items-start">
        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-lg shadow-blue-900/20">
            <i class="fas fa-info-circle text-lg"></i>
        </div>
        <div>
            <h4 class="text-xs font-black text-blue-900 dark:text-blue-400 uppercase tracking-widest mb-1">Cara Pembayaran Denda</h4>
            <p class="text-[11px] text-blue-700 dark:text-blue-500/80 font-medium leading-relaxed italic">
                Pelunasan denda hanya dapat dilakukan secara tunai di meja sirkulasi perpustakaan saat pengembalian buku. Pastikan Anda mendapatkan bukti pembayaran digital setelah pelunasan dilakukan oleh petugas.
            </p>
        </div>
    </div>

</div>
@endsection
