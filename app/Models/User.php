<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN   = 'admin';   // Main Admin / Kepala Perpustakaan
    const ROLE_PETUGAS = 'petugas'; // Library Staff / Petugas
    const ROLE_ANGGOTA = 'anggota';
    const ROLE_KEPALA  = 'kepala';  // Additional Kepala role (legacy/restricted)

    protected $fillable = [
        'name', 'email', 'phone', 'address', 'member_id',
        'role', 'status', 'avatar', 'password', 'gender',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the human-readable role label.
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            self::ROLE_ADMIN   => 'Kepala Perpustakaan',
            self::ROLE_PETUGAS => 'Petugas',
            self::ROLE_KEPALA  => 'Kepala',
            self::ROLE_ANGGOTA => 'Anggota',
            default            => ucfirst($this->role),
        };
    }

    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isAnggota(): bool
    {
        return $this->role === self::ROLE_ANGGOTA;
    }

    public function isKepala(): bool
    {
        return $this->role === self::ROLE_KEPALA || $this->role === self::ROLE_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMember(): bool 
    { 
        return $this->isAnggota(); 
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function activeLoans()
    {
        return $this->peminjaman()->whereIn('status', ['pending', 'dipinjam', 'terlambat']);
    }

    // Keep loans() for backward compatibility if needed, but pointing to Peminjaman
    public function loans()
    {
        return $this->peminjaman();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->belongsToMany(Book::class, 'wishlists')->withTimestamps();
    }

    public function hasWishlisted(int $bookId): bool
    {
        return $this->wishlists()->where('book_id', $bookId)->exists();
    }
}
