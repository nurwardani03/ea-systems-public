<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// === CONTROLLER UNTUK USER (AUDITOR) ===
use App\Http\Controllers\User\WebUserLoginController;
use App\Http\Controllers\User\AuditController;
use App\Http\Controllers\User\NotifikasiController;
use App\Http\Controllers\User\LaporanController;
use App\Http\Controllers\User\ProfileController;

// === CONTROLLER UNTUK ADMIN ===
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AuditController as AdminAuditController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\AuditExportController;
use App\Http\Controllers\Admin\NotifikasiController as AdminNotifikasiController;

/*
|--------------------------------------------------------------------------
| ROUTE UNTUK USER (AUDITOR)
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

// === AUTH USER ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [WebUserLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [WebUserLoginController::class, 'login'])->name('login.post');

    Route::get('/register', [WebUserLoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [WebUserLoginController::class, 'register'])->name('register.post');
});

// === LOGOUT USER ===
Route::post('/logout', [WebUserLoginController::class, 'logout'])->middleware('auth')->name('logout');

// === FITUR USER ===
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AuditController::class, 'dashboard'])->name('dashboard');

    // Profil
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::patch('/foto', [ProfileController::class, 'updatePhoto'])->name('update.photo');
        Route::patch('/password', [ProfileController::class, 'updatePassword'])->name('update.password');
    });

    // Audit
    Route::get('/tambah-audit', [AuditController::class, 'create'])->name('audit.create');
    Route::post('/tambah-audit', [AuditController::class, 'store'])->name('audit.store');
    Route::get('/audit/{id}', [AuditController::class, 'show'])->name('audit.show');
    Route::patch('/audit/{id}/update-sesudah', [AuditController::class, 'updateSesudah'])->name('audit.updateSesudah');
    Route::get('/riwayat-audit', [AuditController::class, 'riwayat'])->name('audit.riwayat');
    Route::get('/hasil-audit', [AuditController::class, 'hasilAudit'])->name('audit.hasil');
    Route::get('/hasil-audit/{id}', [AuditController::class, 'hasilAuditShow'])->name('audit.hasil.show');

    // Notifikasi
    Route::prefix('notifikasi')->name('notifikasi.')->group(function () {
        Route::get('/', [NotifikasiController::class, 'index'])->name('index');
        Route::get('/{id}', [NotifikasiController::class, 'show'])->name('show');
        Route::get('/baca/{id}', [NotifikasiController::class, 'baca'])->name('baca');
        Route::post('/baca-semua', [NotifikasiController::class, 'bacaSemua'])->name('baca.semua');
        Route::delete('/hapus/{id}', [NotifikasiController::class, 'hapus'])->name('hapus');
        Route::delete('/hapus-semua', [NotifikasiController::class, 'hapusSemua'])->name('hapus.semua');
    });

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Kirim ulang verifikasi email (opsional)
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Link verifikasi dikirim!');
    })->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| ROUTE UNTUK ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // === AUTH ADMIN ===
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.post');
    });

    // === FITUR ADMIN ===
    Route::middleware('auth:admin')->group(function () {

        // Logout Admin
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen Audit
        Route::get('/audit', [AdminAuditController::class, 'index'])->name('audit');
        Route::get('/audit/{id}', [AdminAuditController::class, 'show'])->name('audit.detail');
        Route::post('/audit/set-all-audit', [AdminAuditController::class, 'setAllAudit'])->name('audit.setAllAudit');
        Route::post('/audit/verifikasi/{id}', [AdminAuditController::class, 'tentukanVerifikasi'])->name('audit.tentukanVerifikasi');
        Route::patch('/audit/reset-verifikasi/{id}', [AdminAuditController::class, 'resetVerifikasi'])->name('audit.resetVerifikasi');
        Route::post('/audit/set-all-verifikasi', [AdminAuditController::class, 'setAllVerifikasi'])->name('audit.setAllVerifikasi');
        Route::post('/audit/{id}/selesaikan', [AdminAuditController::class, 'selesaikanAudit'])->name('audit.selesai'); 

        // Export Audit
        Route::get('/audit/export/pdf/{id}', [AuditExportController::class, 'exportPDF'])->name('audit.export.pdf');

        // Manajemen Notifikasi
        Route::get('/notifikasi', [AdminNotifikasiController::class, 'index'])->name('notifikasi');
        Route::get('/notifikasi/{id}', [AdminNotifikasiController::class, 'show'])->name('notifikasi.show');
        Route::post('/notifikasi/kirim', [AdminNotifikasiController::class, 'kirim'])->name('notifikasi.kirim');

        // Manajemen User
        Route::get('/user', [AdminUserController::class, 'index'])->name('user');
        Route::get('/user/create', [AdminUserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [AdminUserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit', [AdminUserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [AdminUserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');

        // Laporan
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan');
    });
});
