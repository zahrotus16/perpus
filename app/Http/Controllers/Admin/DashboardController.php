<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Book, Category, Peminjaman, Pengembalian, User};
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books'    => Book::count(),
            'total_users'    => User::where('role', 'anggota')->count(),
            'active_loans'   => Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count(),
            'overdue_loans'  => Peminjaman::where('status', 'terlambat')->count(),
            'returned_loans' => Peminjaman::where('status', 'dikembalikan')->count(),
            'total_loans'    => Peminjaman::count(),
            'total_fines'    => Pengembalian::sum('denda'),
        ];

        $recentLoans = Peminjaman::with(['user', 'book'])
            ->latest()
            ->limit(10)
            ->get();

        $popularBooks = Book::withCount(['peminjaman' => function ($q) {
            $q->where('status', 'dikembalikan');
        }])
            ->orderBy('peminjaman_count', 'desc')
            ->limit(5)
            ->get();

        // Weekly Loan Activity (Last 7 Days)
        $weeklyActivity = Peminjaman::selectRaw('DATE(tgl_pinjam) as date, COUNT(*) as count')
            ->where('tgl_pinjam', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $label = Carbon::now()->subDays($i)->format('D');
            $chartLabels[] = $label;
            $chartData[] = $weeklyActivity->get($date, 0);
        }

        return view('admin.dashboard', compact('stats', 'recentLoans', 'popularBooks', 'chartData', 'chartLabels'));
    }

    public function getChartData(\Illuminate\Http\Request $request)
    {
        $period = $request->period ?? '7days';
        $labels = [];
        $data = [];

        if ($period === '7days') {
            $daysMap = ['Sun' => 'Min', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'];
            for ($i = 6; $i >= 0; $i--) {
                $date = \Carbon\Carbon::now()->subDays($i);
                $labels[] = $daysMap[$date->format('D')];
                $data[] = Peminjaman::whereDate('tgl_pinjam', '=', $date->format('Y-m-d'), 'and')->count();
            }
        } elseif ($period === 'month') {
            $start = \Carbon\Carbon::now()->startOfMonth();
            $end = \Carbon\Carbon::now()->endOfMonth();
            $current = $start->copy();
            while ($current <= $end) {
                $labels[] = $current->format('d');
                $data[] = Peminjaman::whereDate('tgl_pinjam', '=', $current->format('Y-m-d'), 'and')->count();
                $current->addDay();
            }
        } elseif ($period === 'year') {
            $monthsMap = ['Jan' => 'Jan', 'Feb' => 'Feb', 'Mar' => 'Mar', 'Apr' => 'Apr', 'May' => 'Mei', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Agu', 'Sep' => 'Sep', 'Oct' => 'Okt', 'Nov' => 'Nov', 'Dec' => 'Des'];
            for ($i = 1; $i <= 12; $i++) {
                $date = \Carbon\Carbon::create(\Carbon\Carbon::now()->year, $i, 1);
                $labels[] = $monthsMap[$date->format('M')];
                $data[] = Peminjaman::whereYear('tgl_pinjam', '=', \Carbon\Carbon::now()->year, 'and')
                    ->whereMonth('tgl_pinjam', '=', $i, 'and')
                    ->count();
            }
        }

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
            'title'  => $period === '7days' ? 'Peminjaman Per Minggu' : ($period === 'month' ? 'Peminjaman Bulan Ini' : 'Peminjaman Tahunan (' . \Carbon\Carbon::now()->year . ')')
        ]);
    }
}