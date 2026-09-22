<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-white transition-colors group">
                    <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Pusat Laporan
                </a>
            </div>

            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-cyan-400 tracking-tight">Log Aktivasi Pelanggan</h2>
                <p class="text-slate-400 mt-2 font-medium">Rekam jejak seluruh proses pengaktifan kembali layanan pelanggan.</p>
            </div>

            <form method="GET" class="bg-slate-900/80 rounded-2xl border border-slate-800 p-6 mb-8 mx-4 sm:mx-0 flex flex-col md:flex-row items-end gap-4">
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Dari Tanggal</label>
                    <input type="date" name="from_date" value="{{ $fromDate }}" style="color-scheme: dark;"
                        class="w-full px-4 py-3 bg-slate-800/50 text-slate-300 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all">
                </div>
                <div class="w-full md:w-1/3">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                    <input type="date" name="to_date" value="{{ $toDate }}" style="color-scheme: dark;"
                        class="w-full px-4 py-3 bg-slate-800/50 text-slate-300 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all">
                </div>
                <div class="flex gap-3 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none px-6 py-3 bg-sky-600 text-white font-bold rounded-xl hover:bg-sky-500 transition-all">Filter</button>
                    <a href="{{ route('admin.reports.activationLog') }}" class="flex-1 md:flex-none px-6 py-3 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 transition-all text-center">Reset</a>
                </div>
            </form>

            <div class="bg-slate-900/80 rounded-2xl border border-slate-800 overflow-hidden mx-4 sm:mx-0">
                <div class="px-6 py-5 border-b border-slate-700/50 bg-slate-800/30 flex items-center gap-3">
                    <div class="p-1.5 bg-sky-500/10 rounded-lg border border-sky-500/20">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="font-bold text-white">{{ $logs->count() }} Catatan Aktivasi</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-800/50 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-700/50">
                            <tr>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">Dilakukan Oleh</th>
                                <th class="px-6 py-4">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60">
                            @forelse($logs as $log)
                                <tr class="hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-slate-200 font-mono font-bold text-xs">{{ $log->created_at->format('d M Y') }}</div>
                                        <div class="text-slate-500 font-mono text-xs mt-1">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-200">{{ $log->user->name ?? 'System' }}</span>
                                        @if($log->user)
                                            <div class="text-xs text-slate-500 mt-0.5">{{ $log->user->role }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-slate-400">{{ $log->description ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center text-slate-400">
                                            <svg class="w-12 h-12 mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            <p class="font-bold text-slate-300">Tidak ada log aktivasi</p>
                                            <p class="text-sm mt-1">Belum ada pelanggan yang diaktifkan pada periode ini.</p>
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
