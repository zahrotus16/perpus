<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'book_id',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tgl_pinjam' => 'datetime',
        'tgl_kembali' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->kode_peminjaman) {
                $model->kode_peminjaman = 'PJ-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    public function isOverdue(): bool
    {
        // Pastikan tgl_kembali tidak null sebelum dibandingkan
        if (!$this->tgl_kembali) return false;

        return in_array($this->status, ['dipinjam', 'terlambat']) && $this->tgl_kembali->isPast();
    }

    public function getDaysOverdue(): int
    {
        // 1. Cek jika sudah ada data pengembalian
        if ($this->pengembalian && $this->pengembalian->tgl_dikembalikan) {
            // Pastikan tgl_dikembalikan adalah objek Carbon
            $tglSelesai = Carbon::parse($this->pengembalian->tgl_dikembalikan);
            
            if ($tglSelesai > $this->tgl_kembali) {
                return (int) $tglSelesai->diffInDays($this->tgl_kembali);
            }
        }

        // 2. Cek jika masih dipinjam tapi sudah lewat jatuh tempo
        if ($this->isOverdue() && $this->tgl_kembali) {
            return (int) Carbon::today()->diffInDays($this->tgl_kembali);
        }

        return 0;
    }

    public function calculateFine(): int
    {
        $finePerDay = (int) (\App\Models\Setting::where('key', 'fine_per_day')->value('value') ?? 1000);
        return $this->getDaysOverdue() * $finePerDay;
    }
}