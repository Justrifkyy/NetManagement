<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\MasterArea;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        // Hanya memuat data Master Area
        $masterAreas = MasterArea::paginate(10);

        return view('superadmin.master.index', compact('masterAreas'));
    }

    // ==========================================
    // AREA LAYANAN (MASTER AREA)
    // ==========================================
    public function storeArea(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:master_areas',
            'description' => 'nullable|string',
        ]);

        MasterArea::create($validated);
        return redirect()->back()->with('success', 'Area berhasil ditambahkan');
    }

    public function updateArea(Request $request, MasterArea $area)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:master_areas,code,' . $area->id,
            'description' => 'nullable|string',
        ]);

        $area->update($validated);
        return redirect()->back()->with('success', 'Area berhasil diperbarui');
    }

    public function destroyArea(MasterArea $area)
    {
        $area->delete();
        return redirect()->back()->with('success', 'Area berhasil dihapus');
    }
}