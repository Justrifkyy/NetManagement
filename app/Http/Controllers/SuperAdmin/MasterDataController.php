<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\MasterArea;
use App\Models\MasterTechnician;
use App\Models\MasterMarketing;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $masterAreas = MasterArea::paginate(10);
        $masterTechnicians = MasterTechnician::paginate(10);
        $masterMarketings = MasterMarketing::paginate(10);

        return view('superadmin.master.index', compact('masterAreas', 'masterTechnicians', 'masterMarketings'));
    }

    // Master Area
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

    // Master Technician
    public function storeTechnician(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'area_id' => 'required|exists:master_areas,id',
        ]);

        MasterTechnician::create($validated);
        return redirect()->back()->with('success', 'Teknisi berhasil ditambahkan');
    }

    public function updateTechnician(Request $request, MasterTechnician $technician)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'area_id' => 'required|exists:master_areas,id',
        ]);

        $technician->update($validated);
        return redirect()->back()->with('success', 'Teknisi berhasil diperbarui');
    }

    public function destroyTechnician(MasterTechnician $technician)
    {
        $technician->delete();
        return redirect()->back()->with('success', 'Teknisi berhasil dihapus');
    }

    // Master Marketing
    public function storeMarketing(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:master_marketings',
            'phone' => 'required|string',
        ]);

        MasterMarketing::create($validated);
        return redirect()->back()->with('success', 'Marketing berhasil ditambahkan');
    }

    public function updateMarketing(Request $request, MasterMarketing $marketing)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:master_marketings,code,' . $marketing->id,
            'phone' => 'required|string',
        ]);

        $marketing->update($validated);
        return redirect()->back()->with('success', 'Marketing berhasil diperbarui');
    }

    public function destroyMarketing(MasterMarketing $marketing)
    {
        $marketing->delete();
        return redirect()->back()->with('success', 'Marketing berhasil dihapus');
    }
}
