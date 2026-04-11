@extends('layouts.app')
@section('title', 'Manajemen Denda')

@section('content')
<div class="relative min-h-screen p-6 lg:p-10 overflow-hidden">
    
    {{-- Search & Action Row --}}
    <div class="relative z-20 max-w-full mx-auto flex flex-col md:flex-row justify-between items-center mb-8 gap-4 fade-in">
        <form action="{{ route('admin.loans.fines') }}" method="GET" class="w-full md:max-w-md flex gap-0 shadow-lg rounded-full overflow-hidden border-2 border-slate-300">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Anggota atau Judul Buku..." 
                   class="w-full px-6 py-2.5 bg-white/90 backdrop-blur-md border-none text-slate-800 placeholder-slate-500 focus:ring-0 font-medium">
            <button type="submit" class="bg-[#4caf50] hover:bg-[#388e3c] text-white px-8 py-2.5 font-bold transition-all active:scale-95 border-l-2 border-slate-300">
                Cari
            </button>
        </form>
    </div>

    {{-- Table Container --}}
    <div class="relative z-20 max-w-full mx-auto fade-in shadow-2xl rounded-lg overflow-hidden border border-slate-300">
        <div class="overflow-x-auto bg-[#d9d9d9]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#00bcd4] text-slate-900 uppercase text-[12px] font-black tracking-tight border-b-2 border-slate-400">
                        <th class="px-4 py-5 border-r border-slate-400 w-12 text-center">No</th>
                        <th class="px-4 py-5 border-r border-slate-400">Nama (Anggota & Buku)</th>
                        <th class="px-4 py-5 border-r border-slate-400 text-center">Hari Terlambat</th>
                        <th class="px-4 py-5 border-r border-slate-400 text-right">Total Denda</th>
                        <th class="px-4 py-5 border-r border-slate-400 text-center">Tanggal Kembali</th>
                        <th class="px-4 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white/40 backdrop-blur-md">
                    @if(count($fines) > 0)
                        @foreach($fines as $loan)
                        <tr class="border-b border-slate-300 hover:bg-white/20 transition-colors group">
                            <td class="px-4 py-4 text-center font-bold text-slate-700 text-[13px] border-r border-slate-300">
                                {{ ($fines->currentPage() - 1) * $fines->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-4 border-r border-slate-300">
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-900 text-[13px] uppercase leading-tight">{{ $loan->user->name }}</span>
                                    <span class="text-slate-500 text-[11px] font-bold italic">{{ $loan->book->title }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center font-black text-red-600 text-[13px] border-r border-slate-300">
                                {{ $loan->getDaysOverdue() }} Hari
                            </td>
                            <td class="px-4 py-4 text-right font-black text-slate-900 text-[13px] border-r border-slate-300 bg-red-50/30">
                                Rp {{ number_format($loan->pengembalian->denda ?? $loan->calculateFine(), 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-4 text-center font-bold text-slate-600 text-[12px] border-r border-slate-300">
                                {{ $loan->pengembalian ? $loan->pengembalian->tgl_dikembalikan->format('d/m/Y') : 'Belum Kembali' }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.loans.show', $loan) }}" 
                                       class="group bg-sky-400 hover:bg-sky-500 text-white px-3 py-1.5 rounded-lg font-black text-[10px] uppercase transition-all active:scale-95 shadow-md shadow-sky-50 flex items-center gap-2">
                                        <span class="w-4 h-4 rounded-full bg-white flex items-center justify-center text-sky-400">
                                            <i class="fas fa-check text-[8px]"></i>
                                        </span>
                                        Verifikasi
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="px-6 py-20 text-center">
                                <i class="fas fa-hand-holding-usd text-4xl text-slate-300 mb-4 block"></i>
                                <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Belum ada data denda.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-8 flex justify-center fade-in">
        {{ $fines->links() }}
    </div>
</div>

<style>
    .fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
