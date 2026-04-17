<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-black text-red-500">🎟️ Bursa Pekerjaan Gangguan</h1>
                    <p class="text-slate-400 mt-1">Daftar tiket gangguan yang tersedia untuk diambil</p>
                </div>
                <a href="{{ route('technician.dashboard') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
            </div>

            <!-- Alert Info -->
            <div class="mb-6 px-4 sm:px-0">
                <div class="bg-blue-900/40 border border-blue-500 rounded-lg p-4 flex items-start">
                    <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2z" clip-rule="evenodd"/></svg>
                    <div>
                        <p class="text-blue-200 font-semibold">Ambil Pekerjaan Gangguan</p>
                        <p class="text-blue-300 text-sm mt-1">Klik tombol "Ambil Tugas" untuk mengambil tiket dan mulai penanganan</p>
                    </div>
                </div>
            </div>

            <!-- Tickets Table -->
            <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden mx-4 sm:mx-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-700">
                        <thead class="bg-slate-900 border-b border-slate-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">ID / Subjek</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Dibuat</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-slate-700/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                                            <div>
                                                <div class="font-bold text-white">#{{ $ticket->id }}</div>
                                                <div class="text-sm text-slate-400">{{ $ticket->subject }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-white">{{ $ticket->customer->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-slate-400">{{ $ticket->customer->phone_number ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                            @switch($ticket->type)
                                                @case('repair')
                                                    bg-orange-900 text-orange-200
                                                    @break
                                                @case('installation')
                                                    bg-green-900 text-green-200
                                                    @break
                                                @case('survey')
                                                    bg-blue-900 text-blue-200
                                                    @break
                                                @default
                                                    bg-slate-700 text-slate-100
                                            @endswitch
                                        ">
                                            {{ ucfirst($ticket->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                        {{ $ticket->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <form action="{{ route('technician.ticket.claim', $ticket->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 text-slate-900 font-bold text-sm rounded-lg hover:from-yellow-400 hover:to-yellow-500 shadow-md transform hover:-translate-y-0.5 transition">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                Ambil Tugas
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-green-900/30 text-green-400 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="font-bold text-slate-300 text-lg">Tidak ada tiket tersedia</p>
                                            <p class="text-slate-400 text-sm mt-1">Semua tiket gangguan sudah diambil teknisi lain</p>
                                            <a href="{{ route('technician.process.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-slate-700 text-slate-300 font-semibold rounded-lg hover:bg-slate-600 transition">
                                                Lihat Pekerjaan Saya →
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 px-4 sm:px-0 grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('technician.process.index') }}" class="bg-slate-800 border border-slate-700 rounded-xl p-6 hover:border-yellow-500 transition">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-400 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-white">Meja Kerja Saya</p>
                            <p class="text-sm text-slate-400">Tugas yang sedang dikerjakan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('technician.dashboard') }}" class="bg-slate-800 border border-slate-700 rounded-xl p-6 hover:border-yellow-500 transition">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-400 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l-7-4m0 0l-2-3m2 3v10a1 1 0 001 1h2a1 1 0 001-1v-10m0 0l7-4"></path></svg>
                        </div>
                        <div>
                            <p class="font-bold text-white">Dashboard</p>
                            <p class="text-sm text-slate-400">Ringkasan aktivitas</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
