DIGILIB — SISTEM INFORMASI PERPUSTAKAAN DIGITAL

DigiLib adalah platform manajemen perpustakaan modern berbasis web yang dibangun dengan Laravel 11. Dirancang untuk memberikan pengalaman premium bagi pengelola (Admin & Petugas) serta kemudahan akses bagi Anggota dalam menelusuri dan meminjam koleksi buku digital maupun fisik.

-----------------------------------------------------------
FITUR UNGGULAN
-----------------------------------------------------------

- Multi-Role System: Akses khusus untuk Admin (Kepala), Petugas (Staf), dan Anggota.
- Katalog Digital: Pencarian buku cepat dengan integrasi PDF Reader langsung di browser.
- Sistem Peminjaman Terotomasi: Validasi stok, batas peminjaman, dan perhitungan denda otomatis.
- Pusat Akun Anggota: Kelola profil, unggah foto profil, wishlist buku, dan riwayat transaksi.
- Laporan & Statistik: Dashboard visual untuk memantau performa sirkulasi buku.
- User Interface Premium: Desain responsif dengan skema warna Cyan/Teal yang elegan dan bersih.

-----------------------------------------------------------
AKSES DEMO (DEFAULT CREDENTIALS)
-----------------------------------------------------------

Role: Admin (Kepala)
Email: admin@perpustakaan.id
Password: admin123

Role: Petugas (Staf)
Email: petugas@perpustakaan.id
Password: member123

Role: Anggota (Budi Santoso)
Email: budi@gmail.com
Password: member123

-----------------------------------------------------------
CARA INSTALASI (XAMPP / LARAGON)
-----------------------------------------------------------

1. PERSIAPAN AWAL
   - PHP: Versi 8.2 atau lebih tinggi.
   - Database: MySQL / MariaDB.
   - Composer: Terinstal di sistem.

2. LANGKAH-LANGKAH
   - Masuk ke direktori proyek: cd perpustakaan-digital
   - Instalasi dependensi: composer install
   - Konfigurasi Environment: cp .env.example .env
   - Generate Security Key: php artisan key:generate

3. KONFIGURASI DATABASE (PENTING)
   - Buka phpMyAdmin (XAMPP/Laragon).
   - Buat database baru dengan nama: perpustakaan_digital
   - Klik menu Import, pilih file "database_perpustakaan.sql" yang ada di folder utama proyek.
   - Klik Go/Execute. Database sudah siap dengan data demo.

4. AKTIVASI STORAGE & SERVER
   - Hubungkan folder upload (cover & foto profil): php artisan storage:link
   - Jalankan aplikasi: php artisan serve

5. AKSES APLIKASI
   Akses di browser: http://localhost:8000

-----------------------------------------------------------
CAKUPAN FITUR PER ROLE
-----------------------------------------------------------

ADMINISTRATOR (Kepala)
- Kontrol penuh seluruh sistem.
- Monitoring laporan sirkulasi dan statistik pertumbuhan.
- Manajemen Pengaturan Aplikasi & Profil Institusi.

PETUGAS (Staf)
- Input & Update koleksi buku (Cover, PDF, Lokasi Rak).
- Verifikasi transaksi peminjaman & pengembalian buku.
- Manajemen Data Anggota (Aktivasi/Nonaktif).

ANGGOTA (Member)
- Eksplorasi Katalog Buku dengan Filter Kategori.
- Pinjam Buku Online secara mandiri (Maks. 3 buku aktif).
- Membaca versi digital buku langsung melalui browser.
- Cek status denda & riwayat peminjaman secara transparan.

-----------------------------------------------------------
TEKNOLOGI UTAMA
-----------------------------------------------------------

- Framework: Laravel 11.x (PHP 8.2+)
- Styling: Tailwind CSS (Modern & Responsive Layout)
- Database: MySQL with Eloquent ORM
- UI Icons: Font Awesome 6.5
- Typography: Poppins (Modern Web Font)

-----------------------------------------------------------
LISENSI & PENGGUNAAN
-----------------------------------------------------------

Sistem ini dibuat untuk mempermudah digitalisasi perpustakaan. Bebas digunakan dan dimodifikasi untuk kebutuhan komersial maupun pribadi dengan tetap memperhatikan standar keamanan data.

DigiLib — Membawa Literasi ke Ujung Jari.
