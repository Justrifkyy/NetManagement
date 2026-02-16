<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PublicRegistrationController;

// Halaman Depan (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

    Route::get('/daftar-internet', [PublicRegistrationController::class, 'index'])->name('public.register');
    Route::post('/daftar-internet', [PublicRegistrationController::class, 'store'])->name('public.register.store');
    Route::get('/pendaftaran-berhasil', [PublicRegistrationController::class, 'success'])->name('public.register.success');

// Grouping Middleware Auth (Harus Login Dulu)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // 1. DASHBOARD UTAMA (Traffic Cop)
    // Mengarahkan user ke view yang berbeda sesuai role-nya
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ---------------------------------------------------------------------
    // ZONE 1: SUPER ADMIN (Owner/IT)
    // ---------------------------------------------------------------------
    // Akses Eksklusif: Manajemen User (Create/Edit/Delete Pegawai)
    Route::middleware(['role:super_admin'])
        ->prefix('super')
        ->name('super.')
        ->group(function () {
            // Placeholder: Nanti kita buat UserController di sini
            Route::get('/users', function () {
                return 'Halaman Kelola User (Hanya Owner/Super Admin)';
            })->name('users.index');
        });

    // ---------------------------------------------------------------------
    // ZONE 2: OPERATIONAL (Marketing + Admin + Super Admin)
    // ---------------------------------------------------------------------
    // Modul Leads bisa diakses oleh Marketing (Input), Admin (Pantau), dan Boss
    Route::middleware(['role:marketing,admin,super_admin'])
        ->prefix('marketing')
        ->name('marketing.')
        ->group(function () {
            Route::resource('leads', LeadController::class);
            // Route khusus convert lead jadi customer
            Route::post('/leads/{lead}/convert', [LeadController::class, 'convertToCustomer'])->name('leads.convert');
        });

    // ---------------------------------------------------------------------
    // ZONE 3: TECHNICAL (Technician + Admin + Super Admin)
    // ---------------------------------------------------------------------
    // Modul Tiket bisa diakses oleh Teknisi (Kerja), Admin (Assign), dan Boss
    Route::middleware(['role:technician,admin,super_admin'])
        ->prefix('technician')
        ->name('technician.')
        ->group(function () {
            
            // AREA 1: JOBDESK (TIKET OPEN)
            Route::get('/jobdesk', [TicketController::class, 'index'])->name('tickets.index');
            Route::get('/jobdesk/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
            Route::post('/jobdesk/{ticket}/claim', [TicketController::class, 'claim'])->name('tickets.claim');

            // AREA 2: PROCESSED (TUGAS SAYA)
            Route::prefix('process')->name('process.')->group(function() {
                // List Tugas Saya
                Route::get('/', [TicketController::class, 'processIndex'])->name('index');
                
                // Form Input Data (Worksheet)
                Route::get('/{ticket}/input', [TicketController::class, 'processInput'])->name('input');
                
                // Simpan Data (Action)
                Route::put('/{ticket}/store', [TicketController::class, 'processStore'])->name('store');
                
                // Lihat Detail Hasil (Laporan)
                Route::get('/{ticket}/result', [TicketController::class, 'processShow'])->name('show');
                
                // Edit Data (Revisi)
                Route::get('/{ticket}/edit', [TicketController::class, 'processEdit'])->name('edit');
                Route::put('/{ticket}/update', [TicketController::class, 'processUpdate'])->name('update');
            });
        });

    // ---------------------------------------------------------------------
    // ZONE 4: FINANCE & BILLING (Admin + Super Admin)
    // ---------------------------------------------------------------------
    // Area khusus Admin Operasional dan Boss untuk mengelola tagihan
    Route::middleware(['role:admin,super_admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Placeholder: Nanti kita tambahkan InvoiceController di sini
            Route::get('/billing', function () {
                return 'Halaman Billing & Keuangan';
            })->name('billing.index');
        });

    // ---------------------------------------------------------------------
    // ZONE 5: CUSTOMER AREA (Client Only)
    // ---------------------------------------------------------------------
    // Area khusus pelanggan untuk melihat tagihan sendiri
    Route::middleware(['role:customer'])
        ->prefix('client')
        ->name('client.')
        ->group(function () {
            Route::get('/area', function () {
                return view('dashboard.customer'); // Kembali ke dashboard customer
            })->name('area');
        });
});
