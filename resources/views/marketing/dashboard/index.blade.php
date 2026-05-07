<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-indigo-500/10 rounded-lg border border-indigo-500/20">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em]">Sales & Marketing Hub</span>
                    </div>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Dashboard <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Marketing</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Pantau performa prospek, akuisisi pelanggan, dan tingkat konversi Anda bulan ini.</p>
                </div>
                <div class="hidden lg:block text-right">
                    <a href="{{ route('marketing.leads.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-[0_0_15px_rgba(79,70,229,0.3)] hover:bg-indigo-500 hover:shadow-[0_0_25px_rgba(79,70,229,0.5)] transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Input Prospek Baru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                
                <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-[2rem] p-7 group hover:border-indigo-500/50 transition-all duration-500 shadow-xl overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/5 rounded-full blur-3xl group-hover:bg-indigo-500/10 transition-all"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-500/10 rounded-2xl border border-indigo-500/20 text-indigo-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-[0.1em]">Total Leads Database</p>
                    <h3 class="text-5xl font-black text-white tracking-tighter mt-1">{{ $stats['total'] ?? 0 }}</h3>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-[2rem] p-7 group hover:border-sky-500/50 transition-all duration-500 shadow-xl overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-sky-500/5 rounded-full blur-3xl group-hover:bg-sky-500/10 transition-all"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-sky-500/10 rounded-2xl border border-sky-500/20 text-sky-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-[0.1em]">Prospek Baru</p>
                    <h3 class="text-5xl font-black text-white tracking-tighter mt-1">{{ $stats['prospek'] ?? 0 }}</h3>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-[2rem] p-7 group hover:border-amber-500/50 transition-all duration-500 shadow-xl overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/5 rounded-full blur-3xl group-hover:bg-amber-500/10 transition-all"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-amber-500/10 rounded-2xl border border-amber-500/20 text-amber-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-[0.1em]">Dalam Negosiasi</p>
                    <h3 class="text-5xl font-black text-amber-400 tracking-tighter mt-1">{{ $stats['proses'] ?? 0 }}</h3>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-md border border-slate-800 rounded-[2rem] p-7 group hover:border-emerald-500/50 transition-all duration-500 shadow-xl overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl group-hover:bg-emerald-500/10 transition-all"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-emerald-500/10 rounded-2xl border border-emerald-500/20 text-emerald-400 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs font-black text-slate-500 uppercase tracking-[0.1em]">Berhasil Closing</p>
                    <h3 class="text-5xl font-black text-emerald-400 tracking-tighter mt-1">{{ $stats['converted'] ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative">
                <div class="absolute -right-20 -top-20 w-72 h-72 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="bg-gradient-to-r from-indigo-600/20 to-transparent px-10 py-6 border-b border-slate-800/60 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-2.5 bg-indigo-500/10 rounded-2xl border border-indigo-500/20 text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h2 class="text-xl font-black text-white tracking-tight uppercase">5 Prospek Terakhir</h2>
                    </div>
                    <a href="{{ route('marketing.leads.index') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-xs font-black text-slate-300 uppercase tracking-widest hover:bg-indigo-600 hover:text-white hover:border-indigo-500 transition-all duration-300 shadow-sm">
                        Lihat Semua Prospek
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800/50 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800/60">
                            <tr>
                                <th class="px-8 py-5">Nama Pelanggan</th>
                                <th class="px-6 py-5">Paket Diminati</th>
                                <th class="px-6 py-5">Tanggal Masuk</th>
                                <th class="px-8 py-5 text-center">Status Lead</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @php
                                /** @var \App\Models\Lead $lead */
                            @endphp
                            @forelse($recentLeads as $lead)
                                <tr class="hover:bg-slate-800/40 transition-all duration-300 group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-slate-800 rounded-full flex items-center justify-center text-slate-500 border border-slate-700 group-hover:bg-indigo-500/10 group-hover:text-indigo-400 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <div>
                                                <div class="text-white font-bold tracking-tight text-base group-hover:text-indigo-400 transition-colors">{{ $lead->name }}</div>
                                                <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-1 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                    {{ $lead->phone }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="inline-flex px-3 py-1.5 bg-slate-800 border border-slate-700 rounded-xl text-xs font-bold text-slate-300">
                                            {{ $lead->package->name ?? 'Belum Pilih Paket' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-slate-300 font-medium">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $lead->created_at->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @if($lead->status == 'converted' || $lead->status == 'aktif')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase tracking-widest shadow-inner">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                {{ $lead->status }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-amber-500/10 text-amber-500 border border-amber-500/20 uppercase tracking-widest shadow-inner">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                {{ $lead->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-600 border border-slate-700 shadow-inner">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <div class="max-w-xs">
                                                <h5 class="text-white font-bold text-lg tracking-tight">Belum Ada Prospek</h5>
                                                <p class="text-slate-500 text-sm mt-1 leading-relaxed">Saat ini belum ada data prospek pelanggan baru yang diinput ke dalam sistem.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.3em]">
                    NetManagement &bull; Marketing Data Center
                </p>
            </div>

        </div>
    </div>
</x-app-layout>