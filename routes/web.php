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
    Route::middleware(['role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Manajemen User (Akses Ekstra Ketat - Cukup Super Admin)
        Route::middleware(['role:super_admin'])->group(function () {
            Route::resource('users', UserController::class);
        });

        // Verifikasi Tiket & Aktivasi Layanan (QC)
        Route::get('/tickets/verification', [TicketQCController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/verification/{ticket}', [TicketQCController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{ticket}/approve', [TicketQCController::class, 'approve'])->name('tickets.approve');
        Route::post('/tickets/{ticket}/reject', [TicketQCController::class, 'reject'])->name('tickets.reject');

        // Billing & Keuangan (Placeholder)
        Route::get('/billing', function () {
            return 'Halaman Billing & Keuangan';
        })->name('billing.index');
    });


    /*
    |----------------------------------------------------------------------
    | ZONE 2: MARKETING
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:marketing,admin,super_admin'])->prefix('marketing')->name('marketing.')->group(function () {
        // Dashboard Marketing
        Route::get('/dashboard', [MarketingDashboardController::class, 'index'])->name('dashboard');

        // Kelola Leads (Prospek)
        Route::resource('leads', LeadController::class);
        Route::post('/leads/{lead}/convert', [LeadController::class, 'convertToCustomer'])->name('leads.convert');
    });


    /*
    |----------------------------------------------------------------------
    | ZONE 3: TECHNICIAN
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:technician,admin,super_admin'])->prefix('technician')->name('technician.')->group(function () {
        // Dashboard Teknisi
        Route::get('/dashboard', [TechnicianDashboardController::class, 'index'])->name('dashboard');

        // Area 1: Jobdesk (Bursa Tugas)
        Route::get('/jobdesk', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/jobdesk/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::post('/jobdesk/{ticket}/claim', [TicketController::class, 'claim'])->name('tickets.claim');

        // Area 2: Meja Kerja (Tugas Diproses)
        Route::prefix('process')->name('process.')->group(function() {
            Route::get('/', [TicketController::class, 'processIndex'])->name('index');
            Route::get('/{ticket}/input', [TicketController::class, 'processInput'])->name('input');
            Route::put('/{ticket}/store', [TicketController::class, 'processStore'])->name('store');
            Route::get('/{ticket}/result', [TicketController::class, 'processShow'])->name('show');
            Route::get('/{ticket}/edit', [TicketController::class, 'processEdit'])->name('edit');
            Route::put('/{ticket}/update', [TicketController::class, 'processUpdate'])->name('update');
        });
    });


    /*
    |----------------------------------------------------------------------
    | ZONE 4: CUSTOMER (CLIENT AREA)
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:customer'])->prefix('client')->name('client.')->group(function () {
        // Dashboard Pelanggan
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        
        // Fitur Tagihan (Billing)
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    });

});