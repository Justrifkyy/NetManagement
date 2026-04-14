<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Detail Pelanggan') }}
            </h2>
            <a href="{{ route('marketing.customers.index') }}" class="text-white hover:text-yellow-300 transition">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Customer Info Card --}}
                    <div class="bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-bold text-blue-900">Pelanggan Demo</h3>
                                    <p class="text-blue-800">CUST-00001</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-4 py-2 bg-green-100 text-green-700 rounded-lg font-bold">
                                        ✓ Aktif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            {{-- Informasi Dasar --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm font-semibold text-blue-600 uppercase">Email</p>
                                    <p class="text-blue-900 font-medium">pelanggan.demo@email.com</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-blue-600 uppercase">Telepon</p>
                                    <p class="text-blue-900 font-medium">+62 812 3456 7890</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-blue-600 uppercase">NIK</p>
                                    <p class="text-blue-900 font-medium">1234567890123456</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-blue-600 uppercase">Tanggal Konversi</p>
                                    <p class="text-blue-900 font-medium">15 April 2026</p>
                                </div>
                            </div>

                            <hr class="border-blue-200">

                            {{-- Alamat Instalasi --}}
                            <div>
                                <h4 class="text-lg font-bold text-blue-900 mb-3">📍 Lokasi Instalasi</h4>
                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                    <p class="text-blue-900 font-medium">Jl. Contoh Jalan No. 123, Kelurahan Demo</p>
                                    <p class="text-blue-700 text-sm mt-1">Kecamatan Demo, Kota Demo, Provinsi Demo</p>
                                    <p class="text-blue-600 text-xs mt-2">Koordinat: -6.2088, 106.8456</p>
                                </div>
                            </div>

                            <hr class="border-blue-200">

                            {{-- Data Teknis --}}
                            <div>
                                <h4 class="text-lg font-bold text-blue-900 mb-3">🔧 Konfigurasi Teknis</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                        <p class="text-xs font-semibold text-blue-600 uppercase">Username PPPoE</p>
                                        <p class="text-blue-900 font-mono font-bold text-sm mt-1">customer_001@isp</p>
                                    </div>
                                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                        <p class="text-xs font-semibold text-blue-600 uppercase">Password PPPoE</p>
                                        <p class="text-blue-900 font-mono font-bold text-sm mt-1">••••••••••</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Activity Timeline --}}
                    <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                        <h4 class="text-lg font-bold text-blue-900 mb-4">📋 Riwayat Aktivitas</h4>
                        <div class="space-y-4">
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-yellow-100 border-2 border-yellow-400">
                                            <span class="text-yellow-700 text-xs font-bold">{{ $i }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-semibold text-blue-900">
                                            {{ ['Prospek Dibuat', 'Survey Lokasi', 'Instalasi Teknisi', 'Konversi Berhasil'][$i-1] }}
                                        </p>
                                        <p class="text-xs text-blue-600">{{ now()->subDays($i*2)->format('d M Y H:i') }} WIB</p>
                                    </div>
                                </div>
                                @if ($i < 4)
                                    <div class="ml-4 h-4 border-l-2 border-yellow-300"></div>
                                @endif
                            @endfor
                        </div>
                    </div>

                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">

                    {{-- Quick Stats --}}
                    <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                        <h4 class="text-lg font-bold text-blue-900 mb-4">📊 Statistik</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-blue-700 font-medium">Paket</span>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg text-sm font-bold">Paket 10 Mbps</span>
                            </div>
                            <hr class="border-blue-200">
                            <div class="flex items-center justify-between">
                                <span class="text-blue-700 font-medium">Durasi Layanan</span>
                                <span class="text-blue-900 font-bold">30 hari</span>
                            </div>
                            <hr class="border-blue-200">
                            <div class="flex items-center justify-between">
                                <span class="text-blue-700 font-medium">Tarif Bulanan</span>
                                <span class="text-yellow-700 font-bold text-lg">Rp 299.000</span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                        <h4 class="text-lg font-bold text-blue-900 mb-4">⚙️ Aksi</h4>
                        <div class="space-y-3">
                            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition flex items-center justify-center gap-2">
                                <span>Call</span> Hubungi Pelanggan
                            </button>
                            <button class="w-full px-4 py-2 bg-yellow-400 text-blue-900 rounded-lg font-bold hover:bg-yellow-500 transition flex items-center justify-center gap-2">
                                <span>Edit</span> Edit Data
                            </button>
                            <button class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg font-bold hover:bg-red-200 transition flex items-center justify-center gap-2">
                                <span>🚫</span> Isolir Layanan
                            </button>
                        </div>
                    </div>

                    {{-- Support Info --}}
                    <div class="bg-gradient-to-br from-blue-100 to-yellow-100 rounded-xl p-6 border border-blue-200">
                        <h4 class="text-sm font-bold text-blue-900 mb-2">💡 Catatan</h4>
                        <p class="text-xs text-blue-800">Pelanggan ini aktif dan tidak memiliki keluhan untuk 30 hari terakhir.</p>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
