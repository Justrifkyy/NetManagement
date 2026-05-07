<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('technician.survey.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Survey
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Input <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Hasil Survey</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Calon Pelanggan: <span class="text-amber-400 font-bold underline decoration-amber-500/30 underline-offset-4">{{ $lead->name }}</span></p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-5 bg-rose-500/10 border border-rose-500/20 rounded-[2rem] flex items-start gap-4 animate-shake">
                    <div class="p-2 bg-rose-500 rounded-xl text-white shadow-[0_0_15px_rgba(225,29,72,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-rose-400 font-black text-xs uppercase tracking-widest mb-2">Terdapat Kesalahan Input:</p>
                        <ul class="list-disc ml-4 text-sm text-rose-300/80 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('technician.survey.store', $lead->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="absolute -right-20 -top-20 w-72 h-72 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="bg-gradient-to-r from-amber-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-amber-500 rounded-2xl shadow-[0_0_20px_rgba(245,158,11,0.3)]">
                            <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Data Teknis Survey</h2>
                    </div>

                    <div class="p-10 space-y-10">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Status Kelayakan <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-5 cursor-pointer bg-slate-800/30 border-2 border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-all duration-300 group overflow-hidden">
                                    <input type="radio" name="survey_status" value="layak" {{ old('survey_status', $survey->survey_status) == 'layak' ? 'checked' : '' }} class="hidden peer">
                                    <div class="absolute inset-0 bg-emerald-500/5 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-emerald-500 transition-colors z-10">
                                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div class="ml-4 z-10">
                                        <span class="block text-slate-200 font-bold group-hover:text-white transition-colors peer-checked:text-emerald-400 uppercase text-xs tracking-widest">Layak Dipasang</span>
                                        <span class="text-[10px] text-slate-500 font-medium peer-checked:text-emerald-500/60 mt-0.5 block">Infrastruktur mencukupi</span>
                                    </div>
                                    <div class="ml-auto opacity-20 peer-checked:opacity-100 transition-opacity z-10">
                                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-5 cursor-pointer bg-slate-800/30 border-2 border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-all duration-300 group overflow-hidden">
                                    <input type="radio" name="survey_status" value="tidak_layak" {{ old('survey_status', $survey->survey_status) == 'tidak_layak' ? 'checked' : '' }} class="hidden peer">
                                    <div class="absolute inset-0 bg-rose-500/5 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-rose-500 transition-colors z-10">
                                        <div class="w-2.5 h-2.5 rounded-full bg-rose-500 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div class="ml-4 z-10">
                                        <span class="block text-slate-200 font-bold group-hover:text-white transition-colors peer-checked:text-rose-400 uppercase text-xs tracking-widest">Tidak Layak</span>
                                        <span class="text-[10px] text-slate-500 font-medium peer-checked:text-rose-500/60 mt-0.5 block">Kendala teknis berat</span>
                                    </div>
                                    <div class="ml-auto opacity-20 peer-checked:opacity-100 transition-opacity z-10">
                                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Waktu Pelaksanaan <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-500 group-focus-within:text-amber-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="date" name="survey_date" value="{{ old('survey_date', $survey->survey_date?->format('Y-m-d')) }}" required
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Dokumentasi Lokasi</label>
                                <div class="relative">
                                    <input type="file" name="location_photo" accept="image/*" class="hidden" id="location_photo_input">
                                    <label for="location_photo_input" class="flex items-center gap-4 px-6 py-3.5 bg-slate-800/50 border border-slate-700 border-dashed rounded-2xl cursor-pointer hover:bg-slate-800 hover:border-amber-500/50 transition-all group">
                                        <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-400 group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="flex-1 overflow-hidden">
                                            <p class="text-sm font-bold text-slate-200 truncate group-hover:text-white transition-colors">Unggah Foto Lokasi</p>
                                            <p class="text-[10px] text-slate-500 font-medium">Maks. 5MB (JPG, PNG)</p>
                                        </div>
                                    </label>
                                    @if($survey->location_photo_path)
                                        <div class="mt-2 px-3 py-1.5 bg-emerald-500/10 border border-emerald-500/20 rounded-lg flex items-center gap-2">
                                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            <span class="text-[10px] text-emerald-400 font-black uppercase tracking-widest">Tersimpan: {{ basename($survey->location_photo_path) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1 flex items-center justify-between">
                                Ringkasan Hasil Survey <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative group">
                                <textarea name="survey_result" rows="4" required
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-[1.5rem] focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all placeholder-slate-600 leading-relaxed"
                                    placeholder="Jelaskan kondisi sinyal, ketersediaan port ODP terdekat, dan estimasi penarikan kabel...">{{ old('survey_result', $survey->survey_result) }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Detail Kendala / Hambatan</label>
                            <div class="relative group">
                                <textarea name="location_challenge" rows="3"
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-[1.5rem] focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all placeholder-slate-600 leading-relaxed"
                                    placeholder="Sebutkan kendala fisik: medan berat, jarak tiang terlalu jauh, perizinan lingkungan, dll (Opsional)">{{ old('location_challenge', $survey->location_challenge) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 px-8 py-4.5 bg-amber-600 text-white font-black rounded-3xl shadow-[0_0_25px_rgba(217,119,6,0.3)] hover:bg-amber-500 hover:shadow-[0_0_35px_rgba(217,119,6,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Hasil Survey
                    </button>
                    <a href="{{ route('technician.survey.index') }}" class="flex-1 px-8 py-4.5 bg-slate-900 text-slate-400 font-bold rounded-3xl border border-slate-800 hover:bg-slate-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-3">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>