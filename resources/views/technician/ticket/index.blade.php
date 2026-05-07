<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-rose-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('technician.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Dashboard
                    </a>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-rose-500/10 rounded-xl border border-rose-500/20">
                            <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h1 class="text-4xl font-black text-white tracking-tighter">Bursa <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-orange-400">Tiket Gangguan</span></h1>
                    </div>
                    <p class="text-slate-400 mt-2 font-medium">Daftar laporan kendala jaringan pelanggan yang menunggu penanganan teknisi.</p>
                </div>
            </div>

            <div class="mb-10 p-5 bg-indigo-500/10 border border-indigo-500/20 rounded-2xl flex items-start gap-4">
                <div class="p-2 bg-indigo-500/20 rounded-xl text-indigo-400 border border-indigo-500/30 shadow-inner">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-indigo-300 font-bold tracking-tight mb-1">Prosedur Pengambilan Tugas</h4>
                    <p class="text-xs text-indigo-400/80 font-medium leading-relaxed">
                        Evaluasi detail gangguan dan lokasi pelanggan. Klik <strong class="text-indigo-300">"Ambil Tugas"</strong> untuk memindahkan tiket ke meja kerja Anda. Tiket yang sudah diambil akan hilang dari bursa utama.
                    </p>
                </div>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-slate-800 overflow-hidden relative mb-10">
                <div class="absolute -left-20 -top-20 w-72 h-72 bg-rose-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800/50 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800/60">
                            <tr>
                                <th class="px-8 py-5">Identitas Laporan</th>
                                <th class="px-6 py-5">Informasi Pelanggan</th>
                                <th class="px-6 py-5 text-center">Kategori</th>
                                <th class="px-6 py-5 text-center">Waktu Masuk</th>
                                <th class="px-8 py-5 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-slate-800/40 transition-all duration-300 group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-start gap-4">
                                            <div class="mt-1">
                                                <span class="relative flex h-3 w-3">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                                </span>
                                            </div>
                                            <div>
                                                <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1">ID Tiket: #{{ $ticket->id }}</div>
                                                <div class="font-bold text-white tracking-tight leading-snug group-hover:text-rose-400 transition-colors line-clamp-2 max-w-xs">{{ $ticket->subject }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="font-bold text-slate-200">{{ $ticket->customer->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-slate-500 font-medium flex items-center gap-1.5 mt-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                            {{ $ticket->customer->phone_number ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest border
                                            @switch($ticket->type)
                                                @case('repair')
                                                    bg-orange-500/10 text-orange-400 border-orange-500/20
                                                    @break
                                                @case('installation')
                                                    bg-blue-500/10 text-blue-400 border-blue-500/20
                                                    @break
                                                @case('survey')
                                                    bg-purple-500/10 text-purple-400 border-purple-500/20
                                                    @break
                                                @default
                                                    bg-slate-800 text-slate-400 border-slate-700
                                            @endswitch
                                        ">
                                            {{ $ticket->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        <div class="text-slate-300 font-medium">{{ $ticket->created_at->format('d M Y') }}</div>
                                        <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">{{ $ticket->created_at->format('H:i') }} WITA</div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <form action="{{ route('technician.ticket.claim', $ticket->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-amber-600 text-white text-xs font-black uppercase tracking-widest rounded-xl shadow-[0_0_15px_rgba(217,119,6,0.2)] hover:bg-amber-500 hover:shadow-[0_0_25px_rgba(217,119,6,0.4)] transition-all duration-300 transform hover:-translate-y-0.5">
                                                Ambil Tugas
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-24 h-24 bg-emerald-500/10 rounded-[2rem] flex items-center justify-center text-emerald-400 border border-emerald-500/20 shadow-inner">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="max-w-md mx-auto mt-4">
                                                <h5 class="text-white font-black text-xl tracking-tight">Infrastruktur Aman</h5>
                                                <p class="text-slate-500 text-sm mt-2 leading-relaxed">Tidak ada tiket gangguan yang tersedia saat ini. Semua laporan telah ditangani atau jaringan dalam keadaan stabil.</p>
                                            </div>
                                            <a href="{{ route('technician.process.index') }}" class="mt-6 px-6 py-3 bg-slate-800 text-slate-300 border border-slate-700 hover:border-slate-600 hover:text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all">
                                                Cek Meja Kerja Saya
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('technician.process.index') }}" class="group bg-slate-900/50 border border-slate-800 rounded-[2rem] p-6 hover:border-amber-500/30 transition-all duration-300 flex items-center gap-6">
                    <div class="w-16 h-16 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-500 border border-amber-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-black text-white tracking-tight group-hover:text-amber-400 transition-colors">Meja Kerja Saya</h4>
                        <p class="text-xs text-slate-500 font-medium mt-1">Lanjutkan tugas yang sedang dalam proses penanganan.</p>
                    </div>
                </a>

                <a href="{{ route('technician.dashboard') }}" class="group bg-slate-900/50 border border-slate-800 rounded-[2rem] p-6 hover:border-indigo-500/30 transition-all duration-300 flex items-center gap-6">
                    <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-400 border border-indigo-500/20 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-black text-white tracking-tight group-hover:text-indigo-400 transition-colors">Dashboard Utama</h4>
                        <p class="text-xs text-slate-500 font-medium mt-1">Kembali ke ringkasan aktivitas operasional Anda.</p>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>