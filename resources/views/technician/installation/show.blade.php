<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">📋 Detail Instalasi</h1>
                        <p class="text-slate-400 mt-1">{{ $installation->lead->name }}</p>
                    </div>
                    <div class="space-x-3">
                        <a href="{{ route('technician.installation.index') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 mb-8 px-4 sm:px-0">
                <a href="#instalasi" class="bg-yellow-400 text-slate-900 font-bold py-2 px-4 rounded-lg text-center text-sm">🔨 Instalasi</a>
                <a href="#device" class="bg-slate-700 text-yellow-300 font-bold py-2 px-4 rounded-lg text-center text-sm">🖥️ Perangkat</a>
                <a href="#network" class="bg-slate-700 text-yellow-300 font-bold py-2 px-4 rounded-lg text-center text-sm">🌐 Jaringan</a>
                <a href="#test" class="bg-slate-700 text-yellow-300 font-bold py-2 px-4 rounded-lg text-center text-sm">⚡ Uji Koneksi</a>
            </div>

            <!-- Installation Data -->
            <div id="instalasi" class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 p-6 mb-8 mx-4 sm:mx-0">
                <h3 class="text-xl font-bold text-yellow-400 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-yellow-400 text-slate-900 rounded-full flex items-center justify-center mr-3 font-bold">1</span>
                    Data Instalasi
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-slate-400 text-sm">Tanggal Instalasi</p>
                        <p class="text-yellow-300 font-bold">{{ $installation->installation_date?->format('d M Y') ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">Jenis Koneksi</p>
                        <p class="text-yellow-300 font-bold">{{ $installation->connection_type == 'fiber' ? '🔌 Fiber' : '📡 Wireless' }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">Panjang Kabel</p>
                        <p class="text-yellow-300 font-bold">{{ $installation->cable_length ?? '-' }} meter</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">Status Instalasi</p>
                        <p class="text-yellow-300 font-bold">
                            @if($installation->installation_status == 'berhasil')
                                ✅ Berhasil
                            @elseif($installation->installation_status == 'gagal')
                                ❌ Gagal
                            @else
                                ⏳ Pending
                            @endif
                        </p>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-700">
                    <p class="text-slate-400 text-sm">Posisi Pemasangan</p>
                    <p class="text-yellow-300 mt-2">{{ $installation->device_placement ?? '-' }}</p>
                </div>
                @if($installation->installation_notes)
                    <div class="mt-6 pt-6 border-t border-slate-700">
                        <p class="text-slate-400 text-sm">Catatan</p>
                        <p class="text-yellow-300 mt-2">{{ $installation->installation_notes }}</p>
                    </div>
                @endif
                <div class="mt-6 pt-6 border-t border-slate-700">
                    <a href="{{ route('technician.installation.create', $installation->lead_id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">✏️ Edit</a>
                </div>
            </div>

            <!-- Device Data -->
            <div id="device" class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 p-6 mb-8 mx-4 sm:mx-0">
                <h3 class="text-xl font-bold text-yellow-400 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-yellow-400 text-slate-900 rounded-full flex items-center justify-center mr-3 font-bold">2</span>
                    Data Perangkat
                </h3>
                @if($installation->deviceConfig)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-slate-400 text-sm">Jenis Perangkat</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->deviceConfig->device_type }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">Merk</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->deviceConfig->device_brand }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">Serial Number</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->deviceConfig->serial_number }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">MAC Address</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->deviceConfig->mac_address }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">Kondisi</p>
                            <p class="text-yellow-300 font-bold">{{ ucfirst(str_replace('_', ' ', $installation->deviceConfig->device_condition)) }}</p>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-slate-700">
                        <a href="{{ route('technician.device.form', $installation->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">✏️ Edit</a>
                    </div>
                @else
                    <div class="bg-slate-700/50 border border-dashed border-slate-600 rounded-lg p-4">
                        <p class="text-slate-400 text-center mb-4">Belum ada data perangkat</p>
                        <a href="{{ route('technician.device.form', $installation->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold py-2 px-4 rounded-lg inline-block w-full text-center">
                            + Tambah Data Perangkat
                        </a>
                    </div>
                @endif
            </div>

            <!-- Network Data -->
            <div id="network" class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 p-6 mb-8 mx-4 sm:mx-0">
                <h3 class="text-xl font-bold text-yellow-400 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-yellow-400 text-slate-900 rounded-full flex items-center justify-center mr-3 font-bold">3</span>
                    Konfigurasi Jaringan
                </h3>
                @if($installation->networkConfig)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-slate-400 text-sm">Router Area</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->networkConfig->router_area }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">Port/Interface</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->networkConfig->port_interface }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">VLAN ID</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->networkConfig->vlan_id ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">OLT/Access Point</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->networkConfig->olt_access_point }}</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">Mode Koneksi</p>
                            <p class="text-yellow-300 font-bold">{{ strtoupper($installation->networkConfig->connection_mode) }}</p>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-slate-700">
                        <a href="{{ route('technician.network.form', $installation->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">✏️ Edit</a>
                    </div>
                @else
                    <div class="bg-slate-700/50 border border-dashed border-slate-600 rounded-lg p-4">
                        <p class="text-slate-400 text-center mb-4">Belum ada konfigurasi jaringan</p>
                        <a href="{{ route('technician.network.form', $installation->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold py-2 px-4 rounded-lg inline-block w-full text-center">
                            + Tambah Konfigurasi Jaringan
                        </a>
                    </div>
                @endif
            </div>

            <!-- Connection Test -->
            <div id="test" class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 p-6 mx-4 sm:mx-0">
                <h3 class="text-xl font-bold text-yellow-400 mb-6 flex items-center">
                    <span class="w-8 h-8 bg-yellow-400 text-slate-900 rounded-full flex items-center justify-center mr-3 font-bold">4</span>
                    Uji Koneksi
                </h3>
                @if($installation->connectionTest)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-slate-400 text-sm">Status Koneksi</p>
                            <p class="text-yellow-300 font-bold">
                                @if($installation->connectionTest->connection_status == 'berhasil')
                                    ✅ Berhasil
                                @else
                                    ❌ Gagal
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">Download Speed</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->connectionTest->speed_test_download }} Mbps</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">Upload Speed</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->connectionTest->speed_test_upload }} Mbps</p>
                        </div>
                        <div>
                            <p class="text-slate-400 text-sm">Latency</p>
                            <p class="text-yellow-300 font-bold">{{ $installation->connectionTest->latency }} ms</p>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-slate-700">
                        <a href="{{ route('technician.connection-test.form', $installation->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">✏️ Edit</a>
                    </div>
                @else
                    <div class="bg-slate-700/50 border border-dashed border-slate-600 rounded-lg p-4">
                        <p class="text-slate-400 text-center mb-4">Belum ada uji koneksi</p>
                        <a href="{{ route('technician.connection-test.form', $installation->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-slate-900 font-bold py-2 px-4 rounded-lg inline-block w-full text-center">
                            + Tambah Uji Koneksi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
