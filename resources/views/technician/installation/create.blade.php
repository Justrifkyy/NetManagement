<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 text-center md:text-left">
                <div class="fade-in">
                    <a href="{{ route('technician.installation.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Bursa Instalasi
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Eksekusi <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Instalasi</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Pelanggan: <span class="text-amber-400 font-bold underline decoration-amber-500/30 underline-offset-4">{{ $lead->name }}</span></p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-5 bg-rose-500/10 border border-rose-500/20 rounded-[2rem] flex items-start gap-4">
                    <div class="p-2 bg-rose-500 rounded-xl text-white shadow-[0_0_15px_rgba(225,29,72,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-rose-400 font-black text-xs uppercase tracking-widest mb-2">Kendala Validasi Form:</p>
                        <ul class="list-disc ml-4 text-sm text-rose-300/80 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('technician.installation.store', $lead->id) }}" method="POST" class="space-y-8">
                @csrf

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="absolute -right-20 -top-20 w-72 h-72 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="bg-gradient-to-r from-amber-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-amber-500 rounded-2xl shadow-[0_0_20px_rgba(245,158,11,0.3)] text-slate-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 011-1h1a2 2 0 100-4H7a1 1 0 01-1-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Parameter Instalasi Lapangan</h2>
                    </div>

                    <div class="p-10 space-y-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Tanggal Pengerjaan <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-amber-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="date" name="installation_date" value="{{ old('installation_date', $installation->installation_date?->format('Y-m-d')) }}" required
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Media Transmisi <span class="text-rose-500">*</span></label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-amber-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    <select name="connection_type" required
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all appearance-none cursor-pointer">
                                        <option value="" class="bg-slate-900">-- Pilih Jenis Koneksi --</option>
                                        <option value="fiber" @selected(old('connection_type', $installation->connection_type) == 'fiber') class="bg-slate-900">Kabel Fiber Optic (FTTH)</option>
                                        <option value="wireless" @selected(old('connection_type', $installation->connection_type) == 'wireless') class="bg-slate-900">Point-to-Point Wireless</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Estimasi Panjang Kabel <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-amber-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18h12v2H6v-2zM6 14h12v-2H6v2z"></path></svg>
                                </div>
                                <input type="number" name="cable_length" value="{{ old('cable_length', $installation->cable_length) }}" min="0" required placeholder="Contoh: 50"
                                    class="w-full pl-12 pr-16 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all font-mono font-bold">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-slate-500 font-black text-[10px] uppercase">Meter</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Detail Penempatan Perangkat <span class="text-rose-500">*</span></label>
                            <textarea name="device_placement" rows="3" required
                                class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-[1.5rem] focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all placeholder-slate-600 font-medium"
                                placeholder="Jelaskan secara spesifik posisi Router/ONU (Contoh: Di ruang tengah lantai 1, dekat meja TV)">{{ old('device_placement', $installation->device_placement) }}</textarea>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Status Pekerjaan Akhir <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-5 cursor-pointer bg-slate-800/30 border-2 border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-all duration-300 group overflow-hidden">
                                    <input type="radio" name="installation_status" value="berhasil" {{ old('installation_status', $installation->installation_status) == 'berhasil' ? 'checked' : '' }} class="hidden peer">
                                    <div class="absolute inset-0 bg-emerald-500/5 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-emerald-500 transition-colors z-10">
                                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div class="ml-4 z-10">
                                        <span class="block text-slate-200 font-bold group-hover:text-white transition-colors peer-checked:text-emerald-400 uppercase text-xs tracking-widest">Aktivasi Berhasil</span>
                                    </div>
                                    <div class="ml-auto opacity-20 peer-checked:opacity-100 transition-opacity z-10">
                                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-5 cursor-pointer bg-slate-800/30 border-2 border-slate-700/50 rounded-2xl hover:bg-slate-800 transition-all duration-300 group overflow-hidden">
                                    <input type="radio" name="installation_status" value="gagal" {{ old('installation_status', $installation->installation_status) == 'gagal' ? 'checked' : '' }} class="hidden peer">
                                    <div class="absolute inset-0 bg-rose-500/5 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-rose-500 transition-colors z-10">
                                        <div class="w-2.5 h-2.5 rounded-full bg-rose-500 opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                    </div>
                                    <div class="ml-4 z-10">
                                        <span class="block text-slate-200 font-bold group-hover:text-white transition-colors peer-checked:text-rose-400 uppercase text-xs tracking-widest">Pemasangan Gagal</span>
                                    </div>
                                    <div class="ml-auto opacity-20 peer-checked:opacity-100 transition-opacity z-10">
                                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Catatan Tambahan (Log Lapangan)</label>
                            <textarea name="installation_notes" rows="3"
                                class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-[1.5rem] focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all placeholder-slate-600 font-medium leading-relaxed"
                                placeholder="Tuliskan kendala lapangan atau permintaan khusus pelanggan jika ada">{{ old('installation_notes', $installation->installation_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-[2] px-8 py-5 bg-amber-600 text-white font-black rounded-3xl shadow-[0_0_25px_rgba(217,119,6,0.3)] hover:bg-amber-500 hover:shadow-[0_0_35px_rgba(217,119,6,0.5)] transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg tracking-tight uppercase">
                        Simpan & Konfigurasi Perangkat
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <a href="{{ route('technician.installation.index') }}" class="flex-1 px-8 py-5 bg-slate-900 text-slate-400 font-bold rounded-3xl border border-slate-800 hover:bg-slate-800 hover:text-white transition-all duration-300 flex items-center justify-center gap-3 text-lg">
                        Batal
                    </a>
                </div>

            </form>

            <div class="mt-10 p-6 bg-indigo-500/5 border border-indigo-500/10 rounded-3xl flex items-start gap-4">
                <div class="text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] text-slate-500 leading-relaxed font-black uppercase tracking-[0.2em]">
                    Log Kerja: Data yang disimpan akan diteruskan ke proses pendaftaran perangkat (ONU/Router) ke server OLT. Pastikan panjang kabel diinput secara akurat untuk manajemen inventaris logistik kabel drop-core.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>