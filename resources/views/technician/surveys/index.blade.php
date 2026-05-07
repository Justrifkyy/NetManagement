<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-amber-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <a href="{{ route('technician.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Dashboard
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Bursa <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Survey Lokasi</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Daftar prospek pelanggan yang menunggu validasi infrastruktur di lapangan.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 animate-fade-in">
                    <div class="p-1 bg-emerald-500 rounded-full">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-emerald-400 text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                <div class="absolute -right-20 -top-20 w-72 h-72 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800/50 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800/60">
                            <tr>
                                <th class="px-8 py-5">Calon Pelanggan</th>
                                <th class="px-6 py-5">Kontak & Alamat</th>
                                <th class="px-6 py-5">Layanan</th>
                                <th class="px-6 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-right">Navigasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60">
                            @forelse($available_leads as $lead)
                                <tr class="hover:bg-slate-800/40 transition-all duration-300 group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-indigo-500/10 rounded-xl flex items-center justify-center text-indigo-400 border border-indigo-500/20 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-white font-bold tracking-tight text-base group-hover:text-amber-400 transition-colors">{{ $lead->name }}</div>
                                                <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-0.5">Prospect ID: #{{ $lead->id + 1000 }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="text-slate-300 font-medium text-sm flex items-center gap-2 mb-1">
                                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $lead->phone ?? '-' }}
                                        </div>
                                        <div class="text-slate-500 text-xs flex items-start gap-2 leading-relaxed max-w-[250px]">
                                            <svg class="w-3.5 h-3.5 text-slate-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ Str::limit($lead->address_installation ?? 'Alamat belum diinput', 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-xl inline-block">
                                            <span class="text-xs font-bold text-slate-300">{{ $lead->package->name ?? 'Standard' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-lg text-indigo-400 text-[10px] font-black uppercase tracking-widest">
                                            {{ $lead->status }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="{{ route('technician.survey.create', $lead->id) }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-amber-600 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-[0_0_15px_rgba(217,119,6,0.2)] hover:bg-amber-500 hover:shadow-[0_0_20px_rgba(217,119,6,0.4)] transition-all duration-300 transform hover:-translate-y-0.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            Mulai Survey
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-600 border border-slate-700 shadow-inner">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4m8 4v10"></path></svg>
                                            </div>
                                            <div class="max-w-xs">
                                                <h5 class="text-white font-bold text-lg tracking-tight">Antrean Survey Kosong</h5>
                                                <p class="text-slate-500 text-sm mt-1 leading-relaxed">Belum ada calon pelanggan yang memerlukan validasi lokasi untuk saat ini.</p>
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
                {{ $available_leads->links() }}
            </div>

            <div class="mt-12 p-6 bg-slate-900/50 border border-slate-800 rounded-3xl flex items-start gap-4">
                <div class="text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-[10px] text-slate-500 leading-relaxed font-black uppercase tracking-[0.1em]">
                    Catatan Teknisi: Lakukan penginputan koordinat GPS dengan akurat pada setiap hasil survey. Data koordinat yang valid sangat krusial untuk penentuan titik penarikan kabel (ODP) pada proses instalasi selanjutnya.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>