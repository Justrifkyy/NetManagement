<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 p-8 mb-10 overflow-hidden relative group">
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-[100px] group-hover:bg-indigo-500/20 transition-all duration-700"></div>
                <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-emerald-500/5 rounded-full blur-[80px]"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-full text-indigo-400 text-[10px] font-black uppercase tracking-[0.2em]">Technician Portal</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-slate-500 text-xs font-bold uppercase tracking-widest">System Online</span>
                        </div>
                        <h1 class="text-4xl font-black text-white tracking-tighter">
                            Selamat Bertugas, <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">{{ Auth::user()->name }}</span>!
                        </h1>
                        <p class="text-slate-400 mt-3 max-w-2xl font-medium leading-relaxed">
                            Pantau bursa tugas secara berkala. Pastikan standar <span class="text-indigo-300 font-bold">K3 (Kesehatan & Keselamatan Kerja)</span> terpenuhi di setiap instalasi lapangan.
                        </p>
                    </div>
                    <div class="hidden lg:block text-right">
                        <div class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Waktu Server</div>
                        <div class="text-2xl font-mono font-black text-white" id="clock">{{ now()->format('H:i') }} <span class="text-indigo-500 text-sm">WITA</span></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-slate-900/50 backdrop-blur-sm rounded-3xl border border-slate-800 p-6 relative overflow-hidden group hover:border-amber-500/30 transition-all duration-300">
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Bursa Tiket</p>
                            <h3 class="text-4xl font-black text-white tracking-tighter">{{ $openTickets ?? 0 }}</h3>
                            <p class="text-xs text-amber-400/80 font-bold mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Menunggu diklaim
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center border border-amber-500/20 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/50 backdrop-blur-sm rounded-3xl border border-slate-800 p-6 relative overflow-hidden group hover:border-indigo-500/30 transition-all duration-300">
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Meja Kerja</p>
                            <h3 class="text-4xl font-black text-white tracking-tighter">{{ $myActiveTasks ?? 0 }}</h3>
                            <p class="text-xs text-indigo-400/80 font-bold mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Proses pengerjaan
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center border border-indigo-500/20 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/50 backdrop-blur-sm rounded-3xl border border-slate-800 p-6 relative overflow-hidden group hover:border-emerald-500/30 transition-all duration-300">
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-1">Penyelesaian</p>
                            <h3 class="text-4xl font-black text-white tracking-tighter">{{ $completedThisMonth ?? 0 }}</h3>
                            <p class="text-xs text-emerald-400/80 font-bold mt-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Bulan ini
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center border border-emerald-500/20 group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <a href="{{ route('technician.tickets.index') }}"
                    class="group relative bg-slate-900/80 backdrop-blur-md overflow-hidden rounded-[2.5rem] border border-slate-800 hover:border-amber-500/50 transition-all duration-500 shadow-xl">
                    <div class="p-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-amber-500/10 rounded-2xl flex items-center justify-center mb-6 border border-amber-500/20 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500 shadow-[0_0_20px_rgba(245,158,11,0.1)]">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-3 group-hover:text-amber-400 transition-colors tracking-tight">Bursa Tugas (Jobdesk)</h3>
                        <p class="text-slate-400 font-medium leading-relaxed mb-8">
                            Ambil tugas instalasi atau perbaikan baru. Filter berdasarkan lokasi terdekat untuk efisiensi mobilitas Anda.
                        </p>
                        <div class="mt-auto flex items-center text-amber-400 font-black text-sm uppercase tracking-widest">
                            Buka Bursa Tugas
                            <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('technician.process.index') }}"
                    class="group relative bg-slate-900/80 backdrop-blur-md overflow-hidden rounded-[2.5rem] border border-slate-800 hover:border-indigo-500/50 transition-all duration-500 shadow-xl">
                    <div class="p-10 flex flex-col h-full">
                        <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl flex items-center justify-center mb-6 border border-indigo-500/20 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-500 shadow-[0_0_20px_rgba(79,70,229,0.1)]">
                            <svg class="w-9 h-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-3 group-hover:text-indigo-400 transition-colors tracking-tight">Meja Kerja Aktif</h3>
                        <p class="text-slate-400 font-medium leading-relaxed mb-8">
                            Kelola progres instalasi, input koordinat ODP, upload foto bukti material, dan selesaikan laporan akhir.
                        </p>
                        <div class="mt-auto flex items-center text-indigo-400 font-black text-sm uppercase tracking-widest">
                            Kelola Pekerjaan
                            <svg class="ml-2 w-5 h-5 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('clock').innerHTML = `${hours}:${minutes} <span class="text-indigo-500 text-sm">WITA</span>`;
        }
        setInterval(updateClock, 1000);
    </script>
</x-app-layout>