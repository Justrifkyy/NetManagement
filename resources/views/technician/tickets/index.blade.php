<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Bursa Tugas (Jobdesk)</h2>
                    <p class="text-gray-500 mt-1">Daftar tiket instalasi baru dari Marketing yang belum diambil.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('technician.process.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition">
                        Lihat Tugas Saya &rarr;
                    </a>
                </div>
            </div>

            @if(session('error'))
                <div class="mb-6 px-4 sm:px-0">
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                        <p class="font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 sm:px-0">
                @forelse($tickets as $ticket)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300 relative group flex flex-col justify-between">
                        
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700 uppercase tracking-wide border border-green-200">
                                {{ $ticket->status }}
                            </span>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-3 bg-blue-50 text-blue-600 rounded-lg mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 leading-tight">{{ $ticket->subject }}</h3>
                                    <span class="text-xs text-gray-400">{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="space-y-3 border-t border-gray-100 pt-4">
                                <div class="flex items-start text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span class="font-medium">{{ $ticket->customer->user->name ?? 'Pelanggan Tidak Diketahui' }}</span>
                                </div>
                                <div class="flex items-start text-sm text-gray-600">
                                    <svg class="w-5 h-5 mr-2 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span class="line-clamp-2">{{ Str::limit($ticket->customer->address_installation, 60) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 mt-auto">
                            <a href="{{ route('technician.tickets.show', $ticket->id) }}" class="block w-full text-center bg-white border border-gray-300 hover:border-blue-500 hover:text-blue-600 text-gray-700 font-bold py-2 px-4 rounded-lg transition shadow-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gray-50 mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Belum ada tugas baru</h3>
                        <p class="mt-1 text-gray-500">Semua tiket instalasi sudah diambil atau belum ada request baru dari Marketing.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>