<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Book, Peminjaman};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
   

    public function index(Request $request)
    {
     
        Peminjaman::where('status', 'dipinjam')
            ->where('tgl_kembali', '<', Carbon::today())
            ->update(['status' => 'terlambat']);

       
        $query = Peminjaman::with(['user', 'book']);

     
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($u) use ($request) {
                    $u->where('name', 'like', "%{$request->search}%");
                })->orWhereHas('book', function ($b) use ($request) {
                    $b->where('title', 'like', "%{$request->search}%");
                });
            });
        }

     
        // $loans = $query->latest()->paginate(15)->withQueryString();
        $loans = $query->latest()->paginate(3)->withQueryString();

        return view('admin.loans.index', compact('loans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'book_id'     => 'required|exists:books,id',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Cek ketersediaan stock sebelum create
                $book = Book::lockForUpdate()->findOrFail($request->book_id);

                if (!$book->isAvailable()) {
                    throw new \Exception('Stok buku tidak mencukupi!');
                }

                // generate kode peminjaman
                $lastKode = Peminjaman::orderBy('id', 'desc')->value('kode_peminjaman');
                $number = $lastKode ? (int) substr($lastKode, -4) + 1 : 1;
                $kode = 'PMJ-' . str_pad($number, 4, '0', STR_PAD_LEFT);

                Peminjaman::create([
                    'kode_peminjaman' => $kode,
                    'user_id'         => $request->user_id,
                    'book_id'         => $request->book_id,
                    'tgl_pinjam'      => $request->tgl_pinjam,
                    'tgl_kembali'     => $request->tgl_kembali,
                    'status'          => 'pending',
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Peminjaman dibuat (pending)');
    }

    public function confirm(Peminjaman $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Status harus pending!');
        }

        try {
            DB::transaction(function () use ($loan) {
                // Lock book untuk prevent race condition
                $book = Book::lockForUpdate()->findOrFail($loan->book_id);

                // Double check ketersediaan stock
                if (!$book->isAvailable()) {
                    throw new \Exception('Stok buku habis!');
                }

                // Update status peminjaman DAN kurangi stock bersamaan
                $loan->update([
                    'status'      => 'dipinjam',
                    'tgl_pinjam'  => now(),
                    'tgl_kembali' => now()->addDays(7),
                ]);

                // Kurangi stock setelah status confirmed
                $book->decrement('stock');

                // Update available stock jika ada field tersebut
                if ($book->getAttribute('stock_available') !== null) {
                    $book->decrement('stock_available');
                }
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Peminjaman dikonfirmasi dan stock berkurang');
    }

    public function return(Peminjaman $loan)
    {
        if (!in_array($loan->status, ['dipinjam', 'terlambat'])) {
            return back()->with('error', 'Status harus dipinjam atau terlambat!');
        }

        try {
            DB::transaction(function () use ($loan) {
                // Update status pengembalian
                $loan->update([
                    'status' => 'dikembalikan',
                    'tgl_dikembalikan' => now()
                ]);

                // Tambah kembali stock
                $loan->book->increment('stock');

                // Update available stock jika ada field tersebut
                if ($loan->book->getAttribute('stock_available') !== null) {
                    $loan->book->increment('stock_available');
                }

                $loan->load(['book', 'user', 'pengembalian']);
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success_loan', $loan);
    }

    public function show(Peminjaman $loan)
    {
        $loan->load(['user', 'book', 'pengembalian']);
        return view('admin.loans.show', compact('loan'));
    }

    public function destroy(Peminjaman $loan)
    {
        if (in_array($loan->status, ['dipinjam', 'terlambat', 'dikembalikan'])) {
            return back()->with('error', 'Tidak bisa hapus data aktif atau sudah dikembalikan!');
        }

        $loan->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
