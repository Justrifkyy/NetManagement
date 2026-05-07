<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Detail Instalasi
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Uji <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Konektivitas</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Instalasi: <span class="text-amber-400 font-bold underline decoration-amber-500/30 underline-offset-4">{{ $installation->lead->name }}</span></p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-5 bg-rose-500/10 border border-rose-500/20 rounded-[2rem] flex items-start gap-4">
                    <div class="p-2 bg-rose-500 rounded-xl text-white shadow-[0_0_15px_rgba(225,29,72,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-rose-400 font-black text-xs uppercase tracking-widest mb-2">Kesalahan Input Data:</p>
                        <ul class="list-disc ml-4 text-sm text-rose-300/80 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('technician.connection-test.store', $installation->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="absolute -right-20 -top-20 w-72 h-72 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="bg-gradient-to-r from-amber-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-amber-500 rounded-2xl shadow-[0_0_20px_rgba(245,158,11,0.3)]">
                            <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Parameter Kecepatan & Latency</h2>
                    </div>

                    <div class="p-10 space-y-10">
                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Hasil Akhir Pengujian <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-5 cursor-pointer bg-slate-800/30 border-2 border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-all duration-300 group overflow-hidden">
                                    <input type="radio" name="connection_status" value="berhasil" {{ old('connection_status', $test->connection_status) == 'berhasil' ? 'checked' : '' }} class="hidden peer">
                                    <div class="absolute inset-0 bg-emerald-500/5 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-emerald-500 transition-colors z-10">
                                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div class="ml-4 z-10">
                                        <span class="block text-slate-200 font-bold group-hover:text-white transition-colors peer-checked:text-emerald-400 uppercase text-xs tracking-widest">Berhasil (Online)</span>
                                    </div>
                                    <div class="ml-auto opacity-20 peer-checked:opacity-100 transition-opacity z-10">
                                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-5 cursor-pointer bg-slate-800/30 border-2 border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-all duration-300 group overflow-hidden">
                                    <input type="radio" name="connection_status" value="gagal" {{ old('connection_status', $test->connection_status) == 'gagal' ? 'checked' : '' }} class="hidden peer">
                                    <div class="absolute inset-0 bg-rose-500/5 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-rose-500 transition-colors z-10">
                                        <div class="w-2.5 h-2.5 rounded-full bg-rose-500 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div class="ml-4 z-10">
                                        <span class="block text-slate-200 font-bold group-hover:text-white transition-colors peer-checked:text-rose-400 uppercase text-xs tracking-widest">Gagal (Offline)</span>
                                    </div>
                                    <div class="ml-auto opacity-20 peer-checked:opacity-100 transition-opacity z-10">
                                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Download (Mbps)</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                    </div>
                                    <input type="number" name="speed_test_download" value="{{ old('speed_test_download', $test->speed_test_download) }}" step="0.01" min="0" placeholder="0.00"
                                        class="w-full pl-10 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all font-mono font-bold text-lg">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Upload (Mbps)</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    </div>
                                    <input type="number" name="speed_test_upload" value="{{ old('speed_test_upload', $test->speed_test_upload) }}" step="0.01" min="0" placeholder="0.00"
                                        class="w-full pl-10 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all font-mono font-bold text-lg">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Latency (ms)</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <input type="number" name="latency" value="{{ old('latency', $test->latency) }}" min="0" placeholder="0"
                                        class="w-full pl-10 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all font-mono font-bold text-lg">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Bukti Validasi Kecepatan</label>
                            <div class="relative">
                                <input type="file" name="test_result_photo" accept="image/*" class="hidden" id="test_photo_input">
                                <label for="test_photo_input" class="flex flex-col items-center justify-center w-full p-10 border-2 border-dashed border-slate-700 bg-slate-800/30 rounded-[2rem] cursor-pointer hover:border-amber-500/50 hover:bg-slate-800 transition-all duration-300 group">
                                    <div class="w-16 h-16 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-400 mb-4 group-hover:scale-110 transition-transform">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-200 group-hover:text-white transition-colors">Lampirkan Screenshot Speedtest</p>
                                    <p class="text-xs text-slate-500 mt-2">Maksimal 5MB (Format: JPG, PNG, GIF)</p>
                                </label>
                                @if($test->test_result_photo_path)
                                    <div class="mt-4 px-4 py-2 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-2">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="text-xs font-black text-emerald-400 uppercase tracking-widest">Berkas Berhasil Terunggah</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-[2] px-8 py-5 bg-amber-600 text-white font-black rounded-3xl shadow-[0_0_25px_rgba(217,119,6,0.3)] hover:bg-amber-500 hover:shadow-[0_0_35px_rgba(217,119,6,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg tracking-tight uppercase">
                        Simpan & Finalisasi Laporan
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="flex-1 px-8 py-5 bg-slate-900 text-slate-400 font-bold rounded-3xl border border-slate-800 hover:bg-slate-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-3 text-lg">
                        Batal
                    </a>
                </div>

            </form>

            <div class="mt-10 p-6 bg-indigo-500/5 border border-indigo-500/10 rounded-3xl flex items-start gap-4">
                <div class="text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] text-slate-500 leading-relaxed font-black uppercase tracking-[0.2em]">
                    Catatan Teknisi: Pastikan pengujian dilakukan menggunakan kabel LAN langsung dari Router/ONU pelanggan ke perangkat test untuk hasil yang lebih akurat. Data ini akan menjadi acuan kualitas layanan (SLA) bagi pelanggan.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>