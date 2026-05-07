<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <a href="{{ route('technician.profile') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-white transition-colors mb-4 group">
                    <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Profil
                </a>
                <h2 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight">Keamanan Akses</h2>
                <p class="text-slate-400 mt-2 font-medium">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan akun teknisi.</p>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="p-8 md:p-12 relative z-10">
                    <form method="POST" action="#" class="space-y-8">
                        @csrf

                        <div class="space-y-2">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Password Saat Ini</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-500 group-focus-within:text-amber-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <input type="password" name="current_password" required placeholder="Masukkan password lama"
                                    class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500 transition-all placeholder-slate-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Password Baru</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-500 group-focus-within:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                    </div>
                                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all placeholder-slate-600">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Konfirmasi Password</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-500 group-focus-within:text-emerald-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <input type="password" name="password_confirmation" required placeholder="Ulangi password baru"
                                        class="w-full pl-12 pr-4 py-4 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder-slate-600">
                                </div>
                            </div>
                        </div>

                        <div class="bg-indigo-500/5 border border-indigo-500/20 rounded-2xl p-4 flex items-start gap-4">
                            <div class="mt-0.5 text-indigo-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">
                                Gunakan kombinasi huruf kapital, angka, dan simbol untuk keamanan maksimal. Jangan bagikan kata sandi Anda kepada siapapun termasuk staf administrasi.
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-4 pt-4 border-t border-slate-800/60">
                            <button type="submit" class="w-full sm:w-auto px-10 py-4 bg-amber-600 text-white font-black rounded-2xl shadow-[0_0_20px_rgba(217,119,6,0.3)] hover:bg-amber-500 hover:shadow-[0_0_30px_rgba(217,119,6,0.5)] transition-all duration-300 transform hover:-translate-y-1">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('technician.profile') }}" class="w-full sm:w-auto px-10 py-4 bg-slate-800 text-slate-400 font-bold rounded-2xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center text-slate-600 text-[10px] font-black uppercase tracking-[0.3em] mt-10">
                NetManagement Secure Authentication System
            </p>

        </div>
    </div>
</x-app-layout>