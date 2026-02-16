<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Package;
use Illuminate\Http\Request;

class PublicRegistrationController extends Controller
{
    // 1. Tampilkan Form
    public function index()
    {
        // Hanya tampilkan paket yang aktif
        $packages = Package::where('is_active', true)->get();
        return view('public.register', compact('packages'));
    }

    // 2. Proses Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            // Identitas
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'customer_type' => 'required|in:personal,business',
            'ktp_image' => 'required|image|max:5120', // User wajib upload KTP
            
            // Alamat & Paket
            'address' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'package_id' => 'required|exists:packages,id',
            'marketing_code' => 'nullable|string|exists:users,marketing_code',
        ]);

        // A. Cek Kode Marketing
        $marketingId = null;
        if ($request->marketing_code) {
            $marketing = User::where('marketing_code', $request->marketing_code)
                             ->where('role', 'marketing')
                             ->first();
            if ($marketing) {
                $marketingId = $marketing->id;
            }
        }

        // B. Upload Foto
        $ktpPath = $request->file('ktp_image')->store('uploads/ktp', 'public');
        $housePath = $request->file('house_image') ? $request->file('house_image')->store('uploads/house', 'public') : null;
        $custPath = $request->file('customer_image') ? $request->file('customer_image')->store('uploads/customer', 'public') : null;

        // C. Simpan ke Database
        Lead::create([
            'marketing_id' => $marketingId,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'customer_type' => $request->customer_type,
            'business_name' => $request->business_name,
            
            // Kontak Darurat
            'emergency_name' => $request->emergency_name,
            'emergency_phone' => $request->emergency_phone,
            'emergency_relation' => $request->emergency_relation,

            // Alamat Lengkap
            'address' => $request->address,
            'rt_rw' => $request->rt_rw,
            'village' => $request->village,
            'district' => $request->district,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'landmark' => $request->landmark,
            'coordinates' => $request->coordinates,

            // Paket & Status
            'package_id' => $request->package_id,
            'promo_code' => $request->promo_code,
            'preferred_time' => $request->preferred_time,
            'status' => 'prospek', // Default
            'source' => 'Website Register', // Penanda
            
            // Foto
            'ktp_image_path' => $ktpPath,
            'house_image_path' => $housePath,
            'customer_image_path' => $custPath,
        ]);

        return redirect()->route('public.register.success');
    }

    public function success()
    {
        return view('public.success');
    }
}