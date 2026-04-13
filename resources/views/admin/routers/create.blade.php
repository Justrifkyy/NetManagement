<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('admin.routers.index') }}" class="text-purple-600 hover:text-purple-900">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-white mt-2">Tambah Perangkat Jaringan</h2>
            </div>

            <div class="max-w-2xl bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 px-4 sm:px-0">
                <form action="{{ route('admin.routers.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Perangkat <span class="text-red-600">*</span></label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Lokasi <span class="text-red-600">*</span></label>
                        <input type="text" name="location" required
                            class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">IP Address <span class="text-red-600">*</span></label>
                        <input type="text" name="ip_address" placeholder="192.168.1.1" required
                            class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Brand <span class="text-red-600">*</span></label>
                            <input type="text" name="brand" required
                                class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Tipe <span class="text-red-600">*</span></label>
                            <select name="type" required
                                class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Pilih Tipe</option>
                                <option value="OLT">OLT</option>
                                <option value="Router">Router</option>
                                <option value="AP">AP (Access Point)</option>
                                <option value="ODP">ODP</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                        <select name="is_active" required
                            class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Simpan
                        </button>
                        <a href="{{ route('admin.routers.index') }}" class="px-6 py-2 border border-slate-700 rounded-lg hover:bg-slate-950">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
