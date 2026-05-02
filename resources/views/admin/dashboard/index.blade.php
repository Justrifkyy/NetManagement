<x-app-layout>
    <div class="py-8 bg-slate-950 min-h-screen selection:bg-purple-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight">Dashboard Admin</h1>
                    <p class="text-slate-400 mt-2 text-lg font-medium">Pusat kontrol operasional, verifikasi QC, dan ringkasan keuangan.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-5 py-2.5 rounded-full text-sm font-bold bg-slate-900/80 backdrop-blur-sm text-purple-300 border border-purple-500/30 shadow-[0_0_15px_rgba(168,85,247,0.15)]">
                        <span class="flex w-2.5 h-2.5 bg-purple-400 rounded-full mr-3 animate-pulse shadow-[0_0_8px_rgba(168,85,247,0.8)]"></span>
                        Akses Level: {{ str_replace('_', ' ', strtoupper(Auth::user()->role)) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-6 border border-emerald-500/20 hover:border-emerald-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 text-emerald-500/5 group-hover:text-emerald-500/10 transition-colors duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    </div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold text-emerald-400/80 uppercase tracking-wider group-hover:text-emerald-400 transition-colors">Pelanggan Aktif</p>
                            <h3 class="text-3xl font-black text-white mt-2">{{ $stats['active_subs'] }}</h3>
                        </div>
                        <div class="p-3 bg-emerald-500/10 rounded-xl group-hover:bg-emerald-500/20 transition-colors border border-emerald-500/10">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-6 border border-blue-500/20 hover:border-blue-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 text-blue-500/5 group-hover:text-blue-500/10 transition-colors duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                    </div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold text-blue-400/80 uppercase tracking-wider group-hover:text-blue-400 transition-colors">Total Pendapatan</p>
                            <h3 class="text-2xl font-black text-white mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                        </div>
                        <div class="p-3 bg-blue-500/10 rounded-xl group-hover:bg-blue-500/20 transition-colors border border-blue-500/10">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-6 border border-rose-500/30 hover:border-rose-500/60 hover:-translate-y-1 hover:shadow-2xl hover:shadow-rose-500/20 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 text-rose-500/5 group-hover:text-rose-500/10 transition-colors duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold text-rose-400 uppercase tracking-wider flex items-center gap-2">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                </span>
                                Menunggu QC
                            </p>
                            <h3 class="text-3xl font-black text-white mt-2">{{ $stats['pending_qc'] }}</h3>
                        </div>
                        <div class="p-3 bg-rose-500/10 rounded-xl group-hover:bg-rose-500/20 transition-colors border border-rose-500/10">
                            <svg class="w-8 h-8 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-6 border border-amber-500/20 hover:border-amber-500/50 hover:-translate-y-1 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 text-amber-500/5 group-hover:text-amber-500/10 transition-colors duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
                    </div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-xs font-bold text-amber-400/80 uppercase tracking-wider group-hover:text-amber-400 transition-colors">Prospek Baru</p>
                            <h3 class="text-3xl font-black text-white mt-2">{{ $stats['new_leads'] }}</h3>
                        </div>
                        <div class="p-3 bg-amber-500/10 rounded-xl group-hover:bg-amber-500/20 transition-colors border border-amber-500/10">
                            <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-sm rounded-2xl border border-slate-800 overflow-hidden hover:border-slate-700 transition-all duration-300 shadow-lg hover:shadow-xl">
                <div class="px-6 py-5 border-b border-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-800/30">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-rose-500/10 rounded-lg border border-rose-500/20 mt-1 sm:mt-0">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-lg tracking-wide">Laporan Teknisi Menunggu Verifikasi (QC)</h3>
                            <p class="text-sm text-slate-400 mt-0.5">Cek foto bukti pasang sebelum mengaktifkan internet pelanggan.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center text-sm font-bold text-white bg-slate-800 hover:bg-slate-700 px-5 py-2.5 rounded-lg border border-slate-700 hover:border-slate-600 transition-all shadow-sm focus:ring-2 focus:ring-slate-500 focus:outline-none whitespace-nowrap">
                        Lihat Semua QC
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-800/50 text-xs text-slate-400 uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="px-6 py-4">Tiket / Layanan</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Teknisi</th>
                                <th class="px-6 py-4">Waktu Selesai</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60">
                            @php
                                /** @var \App\Models\Ticket $ticket */
                            @endphp
                            @forelse($pendingTickets as $ticket)
                                <tr class="hover:bg-slate-800/40 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-200 group-hover:text-white transition-colors">{{ $ticket->subject }}</div>
                                        <div class="text-xs text-slate-400 mt-1.5 flex items-center gap-1.5">
                                            Status: 
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                {{ $ticket->installation_status }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-semibold text-slate-200">{{ $ticket->customer->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-slate-400 flex items-center gap-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $ticket->customer->phone_number ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1.5 inline-flex text-xs font-semibold rounded-md bg-slate-800/80 text-slate-300 border border-slate-700">
                                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            {{ $ticket->technician->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $ticket->completed_at ? $ticket->completed_at->format('d M Y, H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs rounded-lg shadow-[0_0_10px_rgba(225,29,72,0.3)] hover:shadow-[0_0_15px_rgba(225,29,72,0.5)] transform hover:-translate-y-0.5 transition-all duration-200">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Lakukan QC
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-emerald-500/10 text-emerald-400 rounded-full flex items-center justify-center mb-4 border border-emerald-500/20 shadow-[0_0_15px_rgba(52,211,153,0.1)]">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <p class="font-bold text-slate-300 text-base">Tidak ada tiket yang menunggu verifikasi.</p>
                                            <p class="text-sm mt-1 text-slate-500">Semua pekerjaan teknisi sudah diperiksa dan disetujui.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>