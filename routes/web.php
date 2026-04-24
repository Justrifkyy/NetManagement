<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('/tes', function () {
    return 'Halo! Server berjalan normal.';
});

// 1. Import Controllers Public
use App\Http\Controllers\Public\PublicRegistrationController;

// 2. Import Controllers Admin
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TicketQCController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\RouterController;
use App\Http\Controllers\Admin\IntegrationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TicketManagementController;
use App\Http\Controllers\Admin\LeadManagementController;

// 3. Import Controllers SuperAdmin
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UserManagementController;
use App\Http\Controllers\SuperAdmin\RoleAccessController;
use App\Http\Controllers\SuperAdmin\MasterDataController;
use App\Http\Controllers\SuperAdmin\SystemSettingsController;
use App\Http\Controllers\SuperAdmin\AuditController;
use App\Http\Controllers\SuperAdmin\MaintenanceController;

// 4. Import Controllers Marketing
use App\Http\Controllers\Marketing\MarketingDashboardController;
use App\Http\Controllers\Marketing\LeadController;

// 5. Import Controllers Technician
use App\Http\Controllers\Technician\TechnicianDashboardController;
use App\Http\Controllers\Technician\TicketController;
use App\Http\Controllers\Technician\ProcessController;
use App\Http\Controllers\Technician\TechnicianController;

// 6. Import Controllers Customer
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
        $role = $user->role;

        return match ($role) {
            'super_admin', 'admin' => redirect()->route('admin.dashboard'),
            'marketing' => redirect()->route('marketing.dashboard'),
            'technician' => redirect()->route('technician.dashboard'),
            'customer' => redirect()->route('client.dashboard'),
            default => view('dashboard'),
        };
    })->name('dashboard');

