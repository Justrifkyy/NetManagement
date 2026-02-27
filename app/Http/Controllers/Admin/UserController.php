<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Tampilkan semua user (Kecuali pelanggan biasa, kita fokus ke pegawai)
        $users = User::where('role', '!=', 'customer')->latest()->get();
        return view('Admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('Admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:super_admin,admin,marketing,technician',
            'marketing_code' => 'nullable|string|unique:users',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'marketing_code' => $request->marketing_code,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('Admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:super_admin,admin,marketing,technician',
            'marketing_code' => ['nullable', 'string', Rule::unique('users')->ignore($user->id)],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'marketing_code' => $request->marketing_code,
            'is_active' => $request->has('is_active'),
        ];

        // Jika password diisi, maka update passwordnya
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
