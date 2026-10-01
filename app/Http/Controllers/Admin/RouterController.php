<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NetworkAsset;
use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function index()
    {
        $routers = NetworkAsset::where('type', 'Router')->orWhere('type', 'OLT')->orWhere('type', 'AP')->orWhere('type', 'ODP')->paginate(15);

        return view('admin.routers.index', compact('routers'));
    }

    public function create()
    {
        $types = ['OLT', 'Router', 'AP', 'ODP'];
        return view('admin.routers.create', compact('types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'location'      => 'required|string|max:255',
            'brand'         => 'required|string|max:255',
            'type'          => 'required|in:OLT,Router,AP,ODP',
            'is_active'     => 'required|boolean',
            'ip_address'    => 'required_if:type,Router,OLT,AP|nullable|ip',
            'api_username'  => 'required_if:type,Router,OLT|nullable|string|max:255',
            'api_password'  => 'required_if:type,Router,OLT|nullable|string',
            'api_port'      => 'required_if:type,Router,OLT|nullable|integer|min:1|max:65535',
            'port_capacity' => 'required_if:type,ODP|nullable|integer|min:1',
            'coordinates'   => 'nullable|string|max:255',
        ]);

        if ($validated['type'] === 'ODP') {
            $validated['api_username'] = null;
            $validated['api_password'] = null;
            $validated['api_port'] = null;
        }

        NetworkAsset::create($validated);

        return redirect()->route('admin.routers.index')->with('success', 'Perangkat jaringan berhasil ditambahkan');
    }

    public function edit(NetworkAsset $router)
    {
        $types = ['OLT', 'Router', 'AP', 'ODP'];
        return view('admin.routers.edit', compact('router', 'types'));
    }

    public function update(Request $request, NetworkAsset $router)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'location'      => 'required|string|max:255',
            'brand'         => 'required|string|max:255',
            'type'          => 'required|in:OLT,Router,AP,ODP',
            'is_active'     => 'required|boolean',
            'ip_address'    => 'required_if:type,Router,OLT,AP|nullable|ip',
            'api_username'  => 'required_if:type,Router,OLT|nullable|string|max:255',
            'api_password'  => 'nullable|string',
            'api_port'      => 'required_if:type,Router,OLT|nullable|integer|min:1|max:65535',
            'port_capacity' => 'required_if:type,ODP|nullable|integer|min:1',
            'coordinates'   => 'nullable|string|max:255',
        ]);

        // Pertahankan password lama jika tidak diisi saat update
        if (empty($validated['api_password'])) {
            unset($validated['api_password']);
        }

        if ($validated['type'] === 'ODP') {
            $validated['api_username'] = null;
            $validated['api_password'] = null;
            $validated['api_port'] = null;
        }

        $router->update($validated);

        return redirect()->route('admin.routers.index')->with('success', 'Perangkat jaringan berhasil diperbarui');
    }

    public function testConnection(NetworkAsset $router)
    {
        if ($router->type === 'ODP') {
            return response()->json([
                'status' => 'info',
                'message' => 'Perangkat ODP merupakan splitter pasif optik (tidak memiliki socket IP).',
            ]);
        }

        if (empty($router->ip_address)) {
            return response()->json([
                'status' => 'offline',
                'message' => 'IP Address perangkat belum dikonfigurasi.',
            ]);
        }

        // Tes koneksi non-blocking ke port API MikroTik (dari database perangkat atau default 8728)
        $port = (int) ($router->api_port ?: config('services.mikrotik.port', 8728));
        $isOnline = $this->checkSocket($router->ip_address, $port, 2);

        return response()->json([
            'status' => $isOnline ? 'online' : 'offline',
            'message' => $isOnline ? "Koneksi ke port {$port} berhasil (Online)" : "Perangkat tidak merespons pada port {$port} (Offline / Timeout)",
        ]);
    }

    public function destroy(NetworkAsset $router)
    {
        $router->delete();
        return redirect()->route('admin.routers.index')->with('success', 'Perangkat jaringan berhasil dihapus');
    }

    /**
     * Pengecekan socket non-blocking dengan timeout pendek untuk menghindari thread hanging
     */
    private function checkSocket(string $host, int $port = 8728, int $timeout = 2): bool
    {
        $errno = 0;
        $errstr = '';

        $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);

        if (is_resource($connection)) {
            fclose($connection);
            return true;
        }

        return false;
    }
}
