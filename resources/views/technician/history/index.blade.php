<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8"><p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-400">Performance</p><h1 class="mt-2 text-3xl font-black text-white">Riwayat Pekerjaan</h1><p class="mt-2 text-slate-400">Daftar pekerjaan yang telah Anda selesaikan.</p></div>
            <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/80 shadow-xl backdrop-blur-md">
                <div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="border-b border-slate-800 text-xs uppercase tracking-wider text-slate-500"><tr><th class="px-6 py-4">Tanggal Selesai</th><th class="px-6 py-4">Tipe Pekerjaan</th><th class="px-6 py-4">Pelanggan</th><th class="px-6 py-4">Status Akhir</th></tr></thead>
                    <tbody class="divide-y divide-slate-800/70">@forelse ($tickets as $ticket)<tr class="text-slate-300"><td class="px-6 py-5">{{ $ticket->completed_at?->format('d M Y H:i') ?? '-' }}</td><td class="px-6 py-5 capitalize">{{ $ticket->type }}</td><td class="px-6 py-5 font-semibold text-white">{{ $ticket->customer?->user?->name ?? '-' }}</td><td class="px-6 py-5"><span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-bold capitalize text-emerald-400">{{ $ticket->status }}</span></td></tr>@empty<tr><td colspan="4" class="px-6 py-12 text-center text-slate-400">Belum ada riwayat pekerjaan.</td></tr>@endforelse</tbody>
                </table></div>
            </div>
        </div>
    </div>
</x-app-layout>