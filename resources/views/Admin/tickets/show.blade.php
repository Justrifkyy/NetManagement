<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Detail Laporan') }}
        </h2>
    </x-slot>

    <div x-data="{ openRejectModal: false }" class="py-10 bg-gray-50 min-h-screen relative">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center px-4 sm:px-0">
                <a href="{{ route('admin.tickets.index') }}" class="text-gray-600 hover:text-gray-900 font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Antrean QC
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-xl p-6 mb-8 border-t-4 border-blue-500">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900">{{ $ticket->customer->user->name ?? 'N/A' }}</h3>
                        <p class="text-gray-600 mt-1">{{ $ticket->customer->address_installation }}</p>
                        <div class="mt-3 flex gap-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded">Paket: {{ $ticket->customer->lead->package->name ?? '-' }}</span>
                            <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded">Teknisi: {{ $ticket->technician->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0 text-right">
                        <span class="block text-sm text-gray-500 font-bold mb-1">Status Laporan:</span>
                        <span class="inline-block px-4 py-2 rounded-lg text-sm font-bold uppercase tracking-wide bg-yellow-100 text-yellow-800 border border-yellow-200">
                            Menunggu QC
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                        Data Koneksi & Perangkat
                    </div>
                    <div class="p-5 space-y-4">
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm text-gray-500">SN Perangkat</span>
                            <span class="text-sm font-mono font-bold bg-gray-100 px-2 rounded">{{ $ticket->device_sn ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm text-gray-500">MAC Address</span>
                            <span class="text-sm font-mono font-bold bg-gray-100 px-2 rounded">{{ $ticket->device_mac ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm text-gray-500">Redaman / Signal</span>
                            <span class="text-sm font-bold {{ floatval($ticket->dbm_signal) < -25 ? 'text-red-600' : 'text-green-600' }}">{{ $ticket->dbm_signal ?? '-' }} dBm</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm text-gray-500">Router / ODP</span>
                            <span class="text-sm font-bold text-gray-800">{{ $ticket->router->name ?? '-' }} ({{ $ticket->odp_port ?? '-' }})</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-2">
                            <span class="text-sm text-gray-500">PPPoE Akun</span>
                            <span class="text-sm font-bold text-blue-600">{{ $ticket->pppoe_username ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Bukti Foto & Speedtest
                    </div>
                    <div class="p-5">
                        <div class="mb-4 bg-blue-50 p-3 rounded-lg text-center border border-blue-100">
                            <span class="text-xs text-blue-500 font-bold uppercase block mb-1">Hasil Speedtest (Ditulis Teknisi)</span>
                            <span class="text-xl font-black text-blue-700">{{ $ticket->speed_test_result ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="block text-xs text-gray-500 mb-1 font-bold">Bukti Instalasi</span>
                                @if($ticket->evidence_photo_path)
                                    <a href="{{ Storage::url($ticket->evidence_photo_path) }}" target="_blank" class="block group relative h-32 rounded-lg overflow-hidden border border-gray-300">
                                        <img src="{{ Storage::url($ticket->evidence_photo_path) }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                            <span class="text-white text-xs font-bold">Perbesar</span>
                                        </div>
                                    </a>
                                @else
                                    <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400">Tidak ada foto</div>
                                @endif
                            </div>
                            <div>
                                <span class="block text-xs text-gray-500 mb-1 font-bold">Screenshot Speedtest</span>
                                @if($ticket->speedtest_photo_path)
                                    <a href="{{ Storage::url($ticket->speedtest_photo_path) }}" target="_blank" class="block group relative h-32 rounded-lg overflow-hidden border border-gray-300">
                                        <img src="{{ Storage::url($ticket->speedtest_photo_path) }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                            <span class="text-white text-xs font-bold">Perbesar</span>
                                        </div>
                                    </a>
                                @else
                                    <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400">Tidak ada foto</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-2 bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-200 font-bold text-gray-800">
                        Catatan Teknisi
                    </div>
                    <div class="p-5 text-sm text-gray-700">
                        {!! nl2br(e($ticket->final_technician_notes ?? 'Tidak ada catatan tambahan dari teknisi.')) !!}
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-500 md:w-5/12">
                    <p>Menyetujui ini akan <strong>mengaktifkan internet pelanggan</strong> dan <strong>menerbitkan tagihan pertama</strong>. Anda juga bisa mengedit data teknis jika ada typo.</p>
                </div>
                
                <div class="flex flex-wrap gap-3 w-full md:w-auto justify-end">
                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="px-5 py-3 bg-white border-2 border-blue-500 text-blue-600 font-bold rounded-xl hover:bg-blue-50 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit Data
                    </a>

                    <button @click="openRejectModal = true" class="px-5 py-3 bg-white border-2 border-red-500 text-red-600 font-bold rounded-xl hover:bg-red-50 transition flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Tolak
                    </button>
                    
                    <form action="{{ route('admin.tickets.approve', $ticket->id) }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Aktifkan pelanggan dan terbitkan tagihan sekarang?')" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition transform hover:-translate-y-0.5 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Approve
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="h-20"></div>

        </div>

        <div x-show="openRejectModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openRejectModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="openRejectModal = false" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="openRejectModal" x-transition.scale.origin.bottom class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <form action="{{ route('admin.tickets.reject', $ticket->id) }}" method="POST">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                        Tolak Laporan (Kembalikan ke Teknisi)
                                    </h3>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-500 mb-2">Tuliskan alasan mengapa laporan ini ditolak agar teknisi dapat memperbaikinya:</p>
                                        <textarea name="reject_reason" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-sm" placeholder="Contoh: Foto speedtest buram, tolong foto ulang..." required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                                Kirim Revisi
                            </button>
                            <button type="button" @click="openRejectModal = false" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>