<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('superadmin.users.index') }}" class="text-red-600 hover:text-red-900">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Edit User</h2>
            </div>

            <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-200 p-6 px-4 sm:px-0">
                <form action="{{ route('superadmin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-600">*</span></label>
                        <input type="text" name="name" value="{{ $user->name }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-600">*</span></label>
                        <input type="email" name="email" value="{{ $user->email }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-600">*</span></label>
                        <select name="role" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst(str_replace('_', ' ', $role)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon</label>
                        <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" @checked($user->is_active) class="rounded">
                            <span class="ml-2 text-sm font-medium text-gray-700">Aktif</span>
                        </label>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Perbarui
                        </button>
                        <a href="{{ route('superadmin.users.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
