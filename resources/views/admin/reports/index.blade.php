@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan Perpustakaan')
@section('page-subtitle', 'Analisis data peminjaman dan denda terakumulasi')




@push('styles')
<style>
    @media print {

        #sidebar,
        header,
        .no-print,
        .navbar-actions,
        #notificationDropdown,
        #searchDropdown {
            display: none !important;
        }

        .lg\:ml-64 {
            margin-left: 0 !important;
        }

        body {
            background: white !important;
            color: black !important;
        }

        .dark {
            color-scheme: light !important;
        }

        .bg-dark,
        .bg-dark-card,
        .bg-dark-bg {
            background: white !important;
            border-color: #eee !important;
        }

        .text-white,
        .text-gray-400,
        .text-gray-500 {
            color: black !important;
        }

        .rounded-2xl {
            border-radius: 0 !important;
        }

        .shadow-sm,
        .shadow-md,
        .shadow-lg,
        .shadow-dark-soft {
            shadow: none !important;
        }

        table {
            border-collapse: collapse !important;
        }

        th,
        td {
            border: 1px solid #ddd !important;
        }
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    {{-- Content Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print">
        <div>
            <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Analitik & Pelaporan Strategis</h2>
        </div>
        <button onclick="window.print()" class="flex items-center justify-center gap-3 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-xl shadow-emerald-900/20 active:scale-95">
            <i class="fas fa-print text-sm"></i> Cetak Laporan Resmi
        </button>
    </div>
    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 no-print">
        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Parameter Laporan</h4>
        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1.5 uppercase">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date', $startDate->format('Y-m-d')) }}"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1.5 uppercase">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date', $endDate->format('Y-m-d')) }}"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1.5 uppercase">Status Transaksi</label>
                <select name="status" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500 outline-none transition-all">
                    <option value="">Semua Status</option>
                    <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            <button type="submit" class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-emerald-900/20 active:scale-95">
                <i class="fas fa-sync-alt"></i> Perbarui Data
            </button>
        </form>
    </div>

    {{-- Print Header Only --}}
    <div class="hidden print:block text-center mb-10 border-b-2 border-slate-200 pb-6">
        <h1 class="text-3xl font-black tracking-tighter uppercase mb-1">LAPORAN ARSIP PERPUSTAKAAN</h1>
        <p class="text-sm font-bold text-gray-600 uppercase tracking-widest">Sistem Manajemen Pustaka</p>
        <div class="mt-4 flex justify-between items-center text-xs font-mono">
            <span>Periode: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</span>
            <span>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center items-center transition-all hover:border-slate-300">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Transaksi</p>
            <p class="text-3xl font-black text-slate-800 tracking-tighter">{{ $summary['total_loans'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center items-center transition-all hover:border-blue-300">
            <p class="text-[10px] font-black text-blue-500/70 uppercase tracking-widest mb-2">Dipinjam</p>
            <p class="text-3xl font-black text-blue-600 tracking-tighter">{{ $summary['total_borrowed'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center items-center transition-all hover:border-emerald-300">
            <p class="text-[10px] font-black text-emerald-500/70 uppercase tracking-widest mb-2">Dikembalikan</p>
            <p class="text-3xl font-black text-emerald-600 tracking-tighter">{{ $summary['total_returned'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center items-center transition-all hover:border-red-300">
            <p class="text-[10px] font-black text-red-500/70 uppercase tracking-widest mb-2">Terlambat</p>
            <p class="text-3xl font-black text-red-600 tracking-tighter">{{ $summary['total_overdue'] }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col justify-center items-center transition-all hover:border-amber-300 lg:col-span-1 col-span-2">
            <p class="text-[10px] font-black text-amber-500/70 uppercase tracking-widest mb-2">Total Denda</p>
            <p class="text-2xl font-black text-amber-600 tracking-tighter">Rp {{ number_format($summary['total_fine'],0,',','.') }}</p>
        </div>
    </div>



    {{-- Detail Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-white">
            <div>
                <h3 class="font-black text-slate-800 uppercase tracking-widest text-xs">Arsip Rincian Transaksi</h3>
                <p class="text-[10px] font-bold text-slate-400 mt-1 uppercase">Daftar lengkap riwayat peminjaman buku</p>
            </div>
            <span class="px-3 py-1 bg-slate-100 rounded-full text-[10px] font-bold text-slate-500 uppercase">{{ $loans->count() }} Entri Data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/30 text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5">ID</th>
                        <th class="px-8 py-5">Kode Pinjam</th>
                        <th class="px-8 py-5">Nama Anggota</th>
                        <th class="px-8 py-5">Judul Buku</th>
                        <th class="px-8 py-5 text-center">Tgl Pinjam</th>
                        <th class="px-8 py-5 text-center">Batas Kembalikan</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium whitespace-nowrap">
                    @forelse($loans as $i => $loan)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-4 text-xs text-slate-400 font-mono">{{ $i + 1 }}</td>
                        <td class="px-8 py-4">
                            <span class="px-2 py-1 bg-slate-50 rounded-md text-[10px] font-bold font-mono text-slate-600 border border-slate-200 group-hover:border-blue-500/30 transition-colors">{{ $loan->kode_peminjaman}}</span>
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-sm font-bold text-slate-800">{{ $loan->user->name }}</span>
                        </td>
                        <td class="px-8 py-4">
                            <span class="text-sm text-slate-800 leading-tight block">{{ \Illuminate\Support\Str::limit($loan->book->title, 40) }}</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $loan->book->category->name }}</span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="text-xs text-slate-600">{{ $loan->tgl_pinjam ? $loan->tgl_pinjam->format('d/m/y') : '-' }}</span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="text-xs {{ $loan->isOverdue() ? 'text-red-500 font-black' : 'text-slate-600' }}">{{ $loan->tgl_kembali ? $loan->tgl_kembali->format('d/m/y') : '-' }}</span>
                        </td>
                        <td class="px-8 py-4 text-center">
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-tighter
                            {{ $loan->status === 'borrowed' ? 'bg-blue-50 text-blue-600 border border-blue-100' :
                               ($loan->status === 'returned' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100') }}">
                                {{ $loan->status === 'borrowed' ? 'Pinjam' : ($loan->status === 'returned' ? 'Kembali' : 'Telat') }}
                            </span>
                        </td>
                        <td class="px-8 py-4 text-right">
                            <span class="text-sm font-black {{ $loan->fine > 0 ? 'text-red-600' : 'text-slate-300' }}">
                                {{ $loan->pengembalian && $loan->pengembalian->denda > 0 
                                    ? 'Rp '.number_format($loan->pengembalian->denda,0,',','.') 
                                    : '0' }} </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center mb-4">
                                    <i class="fas fa-search text-slate-300 text-xl"></i>
                                </div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tidak ada record data ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection