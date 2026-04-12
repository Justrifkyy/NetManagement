<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NetworkAsset;
use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function index()
    {
        $routers = NetworkAsset::where('type', 'Router')
            ->orWhere('type', 'OLT')
            ->orWhere('type', 'AP')
            ->orWhere('type', 'ODP')
            ->paginate(15);

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
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'ip_address' => 'required|ip',
            'brand' => 'required|string|max:255',
            'type' => 'required|in:OLT,Router,AP,ODP',
            'is_active' => 'required|boolean',
        ]);

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
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'ip_address' => 'required|ip',
            'brand' => 'required|string|max:255',
            'type' => 'required|in:OLT,Router,AP,ODP',
            'is_active' => 'required|boolean',
        ]);

        $router->update($validated);

        return redirect()->route('admin.routers.index')->with('success', 'Perangkat jaringan berhasil diperbarui');
    }

    public function testConnection(NetworkAsset $router)
    {
        // Test connection to the router
        $isOnline = $this->pingHost($router->ip_address);

        return response()->json([
            'status' => $isOnline ? 'online' : 'offline',
            'message' => $isOnline ? 'Koneksi berhasil' : 'Koneksi gagal',
        ]);
    }

    public function destroy(NetworkAsset $router)
    {
        $router->delete();
        return redirect()->route('admin.routers.index')->with('success', 'Perangkat jaringan berhasil dihapus');
    }

    private function pingHost($host)
    {
        $exitcode = null;
        $output = array();
        exec("ping -c 4 $host", $output, $exitcode);
        return $exitcode === 0;
    }
}
