<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Detail Instalasi
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Konfigurasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Akun Internet</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Instalasi: <span class="text-indigo-400 font-bold underline decoration-indigo-500/30 underline-offset-4">{{ $installation->lead->name }}</span></p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-8 p-5 bg-rose-500/10 border border-rose-500/20 rounded-[2rem] flex items-start gap-4 animate-shake">
                    <div class="p-2 bg-rose-500 rounded-xl text-white shadow-[0_0_15px_rgba(225,29,72,0.4)]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-rose-400 font-black text-xs uppercase tracking-widest mb-2">Kendala Validasi Akun:</p>
                        <ul class="list-disc ml-4 text-sm text-rose-300/80 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('technician.internet-account.store', $installation->id) }}" method="POST" class="space-y-8">
                @csrf

                <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                    <div class="absolute -right-20 -top-20 w-72 h-72 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="bg-gradient-to-r from-indigo-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex items-center gap-4">
                        <div class="p-2.5 bg-indigo-500 rounded-2xl shadow-[0_0_20px_rgba(79,70,229,0.3)]">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">Kredensial PPPoE & Layanan</h2>
                    </div>

                    <div class="p-10 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Username PPPoE</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <input type="text" name="pppoe_username" value="{{ old('pppoe_username', $account->pppoe_username) }}" placeholder="Contoh: mgd_customer_01"
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all font-mono text-sm">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Password PPPoE</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                    </div>
                                    <input type="password" name="pppoe_password" value="{{ old('pppoe_password', $account->pppoe_password) }}" placeholder="••••••••"
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all font-mono text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Paket Layanan Langganan <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <input type="text" name="service_package" value="{{ old('service_package', $account->service_package) }}" required placeholder="Contoh: Internet Broadband 30 Mbps"
                                    class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all font-bold">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Status Aktivasi Awal <span class="text-rose-500">*</span></label>
                            <div class="relative group">
                                <select name="initial_service_status" required
                                    class="w-full px-5 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all appearance-none cursor-pointer font-bold">
                                    <option value="aktif" @selected(old('initial_service_status', $account->initial_service_status) == 'aktif') class="bg-slate-900 text-emerald-400">Aktif (Ready to Use)</option>
                                    <option value="tidak_aktif" @selected(old('initial_service_status', $account->initial_service_status) == 'tidak_aktif') class="bg-slate-900 text-slate-400">Tidak Aktif (Pending)</option>
                                    <option value="suspend" @selected(old('initial_service_status', $account->initial_service_status) == 'suspend') class="bg-slate-900 text-rose-400">Suspend (Blokir Akses)</option>
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
                        Simpan & Uji Konektivitas
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
                    Informasi Konfigurasi: Kredensial PPPoE akan digunakan oleh Router/ONU pelanggan untuk melakukan otentikasi ke server Radius MGD. Pastikan penulisan username dan password sesuai dengan data yang terdaftar di sistem penagihan.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>