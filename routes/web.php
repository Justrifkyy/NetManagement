<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| IMPORT CONTROLLERS
|--------------------------------------------------------------------------
*/
// 1. Public
use App\Http\Controllers\Public\PublicRegistrationController;

// 2. Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\RouterController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\IntegrationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TicketManagementController;
use App\Http\Controllers\Admin\LeadManagementController;

// 3. Super Admin
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UserManagementController;
use App\Http\Controllers\SuperAdmin\RoleAccessController;
use App\Http\Controllers\SuperAdmin\MasterDataController;
use App\Http\Controllers\SuperAdmin\SystemSettingsController;
use App\Http\Controllers\SuperAdmin\AuditController;
use App\Http\Controllers\SuperAdmin\MaintenanceController;

// 4. Marketing
use App\Http\Controllers\Marketing\MarketingDashboardController;
use App\Http\Controllers\Marketing\LeadController;

// 5. Technician
use App\Http\Controllers\Technician\TechnicianDashboardController;
use App\Http\Controllers\Technician\TicketController;


// 6. Customer
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
        /** @var User $user */
        $user = Auth::user();

        return match ($user->role) {
            'super_admin', 'admin' => redirect()->route('admin.dashboard'),
            'marketing' => redirect()->route('marketing.dashboard'),
            'technician' => redirect()->route('technician.dashboard'),
            'customer' => redirect()->route('client.dashboard'),
            default => view('dashboard'),
        };
    })->name('dashboard');


    // ====================================================================
    // ZONE 0: SUPER ADMIN AREA (HANYA Super Admin)
    // ====================================================================
    Route::middleware(['role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        
        // Users Management
        Route::resource('users', UserManagementController::class)->except(['show']);
        Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.resetPassword');
        
        // Roles & Permissions
        Route::get('/roles', [RoleAccessController::class, 'index'])->name('roles.index');
        Route::post('/roles/permissions', [RoleAccessController::class, 'updatePermissions'])->name('roles.updatePermissions');
        
        // Master Data (Hanya Area, Pegawai dihapus)
        Route::get('/master', [MasterDataController::class, 'index'])->name('master.index');
        Route::post('/master/areas', [MasterDataController::class, 'storeArea'])->name('master.storeArea');
        Route::put('/master/areas/{area}', [MasterDataController::class, 'updateArea'])->name('master.updateArea');
        Route::delete('/master/areas/{area}', [MasterDataController::class, 'destroyArea'])->name('master.destroyArea');
        
        // System Settings
        Route::get('/settings', [SystemSettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SystemSettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/backup', [SystemSettingsController::class, 'backupDatabase'])->name('settings.backup');
        Route::post('/settings/restore', [SystemSettingsController::class, 'restoreDatabase'])->name('settings.restore');
        
        // Audit & Security
        Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
        Route::get('/audits/export', [AuditController::class, 'export'])->name('audits.export');
        Route::get('/audits/{log}', [AuditController::class, 'show'])->name('audits.show');
        
        // Maintenance
        Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
        Route::post('/maintenance/mode', [MaintenanceController::class, 'toggleMaintenanceMode'])->name('maintenance.maintenanceMode');
        Route::post('/maintenance/clear-cache', [MaintenanceController::class, 'clearCache'])->name('maintenance.clearCache');
        Route::post('/maintenance/optimize', [MaintenanceController::class, 'optimizeDatabase'])->name('maintenance.optimizeDatabase');
        Route::post('/maintenance/backup', [MaintenanceController::class, 'backupDatabase'])->name('maintenance.backupDatabase');
        Route::get('/maintenance/logs', [MaintenanceController::class, 'viewLogs'])->name('maintenance.viewLogs');
        Route::post('/maintenance/clear-logs', [MaintenanceController::class, 'clearLogs'])->name('maintenance.clearLogs');
    });


    // ====================================================================
    // ZONE 1: ADMIN AREA (Diakses Admin & Super Admin)
    // ====================================================================
    Route::middleware(['role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Customers
        Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search'); // Search harus di atas resource
        Route::resource('customers', CustomerController::class)->except(['create', 'store', 'destroy']);
        Route::post('/customers/{customer}/isolate', [CustomerController::class, 'isolate'])->name('customers.isolate');
        Route::post('/customers/{customer}/activate', [CustomerController::class, 'activate'])->name('customers.activate');
        
        // Resources Utama
        Route::resource('packages', PackageController::class);
        Route::resource('routers', RouterController::class);
        Route::post('/routers/{router}/test', [RouterController::class, 'testConnection'])->name('routers.test');
        
        // Billing
        Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
        Route::get('/billing/{invoice}', [BillingController::class, 'show'])->name('billing.show');
        Route::get('/billing/{invoice}/edit', [BillingController::class, 'edit'])->name('billing.edit');
        Route::put('/billing/{invoice}', [BillingController::class, 'update'])->name('billing.update');
        Route::post('/billing/{invoice}/mark-as-paid', [BillingController::class, 'markAsPaid'])->name('billing.markAsPaid');
        
        // Integrations
        Route::resource('integrations', IntegrationController::class)->except(['create', 'show', 'edit']);
        Route::post('/integrations/{integration}/test', [IntegrationController::class, 'testConnection'])->name('integrations.test');
        
        // Reports & Logs
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/customers', [ReportController::class, 'customerReport'])->name('reports.customers');
        Route::get('/reports/arrears', [ReportController::class, 'arrearsReport'])->name('reports.arrears');
        Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
        Route::get('/logs/export', [LogController::class, 'export'])->name('logs.export');
        Route::get('/logs/{log}', [LogController::class, 'show'])->name('logs.show');
        
        // Profile Admin
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
        Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
        
        // Tickets (Data Teknisi)
        Route::resource('tickets', TicketManagementController::class);
        Route::patch('/tickets/{ticket}/status', [TicketManagementController::class, 'updateStatus'])->name('tickets.updateStatus');
        
        // Leads (Data Marketing)
        Route::post('/leads/bulk-import', [LeadManagementController::class, 'bulkImport'])->name('leads.bulkImport');
        Route::resource('leads', LeadManagementController::class);
        Route::patch('/leads/{lead}/status', [LeadManagementController::class, 'updateStatus'])->name('leads.updateStatus');
    });


    // ====================================================================
    // ZONE 2: MARKETING AREA
    // ====================================================================
    Route::middleware(['role:marketing'])->prefix('marketing')->name('marketing.')->group(function () {
        Route::get('/dashboard', [MarketingDashboardController::class, 'index'])->name('dashboard');
        
        // Mengelola Prospek
        Route::resource('leads', LeadController::class);
        Route::post('/leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');
        
        // View Pages (Sesuai dengan direktori view marketing)
        Route::view('/customers', 'marketing.customers.index')->name('customers.index');
        Route::view('/customers/{id}', 'marketing.customers.show')->name('customers.show');
        Route::view('/schedules', 'marketing.schedules.index')->name('schedules.index');
        Route::view('/reports', 'marketing.reports.index')->name('reports.index');
        Route::view('/profile', 'marketing.profile.index')->name('profile.index');
    });


    // ====================================================================
    // ZONE 3: TECHNICIAN AREA
    // ====================================================================
    Route::middleware(['role:technician'])->prefix('technician')->name('technician.')->group(function () {
        Route::get('/dashboard', [TechnicianDashboardController::class, 'index'])->name('dashboard');
        
        // 1. Bursa Pekerjaan (Open Tickets)
        Route::get('/open-tickets', [App\Http\Controllers\Technician\TicketController::class, 'index'])->name('ticket.index');
        Route::get('/open-tickets/{ticket}', [App\Http\Controllers\Technician\TicketController::class, 'show'])->name('ticket.show');
        Route::post('/open-tickets/{ticket}/take', [App\Http\Controllers\Technician\TicketController::class, 'take'])->name('ticket.take');
        
        // 2. Meja Kerja (My Tasks)
        Route::get('/my-tasks', [TicketController::class, 'processIndex'])->name('process.index');
        Route::get('/my-tasks/{ticket}/input', [TicketController::class, 'processInput'])->name('process.input');
        Route::post('/my-tasks/{ticket}', [TicketController::class, 'processStore'])->name('process.store');
        Route::get('/my-tasks/{ticket}/show', [TicketController::class, 'processShow'])->name('process.show');
        Route::get('/my-tasks/{ticket}/edit', [TicketController::class, 'processEdit'])->name('process.edit');
        Route::put('/my-tasks/{ticket}', [TicketController::class, 'processUpdate'])->name('process.update');
        // Rute Meja Kerja (My Tasks)
Route::get('/my-tasks', [App\Http\Controllers\Technician\TicketController::class, 'processIndex'])->name('process.index');
Route::get('/my-tasks/{ticket}', [App\Http\Controllers\Technician\TicketController::class, 'processShow'])->name('process.show');
        
        // View Pages Statis
        Route::get('/history', [TicketController::class, 'historyIndex'])->name('history.index');
        Route::view('/profile', 'technician.profile.index')->name('profile');
    });


    // ====================================================================
    // ZONE 4: CUSTOMER / CLIENT AREA
    // ====================================================================
    Route::middleware(['role:customer'])->prefix('client')->name('client.')->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

        // Pembayaran & Tagihan
        Route::get('/billing', [InvoiceController::class, 'index'])->name('billing.index');
        Route::get('/billing/{invoice}', [InvoiceController::class, 'show'])->name('billing.show');

        // Pengajuan / Keluhan (Statis berdasarkan views)
        Route::view('/complaints', 'client.complaints.index')->name('complaints.index');
        Route::view('/complaints/create', 'client.complaints.create')->name('complaints.create');
        Route::post('/complaints', function() { return back()->with('success', 'Laporan berhasil dikirim'); })->name('complaints.store');
    });

});