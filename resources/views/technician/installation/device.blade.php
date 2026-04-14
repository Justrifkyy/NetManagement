<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">🖥️ Data Perangkat</h1>
                        <p class="text-slate-400 mt-1">Instalasi: <span class="text-yellow-300 font-semibold">{{ $installation->lead->name }}</span></p>
                    </div>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 mx-4 sm:mx-0 bg-red-900/50 border-l-4 border-red-500 text-red-300 p-4 rounded-r">
                    <p class="font-bold mb-2">⚠️ Terdapat kesalahan:</p>
                    <ul class="list-disc ml-6 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('technician.device.store', $installation->id) }}" method="POST" class="space-y-6">
                @csrf

                <!-- DATA PERANGKAT -->
                <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 px-6 py-4 flex items-center">
                        <h2 class="text-xl font-bold text-slate-900">DATA PERANGKAT PELANGGAN</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Jenis Perangkat -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Jenis Perangkat <span class="text-red-500">*</span></label>
                                <input type="text" name="device_type" value="{{ old('device_type', $device->device_type) }}" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Router, ONU, Converter, dll">
                            </div>

                            <!-- Merk Perangkat -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Merk Perangkat <span class="text-red-500">*</span></label>
                                <input type="text" name="device_brand" value="{{ old('device_brand', $device->device_brand) }}" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: TP-Link, Mikrotik, Huawei, dll">
                            </div>

                            <!-- Serial Number -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Nomor Seri <span class="text-red-500">*</span></label>
                                <input type="text" name="serial_number" value="{{ old('serial_number', $device->serial_number) }}" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="SN atau Serial Number perangkat">
                            </div>

                            <!-- MAC Address -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">MAC Address <span class="text-red-500">*</span></label>
                                <input type="text" name="mac_address" value="{{ old('mac_address', $device->mac_address) }}" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: 00:1A:2B:3C:4D:5E">
                            </div>
                        </div>

                        <!-- Kondisi Perangkat -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">Kondisi Perangkat <span class="text-red-500">*</span></label>
                            <select name="device_condition" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="baru" @selected(old('device_condition', $device->device_condition) == 'baru')>✨ Baru</option>
                                <option value="baik" @selected(old('device_condition', $device->device_condition) == 'baik')>✅ Baik</option>
                                <option value="rusak_ringan" @selected(old('device_condition', $device->device_condition) == 'rusak_ringan')>⚠️ Rusak Ringan</option>
                                <option value="rusak_berat" @selected(old('device_condition', $device->device_condition) == 'rusak_berat')>❌ Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col md:flex-row gap-4 px-4 sm:px-0">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-400 text-slate-900 font-bold py-3 rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition shadow-lg">
                        ✓ Simpan & Lanjut ke Jaringan
                    </button>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="flex-1 bg-slate-700 border border-slate-600 text-yellow-300 font-bold py-3 rounded-lg hover:bg-slate-600 transition text-center">
                        ← Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
