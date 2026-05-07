<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-amber-500/10 rounded-lg border border-amber-500/20">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em]">Operations Center</span>
                    </div>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Dashboard <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Teknisi</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Manajemen infrastruktur, instalasi, dan pemeliharaan jaringan.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-[2rem] p-7 group hover:border-amber-500/50 transition-all duration-500 shadow-xl overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-all"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-500/10 rounded-2xl border border-amber-500/20 text-amber-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <a href="{{ route('technician.installation.index') }}" class="text-[10px] font-black text-slate-500 hover:text-amber-400 uppercase tracking-widest transition-colors">Detail &rarr;</a>
                    </div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-[0.1em]">Tugas Hari Ini</p>
                    <h3 class="text-5xl font-black text-white tracking-tighter mt-1">{{ $today_tasks }}</h3>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-[2rem] p-7 group hover:border-amber-500/50 transition-all duration-500 shadow-xl overflow-hidden relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-500/10 rounded-2xl border border-amber-500/20 text-amber-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <a href="{{ route('technician.installation.index') }}" class="text-[10px] font-black text-slate-500 hover:text-amber-400 uppercase tracking-widest transition-colors">Detail &rarr;</a>
                    </div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-[0.1em]">Instalasi Pending</p>
                    <h3 class="text-5xl font-black text-white tracking-tighter mt-1">{{ $pending_installations }}</h3>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-[2rem] p-7 group hover:border-rose-500/50 transition-all duration-500 shadow-xl overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-rose-500/5 rounded-full blur-3xl group-hover:bg-rose-500/10 transition-all"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-rose-500/10 rounded-2xl border border-rose-500/20 text-rose-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <a href="{{ route('technician.ticket.index') }}" class="text-[10px] font-black text-slate-500 hover:text-rose-400 uppercase tracking-widest transition-colors">Detail &rarr;</a>
                    </div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-[0.1em]">Tiket Gangguan</p>
                    <h3 class="text-5xl font-black text-rose-500 tracking-tighter mt-1">{{ $trouble_tickets }}</h3>
                </div>
            </div>

            <div class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-[2px] bg-amber-500/50 rounded-full"></div>
                    <h3 class="text-sm font-black text-white uppercase tracking-widest">Aksi Cepat</h3>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('technician.survey.index') }}" class="flex flex-col items-center justify-center gap-3 p-5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-800 transition-all duration-300 group">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span class="text-xs font-bold text-slate-300 group-hover:text-white">Cek Survey</span>
                    </a>
                    <a href="{{ route('technician.installation.index') }}" class="flex flex-col items-center justify-center gap-3 p-5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-800 transition-all duration-300 group">
                        <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <span class="text-xs font-bold text-slate-300 group-hover:text-white">Instalasi</span>
                    </a>
                    <a href="{{ route('technician.ticket.index') }}" class="flex flex-col items-center justify-center gap-3 p-5 bg-rose-500/10 border border-rose-500/20 rounded-2xl hover:bg-rose-500/20 transition-all duration-300 group">
                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"></path></svg>
                        <span class="text-xs font-bold text-rose-400">Gangguan</span>
                    </a>
                    <a href="{{ route('technician.profile') }}" class="flex flex-col items-center justify-center gap-3 p-5 bg-slate-900 border border-slate-800 rounded-2xl hover:border-amber-500/50 hover:bg-slate-800 transition-all duration-300 group">
                        <svg class="w-6 h-6 text-slate-400 group-hover:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="text-xs font-bold text-slate-300 group-hover:text-white">Profil</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <div class="bg-slate-900/50 border border-slate-800 rounded-3xl p-8 hover:border-amber-500/30 transition-all duration-500 group">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-400 border border-amber-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                            </div>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Infrastruktur</span>
                        </div>
                        <h4 class="text-xl font-black text-white mb-2 tracking-tight uppercase">Survey & Lokasi</h4>
                        <p class="text-slate-400 text-sm mb-6 leading-relaxed">Kelola data pemetaan, validasi titik ODP, dan hasil survey calon pelanggan.</p>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('technician.survey.index') }}" class="px-4 py-2 bg-slate-800/50 rounded-xl text-xs font-bold text-slate-300 hover:bg-amber-500 hover:text-white transition-all text-center">Daftar Survey</a>
                            <a href="{{ route('technician.survey.index') }}" class="px-4 py-2 bg-slate-800/50 rounded-xl text-xs font-bold text-slate-300 hover:bg-amber-500 hover:text-white transition-all text-center">Hasil Survey</a>
                        </div>
                    </div>

                    <div class="bg-slate-900/50 border border-slate-800 rounded-3xl p-8 hover:border-amber-500/30 transition-all duration-500 group">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-12 h-12 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-400 border border-amber-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-xl font-black text-white mb-2 tracking-tight uppercase">Proses Instalasi</h4>
                        <p class="text-slate-400 text-sm mb-6 leading-relaxed">Pencatatan material, penarikan kabel, hingga aktivasi layanan pelanggan baru.</p>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('technician.installation.index') }}" class="px-4 py-2 bg-slate-800/50 rounded-xl text-xs font-bold text-slate-300 hover:bg-amber-500 hover:text-white transition-all text-center">Daftar Instalasi</a>
                            <a href="{{ route('technician.installation.index') }}" class="px-4 py-2 bg-slate-800/50 rounded-xl text-xs font-bold text-slate-300 hover:bg-amber-500 hover:text-white transition-all text-center">Input Data</a>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-slate-900/50 border border-slate-800 rounded-3xl p-8 hover:border-rose-500/30 transition-all duration-500 group h-fit">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-12 h-12 bg-rose-500/10 rounded-2xl flex items-center justify-center text-rose-400 border border-rose-500/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-xl font-black text-rose-500 mb-2 tracking-tight uppercase">Troubleshoot</h4>
                        <p class="text-slate-400 text-sm mb-6 leading-relaxed">Monitoring tiket gangguan masuk dan pembaruan status perbaikan di lapangan.</p>
                        <div class="space-y-3">
                            <a href="{{ route('technician.ticket.index') }}" class="block px-4 py-3 bg-rose-500/10 border border-rose-500/20 rounded-xl text-xs font-bold text-rose-400 hover:bg-rose-500 hover:text-white transition-all text-center">Kelola Tiket Gangguan</a>
                        </div>
                    </div>

                    <div class="bg-slate-900/50 border border-slate-800 rounded-3xl p-8 hover:border-slate-500 transition-all duration-500 group h-fit">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 border border-slate-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
                        <h4 class="text-xl font-black text-white mb-2 tracking-tight uppercase">Keamanan Akun</h4>
                        <p class="text-slate-400 text-sm mb-6 leading-relaxed">Pengaturan profil personal teknisi dan kredensial akses sistem.</p>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('technician.profile') }}" class="px-4 py-2 bg-slate-800/50 rounded-xl text-xs font-bold text-slate-300 hover:bg-slate-700 hover:text-white transition-all text-center">Profil Saya</a>
                            <a href="{{ route('technician.password') }}" class="px-4 py-2 bg-slate-800/50 rounded-xl text-xs font-bold text-slate-300 hover:bg-slate-700 hover:text-white transition-all text-center">Keamanan</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>