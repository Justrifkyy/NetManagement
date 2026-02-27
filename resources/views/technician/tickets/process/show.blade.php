<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Laporan Instalasi') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex flex-col md:flex-row justify-between items-center px-4 sm:px-0">
                <a href="{{ route('technician.process.index') }}" class="text-gray-600 hover:text-gray-900 font-bold flex items-center mb-4 md:mb-0">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Tugas Saya
                </a>
                
                <div class="flex space-x-3">
                    @if($ticket->status !== 'closed')
                        <a href="{{ route('technician.process.edit', $ticket->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center border border-yellow-600">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Revisi Data
                        </a>
                    @endif
                    <span class="px-4 py-2 rounded-lg text-sm font-bold uppercase tracking-wide bg-green-100 text-green-800 border border-green-200">
                        Status: {{ $ticket->status }}
                    </span>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-xl p-6 mb-8 border-l-4 border-green-500 relative">
                <h3 class="text-2xl font-bold text-gray-900">{{ $ticket->customer->user->name ?? 'Pelanggan N/A' }}</h3>
                <p class="text-gray-600 mt-1">{{ $ticket->customer->address_installation }}</p>
                <div class="mt-4 text-sm text-gray-500 flex flex-wrap gap-4">
                    <span class="font-bold bg-gray-100 px-3 py-1 rounded">📅 Selesai: {{ $ticket->completed_at ? $ticket->completed_at->format('d F Y, H:i') : '-' }}</span>
                    <span class="font-bold bg-blue-50 text-blue-700 px-3 py-1 rounded border border-blue-100">📦 Paket: {{ $ticket->customer->lead->package->name ?? '-' }}</span>
                </div>

                @if($ticket->final_technician_notes && str_contains($ticket->final_technician_notes, '[REVISI ADMIN]'))
                    <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded text-sm">
                        <strong>PERHATIAN (Revisi dari Admin):</strong><br>
                        {{ explode('[REVISI ADMIN]:', $ticket->final_technician_notes)[1] ?? 'Mohon perbaiki data.' }}
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-100">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 font-bold text-gray-700">A. DATA SURVEY</div>
                    <div class="p-5 space-y-3">
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Status Survey</span>
                            <span class="font-bold text-gray-800">{{ $ticket->survey_status ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Tanggal Survey</span>
                            <span class="font-bold text-gray-800">{{ $ticket->survey_date ? $ticket->survey_date->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="text-sm">
                            <span class="block text-gray-500 mb-1">Catatan Survey</span>
                            <p class="bg-gray-50 p-2 rounded border border-gray-100">{{ $ticket->survey_notes ?? '-' }}</p>
                        </div>
                        @if($ticket->location_photo_path)
                            <div class="mt-2">
                                <span class="text-xs text-gray-400">Foto Lokasi:</span>
                                <a href="{{ Storage::url($ticket->location_photo_path) }}" target="_blank" class="block mt-1 text-blue-600 hover:underline text-xs">Lihat Foto</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-100">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 font-bold text-gray-700">B. DATA INSTALASI</div>
                    <div class="p-5 space-y-3">
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Tanggal Pasang</span>
                            <span class="font-bold text-gray-800">{{ $ticket->installation_date ? $ticket->installation_date->format('d/m/Y') : '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Jenis Koneksi</span>
                            <span class="font-bold text-gray-800">{{ $ticket->connection_type ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Panjang Kabel</span>
                            <span class="font-bold text-gray-800">{{ $ticket->cable_length ?? '0' }} Meter</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Posisi Perangkat</span>
                            <span class="font-bold text-gray-800">{{ $ticket->mounting_position ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-100">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 font-bold text-gray-700">C. PERANGKAT (ONT)</div>
                    <div class="p-5 space-y-3">
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Merk / Tipe</span>
                            <span class="font-bold text-gray-800">{{ $ticket->device_brand ?? '-' }} ({{ $ticket->device_type ?? '-' }})</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">SN Perangkat</span>
                            <span class="font-mono bg-yellow-50 px-1 rounded">{{ $ticket->device_sn ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">MAC Address</span>
                            <span class="font-mono bg-yellow-50 px-1 rounded">{{ $ticket->device_mac ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Kondisi</span>
                            <span class="font-bold text-gray-800">{{ $ticket->device_condition ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-100">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 font-bold text-gray-700">D. JARINGAN & AKUN</div>
                    <div class="p-5 space-y-3">
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Router Area</span>
                            <span class="font-bold text-gray-800">{{ $ticket->router->name ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Port ODP</span>
                            <span class="font-bold text-gray-800">{{ $ticket->odp_port ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Redaman</span>
                            <span class="font-bold {{ floatval($ticket->dbm_signal) < -25 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $ticket->dbm_signal ?? '-' }} dBm
                            </span>
                        </div>
                        <div class="border-t border-dashed border-gray-200 my-2 pt-2"></div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">PPPoE User</span>
                            <span class="font-mono font-bold text-blue-600">{{ $ticket->pppoe_username ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-2 text-sm">
                            <span class="text-gray-500">Password</span>
                            <span class="font-mono text-gray-400">********</span>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-100">
                    <div class="px-5 py-3 bg-gray-50 border-b border-gray-100 font-bold text-gray-700">E. HASIL TEST & BUKTI FOTO</div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <span class="block text-gray-500 text-xs uppercase font-bold">Speed Test Result</span>
                            <span class="block text-xl font-extrabold text-blue-700 mt-1">{{ $ticket->speed_test_result ?? 'N/A' }}</span>
                            <span class="text-xs text-gray-500 block mt-1">Latency: {{ $ticket->latency ?? '-' }}</span>
                        </div>

                        <div class="relative group h-40 bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                            @if($ticket->evidence_photo_path)
                                <img src="{{ Storage::url($ticket->evidence_photo_path) }}" class="w-full h-full object-cover">
                                <a href="{{ Storage::url($ticket->evidence_photo_path) }}" target="_blank" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition text-white font-bold">
                                    Lihat Bukti
                                </a>
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 text-xs">Tidak Ada Foto</div>
                            @endif
                            <span class="absolute bottom-0 left-0 bg-black bg-opacity-70 text-white text-xs px-3 py-1 font-semibold">Bukti Instalasi</span>
                        </div>

                        <div class="relative group h-40 bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                            @if($ticket->speedtest_photo_path)
                                <img src="{{ Storage::url($ticket->speedtest_photo_path) }}" class="w-full h-full object-cover">
                                <a href="{{ Storage::url($ticket->speedtest_photo_path) }}" target="_blank" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition text-white font-bold">
                                    Lihat Hasil
                                </a>
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400 text-xs">Tidak Ada Foto</div>
                            @endif
                            <span class="absolute bottom-0 left-0 bg-black bg-opacity-70 text-white text-xs px-3 py-1 font-semibold">Foto Speedtest</span>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>