@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
{{-- Stats Section --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
    @php
    $cards = [
        ['label' => 'Total Koleksi Buku', 'value' => $stats['total_books'], 'icon' => 'fa-book', 'trend' => '+2.5%', 'color' => 'bg-indigo-600'],
        ['label' => 'Total Anggota Aktif', 'value' => $stats['total_users'], 'icon' => 'fa-users', 'trend' => '+12', 'color' => 'bg-emerald-600'],
        ['label' => 'Buku Sedang Dipinjam', 'value' => $stats['active_loans'], 'icon' => 'fa-hand-holding-heart', 'trend' => '-4%', 'color' => 'bg-amber-600'],
        ['label' => 'Peminjaman Terlambat', 'value' => $stats['overdue_loans'], 'icon' => 'fa-triangle-exclamation', 'trend' => 'Alert', 'color' => 'bg-red-600'],
    ];
    @endphp

    @foreach($cards as $card)
    <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-slate-200 dark:border-dark-border/20 shadow-sm dark:shadow-dark-soft hover:shadow-soft transition-all duration-300 group hover-scale cursor-default">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl {{ $card['color'] }} flex items-center justify-center shadow-lg transition-transform duration-300 group-hover:rotate-12">
                <i class="fas {{ $card['icon'] }} text-white text-sm"></i>
            </div>
            <span class="text-[10px] font-extrabold px-2 py-1 rounded-lg {{ $loop->last ? 'bg-red-50 dark:bg-red-900/40 text-red-600 dark:text-red-400' : 'bg-slate-50 dark:bg-white/5 text-slate-500 dark:text-gray-400' }} uppercase tracking-wider">
                {{ $card['trend'] }}
            </span>
        </div>
        <div>
            <p class="text-[11px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mb-1">{{ $card['label'] }}</p>
            <div class="flex items-baseline gap-2">
                <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($card['value']) }}</h3>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Chart Section --}}
    <div class="lg:col-span-2 bg-white dark:bg-dark-card rounded-2xl border border-slate-200 dark:border-dark-border/20 shadow-sm dark:shadow-dark-soft overflow-hidden flex flex-col transition-all duration-300 hover:shadow-md">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-dark-border/10 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-chart-simple text-primary-600"></i> Aktivitas Peminjaman
                </h3>
                <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mt-1">Data Bulanan Tahun {{ date('Y') }}</p>
            </div>
            <div class="flex items-center gap-2 bg-slate-50 dark:bg-white/5 p-1 rounded-lg text-[10px] font-bold text-slate-900 dark:text-white">
                <span class="px-3 py-1 bg-white dark:bg-dark text-slate-900 dark:text-white rounded-md shadow-sm border border-slate-200 dark:border-dark-border/20">Statistik</span>
            </div>
        </div>
        <div class="p-6 flex-1 min-h-[300px] flex flex-col justify-center relative overflow-hidden">
            @if(array_sum($chartData) > 0)
                <canvas id="loanChart" class="w-full"></canvas>
            @else
                <div class="flex flex-col items-center justify-center text-center py-12 relative z-10">
                    <div class="w-16 h-16 bg-slate-50 dark:bg-dark rounded-2xl flex items-center justify-center mb-4 text-slate-300 dark:text-gray-700 border border-slate-100 dark:border-dark-border/10">
                        <i class="fas fa-chart-line text-2xl"></i>
                    </div>
                    <p class="text-sm font-black text-slate-600 dark:text-white uppercase tracking-tight">Data Masih Kosong</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500 mt-1 max-w-[200px] mx-auto">Kami akan menampilkan grafik aktivitas segera setelah ada transaksi peminjaman.</p>
                </div>
                {{-- Skeleton Background Placeholder --}}
                <div class="absolute inset-x-6 bottom-6 h-48 skeleton rounded-xl opacity-20 pointer-events-none dark:opacity-5"></div>
            @endif
        </div>
    </div>

    {{-- Rankings Section --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-slate-200 dark:border-dark-border/20 shadow-sm dark:shadow-dark-soft overflow-hidden flex flex-col transition-all duration-300 hover:shadow-md">
        <div class="px-6 py-5 border-b border-slate-100 dark:border-dark-border/10">
            <h3 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-crown text-amber-500"></i> Buku Terpopuler
            </h3>
            <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mt-1">Berdasarkan total peminjaman</p>
        </div>
        <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4 custom-scrollbar divide-y divide-slate-50 dark:divide-dark-border/10">
            @forelse($popularBooks as $index => $book)
            <div class="flex items-center gap-4 group cursor-default pt-4 first:pt-0">
                <div class="w-8 h-8 rounded-lg {{ $index == 0 ? 'bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400' : ($index == 1 ? 'bg-slate-100 dark:bg-white/10 text-slate-600 dark:text-white' : 'bg-orange-50 dark:bg-orange-900/10 text-orange-600 dark:text-orange-400') }} flex items-center justify-center text-xs font-black flex-shrink-0 transition-all duration-300 group-hover:scale-110 group-hover:rotate-6 border border-transparent dark:border-dark-border/10">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-[13px] font-bold text-slate-800 dark:text-white truncate group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $book->title }}</h4>
                    <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider truncate">{{ $book->author }}</p>
                </div>
                <div class="text-right">
                    <p class="text-[11px] font-black text-slate-900 dark:text-white">{{ $book->loans_count }}</p>
                    <p class="text-[9px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-tighter">Pinjam</p>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center text-center py-12">
                <div class="w-12 h-12 bg-slate-50 dark:bg-dark rounded-xl flex items-center justify-center mb-3 text-slate-300 dark:text-gray-700 border border-slate-100 dark:border-dark-border/10">
                    <i class="fas fa-layer-group"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Belum ada data</p>
            </div>
            @endforelse
        </div>
        <div class="p-4 bg-slate-50 dark:bg-white/5 border-t border-slate-100 dark:border-dark-border/10 text-center">
            <a href="{{ route('admin.books.index') }}" class="text-[10px] font-black text-primary-600 dark:text-primary-400 uppercase tracking-widest hover:text-primary-700 transition-colors flex items-center justify-center gap-2">
                Eksplor Galeri <i class="fas fa-arrow-right text-[8px]"></i>
            </a>
        </div>
    </div>
