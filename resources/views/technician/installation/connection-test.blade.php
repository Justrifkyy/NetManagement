<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">⚡ Uji Koneksi</h1>
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

            <form action="{{ route('technician.connection-test.store', $installation->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- UJI KONEKSI DATA -->
                <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 px-6 py-4 flex items-center">
                        <h2 class="text-xl font-bold text-slate-900">DATA UJI KONEKSI</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Status Koneksi -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">Status Koneksi <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="'{{ old('connection_status', $test->connection_status) }}' == 'berhasil' ? 'border-yellow-400 bg-yellow-400/10' : 'border-slate-600 hover:border-slate-500'">
                                    <input type="radio" name="connection_status" value="berhasil" {{ old('connection_status', $test->connection_status) == 'berhasil' ? 'checked' : '' }} class="w-4 h-4 text-yellow-400">
                                    <span class="ml-3 font-semibold text-yellow-300">✅ Berhasil</span>
                                </label>
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="'{{ old('connection_status', $test->connection_status) }}' == 'gagal' ? 'border-red-500 bg-red-500/10' : 'border-slate-600 hover:border-slate-500'">
                                    <input type="radio" name="connection_status" value="gagal" {{ old('connection_status', $test->connection_status) == 'gagal' ? 'checked' : '' }} class="w-4 h-4 text-red-500">
                                    <span class="ml-3 font-semibold text-red-300">❌ Gagal</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Download Speed -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Download Speed (Mbps)</label>
                                <input type="number" name="speed_test_download" value="{{ old('speed_test_download', $test->speed_test_download) }}" step="0.01" min="0"
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: 25.5">
                            </div>

                            <!-- Upload Speed -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Upload Speed (Mbps)</label>
                                <input type="number" name="speed_test_upload" value="{{ old('speed_test_upload', $test->speed_test_upload) }}" step="0.01" min="0"
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: 10.2">
                            </div>

                            <!-- Latency -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Latency (ms)</label>
                                <input type="number" name="latency" value="{{ old('latency', $test->latency) }}" min="0"
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: 25">
                            </div>
                        </div>

                        <!-- Foto Hasil Tes -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">📸 Foto/Screenshot Hasil Tes</label>
                            <div class="relative">
                                <input type="file" name="test_result_photo" accept="image/*" class="hidden" id="test_photo_input">
                                <label for="test_photo_input" class="block w-full p-6 border-2 border-dashed border-yellow-400 rounded-lg cursor-pointer hover:border-yellow-300 transition bg-slate-700/50">
                                    <div class="text-center">
                                        <svg class="w-10 h-10 text-yellow-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-slate-300 font-semibold">Unggah screenshot speed test</p>
                                        <p class="text-slate-400 text-sm mt-1">PNG, JPG atau GIF (Max 5MB)</p>
                                    </div>
                                </label>
                                @if($test->test_result_photo_path)
                                    <div class="mt-3 text-sm text-yellow-300">
                                        ✅ Foto sudah terupload
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col md:flex-row gap-4 px-4 sm:px-0">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-400 text-slate-900 font-bold py-3 rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition shadow-lg">
                        ✓ Simpan & Lanjut ke Serah Terima
                    </button>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="flex-1 bg-slate-700 border border-slate-600 text-yellow-300 font-bold py-3 rounded-lg hover:bg-slate-600 transition text-center">
                        ← Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
