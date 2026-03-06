<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Laporan (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded shadow-sm">
                    <p class="font-bold text-blue-800">Mode Edit Admin</p>
                    <p class="text-sm text-blue-600">Anda dapat memperbaiki kesalahan ketik (typo) dari laporan teknisi di sini sebelum melakukan Approve.</p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800">
                        Data Perangkat (ONU/Router)
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Merk Perangkat</label>
                            <input type="text" name="device_brand" value="{{ old('device_brand', $ticket->device_brand) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Seri (SN)</label>
                            <input type="text" name="device_sn" value="{{ old('device_sn', $ticket->device_sn) }}" class="w-full border-gray-300 rounded-lg shadow-sm font-mono text-blue-700 font-bold">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">MAC Address</label>
                            <input type="text" name="device_mac" value="{{ old('device_mac', $ticket->device_mac) }}" class="w-full border-gray-300 rounded-lg shadow-sm font-mono text-blue-700 font-bold">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800">
                        Data Jaringan
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Router Area</label>
                            <select name="router_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- Pilih Router --</option>
                                @foreach($routers as $router)
                                    <option value="{{ $router->id }}" {{ $ticket->router_id == $router->id ? 'selected' : '' }}>{{ $router->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Port ODP</label>
                            <input type="text" name="odp_port" value="{{ old('odp_port', $ticket->odp_port) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Redaman (dBm)</label>
                            <input type="text" name="dbm_signal" value="{{ old('dbm_signal', $ticket->dbm_signal) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mode Koneksi</label>
                            <select name="connection_mode" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="PPPoE" {{ $ticket->connection_mode == 'PPPoE' ? 'selected' : '' }}>PPPoE</option>
                                <option value="Static IP" {{ $ticket->connection_mode == 'Static IP' ? 'selected' : '' }}>Static IP</option>
                                <option value="DHCP" {{ $ticket->connection_mode == 'DHCP' ? 'selected' : '' }}>DHCP</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800">
                        Akun Internet & Hasil Test
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username PPPoE</label>
                            <input type="text" name="pppoe_username" value="{{ old('pppoe_username', $ticket->pppoe_username) }}" class="w-full border-gray-300 rounded-lg shadow-sm font-mono font-bold text-green-600">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password PPPoE</label>
                            <input type="text" name="pppoe_password" value="{{ old('pppoe_password', $ticket->pppoe_password) }}" class="w-full border-gray-300 rounded-lg shadow-sm font-mono">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Speed Test (Mbps)</label>
                            <input type="text" name="speed_test_result" value="{{ old('speed_test_result', $ticket->speed_test_result) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition">
                        Simpan Perubahan Admin
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>