// ==========================================
        // ZONE 1: ADMIN AREA (Diakses Admin & Super Admin)
        // ==========================================
        Route::middleware(['role:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
            // Dashboard
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            
            // Customers Management
            Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
            Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
            Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
            Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
            Route::post('/customers/{customer}/isolate', [CustomerController::class, 'isolate'])->name('customers.isolate');
            Route::post('/customers/{customer}/activate', [CustomerController::class, 'activate'])->name('customers.activate');
            Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
            
            // Packages Management
            Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
            Route::get('/packages/create', [PackageController::class, 'create'])->name('packages.create');
            Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
            Route::get('/packages/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
            Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
            Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
            
            // Routers Management
            Route::get('/routers', [RouterController::class, 'index'])->name('routers.index');
            Route::get('/routers/create', [RouterController::class, 'create'])->name('routers.create');
            Route::post('/routers', [RouterController::class, 'store'])->name('routers.store');
            Route::get('/routers/{router}/edit', [RouterController::class, 'edit'])->name('routers.edit');
            Route::put('/routers/{router}', [RouterController::class, 'update'])->name('routers.update');
            Route::delete('/routers/{router}', [RouterController::class, 'destroy'])->name('routers.destroy');
            Route::post('/routers/{router}/test', [RouterController::class, 'testConnection'])->name('routers.test');
            
            // Billing
            Route::get('/billing', [\App\Http\Controllers\Admin\BillingController::class, 'index'])->name('billing.index');
            Route::get('/billing/{invoice}', [\App\Http\Controllers\Admin\BillingController::class, 'show'])->name('billing.show');
            Route::post('/billing/{invoice}/mark-as-paid', [\App\Http\Controllers\Admin\BillingController::class, 'markAsPaid'])->name('billing.markAsPaid');
            
            // Integrations
            Route::get('/integrations', [IntegrationController::class, 'index'])->name('integrations.index');
            Route::post('/integrations', [IntegrationController::class, 'store'])->name('integrations.store');
            Route::put('/integrations/{integration}', [IntegrationController::class, 'update'])->name('integrations.update');
            Route::post('/integrations/{integration}/test', [IntegrationController::class, 'testConnection'])->name('integrations.test');
            Route::delete('/integrations/{integration}', [IntegrationController::class, 'destroy'])->name('integrations.destroy');
            
            // Reports & Logs
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/customers', [ReportController::class, 'customerReport'])->name('reports.customers');
            Route::get('/reports/arrears', [ReportController::class, 'arrearsReport'])->name('reports.arrears');
            Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
            Route::get('/logs/{log}', [LogController::class, 'show'])->name('logs.show');
            Route::get('/logs/export', [LogController::class, 'export'])->name('logs.export');
            
            // Profile
            Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
            Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
            Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
            
            // Tickets Management (Technician Data)
            Route::get('/tickets', [TicketManagementController::class, 'index'])->name('tickets.index');
            Route::get('/tickets/create', [TicketManagementController::class, 'create'])->name('tickets.create');
            Route::post('/tickets', [TicketManagementController::class, 'store'])->name('tickets.store');
            Route::get('/tickets/{ticket}', [TicketManagementController::class, 'show'])->name('tickets.show');
            Route::get('/tickets/{ticket}/edit', [TicketManagementController::class, 'edit'])->name('tickets.edit');
            Route::put('/tickets/{ticket}', [TicketManagementController::class, 'update'])->name('tickets.update');
            Route::delete('/tickets/{ticket}', [TicketManagementController::class, 'destroy'])->name('tickets.destroy');
            Route::patch('/tickets/{ticket}/status', [TicketManagementController::class, 'updateStatus'])->name('tickets.updateStatus');
            
            // Leads Management (Marketing Data)
            Route::get('/leads', [LeadManagementController::class, 'index'])->name('leads.index');
            Route::get('/leads/create', [LeadManagementController::class, 'create'])->name('leads.create');
            Route::post('/leads', [LeadManagementController::class, 'store'])->name('leads.store');
            Route::get('/leads/{lead}', [LeadManagementController::class, 'show'])->name('leads.show');
            Route::get('/leads/{lead}/edit', [LeadManagementController::class, 'edit'])->name('leads.edit');
            Route::put('/leads/{lead}', [LeadManagementController::class, 'update'])->name('leads.update');
            Route::delete('/leads/{lead}', [LeadManagementController::class, 'destroy'])->name('leads.destroy');
            Route::patch('/leads/{lead}/status', [LeadManagementController::class, 'updateStatus'])->name('leads.updateStatus');
            Route::post('/leads/bulk-import', [LeadManagementController::class, 'bulkImport'])->name('leads.bulkImport');
        });

        // ==========================================
        // ZONE 0: SUPER ADMIN AREA (HANYA Super Admin)
        // ==========================================
        Route::middleware(['role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
            // Dashboard
            Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
            
            // Users Management
            Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
            Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
            Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
            Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
            Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.resetPassword');
            Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
            
            // Roles & Permissions
            Route::get('/roles', [RoleAccessController::class, 'index'])->name('roles.index');
            Route::post('/roles/permissions', [RoleAccessController::class, 'updatePermissions'])->name('roles.updatePermissions');
            
            // Master Data
            Route::get('/master', [MasterDataController::class, 'index'])->name('master.index');
            Route::post('/master/areas', [MasterDataController::class, 'storeArea'])->name('master.storeArea');
            Route::put('/master/areas/{area}', [MasterDataController::class, 'updateArea'])->name('master.updateArea');
            Route::delete('/master/areas/{area}', [MasterDataController::class, 'destroyArea'])->name('master.destroyArea');
            Route::post('/master/technicians', [MasterDataController::class, 'storeTechnician'])->name('master.storeTechnician');
            Route::put('/master/technicians/{technician}', [MasterDataController::class, 'updateTechnician'])->name('master.updateTechnician');
            Route::delete('/master/technicians/{technician}', [MasterDataController::class, 'destroyTechnician'])->name('master.destroyTechnician');
            Route::post('/master/marketings', [MasterDataController::class, 'storeMarketing'])->name('master.storeMarketing');
            Route::put('/master/marketings/{marketing}', [MasterDataController::class, 'updateMarketing'])->name('master.updateMarketing');
            Route::delete('/master/marketings/{marketing}', [MasterDataController::class, 'destroyMarketing'])->name('master.destroyMarketing');
            
            // System Settings
            Route::get('/settings', [SystemSettingsController::class, 'index'])->name('settings.index');
            Route::post('/settings', [SystemSettingsController::class, 'update'])->name('settings.update');
            Route::post('/settings/backup', [SystemSettingsController::class, 'backupDatabase'])->name('settings.backup');
            Route::post('/settings/restore', [SystemSettingsController::class, 'restoreDatabase'])->name('settings.restore');
            
            // Audit & Security
            Route::get('/audits', [AuditController::class, 'index'])->name('audits.index');
            Route::get('/audits/{log}', [AuditController::class, 'show'])->name('audits.show');
            Route::get('/audits/export', [AuditController::class, 'export'])->name('audits.export');
            
            // Maintenance
            Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
            Route::post('/maintenance/mode', [MaintenanceController::class, 'toggleMaintenanceMode'])->name('maintenance.maintenanceMode');
            Route::post('/maintenance/clear-cache', [MaintenanceController::class, 'clearCache'])->name('maintenance.clearCache');
            Route::post('/maintenance/optimize', [MaintenanceController::class, 'optimizeDatabase'])->name('maintenance.optimizeDatabase');
            Route::post('/maintenance/backup', [MaintenanceController::class, 'backupDatabase'])->name('maintenance.backupDatabase');
            Route::get('/maintenance/logs', [MaintenanceController::class, 'viewLogs'])->name('maintenance.viewLogs');
            Route::post('/maintenance/clear-logs', [MaintenanceController::class, 'clearLogs'])->name('maintenance.clearLogs');
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
                Route::post('/leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');
                Route::view('/customers', 'marketing.customers.index')->name('customers.index');
                Route::view('/customers/{id}', 'marketing.customers.show')->name('customers.show');
                Route::view('/schedules', 'marketing.schedules.index')->name('schedules.index');
                Route::view('/reports', 'marketing.reports.index')->name('reports.index');
                Route::view('/profile', 'marketing.profile.index')->name('profile.index');
            });

    // ==========================================
    // EMAIL NOTIFICATION TEST ROUTES
    // ==========================================
    Route::get('/test/email-config', function () {
        return [
            'status' => 'ok',
            'mailer' => config('mail.mailer'),
            'host' => config('mail.host'),
            'port' => config('mail.port'),
            'from' => config('mail.from.address'),
            'from_name' => config('mail.from.name'),
        ];
    });

    Route::get('/test/send-email', function () {
        try {
            $user = Auth::user();
            $testEmail = $user ? $user->email : 'test@example.com';
            
            \Illuminate\Support\Facades\Mail::raw(
                'Test email from NetManagement',
                function ($message) use ($testEmail) {
                    $message->to($testEmail)->subject('Test Email');
                }
            );

            return ['status' => 'success', 'sent_to' => $testEmail];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    });

    Route::get('/test/notification/{ticketId}', function ($ticketId) {
        try {
            $ticket = \App\Models\Ticket::find($ticketId);
            if (!$ticket) return ['error' => 'Ticket not found'];

            if (!$ticket->customer || !$ticket->customer->user) {
                return ['error' => 'Ticket customer or user not found'];
            }

            \App\Services\NotificationService::notifyTicketCreated($ticket);

            return ['status' => 'success', 'sent_to' => $ticket->customer->user->email];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    });

        // ==========================================
        // ZONE 3: TECHNICIAN AREA
        // ==========================================
        Route::middleware(['role:technician'])->prefix('technician')->name('technician.')->group(function () {
            
            // 1. Dashboard Teknisi
            Route::get('/dashboard', [TechnicianController::class, 'dashboard'])->name('dashboard');
            
            // 2. Survey Management
            Route::get('/survey', [TechnicianController::class, 'survey_list'])->name('survey.index');
            Route::get('/survey/{lead_id}', [TechnicianController::class, 'survey_create'])->name('survey.create');
            Route::get('/survey/{lead_id}/edit', [TechnicianController::class, 'survey_create'])->name('survey.edit');
            Route::post('/survey/{lead_id}', [TechnicianController::class, 'survey_store'])->name('survey.store');
            
            // 3. Installation Management
            Route::get('/installation', [TechnicianController::class, 'installation_list'])->name('installation.index');
            Route::get('/installation/{lead_id}', [TechnicianController::class, 'installation_create'])->name('installation.create');
            Route::get('/installation/{installation_id}/edit', [TechnicianController::class, 'installation_create'])->name('installation.edit');
            Route::post('/installation/{lead_id}', [TechnicianController::class, 'installation_store'])->name('installation.store');
            Route::get('/installation/{installation_id}/show', [TechnicianController::class, 'installation_show'])->name('installation.show');
            
            // 4. Device Configuration
            Route::get('/installation/{installation_id}/device', [TechnicianController::class, 'device_form'])->name('device.form');
            Route::post('/installation/{installation_id}/device', [TechnicianController::class, 'device_store'])->name('device.store');
            
            // 5. Network Configuration
            Route::get('/installation/{installation_id}/network', [TechnicianController::class, 'network_form'])->name('network.form');
            Route::post('/installation/{installation_id}/network', [TechnicianController::class, 'network_store'])->name('network.store');
            
            // 6. Internet Account
            Route::get('/installation/{installation_id}/internet-account', [TechnicianController::class, 'internet_account_form'])->name('internet-account.form');
            Route::post('/installation/{installation_id}/internet-account', [TechnicianController::class, 'internet_account_store'])->name('internet-account.store');
            
            // 7. Connection Test
            Route::get('/installation/{installation_id}/connection-test', [TechnicianController::class, 'connection_test_form'])->name('connection-test.form');
            Route::post('/installation/{installation_id}/connection-test', [TechnicianController::class, 'connection_test_store'])->name('connection-test.store');
            
            // 8. Handover Confirmation
            Route::get('/installation/{installation_id}/handover', [TechnicianController::class, 'handover_form'])->name('handover.form');
            Route::post('/installation/{installation_id}/handover', [TechnicianController::class, 'handover_store'])->name('handover.store');
            
            // 9. Tickets (Bursa Pekerjaan)
            Route::get('/ticket', [TicketController::class, 'index'])->name('ticket.index');
            Route::get('/ticket/{ticket}', [TicketController::class, 'show'])->name('ticket.show');
            Route::post('/ticket/{ticket}/claim', [TicketController::class, 'claim'])->name('ticket.claim');
            
            // 10. Process (Meja Kerja Teknisi)
            
            // 11. Process (Tugas Saya)
            Route::get('/process', [ProcessController::class, 'index'])->name('process.index');
            Route::get('/process/{ticket}', [ProcessController::class, 'show'])->name('process.show');
            Route::get('/process/{ticket}/edit', [ProcessController::class, 'edit'])->name('process.edit');
            Route::put('/process/{ticket}', [ProcessController::class, 'update'])->name('process.update');
            
            // 12. Profile & Account
            Route::get('/profile', function() { return view('technician.profile'); })->name('profile');
            Route::get('/password', function() { return view('technician.password'); })->name('password');
        });

        // ==========================================
        // ZONE 4: CUSTOMER / CLIENT AREA
        // ==========================================
        Route::middleware(['role:customer'])
            ->prefix('client')
            ->name('client.')
            ->group(function () {
                // Dashboard redirect ke billing
                Route::get('/dashboard', function() {
                    return redirect()->route('client.billing.index');
                })->name('dashboard');

                // 1. Pembayaran & Tagihan
                Route::get('/billing', [InvoiceController::class, 'index'])->name('billing.index');
                Route::get('/billing/{invoice}', [InvoiceController::class, 'show'])->name('billing.show');

                // 2. Pengajuan / Keluhan
                Route::get('/complaints', function() { return view('client.complaints.index'); })->name('complaints.index');
                Route::get('/complaints/create', function() { return view('client.complaints.create'); })->name('complaints.create');
                Route::post('/complaints', function() { return back()->with('success', 'Laporan berhasil dikirim'); })->name('complaints.store');
            });
        });