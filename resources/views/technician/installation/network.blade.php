<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">Konfigurasi Jaringan</h1>
                        <p class="text-slate-400 mt-1">Instalasi: <span class="text-yellow-300 font-semibold">{{ $installation->lead->name }}</span></p>
                    </div>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 mx-4 sm:mx-0 bg-red-900/50 border-l-4 border-red-500 text-red-300 p-4 rounded-r">
                    <li class="font-bold mb-2">⚠️ Terdapat kesalahan:</p>
                    <ul class="list-disc ml-6 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('technician.network.store', $installation->id) }}" method="POST" class="space-y-6">
                @csrf

                <!-- DATA JARINGAN -->
                <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 px-6 py-4 flex items-center">
                        <h2 class="text-xl font-bold text-slate-900">KONFIGURASI JARINGAN</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Router Area -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Router Area <span class="text-red-500">*</span></label>
                                <input type="text" name="router_area" value="{{ old('router_area', $network->router_area) }}" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: RT-01, RT-02, etc">
                            </div>

                            <!-- Port/Interface -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">Port / Interface <span class="text-red-500">*</span></label>
                                <input type="text" name="port_interface" value="{{ old('port_interface', $network->port_interface) }}" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: ether1, ether2, gig1, dll">
                            </div>

                            <!-- VLAN ID -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">VLAN ID (Jika Ada)</label>
                                <input type="text" name="vlan_id" value="{{ old('vlan_id', $network->vlan_id) }}"
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Contoh: 100, 200, dll">
                            </div>

                            <!-- OLT/Access Point -->
                            <div>
                                <label class="block text-sm font-bold text-yellow-400 mb-2">OLT / Access Point <span class="text-red-500">*</span></label>
                                <input type="text" name="olt_access_point" value="{{ old('olt_access_point', $network->olt_access_point) }}" required
                                    class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                    placeholder="Nama/ID sumber OLT atau Access Point">
                            </div>
                        </div>

                        <!-- Connection Mode -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">Mode Koneksi <span class="text-red-500">*</span></label>
                            <select name="connection_mode" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                <option value="pppoe" @selected(old('connection_mode', $network->connection_mode) == 'pppoe')>PPPoE</option>
                                <option value="static_ip" @selected(old('connection_mode', $network->connection_mode) == 'static_ip')>Static IP</option>
                                <option value="dhcp" @selected(old('connection_mode', $network->connection_mode) == 'dhcp')>DHCP</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col md:flex-row gap-4 px-4 sm:px-0">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-400 text-slate-900 font-bold py-3 rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition shadow-lg">
                        ✓ Simpan & Lanjut ke Akun Internet
                    </button>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="flex-1 bg-slate-700 border border-slate-600 text-yellow-300 font-bold py-3 rounded-lg hover:bg-slate-600 transition text-center">
                        ← Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
