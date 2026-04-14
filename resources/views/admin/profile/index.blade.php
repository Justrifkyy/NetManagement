<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('admin.profile.index') }}" class="text-purple-600 hover:text-purple-900">Kembali</a>
                <h2 class="text-3xl font-extrabold text-white mt-2">Profil Saya</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                <!-- Profile Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6">
                        <h3 class="text-xl font-bold text-white mb-6">Informasi Profil</h3>

                        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Nama <span class="text-red-600">*</span></label>
                                <input type="text" name="name" value="{{ $user->name }}" required
                                    class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Email <span class="text-red-600">*</span></label>
                                <input type="email" name="email" value="{{ $user->email }}" required
                                    class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">No. Telepon</label>
                                <input type="text" name="phone_number" value="{{ $user->phone_number ?? '' }}"
                                    class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                Perbarui Profil
                            </button>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6">
                        <h3 class="text-xl font-bold text-white mb-6">Ubah Password</h3>

                        <form action="{{ route('admin.profile.updatePassword') }}" method="POST" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Password Lama <span class="text-red-600">*</span></label>
                                <input type="password" name="current_password" required
                                    class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                @error('current_password')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Password Baru <span class="text-red-600">*</span></label>
                                <input type="password" name="new_password" required
                                    class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password <span class="text-red-600">*</span></label>
                                <input type="password" name="new_password_confirmation" required
                                    class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>

                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Ubah Password
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Informasi Akun</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-medium text-slate-300 uppercase">Role</label>
                            <p class="text-white font-semibold mt-1 capitalize">{{ str_replace('_', ' ', $user->role) }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-slate-300 uppercase">Status</label>
                            <p class="mt-1">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Nonaktif
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-slate-300 uppercase">Bergabung Sejak</label>
                            <p class="text-white mt-1">{{ $user->created_at->format('d M Y') }}</p>
                        </div>

                        <div>
                            <label class="text-xs font-medium text-slate-300 uppercase">Update Terakhir</label>
                            <p class="text-white mt-1">{{ $user->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
