<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Peminjaman, Pengembalian};
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
       $loans = Peminjaman::with(['user','book'])
            ->latest()
            ->paginate(10);
        return view('user.loans.index', compact('loans'));
    }

    public function active()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $loans = $user->peminjaman()->with('book')
            ->whereIn('status', ['pending', 'dipinjam', 'terlambat'])
            ->latest()->paginate(10);
        return view('user.loans.active', compact('loans'));
    }

    public function returns()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $loans = $user->peminjaman()->with(['book', 'pengembalian'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest()->paginate(10);
        return view('user.loans.returns', compact('loans'));
    }

    public function fines()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $fines = $user->peminjaman()
            ->whereHas('pengembalian', function($q) {
                $q->where('denda', '>', 0);
            })
            ->orWhere(function($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->whereIn('status', ['dipinjam', 'terlambat'])
                  ->where('tgl_kembali', '<', Carbon::now());
            })
            ->with(['book', 'pengembalian'])
            ->latest()->get();

        $totalFine = \App\Models\Pengembalian::whereHas('peminjaman', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->sum('denda');

        $potentialFine = 0;
        foreach ($user->activeLoans as $loan) {
            if ($loan->isOverdue()) {
                $potentialFine += $loan->calculateFine();
            }
        }
            
        return view('user.loans.fines', compact('fines', 'totalFine', 'potentialFine'));
    }

    public function show(Peminjaman $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }
        $loan->load(['book.category', 'pengembalian']);
        return view('user.loans.show', compact('loan'));
    }

    public function returnBook(Peminjaman $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }

        if ($loan->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan!');
        }

        // Members usually can't "return" via digital system unless they just submit a request
        // For this system, let's keep it consistent with Admin logic but triggered by user
        
        $tgl_kembali = Carbon::today();
        $fine = $loan->calculateFine();

        Pengembalian::create([
            'peminjaman_id'    => $loan->id,
            'tgl_dikembalikan' => $tgl_kembali,
            'denda'            => $fine,
        ]);

        $loan->update(['status' => 'dikembalikan']);
        $loan->book->increment('stock');

        return back()->with('success', 'Buku berhasil dikembalikan!');
    }
}
