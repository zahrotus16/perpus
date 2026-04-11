<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Book, Peminjaman, User};
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'book']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_peminjaman', 'like', "%{$request->search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%"))
                  ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%{$request->search}%"));
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Auto-update overdue status
        Peminjaman::where('status', 'dipinjam')
            ->where('tgl_kembali', '<', Carbon::today())
            ->update(['status' => 'terlambat']);

        $loans = $query->latest()->paginate(15)->withQueryString();
        $books = Book::where('status', 'available')->where('stock', '>', 0)->orderBy('title')->get();
        $users = User::where('role', 'anggota')->where('status', 'active')->orderBy('name')->get();

        return view('admin.loans.index', compact('loans', 'books', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:users,id',
            'book_id'     => 'required|exists:books,id',
            'tgl_pinjam'  => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
            'catatan'     => 'nullable|string|max:500',
        ]);

        $book = Book::findOrFail($request->book_id);

        if (!$book->isAvailable()) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam!');
        }

        // Check if user already borrows this book
        $existing = Peminjaman::where('user_id', $request->user_id)
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($existing) {
            return back()->with('error', 'Anggota ini sudah meminjam buku tersebut!');
        }

        Peminjaman::create($request->only('user_id', 'book_id', 'tgl_pinjam', 'tgl_kembali', 'catatan') + ['status' => 'dipinjam']);

        $book->decrement('stock');

        return redirect()->route('admin.loans.index')->with('success', 'Peminjaman berhasil dicatat!');
    }


    public function confirm(Peminjaman $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Status peminjaman ini tidak pending.');
        }

        $loan->update([
            'status'     => 'dipinjam',
            'tgl_pinjam' => Carbon::now(),
            'tgl_kembali' => Carbon::now()->addDays(7), // Default 7 days from confirmation
        ]);

        return back()->with('success', 'Peminjaman berhasil dikonfirmasi! Status berubah menjadi sedang dipinjam.');
    }

    public function show(Peminjaman $loan)
    {
        $loan->load(['user', 'book.category', 'pengembalian']);
        return view('admin.loans.show', compact('loan'));
    }

    public function destroy(Peminjaman $loan)
    {
        if ($loan->status === 'dipinjam' || $loan->status === 'terlambat') {
            return back()->with('error', 'Tidak dapat menghapus peminjaman yang masih aktif!');
        }
        $loan->delete();
        return back()->with('success', 'Data peminjaman berhasil dihapus!');
    }
}
