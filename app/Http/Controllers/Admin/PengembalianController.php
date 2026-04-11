<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Peminjaman, Pengembalian};
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // WAJIB: ambil data dulu
        $loans = \App\Models\Peminjaman::with(['user', 'book', 'pengembalian'])
            ->latest()
            ->paginate(10);

        // Admin (kepala) lihat report
        if ($user->role === 'admin') {
            return view('admin.loans.reports', compact('loans'));
        }

        // Petugas lihat halaman biasa
        return view('admin.loans.index', compact('loans'));
    }

    public function store(Request $request, Peminjaman $loan)
    {
        if ($loan->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan!');
        }

        $tgl_kembali = Carbon::today();
        $fine = $loan->calculateFine();

        Pengembalian::create([
            'peminjaman_id'    => $loan->id,
            'tgl_dikembalikan' => $tgl_kembali,
            'denda'            => $fine,
        ]);

        $loan->update(['status' => 'dikembalikan']);
        $loan->book->increment('stock');

        $msg = 'Buku berhasil dikembalikan!';
        if ($fine > 0) {
            $msg .= ' Denda: Rp ' . number_format($fine, 0, ',', '.');
        }

        // Mocking the previous flash behavior for the modal
        // We need to map it to the old structure for the view for now
        $loan->return_date = $tgl_kembali;
        $loan->fine = $fine;
        session()->flash('success_loan', $loan->load(['user', 'book']));

        return back()->with('success', $msg);
    }

    public function fines(Request $request)
    {
        $query = Peminjaman::where(function ($q) {
            $q->whereHas('pengembalian', function ($pq) {
                $pq->where('denda', '>', 0);
            })->orWhere(function ($sq) {
                $sq->whereIn('status', ['dipinjam', 'terlambat'])
                    ->where('tgl_kembali', '<', Carbon::now());
            });
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%")
                        ->orWhere('member_id', 'like', "%{$search}%");
                })->orWhereHas('book', function ($qb) use ($search) {
                    $qb->where('title', 'like', "%{$search}%");
                });
            });
        }

        $fines = $query->with(['user', 'book', 'pengembalian'])->latest()->paginate(15)->withQueryString();

        return view('admin.loans.fines', compact('fines'));
    }
}
