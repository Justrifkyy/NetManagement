<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <a href="{{ route('technician.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Dashboard
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Riwayat <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Log Instalasi</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Rekapitulasi pekerjaan aktivasi dan penarikan jaringan pelanggan.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 animate-fade-in">
                    <div class="p-1 bg-emerald-500 rounded-full shadow-[0_0_15px_rgba(16,185,129,0.3)] text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-emerald-400 text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                <div class="absolute -right-20 -top-20 w-72 h-72 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800/50 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800/60">
                            <tr>
                                <th class="px-8 py-5">Detail Pelanggan</th>
                                <th class="px-6 py-5">Konektivitas</th>
                                <th class="px-6 py-5">Waktu Aktivasi</th>
                                <th class="px-6 py-5">Status Akhir</th>
                                <th class="px-6 py-5">Teknisi Lapangan</th>
                                <th class="px-8 py-5 text-right">Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm font-medium">
                            @forelse($installations as $installation)
                                <tr class="hover:bg-slate-800/40 transition-all duration-300 group">
                                    <td class="px-8 py-6">
                                        <div class="text-white font-bold tracking-tight text-base group-hover:text-amber-400 transition-colors">
                                            {{ $installation->lead->name }}
                                        </div>
                                        <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-0.5">Job: #INST-{{ $installation->id + 3000 }}</div>
                                    </td>
                                    <td class="px-6 py-6">
                                        @if($installation->connection_type == 'fiber')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-blue-500/10 text-blue-400 border border-blue-500/20 uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                Fiber
                                            </span>
                                        @elseif($installation->connection_type == 'wireless')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-purple-500/10 text-purple-400 border border-purple-500/20 uppercase tracking-widest">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                                                Wireless
                                            </span>
                                        @else
                                            <span class="text-slate-600">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-6 text-slate-300">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $installation->installation_date?->format('d M Y') ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        @if($installation->installation_status == 'berhasil')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase tracking-widest">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Berhasil
                                            </span>
                                        @elseif($installation->installation_status == 'gagal')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-rose-500/10 text-rose-400 border border-rose-500/20 uppercase tracking-widest">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                                Gagal
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-amber-500/10 text-amber-500 border border-amber-500/20 uppercase tracking-widest">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-slate-800 rounded-full flex items-center justify-center text-slate-500 border border-slate-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <span class="text-slate-300 font-bold tracking-tight">{{ $installation->technician?->name ?? 'Unassigned' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('technician.installation.show', $installation->id) }}" class="p-2.5 bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-all border border-slate-700" title="Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('technician.installation.edit', $installation->id) }}" class="p-2.5 bg-slate-800 text-amber-500/80 hover:text-white hover:bg-amber-600 rounded-xl transition-all border border-slate-700" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-600 border border-slate-700 shadow-inner">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </div>
                                            <div>
                                                <h5 class="text-white font-bold text-lg tracking-tight">Tidak Ada Log Instalasi</h5>
                                                <p class="text-slate-500 text-sm mt-1">Belum ada riwayat pekerjaan instalasi yang tercatat.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                {{ $installations->links() }}
            </div>

            <div class="mt-12 p-6 bg-slate-900/50 border border-slate-800 rounded-3xl">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-indigo-500/10 rounded-xl text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest leading-relaxed">
                            Informasi: Seluruh data instalasi yang berstatus <span class="text-emerald-400">Berhasil</span> akan diteruskan ke tim administrasi untuk proses penagihan pertama. Harap pastikan koordinat ODP dan foto bukti telah lengkap.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>