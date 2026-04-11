<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Book, Category, Review};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category')->where('status', 'available');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('author', 'like', "%{$request->search}%");
            });
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        $sort = $request->sort ?? 'latest';
        match ($sort) {
            'title'  => $query->orderBy('title'),
            'author' => $query->orderBy('author'),
            'rating' => $query->orderBy('rating', 'desc'),
            default  => $query->latest(),
        };

        $books      = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('books')->orderBy('books_count', 'desc')->get();

        return \view('user.books.index', compact('books', 'categories'));
    }

    public function show(Book $book)
    {
        $book->increment('views');
        $book->load(['category', 'reviews.user']);

        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->limit(4)->get();

        $userReview   = null;
        $userLoan     = null;
        $isWishlisted = false;

        if (Auth::check()) {
            $userReview   = $book->reviews()->where('user_id', Auth::id())->first();
            $userLoan     = Auth::user()->peminjaman()->where('book_id', $book->id)->where('status', 'dipinjam')->first();
            $isWishlisted = Auth::user()->hasWishlisted($book->id);
        }

        // Calculate rating distribution
        $ratingDetails = $book->reviews()->select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();
        
        $starDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $starDistribution[$i] = $ratingDetails[$i] ?? 0;
        }

        return view('user.books.show', compact('book', 'relatedBooks', 'userReview', 'userLoan', 'isWishlisted', 'starDistribution'));
    }

    public function read(Book $book)
    {
        if (!$book->pdf_file) {
            return back()->with('error', 'File PDF buku ini belum tersedia.');
        }

        $book->increment('views');
        return \view('user.books.read', compact('book'));
    }

    public function borrow(Book $book)
    {
        $user = Auth::user();

        // Check if book is available
        if (!$book->isAvailable()) {
            return \back()->with('error', 'Maaf, stok buku ini sedang habis atau tidak tersedia.');
        }

        // Check if user already has this book borrowed
        if ($user->peminjaman()->where('book_id', $book->id)->whereIn('status', ['dipinjam', 'pending', 'terlambat'])->exists()) {
            return \back()->with('error', 'Anda sedang meminjam atau sedang menunggu konfirmasi buku ini.');
        }

        // Check active loan limit (max 3)
        if ($user->peminjaman()->whereIn('status', ['dipinjam', 'terlambat'])->count() >= 3) {
            return \back()->with('error', 'Batas peminjaman aktif Anda (3 buku) telah tercapai.');
        }

        // Create Peminjaman
        $user->peminjaman()->create([
            'book_id'    => $book->id,
            'tgl_pinjam' => \now(),
            'tgl_kembali' => \now()->addDays(7),
            'status'     => 'pending',
        ]);

        // Decrement Stock
        $book->update(['stock' => $book->stock - 1]);

        return \back()->with('success', 'Buku berhasil dipinjam! Silakan ambil fisik buku di perpustakaan.');
    }

    public function storeReview(Request $request, Book $book)
    {
        $user = Auth::user();

        // Check if user has ever borrowed this book
        $hasBorrowed = $user->peminjaman()->where('book_id', $book->id)->exists();

        if (!$hasBorrowed) {
            return \back()->with('error', 'Anda harus meminjam buku ini terlebih dahulu sebelum dapat memberikan ulasan.');
        }

        $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['user_id' => $user->id, 'book_id' => $book->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        $book->updateRating();

        return \back()->with('success', 'Ulasan berhasil disimpan!');
    }

    public function toggleWishlist(Book $book)
    {
        $user = Auth::user();
        
        if ($user->wishlists()->where('book_id', $book->id)->exists()) {
            $user->wishlists()->detach($book->id);
            $message = 'Buku dihapus dari wishlist.';
            $status = 'removed';
        } else {
            $user->wishlists()->attach($book->id);
            $message = 'Buku ditambahkan ke wishlist.';
            $status = 'added';
        }

        if (\request()->ajax()) {
            return \response()->json(['status' => $status, 'message' => $message]);
        }

        return \back()->with('success', $message);
    }
}
