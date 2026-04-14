<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Meja Kerja Saya (Tugas Aktif)') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-sky-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header dengan statistik --}}
            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                    <p class="text-sm font-semibold text-slate-500 uppercase">Total Tugas</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $tasks->total() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
                    <p class="text-sm font-semibold text-slate-500 uppercase">Menunggu</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $tasks->where('status', 'assigned')->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
                    <p class="text-sm font-semibold text-slate-500 uppercase">Sedang Dikerjakan</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ $tasks->where('status', 'in_progress')->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                    <p class="text-sm font-semibold text-slate-500 uppercase">Selesai</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $tasks->where('status', 'resolved')->sum('status') ? $tasks->where('status', 'resolved')->count() : 0 }}</p>
                </div>
            </div>

            {{-- Tabel Tugas --}}
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">Daftar Tugas Saya</h3>
                </div>

                @if($tasks->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-100 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">ID Tugas</th>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Pelanggan</th>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Tipe</th>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Status</th>
                                    <th class="px-6 py-3 text-left font-semibold text-slate-600">Dibuat</th>
                                    <th class="px-6 py-3 text-center font-semibold text-slate-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                    <tr class="border-b border-slate-200 hover:bg-slate-50">
                                        <td class="px-6 py-4 font-mono text-blue-600 font-semibold">#{{ $task->id }}</td>
                                        <td class="px-6 py-4">
                                            <div>
                                                <p class="font-semibold text-slate-800">{{ $task->customer->user->name ?? 'N/A' }}</p>
                                                <p class="text-xs text-slate-500">{{ $task->customer->phone ?? '-' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 bg-slate-200 text-slate-700 text-xs font-semibold rounded-full">
                                                {{ ucfirst($task->type ?? 'general') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'assigned' => 'bg-yellow-100 text-yellow-700',
                                                    'in_progress' => 'bg-blue-100 text-blue-700',
                                                    'pending' => 'bg-orange-100 text-orange-700',
                                                    'resolved' => 'bg-green-100 text-green-700',
                                                    'closed' => 'bg-slate-100 text-slate-700',
                                                ];
                                                $color = $statusColors[$task->status] ?? 'bg-slate-100 text-slate-700';
                                            @endphp
                                            <span class="px-3 py-1 {{ $color }} text-xs font-semibold rounded-full">
                                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">{{ $task->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="{{ route('technician.process.show', $task) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                                Lihat Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                            <p class="text-lg">Tidak ada tugas saat ini</p>
                                            <a href="{{ route('technician.tickets.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                                                Kembali ke Jobdesk untuk mengambil tugas baru
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @if($tasks->hasPages())
                        <div class="px-6 py-4 border-t border-slate-200">
                            {{ $tasks->links() }}
                        </div>
                    @endif
                @else
                    <div class="p-8 text-center">
                        <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-slate-600 text-lg mb-4">Anda tidak memiliki tugas aktif</p>
                        <a href="{{ route('technician.tickets.index') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Ambil Tugas Baru
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
