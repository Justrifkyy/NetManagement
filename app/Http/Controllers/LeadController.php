<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Customer;
use App\Models\Package; // Jangan lupa import model Package
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LeadController extends Controller
{
    // 1. INDEX: Menampilkan Daftar Prospek
    public function index()
    {
        $user = Auth::user();

        // Admin/SuperAdmin lihat semua, Marketing lihat miliknya sendiri
        if (in_array($user->role, ['admin', 'super_admin'])) {
            $leads = Lead::with('package')->orderBy('created_at', 'desc')->get();
        } else {
            $leads = Lead::with('package')->where('marketing_id', $user->id)->orderBy('created_at', 'desc')->get();
        }

        return view('leads.index', compact('leads'));
    }

    // 2. CREATE: Form Input Baru
    public function create()
    {
        // Kirim data paket ke view untuk dropdown
        $packages = Package::where('is_active', true)->get();
        return view('leads.create', compact('packages'));
    }

    // 3. STORE: Simpan Data Baru
    public function store(Request $request)
    {
        // Validasi Inputan (Sesuai Database Baru)
        $request->validate([
            // Identitas
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'customer_type' => 'required|in:personal,business',
            'package_id' => 'required|exists:packages,id',

            // Alamat Wajib
            'address' => 'required|string',
            'district' => 'required|string', // Kecamatan
            'city' => 'required|string', // Kota/Kab

            // Foto (Opsional tapi disarankan)
            'ktp_image' => 'nullable|image|max:5120', // Max 5MB
            'house_image' => 'nullable|image|max:5120',
            'customer_image' => 'nullable|image|max:5120',
        ]);

        // Proses Upload 3 Foto
        $ktpPath = $request->file('ktp_image') ? $request->file('ktp_image')->store('uploads/ktp', 'public') : null;
        $housePath = $request->file('house_image') ? $request->file('house_image')->store('uploads/house', 'public') : null;
        $custPath = $request->file('customer_image') ? $request->file('customer_image')->store('uploads/customer', 'public') : null;

        // Simpan ke Database
        Lead::create([
            'marketing_id' => Auth::id(),

            // A. Identitas
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'customer_type' => $request->customer_type,
            'business_name' => $request->business_name,

            // B. Kontak Darurat (Baru)
            'emergency_name' => $request->emergency_name,
            'emergency_phone' => $request->emergency_phone,
            'emergency_relation' => $request->emergency_relation,

            // C. Alamat Lengkap
            'address' => $request->address,
            'rt_rw' => $request->rt_rw,
            'village' => $request->village,
            'district' => $request->district,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'landmark' => $request->landmark,
            'coordinates' => $request->coordinates,

            // D. Paket
            'package_id' => $request->package_id,
            'promo_code' => $request->promo_code,

            // E. Status & Jadwal
            'status' => 'prospek', // Default awal
            'source' => $request->source,
            'survey_date' => $request->survey_date,
            'installation_date' => $request->installation_date,
            'preferred_time' => $request->preferred_time,

            // F. Catatan
            'notes_summary' => $request->notes_summary,
            'notes_obstacle' => $request->notes_obstacle,
            'notes_special' => $request->notes_special,

            // G. Foto
            'ktp_image_path' => $ktpPath,
            'house_image_path' => $housePath,
            'customer_image_path' => $custPath,
        ]);

        return redirect()->route('marketing.leads.index')->with('success', 'Prospek berhasil disimpan!');
    }

    // 4. SHOW: Lihat Detail
    public function show(Lead $lead)
    {
        // Cek Hak Akses
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin' && $lead->marketing_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('leads.show', compact('lead'));
    }

    // 5. EDIT: Form Edit
    public function edit(Lead $lead)
    {
        // Cek Hak Akses
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin' && $lead->marketing_id !== Auth::id()) {
            abort(403);
        }

        // Cek Status (Converted = Read Only)
        if ($lead->status === 'converted') {
            return back()->with('error', 'Data yang sudah menjadi pelanggan tidak bisa diedit.');
        }

        $packages = Package::where('is_active', true)->get();
        return view('leads.edit', compact('lead', 'packages'));
    }

    // 6. UPDATE: Simpan Perubahan
    public function update(Request $request, Lead $lead)
    {
        if ($lead->status === 'converted') {
            return back()->with('error', 'Data terkunci (sudah convert).');
        }

        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'package_id' => 'required|exists:packages,id',
            'ktp_image' => 'nullable|image|max:5120',
            'house_image' => 'nullable|image|max:5120',
            'customer_image' => 'nullable|image|max:5120',
        ]);

        // Logika Update Foto (Hapus lama jika ada baru)
        $ktpPath = $lead->ktp_image_path;
        if ($request->hasFile('ktp_image')) {
            if ($ktpPath && Storage::disk('public')->exists($ktpPath)) {
                Storage::disk('public')->delete($ktpPath);
            }
            $ktpPath = $request->file('ktp_image')->store('uploads/ktp', 'public');
        }

        $housePath = $lead->house_image_path;
        if ($request->hasFile('house_image')) {
            if ($housePath && Storage::disk('public')->exists($housePath)) {
                Storage::disk('public')->delete($housePath);
            }
            $housePath = $request->file('house_image')->store('uploads/house', 'public');
        }

        $custPath = $lead->customer_image_path;
        if ($request->hasFile('customer_image')) {
            if ($custPath && Storage::disk('public')->exists($custPath)) {
                Storage::disk('public')->delete($custPath);
            }
            $custPath = $request->file('customer_image')->store('uploads/customer', 'public');
        }

        // Update Data (Mass Assignment tidak aman jika field berubah-ubah, manual lebih aman)
        $lead->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'customer_type' => $request->customer_type,
            'business_name' => $request->business_name,
            'emergency_name' => $request->emergency_name,
            'emergency_phone' => $request->emergency_phone,
            'emergency_relation' => $request->emergency_relation,
            'address' => $request->address,
            'rt_rw' => $request->rt_rw,
            'village' => $request->village,
            'district' => $request->district,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'landmark' => $request->landmark,
            'coordinates' => $request->coordinates,
            'package_id' => $request->package_id,
            'promo_code' => $request->promo_code,
            'source' => $request->source,
            'survey_date' => $request->survey_date,
            'installation_date' => $request->installation_date,
            'preferred_time' => $request->preferred_time,
            'notes_summary' => $request->notes_summary,
            'notes_obstacle' => $request->notes_obstacle,
            'notes_special' => $request->notes_special,
            'ktp_image_path' => $ktpPath,
            'house_image_path' => $housePath,
            'customer_image_path' => $custPath,
        ]);

        return redirect()->route('marketing.leads.index')->with('success', 'Data berhasil diperbarui.');
    }

    // 7. DESTROY: Hapus Data
    public function destroy(Lead $lead)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin' && $lead->marketing_id !== Auth::id()) {
            abort(403);
        }

        // Hapus Semua Foto
        if ($lead->ktp_image_path && Storage::disk('public')->exists($lead->ktp_image_path)) {
            Storage::disk('public')->delete($lead->ktp_image_path);
        }
        if ($lead->house_image_path && Storage::disk('public')->exists($lead->house_image_path)) {
            Storage::disk('public')->delete($lead->house_image_path);
        }
        if ($lead->customer_image_path && Storage::disk('public')->exists($lead->customer_image_path)) {
            Storage::disk('public')->delete($lead->customer_image_path);
        }

        $lead->delete();
        return redirect()->route('marketing.leads.index')->with('success', 'Data prospek dihapus permanen.');
    }

    // 8. CONVERT: Jadi Pelanggan & Buat Tiket
    public function convertToCustomer(Request $request, Lead $lead)
    {
        if ($lead->status === 'converted') {
            return back()->with('error', 'Sudah menjadi pelanggan.');
        }

        DB::transaction(function () use ($lead) {
            // A. Buat Akun Login User
            $uniqueId = 'CUST-' . strtoupper(Str::random(5)); // Kode Pelanggan Unik
            $password = Str::random(8); // Password sementara

            $user = User::create([
                'name' => $lead->name,
                'email' => $lead->email ?? strtolower(str_replace(' ', '', $lead->name)) . rand(100, 999) . '@net.local',
                'password' => Hash::make($password),
                'role' => 'customer',
                'is_active' => true,
            ]);

            // B. Buat Data Customer (Arsip Tetap)
            $customer = Customer::create([
                'user_id' => $user->id,
                'lead_id' => $lead->id,
                'customer_code' => $uniqueId,
                'phone_number' => $lead->phone,
                'address_installation' => $lead->address, // Alamat lengkap dari Lead
                'coordinates' => $lead->coordinates,
                // Data teknis (PPPoE dll) nanti diisi Admin/Teknisi
            ]);

            // C. Update Status Lead
            $lead->update(['status' => 'converted']);

            // D. Buat Tiket Instalasi (Work Order)
            Ticket::create([
                'customer_id' => $customer->id,
                'technician_id' => null, // Belum ada teknisi (Open)
                'type' => 'installation', // Tipe Instalasi Baru
                'subject' => 'Pasang Baru: ' . $lead->package->name, // Judul Tiket
                'status' => 'open',
                // Data teknis detail akan diisi teknisi di lapangan nanti (via form teknisi)
            ]);

            // Simpan info kredensial sementara ke session untuk ditampilkan sekali
            session()->flash('generated_credential', [
                'username' => $user->email,
                'password' => $password,
                'code' => $uniqueId,
            ]);
        });

        return redirect()->route('marketing.leads.index')->with('success', 'Konversi Berhasil! Akun & Tiket Instalasi telah dibuat.');
    }
}
