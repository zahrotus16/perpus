<?php

namespace Database\Seeders;

use App\Models\{Book, Category, Loan, User};
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin / Kepala Perpustakaan
        User::create([
            'name'      => 'Kepala Perpustakaan',
            'email'     => 'admin@perpustakaan.id',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'status'    => 'active',
            'member_id' => 'ADM-000001',
            'phone'     => '08123456789',
        ]);

        // Staff / Petugas
        User::create([
            'name'      => 'Petugas Perpustakaan',
            'email'     => 'petugas@perpustakaan.id',
            'password'  => Hash::make('petugas123'),
            'role'      => 'petugas',
            'status'    => 'active',
            'member_id' => 'STF-000001',
            'phone'     => '08987654321',
        ]);

        // Members
        $members = [
            ['name' => 'Budi Santoso',   'email' => 'budi@gmail.com'],
            ['name' => 'Siti Rahma',     'email' => 'siti@gmail.com'],
            ['name' => 'Andi Firmansyah','email' => 'andi@gmail.com'],
        ];
        foreach ($members as $m) {
            User::create(array_merge($m, [
                'password'  => Hash::make('member123'),
                'role'      => 'anggota',
                'status'    => 'active',
                'member_id' => 'MBR-' . strtoupper(Str::random(6)),
            ]));
        }

        // Categories
        $categories = [
            ['name' => 'Teknologi',    'color' => '#6366f1', 'description' => 'Buku seputar teknologi dan IT'],
            ['name' => 'Sains',        'color' => '#0ea5e9', 'description' => 'Buku ilmu pengetahuan alam'],
            ['name' => 'Sejarah',      'color' => '#f59e0b', 'description' => 'Buku sejarah dan budaya'],
            ['name' => 'Sastra',       'color' => '#ec4899', 'description' => 'Novel dan karya sastra'],
            ['name' => 'Pendidikan',   'color' => '#10b981', 'description' => 'Buku pelajaran dan pendidikan'],
            ['name' => 'Bisnis',       'color' => '#8b5cf6', 'description' => 'Manajemen dan kewirausahaan'],
        ];
        foreach ($categories as $c) {
            Category::create($c);
        }

        // Books
        $books = [
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'year' => 2008, 'category_id' => 1, 'stock' => 3, 'cover' => 'books/clean-code-1775468756.jpg', 'description' => 'Panduan menulis kode yang bersih dan terstruktur.', 'publisher' => 'Prentice Hall', 'pages' => 464],
            ['title' => 'Laravel: Up & Running', 'author' => 'Matt Stauffer', 'year' => 2023, 'category_id' => 1, 'stock' => 2, 'cover' => 'books/laravel-up-running-1775468762.jpg', 'description' => 'Panduan lengkap framework Laravel.', 'publisher' => "O'Reilly", 'pages' => 610],
            ['title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'year' => 1988, 'category_id' => 2, 'stock' => 2, 'cover' => 'books/a-brief-history-of-time-1775468768.jpg', 'description' => 'Perjalanan ilmiah memahami alam semesta.', 'publisher' => 'Bantam Books', 'pages' => 212],
            ['title' => 'Sapiens', 'author' => 'Yuval Noah Harari', 'year' => 2011, 'category_id' => 3, 'stock' => 4, 'cover' => 'books/sapiens-1775468773.jpg', 'description' => 'Sejarah singkat umat manusia.', 'publisher' => 'Harvill Secker', 'pages' => 443],
            ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata', 'year' => 2005, 'category_id' => 4, 'stock' => 5, 'cover' => 'books/laskar-pelangi-1775468778.jpg', 'description' => 'Novel inspiratif tentang perjuangan anak-anak di Belitung.', 'publisher' => 'Bentang', 'pages' => 529],
            ['title' => 'Zero to One', 'author' => 'Peter Thiel', 'year' => 2014, 'category_id' => 6, 'stock' => 3, 'cover' => 'books/zero-to-one-1775468785.jpg', 'description' => 'Panduan membangun startup dari nol.', 'publisher' => 'Crown Business', 'pages' => 224],
            ['title' => 'Atomic Habits', 'author' => 'James Clear', 'year' => 2018, 'category_id' => 5, 'stock' => 4, 'cover' => 'books/atomic-habits-1775468791.jpg', 'description' => 'Cara membangun kebiasaan kecil yang berdampak besar.', 'publisher' => 'Avery', 'pages' => 320],
            ['title' => 'The Psychology of Money', 'author' => 'Morgan Housel', 'year' => 2020, 'category_id' => 6, 'stock' => 3, 'cover' => 'books/the-psychology-of-money-1775468797.jpg', 'description' => 'Cara berpikir tentang uang dan kekayaan.', 'publisher' => 'Harriman House', 'pages' => 256],
        ];
        foreach ($books as $b) {
            Book::create(array_merge($b, ['status' => 'available', 'total_stock' => $b['stock']]));
        }

        // Sample loans
        $loan = Loan::create([
            'user_id'   => 2,
            'book_id'   => 1,
            'loan_date' => Carbon::today()->subDays(5),
            'due_date'  => Carbon::today()->addDays(9),
            'status'    => 'borrowed',
        ]);
        Book::find(1)->decrement('stock');
    }
}
