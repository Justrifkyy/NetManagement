<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemIntegration;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index()
    {
        $integrations = SystemIntegration::all();
        $availableServices = [
            'payment_gateway' => 'Payment Gateway (Midtrans)',
            'whatsapp_api' => 'WhatsApp API',
            'maps_api' => 'Google Maps API',
            'email_service' => 'Email Service',
            'sms_service' => 'SMS Service',
        ];

        return view('admin.integrations.index', compact('integrations', 'availableServices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string',
            'api_key' => 'required|string',
            'api_secret' => 'nullable|string',
            'webhook_url' => 'nullable|url',
            'is_active' => 'required|boolean',
        ]);

        SystemIntegration::create($validated);

        return redirect()->back()->with('success', 'Integrasi berhasil ditambahkan');
    }

    public function update(Request $request, SystemIntegration $integration)
    {
        $validated = $request->validate([
            'service_name' => 'required|string',
            'api_key' => 'required|string',
            'api_secret' => 'nullable|string',
            'webhook_url' => 'nullable|url',
            'is_active' => 'required|boolean',
        ]);

        $integration->update($validated);

        return redirect()->back()->with('success', 'Integrasi berhasil diperbarui');
    }

    public function testConnection(SystemIntegration $integration)
    {
        // Test API connection
        $isConnected = $this->testServiceConnection($integration);

        return response()->json([
            'status' => $isConnected ? 'connected' : 'disconnected',
            'message' => $isConnected ? 'Koneksi berhasil' : 'Koneksi gagal',
        ]);
    }

    public function destroy(SystemIntegration $integration)
    {
        $integration->delete();
        return redirect()->back()->with('success', 'Integrasi berhasil dihapus');
    }

    private function testServiceConnection(SystemIntegration $integration)
    {
        // Implement actual connection testing logic
        return true;
    }
}
