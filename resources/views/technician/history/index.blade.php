<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-400">Performance</p>
                <h1 class="mt-2 text-3xl font-black text-white">Riwayat Pekerjaan</h1>
                <p class="mt-2 text-slate-400">Daftar pekerjaan yang telah Anda selesaikan.</p>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/80 shadow-xl backdrop-blur-md">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead class="bg-slate-800/50 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-700/50">
                            <tr>
                                <th class="px-6 py-4">Tanggal Selesai</th>
                                <th class="px-6 py-4">Tipe Pekerjaan</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4 text-center">Status Akhir</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @forelse ($tickets as $ticket)
                                @php
                                    $typeBadge = match($ticket->type) {
                                        'survey' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                        'installation' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                        'repair' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                        default => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-800/40 transition-colors group">
                                    <td class="px-6 py-4 text-slate-300 font-mono text-xs">
                                        {{ $ticket->completed_at?->format('d M Y H:i') ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border {{ $typeBadge }}">
                                            {{ $ticket->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-white">
                                        {{ $ticket->customer?->user?->name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border bg-emerald-500/10 text-emerald-400 border-emerald-500/20">
                                            {{ $ticket->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('technician.ticket.show', $ticket) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold rounded-xl border border-slate-700 transition-all">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        Belum ada riwayat pekerjaan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tickets->hasPages())
                    <div class="px-6 border-t border-slate-800/80 bg-slate-900/40">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>