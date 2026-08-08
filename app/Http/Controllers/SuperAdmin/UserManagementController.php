<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = ['super_admin', 'admin', 'marketing', 'technician', 'customer'];
        return view('superadmin.users.create', compact('roles'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8',
        'role' => 'required|in:super_admin,admin,marketing,technician,customer',
        'phone_number' => 'nullable|string', // Pastikan kolom ini ada di migrasi jika ingin digunakan
        'is_active' => 'required|boolean',
        // Tambahkan validasi untuk area dan kode marketing
        'area_id' => 'nullable|exists:master_areas,id',
        'marketing_code' => 'nullable|string|unique:users', 
    ]);

    $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
    
    User::create($validated);

    return redirect()->route('superadmin.users.index')->with('success', 'Pegawai berhasil ditambahkan');
}

    public function edit(User $user)
    {
        $roles = ['super_admin', 'admin', 'marketing', 'technician', 'customer'];
        return view('superadmin.users.edit', compact('user', 'roles'));
    }

 public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:super_admin,admin,marketing,technician,customer',
        'phone_number' => 'nullable|string',
        'is_active' => 'required|boolean',
        // Tambahkan validasi update
        'area_id' => 'nullable|exists:master_areas,id',
        'marketing_code' => 'nullable|string|unique:users,marketing_code,' . $user->id,
    ]);

    $user->update($validated);

    return redirect()->route('superadmin.users.index')->with('success', 'Pegawai berhasil diperbarui');
}

    public function resetPassword(User $user)
    {
        $newPassword = 'temp' . rand(10000, 99999);
        $user->update(['password' => Hash::make($newPassword)]);

        return redirect()->back()->with('success', "Password reset. Temporary password: $newPassword");
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil dihapus');
    }
}
