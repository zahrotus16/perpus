<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Peminjaman, Pengembalian, Book};
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->startOfMonth();
        $endDate   = $request->end_date   ? Carbon::parse($request->end_date)   : Carbon::now()->endOfMonth();

        $query = Peminjaman::with(['user', 'book.category', 'pengembalian'])
            ->whereBetween('tgl_pinjam', [$startDate, $endDate]);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $loans = $query->latest()->get();

        $summary = [
            'total_loans'    => $loans->count(),
            'total_borrowed' => $loans->where('status', 'dipinjam')->count(),
            'total_returned' => $loans->where('status', 'dikembalikan')->count(),
            'total_overdue'  => $loans->where('status', 'terlambat')->count(),
            'total_fine'     => Pengembalian::whereIn('peminjaman_id', $loans->pluck('id'))->sum('denda'),
        ];

        $topBooks = Book::withCount(['peminjaman' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('tgl_pinjam', [$startDate, $endDate]);
        }])
            ->orderBy('peminjaman_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact('loans', 'summary', 'topBooks', 'startDate', 'endDate'));
    }

    public function loans(Request $request)
    {
        return $this->index($request); // Reuse index for now
    }

    public function members(Request $request)
    {
        return $this->index($request); // Placeholder
    }

    public function stats(Request $request)
    {
        return $this->index($request); // Placeholder
    }

    public function print(Request $request)
    {
        return $this->index($request);
    }
}
