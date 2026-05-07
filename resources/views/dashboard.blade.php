<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight tracking-tight">
            {{ __('Dashboard Utama') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900/80 backdrop-blur-md overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-slate-800 relative group">
                
                <div class="absolute -right-24 -top-24 w-96 h-96 bg-indigo-600/10 rounded-full blur-[100px] pointer-events-none"></div>
                <div class="absolute -left-24 -bottom-24 w-80 h-80 bg-purple-600/10 rounded-full blur-[100px] pointer-events-none"></div>

                <div class="p-10 md:p-16 text-center relative z-10">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-indigo-500/10 border border-indigo-500/20 rounded-full mb-8">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        <span class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em]">Koneksi Terverifikasi</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tighter leading-tight">
                        Selamat Datang di <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">NetManagement</span>
                    </h2>
                    <p class="text-slate-400 text-lg mb-12 max-w-2xl mx-auto font-medium">
                        Ekosistem manajemen jaringan dan layanan pelanggan terpadu untuk efisiensi operasional maksimal.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="group/card bg-slate-800/40 p-8 rounded-[2rem] border border-slate-700/50 hover:border-indigo-500/50 hover:bg-slate-800/60 transition-all duration-500 shadow-xl flex flex-col items-center">
                            <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl flex items-center justify-center mb-6 border border-indigo-500/20 group-hover/card:bg-indigo-500 group-hover/card:text-white transition-all duration-500">
                                <svg class="w-8 h-8 text-indigo-400 group-hover/card:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-black text-lg mb-2 tracking-tight">Panel Kontrol</h3>
                            <p class="text-slate-400 text-sm font-medium leading-relaxed">Akses dashboard analitik dan manajemen sesuai otoritas Anda.</p>
                        </div>

                        <div class="group/card bg-slate-800/40 p-8 rounded-[2rem] border border-slate-700/50 hover:border-purple-500/50 hover:bg-slate-800/60 transition-all duration-500 shadow-xl flex flex-col items-center">
                            <div class="w-16 h-16 bg-purple-500/10 rounded-2xl flex items-center justify-center mb-6 border border-purple-500/20 group-hover/card:bg-purple-500 group-hover/card:text-white transition-all duration-500">
                                <svg class="w-8 h-8 text-purple-400 group-hover/card:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-black text-lg mb-2 tracking-tight">Konfigurasi Profil</h3>
                            <p class="text-slate-400 text-sm font-medium leading-relaxed">Personalisasi data akun, keamanan 2FA, dan preferensi notifikasi.</p>
                        </div>

                        <div class="group/card bg-slate-800/40 p-8 rounded-[2rem] border border-slate-700/50 hover:border-pink-500/50 hover:bg-slate-800/60 transition-all duration-500 shadow-xl flex flex-col items-center">
                            <div class="w-16 h-16 bg-pink-500/10 rounded-2xl flex items-center justify-center mb-6 border border-pink-500/20 group-hover/card:bg-pink-500 group-hover/card:text-white transition-all duration-500">
                                <svg class="w-8 h-8 text-pink-400 group-hover/card:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-black text-lg mb-2 tracking-tight">Bantuan Teknis</h3>
                            <p class="text-slate-400 text-sm font-medium leading-relaxed">Hubungi pusat bantuan atau kirim tiket pengajuan masalah 24/7.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>