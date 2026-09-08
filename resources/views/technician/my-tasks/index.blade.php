<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8"><p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-400">Workspace</p><h1 class="mt-2 text-3xl font-black text-white">Meja Kerja</h1><p class="mt-2 text-slate-400">Tugas yang sedang Anda kerjakan.</p></div>
            @if (session('success'))<div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-300">{{ session('success') }}</div>@endif
            <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/80 shadow-xl backdrop-blur-md">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b border-slate-800 text-xs uppercase tracking-wider text-slate-500"><tr><th class="px-6 py-4">Tiket</th><th class="px-6 py-4">Pelanggan</th><th class="px-6 py-4">Tipe</th><th class="px-6 py-4">Status</th><th class="px-6 py-4"></th></tr></thead>
                        <tbody class="divide-y divide-slate-800/70">
                            @forelse ($tasks as $task)
                                <tr class="text-slate-300"><td class="px-6 py-5 font-bold text-white">#{{ $task->id }}<span class="mt-1 block text-xs font-normal text-slate-500">{{ $task->subject ?: 'Tugas lapangan' }}</span></td><td class="px-6 py-5">{{ $task->customer?->user?->name ?? '-' }}</td><td class="px-6 py-5 capitalize">{{ $task->type }}</td><td class="px-6 py-5"><span class="rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-bold capitalize text-indigo-400">{{ str_replace('_', ' ', $task->status) }}</span></td><td class="px-6 py-5 text-right"><a href="{{ route('technician.process.show', $task) }}" class="rounded-xl bg-indigo-500/10 px-4 py-2 font-bold text-indigo-300 hover:bg-indigo-500 hover:text-white">Kerjakan</a></td></tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada tugas aktif.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>