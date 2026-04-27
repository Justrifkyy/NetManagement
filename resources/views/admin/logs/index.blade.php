<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen selection:bg-sky-500/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 px-4 sm:px-0">
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-400 hover:text-white transition-colors mb-4 group">
                    <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Pusat Laporan
                </a>
                <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 tracking-tight">Activity Log Sistem</h2>
                <p class="text-slate-400 mt-2 font-medium">Pantau seluruh rekam jejak aktivitas, login, dan perubahan data di dalam sistem.</p>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 p-6 mb-8 mx-4 sm:mx-0">
                <form method="GET" class="flex flex-col md:flex-row items-end gap-5">
                    <div class="w-full md:w-1/3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pencarian Aksi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" name="action" placeholder="Contoh: create_user, delete..." value="{{ request('action') }}"
                                class="w-full pl-10 pr-4 py-3 bg-slate-800/50 text-slate-100 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all placeholder-slate-500">
                        </div>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" style="color-scheme: dark;"
                            class="w-full px-4 py-3 bg-slate-800/50 text-slate-300 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all">
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" style="color-scheme: dark;"
                            class="w-full px-4 py-3 bg-slate-800/50 text-slate-300 border border-slate-700 rounded-xl focus:outline-none focus:ring-2 focus:ring-sky-500/50 focus:border-sky-500 transition-all">
                    </div>
                    <div class="w-full md:w-auto flex gap-3">
                        <button type="submit" class="flex-1 md:flex-none px-6 py-3 bg-sky-600 text-white font-bold rounded-xl hover:bg-sky-500 shadow-[0_0_15px_rgba(14,165,233,0.3)] hover:shadow-[0_0_20px_rgba(14,165,233,0.5)] transition-all flex items-center justify-center gap-2">
                            Filter
                        </button>
                        <a href="{{ route('admin.logs.index') }}" class="flex-1 md:flex-none px-6 py-3 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:bg-slate-700 hover:text-white transition-all text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-slate-900/80 backdrop-blur-md rounded-2xl shadow-xl border border-slate-800 overflow-hidden mx-4 sm:mx-0">
                <div class="px-6 py-5 border-b border-slate-700/50 bg-slate-800/30 flex items-center gap-3">
                    <div class="p-1.5 bg-slate-800 rounded-lg border border-slate-600">
                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    </div>
                    <h3 class="font-bold text-white text-lg tracking-wide">Daftar Log Riwayat</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-800/50 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-700/50">
                            <tr>
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">User Pelaku</th>
                                <th class="px-6 py-4">Aksi / Modul</th>
                                <th class="px-6 py-4">Deskripsi Singkat</th>
                                <th class="px-6 py-4 text-right">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @forelse ($logs as $log)
                                @php
                                    // Logika warna badge berdasarkan nama aksi (Smart Badge)
                                    $actionStr = strtolower($log->action);
                                    $actionColor = 'slate';
                                    
                                    if (str_contains($actionStr, 'create') || str_contains($actionStr, 'store') || str_contains($actionStr, 'add')) {
                                        $actionColor = 'emerald';
                                    } elseif (str_contains($actionStr, 'update') || str_contains($actionStr, 'edit') || str_contains($actionStr, 'modify')) {
                                        $actionColor = 'amber';
                                    } elseif (str_contains($actionStr, 'delete') || str_contains($actionStr, 'remove') || str_contains($actionStr, 'destroy')) {
                                        $actionColor = 'rose';
                                    } elseif (str_contains($actionStr, 'login') || str_contains($actionStr, 'auth')) {
                                        $actionColor = 'sky';
                                    } else {
                                        $actionColor = 'indigo';
                                    }
                                @endphp
                                <tr class="hover:bg-slate-800/40 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-slate-200 font-bold font-mono text-xs">{{ $log->created_at->format('d M Y') }}</div>
                                        <div class="text-slate-500 font-mono text-xs mt-1">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($log->user)
                                                <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-600 flex items-center justify-center flex-shrink-0">
                                                    <span class="text-slate-300 font-bold text-xs">{{ substr($log->user->name, 0, 1) }}</span>
                                                </div>
                                                <span class="font-bold text-slate-200 group-hover:text-white transition-colors">{{ $log->user->name }}</span>
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-rose-500/20 border border-rose-500/30 flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                </div>
                                                <span class="font-bold text-rose-400 group-hover:text-rose-300 transition-colors italic">System / Auto</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-black tracking-wider bg-{{ $actionColor }}-500/10 text-{{ $actionColor }}-400 border border-{{ $actionColor }}-500/20 uppercase">
                                            {{ str_replace('_', ' ', $log->action) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-slate-400 text-sm truncate max-w-xs" title="{{ $log->description }}">
                                            {{ \Illuminate\Support\Str::limit($log->description, 60, '...') }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.logs.show', $log) }}" class="inline-flex items-center justify-center p-2 bg-sky-500/10 hover:bg-sky-500/20 text-sky-400 rounded-lg border border-sky-500/20 transition-colors" title="Lihat Detail Log">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <div class="w-16 h-16 mb-4 bg-slate-800/50 border border-slate-700/50 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <p class="font-bold text-slate-300 text-lg">Log Kosong</p>
                                            <p class="text-sm mt-1">Tidak ada catatan aktivitas yang sesuai dengan filter Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 px-4 sm:px-0">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-app-layout>