<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">🔨 Form Instalasi</h1>
                        <p class="text-slate-400 mt-1">Calon Pelanggan: <span class="text-yellow-300 font-semibold">{{ $lead->name }}</span></p>
                    </div>
                    <a href="{{ route('technician.installation.index') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
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
            <form action="{{ route('technician.installation.store', $lead->id) }}" method="POST" class="space-y-6">
                @csrf

                <!-- DATA INSTALASI -->
                <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 px-6 py-4 flex items-center">
                        <h2 class="text-xl font-bold text-slate-900">DATA INSTALASI</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal Instalasi -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Tanggal Instalasi <span class="text-red-500">*</span></label>
                                <input type="date" name="installation_date" value="{{ old('installation_date', $installation->installation_date?->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                            </div>

                            <!-- Jenis Koneksi -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Jenis Koneksi <span class="text-red-500">*</span></label>
                                <select name="connection_type" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                    <option value="">-- Pilih --</option>
                                    <option value="fiber" @selected(old('connection_type', $installation->connection_type) == 'fiber')>🔌 Fiber</option>
                                    <option value="wireless" @selected(old('connection_type', $installation->connection_type) == 'wireless')>📡 Wireless</option>
                                </select>
                            </div>
                        </div>

                        <!-- Panjang Kabel -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">Panjang Kabel (meter) <span class="text-red-500">*</span></label>
                            <input type="number" name="cable_length" value="{{ old('cable_length', $installation->cable_length) }}" min="0" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Contoh: 50">
                        </div>

                        <!-- Posisi Pemasangan Perangkat -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">Posisi Pemasangan Perangkat <span class="text-red-500">*</span></label>
                            <textarea name="device_placement" rows="3" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Deskripsi posisi pemasangan: Di kamar, di ruang tamu, di garasi, dll">{{ old('device_placement', $installation->device_placement) }}</textarea>
                        </div>

                        <!-- Status Instalasi -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">Status Instalasi <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="'{{ old('installation_status', $installation->installation_status) }}' == 'berhasil' ? 'border-yellow-400 bg-yellow-400/10' : 'border-slate-600 hover:border-slate-500'">
                                    <input type="radio" name="installation_status" value="berhasil" {{ old('installation_status', $installation->installation_status) == 'berhasil' ? 'checked' : '' }} class="w-4 h-4 text-yellow-400">
                                    <span class="ml-3 font-semibold text-yellow-300">✅ Berhasil</span>
                                </label>
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="'{{ old('installation_status', $installation->installation_status) }}' == 'gagal' ? 'border-red-500 bg-red-500/10' : 'border-slate-600 hover:border-slate-500'">
                                    <input type="radio" name="installation_status" value="gagal" {{ old('installation_status', $installation->installation_status) == 'gagal' ? 'checked' : '' }} class="w-4 h-4 text-red-500">
                                    <span class="ml-3 font-semibold text-red-300">❌ Gagal</span>
                                </label>
                            </div>
                        </div>

                        <!-- Catatan Instalasi -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">📝 Catatan Instalasi</label>
                            <textarea name="installation_notes" rows="3"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Catatan penting tentang proses instalasi, kendala yang ditemui, dll">{{ old('installation_notes', $installation->installation_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col md:flex-row gap-4 px-4 sm:px-0">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-400 text-slate-900 font-bold py-3 rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition shadow-lg">
                        ✓ Simpan & Lanjut ke Perangkat
                    </button>
                    <a href="{{ route('technician.installation.index') }}" class="flex-1 bg-slate-700 border border-slate-600 text-yellow-300 font-bold py-3 rounded-lg hover:bg-slate-600 transition text-center">
                        ← Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
