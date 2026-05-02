<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-purple-500/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-10 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight">Pusat Laporan & Log Sistem</h2>
                <p class="text-slate-400 mt-2 font-medium">Akses cepat ke seluruh data rekapitulasi, tunggakan, dan rekam jejak aktivitas.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                <a href="{{ route('admin.reports.customers') }}" class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 hover:border-emerald-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                    <div class="absolute -right-6 -top-6 text-emerald-500/5 group-hover:text-emerald-500/10 transition-colors duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div class="flex items-center gap-4 mb-4 relative z-10">
                        <div class="p-3 bg-emerald-500/10 rounded-xl group-hover:bg-emerald-500/20 transition-colors border border-emerald-500/20">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl text-white tracking-wide">Laporan Pelanggan</h3>
                    </div>
                    <p class="text-slate-400 text-sm mb-6 flex-grow relative z-10">Data rekap pelanggan baru, aktif, dan isolir dalam periode waktu tertentu.</p>
                    <div class="inline-flex items-center text-sm font-bold text-emerald-400 group-hover:text-emerald-300 relative z-10">
                        Lihat Laporan <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>

                <a href="{{ route('admin.reports.arrears') }}" class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 hover:border-rose-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-rose-500/10 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                    <div class="absolute -right-6 -top-6 text-rose-500/5 group-hover:text-rose-500/10 transition-colors duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                    <div class="flex items-center gap-4 mb-4 relative z-10">
                        <div class="p-3 bg-rose-500/10 rounded-xl group-hover:bg-rose-500/20 transition-colors border border-rose-500/20">
                            <svg class="w-6 h-6 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl text-white tracking-wide">Laporan Tunggakan</h3>
                    </div>
                    <p class="text-slate-400 text-sm mb-6 flex-grow relative z-10">Pantau dan kelola daftar pelanggan dengan tagihan invoice yang belum lunas.</p>
                    <div class="inline-flex items-center text-sm font-bold text-rose-400 group-hover:text-rose-300 relative z-10">
                        Lihat Laporan <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 hover:border-purple-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-purple-500/10 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                    <div class="absolute -right-6 -top-6 text-purple-500/5 group-hover:text-purple-500/10 transition-colors duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    </div>
                    <div class="flex items-center gap-4 mb-4 relative z-10">
                        <div class="p-3 bg-purple-500/10 rounded-xl group-hover:bg-purple-500/20 transition-colors border border-purple-500/20">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl text-white tracking-wide">Laporan Pendapatan</h3>
                    </div>
                    <p class="text-slate-400 text-sm mb-6 flex-grow relative z-10">Kalkulasi total pendapatan dari pembayaran invoice yang lunas pada periode tertentu.</p>
                    <div class="inline-flex items-center text-sm font-bold text-purple-400 group-hover:text-purple-300 relative z-10">
                        Lihat Laporan <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>

                <a href="{{ route('admin.logs.index') }}" class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 hover:border-sky-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-sky-500/10 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-4 relative z-10">
                        <div class="p-3 bg-sky-500/10 rounded-xl group-hover:bg-sky-500/20 transition-colors border border-sky-500/20">
                            <svg class="w-6 h-6 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl text-white tracking-wide">Log Aktivasi</h3>
                    </div>
                    <p class="text-slate-400 text-sm mb-6 flex-grow relative z-10">Riwayat detail pelanggan yang layanannya telah diaktifkan ke dalam sistem.</p>
                    <div class="inline-flex items-center text-sm font-bold text-sky-400 group-hover:text-sky-300 relative z-10">
                        Buka Log <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>

                <a href="{{ route('admin.logs.index') }}" class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 hover:border-amber-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-4 relative z-10">
                        <div class="p-3 bg-amber-500/10 rounded-xl group-hover:bg-amber-500/20 transition-colors border border-amber-500/20">
                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl text-white tracking-wide">Log Isolasi</h3>
                    </div>
                    <p class="text-slate-400 text-sm mb-6 flex-grow relative z-10">Daftar riwayat pemutusan sementara (isolir) pelanggan beserta keterangan alasannya.</p>
                    <div class="inline-flex items-center text-sm font-bold text-amber-400 group-hover:text-amber-300 relative z-10">
                        Buka Log <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>

                <a href="{{ route('admin.logs.index') }}" class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 hover:border-slate-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-slate-500/10 transition-all duration-300 group relative overflow-hidden flex flex-col h-full">
                    <div class="flex items-center gap-4 mb-4 relative z-10">
                        <div class="p-3 bg-slate-800 rounded-xl group-hover:bg-slate-700 transition-colors border border-slate-600">
                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <h3 class="font-bold text-xl text-white tracking-wide">Activity Log</h3>
                    </div>
                    <p class="text-slate-400 text-sm mb-6 flex-grow relative z-10">Catatan audit menyeluruh tentang semua aktivitas dan perubahan di dalam sistem.</p>
                    <div class="inline-flex items-center text-sm font-bold text-slate-300 group-hover:text-white relative z-10">
                        Buka Log <svg class="w-4 h-4 ml-1.5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>