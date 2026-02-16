<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tugas Tersedia') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('technician.tickets.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Bursa Tugas
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 relative">
                
                <div class="bg-green-50 border-b border-green-100 p-4 text-center">
                    <span class="text-green-800 font-bold text-sm uppercase tracking-wide flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tiket Tersedia (Open)
                    </span>
                </div>

                <div class="p-8">
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-extrabold text-gray-900">{{ $ticket->subject }}</h1>
                        <p class="text-gray-500 mt-2">Dibuat pada {{ $ticket->created_at->format('d F Y, H:i') }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-100 pt-8">
                        
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Informasi Pelanggan</h4>
                            
                            <div>
                                <span class="block text-xs text-gray-500">Nama Pelanggan</span>
                                <span class="block text-lg font-semibold text-gray-800">{{ $ticket->customer->user->name }}</span>
                            </div>

                            <div>
                                <span class="block text-xs text-gray-500">Nomor Telepon</span>
                                <span class="block text-lg font-semibold text-gray-800">{{ $ticket->customer->phone_number }}</span>
                            </div>

                            <div>
                                <span class="block text-xs text-gray-500">Paket Langganan</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 text-blue-700 font-bold text-sm">
                                    {{ $ticket->customer->lead->package->name ?? 'Paket Tidak Diketahui' }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Lokasi Instalasi</h4>
                            
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-red-500 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <p class="text-gray-700 leading-relaxed">{{ $ticket->customer->address_installation }}</p>
                                </div>
                                
                                @if($ticket->customer->coordinates)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $ticket->customer->coordinates }}" target="_blank" class="mt-4 block w-full text-center bg-white border border-gray-300 text-gray-700 font-bold py-2 rounded-lg hover:bg-gray-50 transition text-sm">
                                        Buka di Google Maps
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-gray-100">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Dengan menekan tombol di bawah, Anda bertanggung jawab untuk menyelesaikan instalasi ini. Status tiket akan berubah menjadi <strong>ASSIGNED</strong>.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('technician.tickets.claim', $ticket->id) }}" method="POST">
                            @csrf
                            <button type="submit" onclick="return confirm('Yakin ingin mengambil tugas ini?');" class="w-full flex justify-center items-center py-4 px-6 border border-transparent rounded-xl shadow-lg text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition transform hover:-translate-y-1">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                PROSES / AMBIL TUGAS
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>