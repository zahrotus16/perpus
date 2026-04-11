<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/auth/selection', function() {
    return view('auth.selection');
})->name('auth.selection');

Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('password')->middleware('guest')->group(function() {
    Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Admin / Petugas Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:admin,petugas']], function () {

    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart', [Admin\DashboardController::class, 'getChartData'])->name('dashboard.chart');

    // Books
    Route::resource('books', Admin\BookController::class);

    // Categories
    Route::resource('categories', Admin\CategoryController::class)->except(['create','edit','show']);

    // Users / Members
    Route::resource('users', Admin\UserController::class);
    Route::post('users/{user}/reset-password', [Admin\UserController::class, 'resetPassword'])->name('users.resetPassword');

    // Peminjaman (Borrowing)
    Route::get('peminjaman', [Admin\PeminjamanController::class, 'index'])->name('loans.index');
    Route::post('peminjaman', [Admin\PeminjamanController::class, 'store'])->name('loans.store');
    Route::get('peminjaman/{loan}', [Admin\PeminjamanController::class, 'show'])->name('loans.show');
    Route::patch('peminjaman/{loan}/confirm', [Admin\PeminjamanController::class, 'confirm'])->name('loans.confirm');
    Route::delete('peminjaman/{loan}', [Admin\PeminjamanController::class, 'destroy'])->name('loans.destroy');
    
    // Pengembalian (Returns)
    Route::get('pengembalian', [Admin\PengembalianController::class, 'index'])->name('loans.returns');
    Route::patch('pengembalian/{loan}/proses', [Admin\PengembalianController::class, 'store'])->name('loans.return');
    Route::get('denda',   [Admin\PengembalianController::class, 'fines'])->name('loans.fines');

    // Functional Search & Notifications
    Route::get('search', [Admin\SearchController::class, 'index'])->name('search');
    Route::get('notifications', [Admin\NotificationController::class, 'index'])->name('notifications');

    // Settings & Shared Profile
    Route::get('settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::patch('settings/profile', [Admin\SettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::patch('settings/password', [Admin\SettingsController::class, 'updatePassword'])->name('settings.password');

    // Restricted to Kepala Perpustakaan (Admin) Only
    Route::middleware('role:admin')->group(function() {
        // Reports
        Route::get('reports',           [Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/loans',     [Admin\ReportController::class, 'loans'])->name('reports.loans');
        Route::get('reports/members',    [Admin\ReportController::class, 'members'])->name('reports.members');
        Route::get('reports/statistics', [Admin\ReportController::class, 'stats'])->name('reports.stats');
        Route::get('reports/print',      [Admin\ReportController::class, 'print'])->name('reports.print');
        
        // System Settings
        Route::patch('settings/app', [Admin\SettingsController::class, 'updateAppSettings'])->name('settings.updateApp');
        
        Route::get('staff', [Admin\SettingsController::class, 'staff'])->name('staff.index');
        Route::get('roles', [Admin\SettingsController::class, 'roles'])->name('roles.index');
    });
});

/*
|--------------------------------------------------------------------------
| Member / Anggota Routes
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->middleware(['auth', 'role:anggota'])->group(function () {

    Route::get('/dashboard', [User\DashboardController::class, 'index'])->name('dashboard');

    // Books catalog
    Route::get('books',             [User\BookController::class, 'index'])->name('books.index');
    Route::get('books/{book}',      [User\BookController::class, 'show'])->name('books.show');
    Route::get('books/{book}/read', [User\BookController::class, 'read'])->name('books.read');
    Route::post('books/{book}/borrow',   [User\BookController::class, 'borrow'])->name('books.borrow');
    Route::post('books/{book}/review',   [User\BookController::class, 'storeReview'])->name('books.review');
    Route::post('books/{book}/wishlist', [User\BookController::class, 'toggleWishlist'])->name('books.wishlist');

    // Peminjaman (Borrowing)
    Route::get('peminjaman',             [User\PeminjamanController::class, 'index'])->name('loans.index');
    Route::get('peminjaman/aktif',      [User\PeminjamanController::class, 'active'])->name('loans.active');
    Route::get('peminjaman/kembali',     [User\PeminjamanController::class, 'returns'])->name('loans.returns');
    Route::patch('peminjaman/{loan}/kembalikan', [User\PeminjamanController::class, 'returnBook'])->name('loans.return');
    Route::get('peminjaman/denda',       [User\PeminjamanController::class, 'fines'])->name('loans.fines');
    Route::get('peminjaman/{loan}',      [User\PeminjamanController::class, 'show'])->name('loans.show');

    // Profile
    Route::get('profile', [User\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile',           [User\ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/password',  [User\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('wishlist',            [User\ProfileController::class, 'wishlist'])->name('wishlist');
});

/*
|--------------------------------------------------------------------------
| Kepala Routes
|--------------------------------------------------------------------------
*/
Route::prefix('kepala')->name('kepala.')->middleware(['auth', 'role:kepala'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard'); // Placeholder for now
    
    // Kepala typically only sees reports
    Route::get('reports',           [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/statistics', [Admin\ReportController::class, 'stats'])->name('reports.stats');
    Route::get('reports/print',      [Admin\ReportController::class, 'print'])->name('reports.print');
});
