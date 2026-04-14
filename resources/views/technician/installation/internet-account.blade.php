<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">🔐 Akun Internet</h1>
                        <p class="text-slate-400 mt-1">Instalasi: <span class="text-yellow-300 font-semibold">{{ $installation->lead->name }}</span></p>
                    </div>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 mx-4 sm:mx-0 bg-red-900/50 border-l-4 border-red-500 text-red-300 p-4 rounded-r">
                    <p class="font-bold mb-2">⚠️ Terdapat kesalahan:</p>
                    <ul class="list-disc ml-6 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('technician.internet-account.store', $installation->id) }}" method="POST" class="space-y-6">
                @csrf

                <!-- DATA AKUN INTERNET -->
                <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 px-6 py-4 flex items-center">
                        <h2 class="text-xl font-bold text-slate-900">DATA AKUN INTERNET</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Username PPPoE -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">Username PPPoE</label>
                            <input type="text" name="pppoe_username" value="{{ old('pppoe_username', $account->pppoe_username) }}"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Username untuk koneksi PPPoE">
                        </div>

                        <!-- Password PPPoE -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">Password PPPoE</label>
                            <input type="password" name="pppoe_password" value="{{ old('pppoe_password', $account->pppoe_password) }}"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Password untuk koneksi PPPoE">
                        </div>

                        <!-- Paket Layanan -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">Paket Layanan <span class="text-red-500">*</span></label>
                            <input type="text" name="service_package" value="{{ old('service_package', $account->service_package) }}" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Contoh: Internet 10 Mbps, Internet 30 Mbps, dll">
                        </div>

                        <!-- Status Awal Layanan -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">Status Awal Layanan <span class="text-red-500">*</span></label>
                            <select name="initial_service_status" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                                <option value="aktif" @selected(old('initial_service_status', $account->initial_service_status) == 'aktif')>✅ Aktif</option>
                                <option value="tidak_aktif" @selected(old('initial_service_status', $account->initial_service_status) == 'tidak_aktif')>⏸️ Tidak Aktif</option>
                                <option value="suspend" @selected(old('initial_service_status', $account->initial_service_status) == 'suspend')>🚫 Suspend</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col md:flex-row gap-4 px-4 sm:px-0">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-yellow-500 to-yellow-400 text-slate-900 font-bold py-3 rounded-lg hover:from-yellow-600 hover:to-yellow-500 transition shadow-lg">
                        ✓ Simpan & Lanjut ke Uji Koneksi
                    </button>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="flex-1 bg-slate-700 border border-slate-600 text-yellow-300 font-bold py-3 rounded-lg hover:bg-slate-600 transition text-center">
                        ← Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
