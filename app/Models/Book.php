<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $fillable = [
        'title', 'slug', 'author', 'publisher', 'isbn', 'year',
        'category_id', 'shelf_location', 'description', 'cover', 'pdf_file',
        'pages', 'stock', 'total_stock', 'status', 'views', 'rating', 'rating_count',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($book) {
            $book->slug = Str::slug($book->title) . '-' . Str::random(5);
            $book->total_stock = $book->stock;
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function loans()
    {
        return $this->peminjaman();
    }

    public function activeLoans()
    {
        return $this->peminjaman()->whereIn('status', ['pending', 'dipinjam', 'terlambat']);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0 && $this->status === 'available';
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover) {
            return asset('storage/' . $this->cover);
        }
        return asset('images/no-cover.png');
    }

    public function updateRating(): void
    {
        $avg = $this->reviews()->avg('rating') ?? 0;
        $count = $this->reviews()->count();
        $this->update(['rating' => round($avg, 2), 'rating_count' => $count]);
    }
}
