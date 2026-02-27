<x-app-layout>
    <div class="py-10 bg-sky-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Tugas Saya (My Tasks)</h2>
                    <p class="text-gray-500 mt-1">Kelola pekerjaan instalasi yang sedang berjalan dan selesai.</p>
                </div>
                <a href="{{ route('technician.tickets.index') }}" class="text-sm font-bold text-sky-600 hover:text-sky-800 flex items-center bg-white px-4 py-2 rounded-lg shadow-sm border border-sky-100 transition">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Cari Tugas Baru
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                @forelse($tickets as $ticket)
                    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300 flex flex-col relative">
                        
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center {{ $ticket->status == 'resolved' || $ticket->status == 'closed' ? 'bg-green-50' : 'bg-yellow-50' }}">
                            <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide
                                {{ $ticket->status == 'assigned' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $ticket->status == 'in_progress' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $ticket->status == 'resolved' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $ticket->status == 'closed' ? 'bg-gray-200 text-gray-700' : '' }}">
                                {{ str_replace('_', ' ', $ticket->status) }}
                            </span>
                            <span class="text-xs text-gray-500 font-mono">{{ $ticket->updated_at->format('d M, H:i') }}</span>
                        </div>

                        <div class="p-6 flex-grow">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $ticket->subject }}</h3>
                            <p class="text-xs text-gray-400 mb-4">Tiket ID: #{{ $ticket->id }}</p>

                            <div class="space-y-3 border-t border-gray-50 pt-4">
                                <div class="flex items-start text-sm text-gray-600">
                                    <div class="flex-shrink-0 w-8 text-center">👤</div>
                                    <span class="font-semibold">{{ $ticket->customer->user->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="flex items-start text-sm text-gray-600">
                                    <div class="flex-shrink-0 w-8 text-center">📍</div>
                                    <span class="line-clamp-2">{{ Str::limit($ticket->customer->address_installation, 50) }}</span>
                                </div>
                                <div class="flex items-start text-sm text-gray-600">
                                    <div class="flex-shrink-0 w-8 text-center">📦</div>
                                    <span class="text-sky-600 font-bold">{{ $ticket->customer->lead->package->name ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            @if($ticket->status == 'assigned' || $ticket->status == 'in_progress')
                                <a href="{{ route('technician.process.input', $ticket->id) }}" class="flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Input Laporan
                                </a>
                            @else
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="{{ route('technician.process.show', $ticket->id) }}" class="flex items-center justify-center bg-white border border-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-50 transition shadow-sm">
                                        <svg class="w-5 h-5 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Lihat
                                    </a>
                                    @if($ticket->status !== 'closed')
                                        <a href="{{ route('technician.process.edit', $ticket->id) }}" class="flex items-center justify-center bg-yellow-100 text-yellow-700 border border-yellow-200 font-bold py-2 px-4 rounded-lg hover:bg-yellow-200 transition shadow-sm">
                                            Revisi
                                        </a>
                                    @else
                                        <div class="flex items-center justify-center bg-gray-100 text-gray-400 border border-gray-200 font-bold py-2 px-4 rounded-lg cursor-not-allowed text-xs">
                                            Terkunci
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
                        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <h3 class="text-lg font-medium text-gray-900">Belum ada tugas yang diambil</h3>
                        <p class="text-gray-500 mb-6">Silakan ambil tugas baru di Jobdesk.</p>
                        <a href="{{ route('technician.tickets.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition shadow-lg">
                            Ke Bursa Tugas
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>