<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function index()
    {
        $settings = SystemSetting::all()->keyBy('key');
        
        return view('superadmin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_phone' => 'required|string',
            'company_email' => 'required|email',
            'company_address' => 'required|string',
            'maintenance_mode' => 'boolean',
            'timezone' => 'required|string',
            'currency' => 'required|string',
            'enable_two_factor' => 'boolean',
            'password_expiry_days' => 'required|integer',
            'backup_frequency' => 'required|string',
        ]);

        foreach ($validated as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui');
    }

    public function backupDatabase()
    {
        // Implement backup logic here
        return redirect()->back()->with('success', 'Database backup dimulai');
    }

    public function restoreDatabase(Request $request)
    {
        // Implement restore logic here
        return redirect()->back()->with('success', 'Database restore dimulai');
    }
}
