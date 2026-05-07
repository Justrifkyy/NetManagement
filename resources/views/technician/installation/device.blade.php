<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Detail Instalasi
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Registrasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Perangkat</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Instalasi: <span class="text-amber-400 font-bold underline decoration-amber-500/30 underline-offset-4">{{ $installation->lead->name }}</span></p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-5 bg-rose-500/10 border border-rose-500/20 rounded-[2rem] flex items-start gap-4 animate-shake">
                    <div class="p-2 bg-rose-500 rounded-xl text-white shadow-[0_0_15px_rgba(225,29,72,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-rose-400 font-black text-xs uppercase tracking-widest mb-2">Kendala Validasi Hardware:</p>
                        <ul class="list-disc ml-4 text-sm text-rose-300/80 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('technician.device.store', $installation->id) }}" method="POST" class="space-y-8">
                @csrf

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="absolute -right-20 -top-20 w-72 h-72 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="bg-gradient-to-r from-indigo-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-indigo-500 rounded-2xl shadow-[0_0_20px_rgba(79,70,229,0.3)]">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Spesifikasi Hardware Pelanggan</h2>
                    </div>

                    <div class="p-10 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Kategori Unit <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <input type="text" name="device_type" value="{{ old('device_type', $device->device_type) }}" required placeholder="Contoh: Router / ONU / OTB"
                                        class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-600 font-bold">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Vendor / Brand <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <input type="text" name="device_brand" value="{{ old('device_brand', $device->device_brand) }}" required placeholder="Contoh: Huawei / Mikrotik / ZTE"
                                        class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-600 font-bold">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Serial Number (SN) <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                    </div>
                                    <input type="text" name="serial_number" value="{{ old('serial_number', $device->serial_number) }}" required placeholder="Masukkan SN Perangkat"
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all font-mono text-sm tracking-widest uppercase">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">MAC Address <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="text" name="mac_address" value="{{ old('mac_address', $device->mac_address) }}" required placeholder="FF:FF:FF:FF:FF:FF"
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all font-mono text-sm tracking-widest uppercase">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Kondisi Fisik & Fungsi <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <select name="device_condition" required
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all appearance-none cursor-pointer font-bold">
                                    <option value="" class="bg-slate-900">-- Pilih Kondisi Perangkat --</option>
                                    <option value="baru" @selected(old('device_condition', $device->device_condition) == 'baru') class="bg-slate-900 text-emerald-400">Unit Baru (Box/Segel)</option>
                                    <option value="baik" @selected(old('device_condition', $device->device_condition) == 'baik') class="bg-slate-900 text-indigo-400">Unit Normal (Bekas Layak)</option>
                                    <option value="rusak_ringan" @selected(old('device_condition', $device->device_condition) == 'rusak_ringan') class="bg-slate-900 text-amber-400">Rusak Ringan (Lecet/Fisik)</option>
                                    <option value="rusak_berat" @selected(old('device_condition', $device->device_condition) == 'rusak_berat') class="bg-slate-900 text-rose-400">Rusak Berat (Gagal Fungsi)</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-[2] px-8 py-5 bg-amber-600 text-white font-black rounded-3xl shadow-[0_0_25px_rgba(217,119,6,0.3)] hover:bg-amber-500 hover:shadow-[0_0_35px_rgba(217,119,6,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg tracking-tight uppercase">
                        Simpan & Konfigurasi Jaringan
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="flex-1 px-8 py-5 bg-slate-900 text-slate-400 font-bold rounded-3xl border border-slate-800 hover:bg-slate-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-3 text-lg text-center leading-none">
                        Batal
                    </a>
                </div>

            </form>

            <div class="mt-10 p-6 bg-indigo-500/5 border border-indigo-500/10 rounded-3xl flex items-start gap-4">
                <div class="text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] text-slate-500 leading-relaxed font-black uppercase tracking-[0.2em]">
                    Verifikasi Perangkat: Pastikan SN dan MAC Address diinput sesuai dengan label fisik yang tertera pada perangkat untuk menghindari kegagalan otentikasi pada OLT/Server Jaringan.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>