<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <a href="{{ route('technician.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Dashboard
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Profil <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Teknisi</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Informasi kredensial dan identitas operasional Anda.</p>
                </div>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                <div class="absolute -right-20 -top-20 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="p-8 md:p-12 relative z-10">
                    <div class="flex flex-col md:flex-row items-center gap-8 mb-12 border-b border-slate-800/60 pb-10">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                            <div class="relative w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center border-4 border-slate-900 shadow-xl">
                                <svg class="w-12 h-12 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div class="absolute bottom-1 right-1 w-6 h-6 bg-emerald-500 border-4 border-slate-900 rounded-full shadow-lg"></div>
                        </div>

                        <div class="text-center md:text-left">
                            <h3 class="text-3xl font-black text-white tracking-tight mb-1">{{ auth()->user()->name }}</h3>
                            <div class="flex flex-wrap justify-center md:justify-start gap-3 mt-3">
                                <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-lg text-indigo-400 text-[10px] font-black uppercase tracking-widest">
                                    {{ auth()->user()->role }}
                                </span>
                                <span class="px-3 py-1 bg-slate-800 border border-slate-700 rounded-lg text-slate-400 text-[10px] font-black uppercase tracking-widest">
                                    ID: {{ auth()->user()->technician_code ?? 'MGD-OFFLINE' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-10 gap-x-12">
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Nama Lengkap</label>
                            <div class="bg-slate-800/30 border border-slate-700/50 p-4 rounded-2xl">
                                <p class="text-white font-bold">{{ auth()->user()->name }}</p>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Alamat Email</label>
                            <div class="bg-slate-800/30 border border-slate-700/50 p-4 rounded-2xl">
                                <p class="text-white font-bold">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Otoritas Sistem</label>
                            <div class="bg-slate-800/30 border border-slate-700/50 p-4 rounded-2xl flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                <p class="text-white font-bold">{{ ucfirst(auth()->user()->role) }}</p>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Verifikasi Karyawan</label>
                            <div class="bg-slate-800/30 border border-slate-700/50 p-4 rounded-2xl flex items-center gap-3">
                                <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <p class="text-white font-bold">Terverifikasi</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-16 pt-8 border-t border-slate-800/60 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-4 text-slate-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <p class="text-xs font-medium">Terakhir diperbarui: {{ auth()->user()->updated_at->format('d M Y') }}</p>
                        </div>
                        <a href="{{ route('technician.password') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:bg-indigo-500 hover:shadow-[0_0_30px_rgba(79,70,229,0.5)] transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            Ganti Password
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-10 p-6 bg-amber-500/5 border border-amber-500/10 rounded-3xl flex items-start gap-4">
                <div class="text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed font-medium">
                    <strong class="text-amber-400/80">Informasi Keamanan:</strong> Jangan memberikan kredensial login atau kode teknisi Anda kepada pihak ketiga. Segala aktivitas yang dilakukan menggunakan akun ini menjadi tanggung jawab pemilik akun sepenuhnya sesuai dengan kebijakan PT. Mandiri Global Data.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>