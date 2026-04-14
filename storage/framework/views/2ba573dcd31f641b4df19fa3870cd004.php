<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8 animate-fade-in">
    
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-10">
        <div class="relative w-full max-w-2xl group">
            <input type="text" placeholder="Cari Koleksi atau Anggota..." class="w-full bg-white border border-slate-200 rounded-2xl py-4 px-6 text-sm text-slate-600 placeholder:text-slate-400 focus:ring-4 focus:ring-[#00bcd4]/10 focus:border-[#00bcd4] outline-none transition-all pl-14 shadow-sm group-hover:shadow-md">
            <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-300 group-hover:text-[#00bcd4] transition-colors"></i>
        </div>
        <div class="flex items-center gap-4">
            <div class="px-4 py-2 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center gap-3">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Sistem Aktif</span>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <?php
            $cards = [
                ['label' => 'Total Buku', 'value' => $stats['total_books'], 'icon' => 'fa-book', 'color' => 'emerald'],
                ['label' => 'Total Anggota', 'value' => $stats['total_users'], 'icon' => 'fa-users', 'color' => 'blue'],
                ['label' => 'Terlambat', 'value' => $stats['overdue_loans'], 'icon' => 'fa-clock', 'color' => 'rose'],
                ['label' => 'Total Denda', 'value' => 'Rp ' . number_format($stats['total_fines'], 0, ',', '.'), 'icon' => 'fa-wallet', 'color' => 'amber'],
            ];
        ?>

        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="group bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-6 transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="w-16 h-16 rounded-2xl bg-<?php echo e($card['color']); ?>-50 text-<?php echo e($card['color']); ?>-600 flex items-center justify-center text-2xl shadow-inner border border-<?php echo e($card['color']); ?>-100 group-hover:scale-110 transition-transform">
                <i class="fas <?php echo e($card['icon']); ?>"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1"><?php echo e($card['label']); ?></p>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight"><?php echo e($card['value']); ?></h3>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="flex flex-col gap-8">
        
        <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden w-full">
            <div class="p-8 flex flex-col items-center">
                
                <div class="flex items-center border border-slate-100 p-1 rounded-2xl bg-slate-50/50 mb-10">
                    <button onclick="updateChart('7days', this)" class="period-btn px-10 py-3.5 bg-slate-900 text-white shadow-lg shadow-slate-200 rounded-xl text-xs font-black uppercase tracking-widest transition-all">7 Hari</button>
                    <button onclick="updateChart('month', this)" class="period-btn px-10 py-3.5 hover:bg-white text-slate-500 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Bulan Ini</button>
                    <button onclick="updateChart('year', this)" class="period-btn px-10 py-3.5 hover:bg-white text-slate-500 rounded-xl text-xs font-black uppercase tracking-widest transition-all">Tahunan</button>
                </div>

                <div class="w-full text-left mb-6 px-4 md:px-10">
                    <h3 id="chartTitle" class="text-xl font-black text-slate-900 tracking-tight">Peminjaman Per Minggu</h3>
                </div>

                <div class="w-full px-4 md:px-10 h-[450px]">
                    <canvas id="hybridChart"></canvas>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">Koleksi Terpopuler</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Literasi paling diminati anggota</p>
                </div>
                <a href="<?php echo e(route('admin.books.index')); ?>" class="px-4 py-2 bg-slate-50 rounded-xl text-[10px] font-black text-slate-500 uppercase tracking-widest hover:bg-[#00bcd4] hover:text-white transition-all">Lihat Semua</a>
            </div>
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php $__empty_1 = true; $__currentLoopData = $popularBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50/50 hover:bg-white border border-transparent hover:border-slate-100 hover:shadow-lg transition-all group">
                    <div class="w-12 h-12 rounded-xl bg-white flex-shrink-0 flex items-center justify-center text-sm font-black text-slate-300 group-hover:text-[#00bcd4] shadow-sm transition-all">
                        <?php echo e($index + 1); ?>

                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-black text-slate-800 truncate"><?php echo e($book->title); ?></p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-1"><?php echo e($book->category->name ?? 'Kategori'); ?></p>
                    </div>
                    <div class="text-right bg-white px-3 py-1.5 rounded-lg shadow-sm border border-slate-50">
                        <p class="text-[8px] font-black text-slate-300 uppercase leading-none mb-0.5">Sisa</p>
                        <p class="text-xs font-black text-[#00bcd4] leading-none"><?php echo e($book->stock); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full py-12 text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Data belum tersedia</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart;
    
    function initChart(labels, data, title) {
        const ctx = document.getElementById('hybridChart').getContext('2d');
        
        chart = new Chart(ctx, {
            data: {
                labels: labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Tren',
                        data: data,
                        borderColor: '#00bcd4',
                        borderWidth: 4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#00bcd4',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.4,
                        fill: false,
                        order: 1
                    },
                    {
                        type: 'bar',
                        label: 'Volume',
                        data: data,
                        backgroundColor: '#00bcd4',
                        hoverBackgroundColor: '#0097a7',
                        borderRadius: 4,
                        barThickness: 45,
                        order: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 12, weight: 'bold' },
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 100,
                        grid: { color: '#f1f5f9', drawBorder: false },
                        ticks: { 
                            stepSize: 20,
                            color: '#94a3b8', 
                            font: { size: 10, weight: '600' }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 10, weight: '700' } }
                    }
                }
            }
        });
    }

    function updateChart(period, btn) {
        // Update UI
        document.querySelectorAll('.period-btn').forEach(b => {
            b.classList.remove('bg-slate-900', 'text-white', 'shadow-lg', 'shadow-slate-200');
            b.classList.add('text-slate-500', 'hover:bg-white');
        });
        btn.classList.add('bg-slate-900', 'text-white', 'shadow-lg', 'shadow-slate-200');
        btn.classList.remove('text-slate-500', 'hover:bg-white');

        // Fetch Data
        fetch(`<?php echo e(route('admin.dashboard.chart')); ?>?period=${period}`)
            .then(res => res.json())
            .then(res => {
                document.getElementById('chartTitle').innerText = res.title;
                if (chart) {
                    chart.data.labels = res.labels;
                    chart.data.datasets[0].data = res.data;
                    chart.data.datasets[1].data = res.data;
                    chart.update('active');
                } else {
                    initChart(res.labels, res.data, res.title);
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const firstBtn = document.querySelector('.period-btn');
        if (firstBtn) updateChart('7days', firstBtn);
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\perpustakaan-digital\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>