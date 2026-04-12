<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Manajemen Akun Staf</h2>
                    <p class="text-gray-500 mt-1">Kelola kredensial dan akses semua pegawai/staf</p>
                </div>
                <a href="{{ route('superadmin.users.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    + Tambah User
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 px-4 sm:px-0 rounded-xl bg-green-50 p-4 border border-green-200">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden px-4 sm:px-0">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                            {{ str_replace('_', ' ', $user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($user->is_active)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex gap-2">
                                            <a href="{{ route('superadmin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form action="{{ route('superadmin.users.resetPassword', $user) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900" onclick="return confirm('Reset password user ini?')">Reset PW</button>
                                            </form>
                                            <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus user ini?')">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada user</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 px-4 sm:px-0">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
