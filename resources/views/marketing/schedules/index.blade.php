<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-indigo-500/10 rounded-lg border border-indigo-500/20 text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-indigo-500 uppercase tracking-[0.2em]">Activity Planner</span>
                    </div>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Jadwal & <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-300">Timeline</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Kelola ritme kerja, janji temu, dan tindak lanjut (follow-up) prospek pelanggan.</p>
                </div>
                <button class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-[0_0_20px_rgba(79,70,229,0.3)] hover:bg-indigo-500 hover:shadow-[0_0_30px_rgba(79,70,229,0.5)] transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Jadwal
                </button>
            </div>

            {{-- Advanced Filter Card --}}
            <div class="bg-slate-900/80 backdrop-blur-md rounded-[2rem] shadow-2xl border border-slate-800 p-8 mb-10 relative overflow-hidden">
                <div class="absolute -left-20 -top-20 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Kategori Tugas</label>
                        <select class="w-full px-5 py-3.5 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all font-bold appearance-none cursor-pointer">
                            <option class="bg-slate-900">Semua Jadwal</option>
                            <option class="bg-slate-900">Follow-up</option>
                            <option class="bg-slate-900">Survei</option>
                            <option class="bg-slate-900">Presentasi</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Status Progres</label>
                        <select class="w-full px-5 py-3.5 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 font-bold appearance-none cursor-pointer">
                            <option class="bg-slate-900">Semua Status</option>
                            <option class="bg-slate-900">Terjadwal</option>
                            <option class="bg-slate-900">Selesai</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Rentang Waktu</label>
                        <select class="w-full px-5 py-3.5 bg-slate-800/50 border border-slate-700 text-white rounded-2xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 font-bold appearance-none cursor-pointer">
                            <option class="bg-slate-900">Minggu Ini</option>
                            <option class="bg-slate-900">Bulan Ini</option>
                        </select>
                    </div>
                    <button class="w-full py-4 bg-slate-800 border border-slate-700 text-white font-black rounded-2xl hover:bg-indigo-600 hover:border-indigo-500 transition-all duration-300 uppercase tracking-widest text-[10px]">
                        Terapkan Filter
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

                {{-- Timeline Column --}}
                <div class="lg:col-span-3 space-y-8">
                    @for ($day = 0; $day < 7; $day++)
                        @php
                            $date = now()->addDays($day);
                            $isToday = $day === 0;
                            $count = rand(1, 3);
                        @endphp

                        <div class="relative">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="px-5 py-2 rounded-xl {{ $isToday ? 'bg-indigo-500 text-white shadow-[0_0_15px_rgba(79,70,229,0.4)]' : 'bg-slate-900 border border-slate-800 text-slate-400' }} font-black text-xs uppercase tracking-widest">
                                    {{ $date->format('l, d F') }}
                                </div>
                                @if($isToday)
                                    <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest animate-pulse">● Hari Ini</span>
                                @endif
                                <div class="h-px bg-slate-800 flex-grow"></div>
                                <span class="text-[10px] font-bold text-slate-600 uppercase">{{ $count }} Items</span>
                            </div>

                            <div class="space-y-4 ml-2 border-l-2 border-slate-900 pl-8">
                                @for ($i = 0; $i < $count; $i++)
                                    @php
                                        $types = ['Follow-up', 'Survei', 'Presentasi', 'Instalasi'];
                                        $type = $types[$i % count($types)];
                                        $time = sprintf('%02d:%02d', rand(8, 17), [0, 30][$i % 2]);
                                        $status = ['Belum Dimulai', 'Selesai'][$i % 2];
                                    @endphp

                                    <div class="group relative bg-slate-900/50 backdrop-blur-md border border-slate-800 rounded-[2rem] p-6 hover:border-indigo-500/30 transition-all duration-300">
                                        <div class="absolute -left-[2.55rem] top-1/2 -translate-y-1/2 w-4 h-4 rounded-full border-4 border-slate-950 group-hover:scale-125 transition-transform {{ $status == 'Selesai' ? 'bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]' : 'bg-slate-700' }}"></div>

                                        <div class="flex flex-col md:flex-row md:items-center gap-6">
                                            <div class="flex-shrink-0">
                                                <div class="text-2xl font-black text-white font-mono tracking-tighter">{{ $time }}</div>
                                                <div class="text-[10px] font-black text-slate-600 uppercase tracking-widest text-center md:text-left">WITA</div>
                                            </div>

                                            <div class="flex-grow">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <h5 class="font-black text-white text-lg tracking-tight group-hover:text-indigo-400 transition-colors">{{ $type }}</h5>
                                                    <span class="text-slate-700">•</span>
                                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">ID #{{ 1000 + $i }}</span>
                                                </div>
                                                <p class="text-sm text-slate-300 font-medium">Customer: <span class="text-white">Prospek {{ $i + 1 }}</span> | +62 812 3456 xxxx</p>
                                                <div class="flex items-center gap-3 mt-3">
                                                    <div class="flex items-center gap-1.5 px-3 py-1 bg-slate-800 rounded-lg border border-slate-700">
                                                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest line-clamp-1">Area: Gowa, Sulawesi Selatan</span>
                                                    </div>
                                                    @if($status == 'Selesai')
                                                        <span class="px-2 py-0.5 text-[9px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded uppercase tracking-widest shadow-inner">Complete</span>
                                                    @else
                                                        <span class="px-2 py-0.5 text-[9px] font-black bg-amber-500/10 text-amber-500 border border-amber-500/20 rounded uppercase tracking-widest shadow-inner">Upcoming</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex md:flex-col gap-2">
                                                <button class="p-2.5 bg-slate-800 text-slate-400 hover:text-indigo-400 rounded-xl transition-all border border-slate-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                                <button class="p-2.5 bg-slate-800 text-slate-400 hover:text-rose-500 rounded-xl transition-all border border-slate-700">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    @endfor
                </div>

                {{-- Sidebar Column --}}
                <div class="space-y-8">
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden group">
                        <div class="absolute -right-4 -bottom-4 text-white/10 group-hover:scale-110 transition-transform">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>
                        </div>
                        <h4 class="text-xs font-black text-white uppercase tracking-[0.2em] mb-6 relative z-10">Ringkasan Hari Ini</h4>
                        <div class="space-y-6 relative z-10">
                            <div>
                                <p class="text-white/60 text-[10px] font-black uppercase tracking-widest">Target Tercapai</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-4xl font-black text-white tracking-tighter">75%</span>
                                    <span class="text-xs font-bold text-indigo-200 mb-1.5">3/4 Tugas</span>
                                </div>
                                <div class="w-full h-1.5 bg-white/20 rounded-full mt-2">
                                    <div class="w-3/4 h-full bg-white rounded-full shadow-[0_0_10px_rgba(255,255,255,0.5)]"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 border border-slate-800 rounded-[2rem] p-8 shadow-xl">
                        <h4 class="text-xs font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Template Aksi Cepat</h4>
                        <div class="space-y-3">
                            <button class="w-full flex items-center justify-between p-4 bg-slate-800/50 hover:bg-indigo-600 rounded-2xl border border-slate-700 hover:border-indigo-500 transition-all duration-300 group">
                                <span class="text-xs font-bold text-slate-300 group-hover:text-white uppercase tracking-widest">WhatsApp Follow-up</span>
                                <svg class="w-4 h-4 text-indigo-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                            <button class="w-full flex items-center justify-between p-4 bg-slate-800/50 hover:bg-emerald-600 rounded-2xl border border-slate-700 hover:border-emerald-500 transition-all duration-300 group">
                                <span class="text-xs font-bold text-slate-300 group-hover:text-white uppercase tracking-widest">Reminder Tagihan</span>
                                <svg class="w-4 h-4 text-emerald-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                            <button class="w-full flex items-center justify-between p-4 bg-slate-800/50 hover:bg-rose-600 rounded-2xl border border-slate-700 hover:border-rose-500 transition-all duration-300 group">
                                <span class="text-xs font-bold text-slate-300 group-hover:text-white uppercase tracking-widest">Reschedule Janji</span>
                                <svg class="w-4 h-4 text-rose-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>