<x-app-layout>
    <div class="min-h-screen bg-slate-950 py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-xs font-black uppercase tracking-[0.2em] text-indigo-400">Workspace</p>
                <h1 class="mt-2 text-3xl font-black text-white">Meja Kerja</h1>
                <p class="mt-2 text-slate-400">Tugas yang sedang Anda kerjakan.</p>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm font-semibold text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/80 shadow-xl backdrop-blur-md">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead class="bg-slate-800/50 text-xs font-semibold text-slate-400 uppercase tracking-wider border-b border-slate-700/50">
                            <tr>
                                <th class="px-6 py-4">Tiket</th>
                                <th class="px-6 py-4">Pelanggan</th>
                                <th class="px-6 py-4">Tipe</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @forelse ($tasks as $task)
                                @php
                                    $typeBadge = match($task->type) {
                                        'survey' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                        'installation' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                        'repair' => 'bg-rose-500/10 text-rose-400 border-rose-500/20',
                                        default => 'bg-sky-500/10 text-sky-400 border-sky-500/20',
                                    };
                                    $statusBadge = match($task->status) {
                                        'in_progress' => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                        'assigned' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                        'completed', 'closed' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                        default => 'bg-slate-800 text-slate-300 border-slate-700',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-800/40 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="px-2.5 py-1 bg-slate-800 border border-slate-700 rounded-md inline-block text-slate-300 font-bold text-xs tracking-wider">
                                            #{{ $task->id }}
                                        </div>
                                        <div class="mt-1 font-semibold text-white group-hover:text-indigo-400 transition-colors">
                                            {{ $task->subject ?: 'Tugas lapangan' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-200">{{ $task->customer?->user?->name ?? '-' }}</div>
                                        @if($task->customer?->phone)
                                            <div class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                                <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                                {{ $task->customer->phone }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border {{ $typeBadge }}">
                                            {{ $task->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border {{ $statusBadge }}">
                                            {{ str_replace('_', ' ', $task->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('technician.ticket.show', $task) }}" class="inline-flex items-center px-3 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white text-xs font-bold rounded-xl border border-slate-700 transition-all">
                                                Detail
                                            </a>
                                            <a href="{{ route('technician.process.show', $task) }}" class="inline-flex items-center px-3.5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl shadow-[0_0_12px_rgba(79,70,229,0.3)] hover:shadow-[0_0_18px_rgba(79,70,229,0.5)] transform hover:-translate-y-0.5 transition-all duration-200">
                                                Kerjakan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">Belum ada tugas aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($tasks->hasPages())
                    <div class="px-6 border-t border-slate-800/80 bg-slate-900/40">
                        {{ $tasks->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>