</div>

{{-- Recent Activities Table --}}
<div class="mt-8 bg-white dark:bg-dark-card rounded-2xl border border-slate-200 dark:border-dark-border/20 shadow-sm dark:shadow-dark-soft overflow-hidden mb-8 transition-all duration-300 hover:shadow-md">
    <div class="px-6 py-5 border-b border-slate-100 dark:border-dark-border/10 flex items-center justify-between">
        <div>
            <h3 class="text-sm font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-clock-rotate-left text-primary-600"></i> Aktivitas Terbaru
            </h3>
            <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mt-1">Riwayat peminjaman terakhir</p>
        </div>
        <a href="{{ route('admin.loans.index') }}" class="px-4 py-2 bg-slate-50 dark:bg-white/5 hover:bg-slate-100 dark:hover:bg-white/10 text-slate-600 dark:text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-slate-100 dark:border-dark-border/10 flex items-center gap-2">
            <span>Selengkapnya</span> <i class="fas fa-chevron-right text-[8px]"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 dark:bg-white/5">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-gray-400 uppercase tracking-widest">Peminjam</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-gray-400 uppercase tracking-widest">Judul Buku</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-gray-400 uppercase tracking-widest text-center">Tgl Pinjam</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-gray-400 uppercase tracking-widest text-center text-nowrap">Batas Kembali</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 dark:text-gray-400 uppercase tracking-widest text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-dark-border/10">
                @forelse($recentLoans as $loan)
                <tr class="hover:bg-slate-50/50 dark:hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-dark flex items-center justify-center text-slate-600 dark:text-gray-400 text-[10px] font-black border border-slate-200 dark:border-dark-border/10 group-hover:bg-primary-50 dark:group-hover:bg-primary-900/40 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                            </div>
                            <span class="text-xs font-bold text-slate-800 dark:text-white">{{ $loan->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="max-w-[240px] truncate">
                            <p class="text-xs font-bold text-slate-700 dark:text-white truncate mb-0.5">{{ $loan->book->title }}</p>
                            <p class="text-[10px] font-bold text-slate-400 dark:text-gray-500 uppercase tracking-wider">{{ $loan->book->category->name ?? 'Uncategorized' }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-xs font-bold text-slate-600 dark:text-gray-400">{{ $loan->loan_date->format('d/m/y') }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-xs font-bold text-slate-600 dark:text-gray-400">{{ $loan->due_date->format('d/m/y') }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($loan->status === 'borrowed')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 text-[10px] font-black uppercase tracking-widest rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 badge-pulse"></span> Dipinjam
                            </span>
                        @elseif($loan->status === 'returned')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 text-[10px] font-black uppercase tracking-widest rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Kembali
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 dark:bg-red-900/40 text-red-700 dark:text-red-400 text-[10px] font-black uppercase tracking-widest rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 badge-pulse"></span> Lambat
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center opacity-40">
                            <i class="fas fa-inbox text-3xl mb-3 text-slate-300 dark:text-gray-700"></i>
                            <p class="text-xs font-black uppercase tracking-widest text-slate-400">Belum ada aktivitas</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(array_sum($chartData) > 0)
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('loanChart').getContext('2d');
        const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        const data = @json($chartData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Peminjaman',
                    data: data,
                    backgroundColor: 'rgba(79, 70, 229, 0.9)',
                    hoverBackgroundColor: '#312e81',
                    borderRadius: 6,
                    borderSkipped: false,
                    barThickness: 24,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: document.documentElement.classList.contains('dark') ? '#1e1e1e' : '#1e293b',
                        padding: 12,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        cornerRadius: 8,
                        displayColors: false,
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: document.documentElement.classList.contains('dark') ? 'rgba(176, 176, 176, 0.2)' : 'transparent',
                        borderWidth: 1
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { 
                            borderDash: [5, 5], 
                            color: document.documentElement.classList.contains('dark') ? 'rgba(255,255,255,0.05)' : '#f1f5f9', 
                            drawBorder: false 
                        },
                        ticks: { stepSize: 1, color: '#94a3b8', font: { size: 10, weight: '600' } }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#94a3b8', font: { size: 10, weight: '600' } }
                    }
                }
            }
        });
    });
    @endif
</script>
@endpush
