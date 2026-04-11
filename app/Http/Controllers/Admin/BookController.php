<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Book, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category')->withCount('loans');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                  ->orWhere('author', 'like', "%{$request->search}%")
                  ->orWhere('isbn', 'like', "%{$request->search}%");
            });
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $books = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'isbn'        => 'nullable|string|max:20|unique:books',
            'year'        => 'nullable|integer|min:1800|max:' . date('Y'),
            'category_id' => 'required|exists:categories,id',
            'shelf_location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'pages'       => 'nullable|integer|min:1',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:available,unavailable',
            'cover'       => 'nullable|image|max:2048',
            'pdf_file'    => 'nullable|mimes:pdf|max:51200',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        $validated['total_stock'] = $validated['stock'];

        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Book $book)
    {
        $book->load(['category', 'loans.user', 'reviews.user']);
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'isbn'        => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'year'        => 'nullable|integer|min:1800|max:' . date('Y'),
            'category_id' => 'required|exists:categories,id',
            'shelf_location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'pages'       => 'nullable|integer|min:1',
            'stock'       => 'required|integer|min:0',
            'status'      => 'required|in:available,unavailable',
            'cover'       => 'nullable|image|max:2048',
            'pdf_file'    => 'nullable|mimes:pdf|max:51200',
        ]);

        if ($request->hasFile('cover')) {
            if ($book->cover) Storage::disk('public')->delete($book->cover);
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($book->pdf_file) Storage::disk('public')->delete($book->pdf_file);
            $validated['pdf_file'] = $request->file('pdf_file')->store('pdfs', 'public');
        }

        // Adjust total_stock based on stock change
        $stockDiff = $validated['stock'] - $book->stock;
        $validated['total_stock'] = $book->total_stock + $stockDiff;

        $book->update($validated);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function destroy(Book $book)
    {
        if ($book->activeLoans()->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena masih dipinjam!');
        }

        if ($book->cover) Storage::disk('public')->delete($book->cover);
        if ($book->pdf_file) Storage::disk('public')->delete($book->pdf_file);

        $book->delete();

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }
}
