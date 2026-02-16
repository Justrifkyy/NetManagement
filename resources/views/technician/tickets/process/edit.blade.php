<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Revisi Laporan Instalasi') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('technician.process.update', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-yellow-50 border-b border-yellow-200 font-bold text-yellow-800 flex items-center">
                        <span class="bg-yellow-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">A</span>
                        DATA SURVEY (EDIT MODE)
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Survey</label>
                            <select name="survey_status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="Layak" {{ $ticket->survey_status == 'Layak' ? 'selected' : '' }}>Layak Pasang</option>
                                <option value="Tidak Layak" {{ $ticket->survey_status == 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak</option>
                                <option value="Pending" {{ $ticket->survey_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Survey</label>
                            <input type="date" name="survey_date" value="{{ old('survey_date', $ticket->survey_date ? $ticket->survey_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Survey Singkat</label>
                            <textarea name="survey_notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm">{{ old('survey_notes', $ticket->survey_notes) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kendala Lokasi</label>
                            <input type="text" name="location_obstacle" value="{{ old('location_obstacle', $ticket->location_obstacle) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Update Foto Lokasi (Opsional)</label>
                            <input type="file" name="location_photo" accept="image/*" class="w-full text-sm text-gray-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-yellow-50 border-b border-yellow-200 font-bold text-yellow-800 flex items-center">
                        <span class="bg-yellow-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">B</span>
                        DATA INSTALASI
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Instalasi</label>
                            <input type="date" name="installation_date" value="{{ old('installation_date', $ticket->installation_date ? $ticket->installation_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Koneksi</label>
                            <select name="connection_type" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="Fiber Optic" {{ $ticket->connection_type == 'Fiber Optic' ? 'selected' : '' }}>Fiber Optic (FO)</option>
                                <option value="Wireless" {{ $ticket->connection_type == 'Wireless' ? 'selected' : '' }}>Wireless (PTP)</option>
                                <option value="LAN" {{ $ticket->connection_type == 'LAN' ? 'selected' : '' }}>Kabel LAN</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Panjang Kabel (Meter)</label>
                            <input type="number" name="cable_length" value="{{ old('cable_length', $ticket->cable_length) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Posisi Pemasangan</label>
                            <input type="text" name="mounting_position" value="{{ old('mounting_position', $ticket->mounting_position) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Instalasi</label>
                            <select name="installation_status" required class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="Berhasil" {{ $ticket->installation_status == 'Berhasil' ? 'selected' : '' }}>Berhasil</option>
                                <option value="Gagal" {{ $ticket->installation_status == 'Gagal' ? 'selected' : '' }}>Gagal / Pending</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Instalasi</label>
                            <textarea name="installation_notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm">{{ old('installation_notes', $ticket->installation_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-yellow-50 border-b border-yellow-200 font-bold text-yellow-800 flex items-center">
                        <span class="bg-yellow-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">C</span>
                        DATA PERANGKAT
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Perangkat</label>
                            <input type="text" name="device_type" value="{{ old('device_type', $ticket->device_type) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Merk Perangkat</label>
                            <input type="text" name="device_brand" value="{{ old('device_brand', $ticket->device_brand) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Seri (SN)</label>
                            <input type="text" name="device_sn" value="{{ old('device_sn', $ticket->device_sn) }}" class="w-full border-gray-300 rounded-lg shadow-sm font-mono">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">MAC Address</label>
                            <input type="text" name="device_mac" value="{{ old('device_mac', $ticket->device_mac) }}" class="w-full border-gray-300 rounded-lg shadow-sm font-mono">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                            <select name="device_condition" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="Baru" {{ $ticket->device_condition == 'Baru' ? 'selected' : '' }}>Baru</option>
                                <option value="Bekas" {{ $ticket->device_condition == 'Bekas' ? 'selected' : '' }}>Bekas</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-yellow-50 border-b border-yellow-200 font-bold text-yellow-800 flex items-center">
                        <span class="bg-yellow-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">D</span>
                        DATA JARINGAN
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">Port / Interface</label>
                            <input type="text" name="port_interface" value="{{ old('port_interface', $ticket->port_interface) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">VLAN ID</label>
                            <input type="text" name="vlan_id" value="{{ old('vlan_id', $ticket->vlan_id) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Port ODP</label>
                            <input type="text" name="odp_port" value="{{ old('odp_port', $ticket->odp_port) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">OLT / AP Sumber</label>
                            <input type="text" name="olt_source" value="{{ old('olt_source', $ticket->olt_source) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
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
                    <div class="px-6 py-4 bg-yellow-50 border-b border-yellow-200 font-bold text-yellow-800 flex items-center">
                        <span class="bg-yellow-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">E</span>
                        AKUN & HASIL TEST
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username PPPoE</label>
                            <input type="text" name="pppoe_username" value="{{ old('pppoe_username', $ticket->pppoe_username) }}" class="w-full border-gray-300 rounded-lg shadow-sm font-mono">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password PPPoE</label>
                            <input type="text" name="pppoe_password" value="{{ old('pppoe_password', $ticket->pppoe_password) }}" class="w-full border-gray-300 rounded-lg shadow-sm font-mono">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Koneksi</label>
                            <select name="connectivity_status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="Connected" {{ $ticket->connectivity_status == 'Connected' ? 'selected' : '' }}>Connected</option>
                                <option value="No Internet" {{ $ticket->connectivity_status == 'No Internet' ? 'selected' : '' }}>No Internet</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Redaman (dBm)</label>
                            <input type="text" name="dbm_signal" value="{{ old('dbm_signal', $ticket->dbm_signal) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Speed Test (Mbps)</label>
                            <input type="text" name="speed_test_result" value="{{ old('speed_test_result', $ticket->speed_test_result) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Latency (ms)</label>
                            <input type="text" name="latency" value="{{ old('latency', $ticket->latency) }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Update Foto Speedtest (Opsional)</label>
                            <input type="file" name="speedtest_photo" accept="image/*" class="w-full text-sm text-gray-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Update Foto Bukti Instalasi (Opsional)</label>
                            <input type="file" name="evidence_photo" accept="image/*" class="w-full text-sm text-gray-500">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-yellow-200">
                    <div class="px-6 py-4 bg-yellow-50 border-b border-yellow-200 font-bold text-yellow-800 flex items-center">
                        <span class="bg-yellow-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">G</span>
                        DATA SERAH TERIMA
                    </div>
                    <div class="p-6 grid grid-cols-1 gap-6">
                        <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                            <input type="checkbox" name="internet_active_confirmation" id="active_confirm" class="rounded border-gray-300 text-yellow-600 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50 w-5 h-5" value="1" {{ $ticket->internet_active_confirmation ? 'checked' : '' }}>
                            <label for="active_confirm" class="ml-3 block text-sm font-bold text-gray-900 cursor-pointer">
                                Konfirmasi Internet AKTIF
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Serah Terima</label>
                            <input type="date" name="handover_date" value="{{ old('handover_date', $ticket->handover_date ? $ticket->handover_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Akhir Teknisi</label>
                            <textarea name="final_technician_notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm">{{ old('final_technician_notes', $ticket->final_technician_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-gray-200 md:static md:bg-transparent md:border-0 md:p-0 flex justify-end z-50">
                    <a href="{{ route('technician.process.show', $ticket->id) }}" class="mr-3 px-6 py-4 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition flex items-center">
                        Batal
                    </a>
                    <button type="submit" onclick="return confirm('Simpan perubahan data?')" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-bold rounded-xl shadow-lg hover:from-yellow-600 hover:to-orange-700 focus:outline-none focus:ring-4 focus:ring-yellow-300 transition transform hover:-translate-y-1 flex items-center justify-center">
                        Simpan Perubahan
                    </button>
                </div>
                <div class="h-24 md:hidden"></div>

            </form>
        </div>
    </div>
</x-app-layout>