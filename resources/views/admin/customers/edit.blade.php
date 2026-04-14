<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('admin.customers.index') }}" class="text-purple-600 hover:text-purple-900">Kembali</a>
                <h2 class="text-3xl font-extrabold text-white mt-2">Edit Data Pelanggan</h2>
            </div>

            <div class="max-w-2xl bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 px-4 sm:px-0">
                <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Pelanggan</label>
                        <input type="text" value="{{ $customer->user->name }}" disabled
                            class="w-full px-4 py-2 border border-slate-700 rounded-lg bg-slate-950">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">No. HP <span class="text-red-600">*</span></label>
                        <input type="text" name="phone_number" value="{{ $customer->phone_number }}" required
                            class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('phone_number')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Alamat Instalasi <span class="text-red-600">*</span></label>
                        <textarea name="address_installation" required rows="4"
                            class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">{{ $customer->address_installation }}</textarea>
                        @error('address_installation')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Koordinat</label>
                        <input type="text" name="coordinates" placeholder="-6.1234, 106.5678" value="{{ $customer->coordinates }}"
                            class="w-full px-4 py-2 border border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Simpan
                        </button>
                        <a href="{{ route('admin.customers.index') }}" class="px-6 py-2 border border-slate-700 rounded-lg hover:bg-slate-950">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
