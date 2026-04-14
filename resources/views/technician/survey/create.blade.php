<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">🔍 Form Hasil Survey</h1>
                        <p class="text-slate-400 mt-1">Calon Pelanggan: <span class="text-yellow-300 font-semibold">{{ $lead->name }}</span></p>
                    </div>
                    <a href="{{ route('technician.survey.index') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
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
            <form action="{{ route('technician.survey.store', $lead->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- DATA SURVEY -->
                <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 px-6 py-4 flex items-center">
                        <div class="flex items-center justify-center w-10 h-10 bg-slate-800/30 rounded-full mr-3">
                            <svg class="w-6 h-6 text-slate-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900">DATA SURVEY</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Status Survey -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">Status Survey <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition" 
                                    :class="'{{ old('survey_status', $survey->survey_status) }}' == 'layak' ? 'border-yellow-400 bg-yellow-400/10' : 'border-slate-600 hover:border-slate-500'">
                                    <input type="radio" name="survey_status" value="layak" {{ old('survey_status', $survey->survey_status) == 'layak' ? 'checked' : '' }} class="w-4 h-4 text-yellow-400">
                                    <span class="ml-3 font-semibold text-yellow-300">✅ Layak Dipasang</span>
                                </label>
                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="'{{ old('survey_status', $survey->survey_status) }}' == 'tidak_layak' ? 'border-red-500 bg-red-500/10' : 'border-slate-600 hover:border-slate-500'">
                                    <input type="radio" name="survey_status" value="tidak_layak" {{ old('survey_status', $survey->survey_status) == 'tidak_layak' ? 'checked' : '' }} class="w-4 h-4 text-red-500">
                                    <span class="ml-3 font-semibold text-red-300">❌ Tidak Layak</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tanggal Survey -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">Tanggal Survey <span class="text-red-500">*</span></label>
                            <input type="date" name="survey_date" value="{{ old('survey_date', $survey->survey_date?->format('Y-m-d')) }}" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>

                        <!-- Hasil Survey -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">📝 Hasil Survey Singkat <span class="text-red-500">*</span></label>
                            <textarea name="survey_result" rows="4" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Ringkas hasil survey: Kondisi lokasi, signal strength, infrastruktur yang dibutuhkan, dll">{{ old('survey_result', $survey->survey_result) }}</textarea>
                        </div>

                        <!-- Kendala Lokasi -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">⚠️ Kendala / Hambatan Lokasi</label>
                            <textarea name="location_challenge" rows="3"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Kendala teknis: Medan sulit, bangunan tinggi, interferensi, jarak jauh, dll">{{ old('location_challenge', $survey->location_challenge) }}</textarea>
                        </div>

                        <!-- Foto Lokasi -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">📸 Foto Lokasi</label>
                            <div class="relative">
                                <input type="file" name="location_photo" accept="image/*"
                                    class="hidden" id="location_photo_input">
                                <label for="location_photo_input" class="block w-full p-6 border-2 border-dashed border-yellow-400 rounded-lg cursor-pointer hover:border-yellow-300 transition bg-slate-700/50">
                                    <div class="text-center">
                                        <svg class="w-10 h-10 text-yellow-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-slate-300 font-semibold">Pilih atau drag foto lokasi di sini</p>
                                        <p class="text-slate-400 text-sm mt-1">PNG, JPG atau GIF (Max 5MB)</p>
                                    </div>
                                </label>
                                @if($survey->location_photo_path)
                                    <div class="mt-3 text-sm text-yellow-300">
                                        ✅ Foto sudah terupload: <span class="font-semibold">{{ basename($survey->location_photo_path) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col md:flex-row gap-4 px-4 sm:px-0">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-400 text-slate-900 font-bold py-3 rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition shadow-lg">
                        ✓ Simpan Survey
                    </button>
                    <a href="{{ route('technician.survey.index') }}" class="flex-1 bg-slate-700 border border-slate-600 text-yellow-300 font-bold py-3 rounded-lg hover:bg-slate-600 transition text-center">
                        ← Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
