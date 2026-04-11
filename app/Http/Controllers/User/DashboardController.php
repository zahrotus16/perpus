<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Book, Peminjaman, Category};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Actual paid or recorded fines from pengembalian table
        $totalFine = \App\Models\Pengembalian::whereHas('peminjaman', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->sum('denda');

        $potentialFine = 0;
        foreach ($user->activeLoans as $loan) {
            if ($loan->isOverdue()) {
                $potentialFine += $loan->calculateFine();
            }
        }

        $stats = [
            'active_loans'  => $user->activeLoans()->count(),
            'total_loans'   => $user->peminjaman()->count(),
            'returned'      => $user->peminjaman()->where('status', 'dikembalikan')->count(),
            'total_fine'    => $totalFine + $potentialFine,
        ];

        $activeLoans = $user->activeLoans()->with('book.category')->latest()->limit(5)->get();
        $dueSoonLoans = $user->activeLoans()
            ->where('tgl_kembali', '<=', Carbon::now()->addDays(2))
            ->where('tgl_kembali', '>=', Carbon::now())
            ->get();

        $recentBooks = Book::with('category')->where('status', 'available')->latest()->limit(8)->get();
        $categories  = Category::withCount('books')->orderBy('books_count', 'desc')->limit(6)->get();

        return view('user.dashboard_anggota', compact('stats', 'activeLoans', 'recentBooks', 'categories', 'dueSoonLoans'));
    }
}
