<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Laporan Instalasi') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-sm sm:rounded-xl p-6 mb-8 border-l-4 border-blue-600 relative overflow-hidden">
                <div class="absolute right-0 top-0 opacity-10">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900">{{ $ticket->customer->user->name }}</h3>
                <p class="text-gray-600 text-sm mt-1">{{ $ticket->customer->address_installation }}</p>
                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-xs font-bold">{{ $ticket->customer->lead->package->name ?? 'Paket N/A' }}</span>
                    <a href="https://wa.me/{{ $ticket->customer->phone_number }}" target="_blank" class="px-3 py-1 bg-green-100 text-green-800 rounded-lg text-xs font-bold flex items-center hover:bg-green-200">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        WhatsApp
                    </a>
                    @if($ticket->customer->coordinates)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $ticket->customer->coordinates }}" target="_blank" class="px-3 py-1 bg-red-100 text-red-800 rounded-lg text-xs font-bold flex items-center hover:bg-red-200">
                            Maps
                        </a>
                    @endif
                </div>
            </div>

            <form action="{{ route('technician.process.store', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">A</span>
                        DATA SURVEY
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Survey</label>
                            <select name="survey_status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Layak">Layak Pasang</option>
                                <option value="Tidak Layak">Tidak Layak</option>
                                <option value="Pending">Pending (Butuh Tiang/Ijin)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Survey</label>
                            <input type="date" name="survey_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Survey Singkat</label>
                            <textarea name="survey_notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kendala Lokasi</label>
                            <input type="text" name="location_obstacle" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Misal: Pohon tinggi, rumah terkunci">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Lokasi</label>
                            <input type="file" name="location_photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">B</span>
                        DATA INSTALASI
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Instalasi</label>
                            <input type="date" name="installation_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Koneksi</label>
                            <select name="connection_type" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Fiber Optic">Fiber Optic (FO)</option>
                                <option value="Wireless">Wireless (PTP)</option>
                                <option value="LAN">Kabel LAN</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Panjang Kabel (Meter)</label>
                            <input type="number" name="cable_length" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Posisi Pemasangan</label>
                            <input type="text" name="mounting_position" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Dinding Ruang Tamu">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Instalasi *</label>
                            <select name="installation_status" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 font-bold bg-gray-50">
                                <option value="Berhasil">Berhasil</option>
                                <option value="Gagal">Gagal / Pending</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Instalasi</label>
                            <textarea name="installation_notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">C</span>
                        DATA PERANGKAT (ONT/ROUTER)
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Perangkat</label>
                            <input type="text" name="device_type" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: ONU / Router Wifi">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Merk Perangkat</label>
                            <input type="text" name="device_brand" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="ZTE / Huawei / TP-Link">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Seri (SN)</label>
                            <input type="text" name="device_sn" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono" placeholder="ZTEGC812345...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">MAC Address</label>
                            <input type="text" name="device_mac" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono" placeholder="XX:XX:XX:XX:XX:XX">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                            <select name="device_condition" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Baru">Unit Baru</option>
                                <option value="Bekas">Unit Bekas / Refurbished</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">D</span>
                        DATA JARINGAN
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Router Area</label>
                            <select name="router_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Pilih Router --</option>
                                @foreach($routers as $router)
                                    <option value="{{ $router->id }}">{{ $router->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Port / Interface</label>
                            <input type="text" name="port_interface" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Contoh: Ether 5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">VLAN ID</label>
                            <input type="text" name="vlan_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Port ODP</label>
                            <input type="text" name="odp_port" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="ODP-A-01 / Port 3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">OLT / AP Sumber</label>
                            <input type="text" name="olt_source" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mode Koneksi</label>
                            <select name="connection_mode" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="PPPoE">PPPoE</option>
                                <option value="Static IP">Static IP</option>
                                <option value="DHCP">DHCP</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">E</span>
                        DATA AKUN INTERNET
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username PPPoE</label>
                            <input type="text" name="pppoe_username" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono bg-yellow-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password PPPoE</label>
                            <input type="text" name="pppoe_password" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 font-mono bg-yellow-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Paket Layanan (Read Only)</label>
                            <input type="text" value="{{ $ticket->customer->lead->package->name ?? 'N/A' }}" disabled class="w-full border-gray-200 bg-gray-100 rounded-lg text-gray-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Awal Layanan</label>
                            <select name="service_status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Aktif">Aktif</option>
                                <option value="Isolir">Isolir</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">F</span>
                        DATA UJI KONEKSI
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Koneksi</label>
                            <select name="connectivity_status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Connected">Connected (Internet Jalan)</option>
                                <option value="No Internet">No Internet</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Redaman (dBm)</label>
                            <input type="text" name="dbm_signal" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="-19.5 dBm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Speed Test (Mbps)</label>
                            <input type="text" name="speed_test_result" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="DL: 20 / UL: 5">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Latency (ms)</label>
                            <input type="text" name="latency" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="10 ms">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Screenshot Hasil Test</label>
                            <input type="file" name="speedtest_photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-green-200">
                    <div class="px-6 py-4 bg-green-50 border-b border-green-200 font-bold text-green-800 flex items-center">
                        <span class="bg-green-600 text-white rounded-full h-6 w-6 flex items-center justify-center text-xs mr-2">G</span>
                        DATA SERAH TERIMA
                    </div>
                    <div class="p-6 grid grid-cols-1 gap-6">
                        <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                            <input type="checkbox" name="internet_active_confirmation" id="active_confirm" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 w-5 h-5" value="1">
                            <label for="active_confirm" class="ml-3 block text-sm font-bold text-gray-900 cursor-pointer">
                                Saya mengkonfirmasi bahwa internet di lokasi pelanggan sudah AKTIF dan bisa digunakan dengan baik.
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Serah Terima</label>
                            <input type="date" name="handover_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Akhir Teknisi</label>
                            <textarea name="final_technician_notes" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Pesan untuk admin atau pelanggan..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Bukti Instalasi (Wajib)</label>
                            <input type="file" name="evidence_photo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <div class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-gray-200 md:static md:bg-transparent md:border-0 md:p-0 flex justify-end z-50">
                    <button type="submit" onclick="return confirm('Apakah semua data sudah benar?')" class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-300 transition transform hover:-translate-y-1 flex items-center justify-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan & Selesaikan
                    </button>
                </div>
                <div class="h-24 md:hidden"></div>

            </form>
        </div>
    </div>
</x-app-layout>