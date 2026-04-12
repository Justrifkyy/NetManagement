<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('admin.packages.index') }}" class="text-purple-600 hover:text-purple-900">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Edit Paket</h2>
            </div>

            <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-200 p-6 px-4 sm:px-0">
                <form action="{{ route('admin.packages.update', $package) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Paket <span class="text-red-600">*</span></label>
                        <input type="text" name="name" value="{{ $package->name }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Harga/Bulan <span class="text-red-600">*</span></label>
                            <input type="number" name="price" value="{{ $package->price }}" step="1000" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kec. (Mbps) <span class="text-red-600">*</span></label>
                            <input type="number" name="speed_mbps" value="{{ $package->speed_mbps }}" step="0.1" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Biaya Instalasi <span class="text-red-600">*</span></label>
                        <input type="number" name="installation_fee" value="{{ $package->installation_fee }}" step="1000" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">{{ $package->description }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="is_active" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="1" @selected($package->is_active)>Aktif</option>
                            <option value="0" @selected(!$package->is_active)>Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Simpan
                        </button>
                        <a href="{{ route('admin.packages.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
