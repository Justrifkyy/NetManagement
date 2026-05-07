<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-indigo-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="fade-in">
                    <a href="{{ route('technician.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-white transition-colors mb-4 group">
                        <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Dashboard
                    </a>
                    <h1 class="text-4xl font-black text-white tracking-tighter">Riwayat <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-yellow-200">Hasil Survey</span></h1>
                    <p class="text-slate-400 mt-2 font-medium">Laporan validasi teknis lokasi pelanggan yang telah dikerjakan.</p>
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
                <div class="absolute -right-20 -top-20 w-72 h-72 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800/50 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800/60">
                            <tr>
                                <th class="px-8 py-5">Informasi Pelanggan</th>
                                <th class="px-6 py-5">Status Kelayakan</th>
                                <th class="px-6 py-5">Jadwal Survey</th>
                                <th class="px-6 py-5">Teknisi Penanggung Jawab</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @forelse($surveys as $survey)
                                <tr class="hover:bg-slate-800/40 transition-all duration-300 group">
                                    <td class="px-8 py-6">
                                        <div class="font-bold text-white text-base group-hover:text-amber-400 transition-colors">
                                            {{ $survey->lead->name }}
                                        </div>
                                        <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-1">
                                            ID: #{{ $survey->lead_id + 2000 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        @if($survey->survey_status == 'layak')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 uppercase tracking-widest shadow-inner">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Layak
                                            </span>
                                        @elseif($survey->survey_status == 'tidak_layak')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-rose-500/10 text-rose-400 border border-rose-500/20 uppercase tracking-widest shadow-inner">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                Tidak Layak
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg text-[10px] font-black bg-slate-800 text-slate-500 border border-slate-700 uppercase tracking-widest shadow-inner">
                                                Belum Survey
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-6 text-slate-300 font-medium">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $survey->survey_date?->format('d M Y') ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 bg-slate-800 rounded-full flex items-center justify-center text-slate-500 border border-slate-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                            <span class="text-slate-300 font-bold">{{ $survey->technician?->name ?? 'Unassigned' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="{{ route('technician.survey.edit', $survey->lead_id) }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-xs font-black text-slate-300 uppercase tracking-widest hover:bg-amber-600 hover:text-white hover:border-amber-500 transition-all duration-300 shadow-sm">
                                            Edit Data
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-20 h-20 bg-slate-800 rounded-3xl flex items-center justify-center text-slate-600 border border-slate-700 shadow-inner">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <div>
                                                <h5 class="text-white font-bold text-lg tracking-tight">Data Survey Kosong</h5>
                                                <p class="text-slate-500 text-sm mt-1">Belum ada riwayat hasil survey yang tercatat di sistem.</p>
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
                {{ $surveys->links() }}
            </div>

            <div class="mt-12 p-6 bg-slate-900/50 border border-slate-800 rounded-3xl">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-amber-500/10 rounded-xl text-amber-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest leading-relaxed">
                            Panduan Teknis: Hasil survey yang ditandai sebagai <span class="text-emerald-400">Layak</span> akan otomatis masuk ke antrean instalasi tim teknisi lapangan. Pastikan dokumentasi foto lokasi sudah terunggah dengan benar.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>