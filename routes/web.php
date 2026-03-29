<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/tes', function () {
    return 'Halo! Server berjalan normal.';
});

// 1. Import Controllers Public
use App\Http\Controllers\Public\PublicRegistrationController;

// 2. Import Controllers Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TicketQCController;

// 3. Import Controllers Marketing
use App\Http\Controllers\Marketing\MarketingDashboardController;
use App\Http\Controllers\Marketing\LeadController;

// 4. Import Controllers Technician
use App\Http\Controllers\Technician\TechnicianDashboardController;
use App\Http\Controllers\Technician\TicketController;

// 5. Import Controllers Customer
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\InvoiceController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/daftar-internet', [PublicRegistrationController::class, 'index'])->name('public.register');
Route::post('/daftar-internet', [PublicRegistrationController::class, 'store'])->name('public.register.store');
Route::get('/pendaftaran-berhasil', [PublicRegistrationController::class, 'success'])->name('public.register.success');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    // GATEKEEPER DASHBOARD: Redirect ke dashboard masing-masing role
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        return match ($role) {
            'super_admin', 'admin' => redirect()->route('admin.dashboard'),
            'marketing' => redirect()->route('marketing.dashboard'),
            'technician' => redirect()->route('technician.dashboard'),
            'customer' => redirect()->route('client.dashboard'),
            default => view('dashboard'),
        };
    })->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | ZONE 1: ADMIN & SUPER ADMIN
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:admin,super_admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Dashboard Admin
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

            // Manajemen User (Akses Ekstra Ketat - Cukup Super Admin)
            Route::middleware(['role:super_admin'])->group(function () {
                Route::resource('users', UserController::class);
            });

            // Verifikasi Tiket & Aktivasi Layanan (QC)
            // Verifikasi Tiket & Aktivasi Layanan (QC)
            Route::get('/tickets/verification', [TicketQCController::class, 'index'])->name('tickets.index');
            Route::get('/tickets/verification/{ticket}', [TicketQCController::class, 'show'])->name('tickets.show');
            Route::get('/tickets/{ticket}/edit', [TicketQCController::class, 'edit'])->name('tickets.edit');
            Route::put('/tickets/{ticket}/update', [TicketQCController::class, 'update'])->name('tickets.update');
            Route::post('/tickets/{ticket}/approve', [TicketQCController::class, 'approve'])->name('tickets.approve');
            Route::post('/tickets/{ticket}/reject', [TicketQCController::class, 'reject'])->name('tickets.reject');

            // Billing & Keuangan (Placeholder)
            Route::get('/billing', [\App\Http\Controllers\Admin\BillingController::class, 'index'])->name('billing.index');
            Route::get('/billing/{invoice}', [\App\Http\Controllers\Admin\BillingController::class, 'show'])->name('billing.show');
            Route::get('/billing/{invoice}/edit', [\App\Http\Controllers\Admin\BillingController::class, 'edit'])->name('billing.edit');
            Route::put('/billing/{invoice}/update', [\App\Http\Controllers\Admin\BillingController::class, 'update'])->name('billing.update');
            Route::post('/billing/{invoice}/pay', [\App\Http\Controllers\Admin\BillingController::class, 'markAsPaid'])->name('billing.pay');
        });

    // ==========================================
    // ZONE 2: MARKETING AREA
    // ==========================================
    Route::middleware(['role:marketing'])
        ->prefix('marketing')
        ->name('marketing.')
        ->group(function () {
            Route::get('/dashboard', [MarketingDashboardController::class, 'index'])->name('dashboard');
            Route::resource('leads', LeadController::class);
            Route::view('/customers', 'marketing.customers.index')->name('customers.index');
            Route::view('/customers/{id}', 'marketing.customers.show')->name('customers.show');
            Route::view('/schedules', 'marketing.schedules.index')->name('schedules.index');
            Route::view('/reports', 'marketing.reports.index')->name('reports.index');
            Route::view('/profile', 'marketing.profile.index')->name('profile.index');
        });

// ==========================================
        // ZONE 3: TECHNICIAN AREA
        // ==========================================
        Route::middleware(['role:technician'])->prefix('technician')->name('technician.')->group(function () {
            
            // 1. Dashboard Teknisi
            Route::get('/dashboard', [TechnicianDashboardController::class, 'index'])->name('dashboard');
            
            // 2. Survey
            Route::view('/surveys', 'technician.surveys.index')->name('surveys.index');
            Route::view('/surveys/{id}', 'technician.surveys.show')->name('surveys.show');
            Route::view('/surveys/{id}/edit', 'technician.surveys.edit')->name('surveys.edit');

            // 3. Instalasi
            Route::view('/installations', 'technician.installations.index')->name('installations.index');
            Route::view('/installations/{id}', 'technician.installations.show')->name('installations.show');
            Route::view('/installations/{id}/edit', 'technician.installations.edit')->name('installations.edit');

            // 4. Gangguan (Troubleshoots)
            Route::view('/troubleshoots', 'technician.troubleshoots.index')->name('troubleshoots.index');
            Route::view('/troubleshoots/{id}', 'technician.troubleshoots.show')->name('troubleshoots.show');

            // 5. Data Pelanggan Teknis
            Route::view('/customers/{id}', 'technician.customers.show')->name('customers.show');

            // 6. Akun & Profil
            Route::view('/profile', 'technician.profile.index')->name('profile.index');
        });

    // ==========================================
    // ZONE 4: CUSTOMER / CLIENT AREA
    // ==========================================
    Route::middleware(['role:customer'])
        ->prefix('client')
        ->name('client.')
        ->group(function () {
            // 1. Dashboard (Beranda)
            Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

            // 2. Akun & Profil (Gunakan Controller bawaan nanti, sementara kita arahkan ke dashboard/profil dummy)
            Route::view('/profile', 'user.profile.index')->name('profile.index');

            // 3. Tagihan & Pembayaran
            Route::get('/billing', [InvoiceController::class, 'index'])->name('billing.index');
            Route::get('/billing/{invoice}', [InvoiceController::class, 'show'])->name('billing.show');

            // 4. Layanan (Status, Ganti Paket, Isolir)
            Route::view('/services', 'user.services.index')->name('services.index');

            // 5. Keluhan (Ticketing Pelanggan)
            Route::view('/tickets', 'user.tickets.index')->name('tickets.index');
            Route::view('/tickets/create', 'user.tickets.create')->name('tickets.create');

            // 6. Notifikasi
            Route::view('/notifications', 'user.notifications.index')->name('notifications.index');
        });
});
