<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-purple-500/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-white transition-colors mb-4 group">
                    <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Pusat Laporan
                </a>
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight">Laporan Data Pelanggan</h2>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 mb-8 mx-4 sm:mx-0">
                <form action="{{ route('admin.reports.customers') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-5">
                    <div class="w-full sm:w-1/3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Mulai Dari Tanggal</label>
                        <input type="date" name="from_date" value="{{ $fromDate }}" class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all text-slate-300">
                    </div>
                    <div class="w-full sm:w-1/3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                        <input type="date" name="to_date" value="{{ $toDate }}" class="w-full px-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all text-slate-300">
                    </div>
                    <div class="w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.3)] hover:shadow-[0_0_20px_rgba(16,185,129,0.5)] transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 overflow-hidden mx-4 sm:mx-0">
                <div class="px-6 py-5 border-b border-slate-700/50 bg-slate-800/30 flex items-center gap-3">
                    <div class="p-1.5 bg-emerald-500/20 rounded-lg">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-white text-lg tracking-wide">Daftar Pelanggan Baru <span class="text-emerald-400 font-medium text-sm ml-2">({{ \Carbon\Carbon::parse($fromDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($toDate)->format('d M Y') }})</span></h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800/50 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-700/50">
                            <tr>
                                <th class="px-6 py-4">Nama Pelanggan</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">No. Telepon</th>
                                <th class="px-6 py-4">Paket Aktif</th>
                                <th class="px-6 py-4">Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @forelse($report as $customer)
                                <tr class="hover:bg-slate-800/40 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-200 group-hover:text-white transition-colors">{{ $customer->user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 group-hover:text-slate-300 transition-colors">{{ $customer->user->email }}</td>
                                    <td class="px-6 py-4 text-slate-300 font-medium">{{ $customer->phone_number ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            {{ $customer->subscriptions->first()?->package->name ?? 'Belum Ada Paket' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 font-medium">{{ $customer->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <div class="w-16 h-16 mb-4 bg-slate-800/50 border border-slate-700/50 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            </div>
                                            <p class="font-bold text-slate-300">Tidak ada pelanggan baru</p>
                                            <p class="text-sm mt-1">Tidak ada data pelanggan yang terdaftar pada rentang tanggal tersebut.</p>
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