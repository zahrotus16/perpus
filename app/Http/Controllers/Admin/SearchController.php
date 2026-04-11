<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        if (!$q || strlen($q) < 2) {
            return response()->json([
                'books' => [],
                'users' => [],
                'loans' => []
            ]);
        }

        $books = Book::where('title', 'like', "%{$q}%")
            ->orWhere('author', 'like', "%{$q}%")
            ->limit(5)
            ->get(['id', 'title', 'author', 'cover'])
            ->map(fn($book) => [
                'title' => $book->title,
                'sub'   => $book->author,
                'url'   => route('admin.books.show', $book->id),
                'type'  => 'Buku'
            ]);

        $users = User::where('role', 'anggota')
            ->where(function($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%")
                      ->orWhere('member_id', 'like', "%{$q}%");
            })
            ->limit(5)
            ->get(['id', 'name', 'member_id'])
            ->map(fn($user) => [
                'title' => $user->name,
                'sub'   => $user->member_id,
                'url'   => route('admin.users.show', $user->id),
                'type'  => 'Anggota'
            ]);

        $loans = Loan::with(['user', 'book'])
            ->where('status', 'like', "%{$q}%")
            ->orWhereHas('user', fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->orWhereHas('book', fn($query) => $query->where('title', 'like', "%{$q}%"))
            ->limit(5)
            ->get()
            ->map(fn($loan) => [
                'title' => $loan->user->name . ' - ' . \Illuminate\Support\Str::limit($loan->book->title, 20),
                'sub'   => 'Status: ' . ucfirst($loan->status),
                'url'   => route('admin.loans.show', $loan->id),
                'type'  => 'Peminjaman'
            ]);

        return response()->json([
            'books' => $books,
            'users' => $users,
            'loans' => $loans
        ]);
    }
}
