<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Daftar Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 px-4 sm:px-0">
                <div>
                    <h3 class="text-3xl font-bold text-blue-900">Pelanggan Saya</h3>
                    <p class="text-blue-600 mt-1">Kelola data pelanggan yang telah konversi dari prospek</p>
                </div>
            </div>

            {{-- Search & Filter --}}
            <div class="bg-white rounded-xl shadow-md p-6 mb-6 border border-blue-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-2">Cari Pelanggan</label>
                        <input type="text" placeholder="Nama atau No. Telepon..." 
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-2">Status Layanan</label>
                        <select class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="tertunda">Tertunda</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-2">&nbsp;</label>
                        <button class="w-full px-4 py-2 bg-gradient-to-r from-yellow-400 to-yellow-500 text-blue-900 rounded-lg font-bold hover:from-yellow-500 hover:to-yellow-600 transition">
                            🔍 Cari
                        </button>
                    </div>
                </div>
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden md:block bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden">
                <table class="w-full divide-y divide-blue-200">
                    <thead class="bg-gradient-to-r from-yellow-400 to-yellow-500">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase">Kode Pelanggan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase">Nama</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase">Telepon</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-blue-900 uppercase">Lokasi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-blue-900 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-100">
                        {{-- Sample Data --}}
                        @for ($i = 1; $i <= 5; $i++)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono font-bold text-blue-700">CUST-{{ str_pad($i, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-blue-900">Pelanggan {{ $i }}</div>
                                    <div class="text-xs text-blue-600">Konversi: {{ now()->subDays($i)->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-blue-700">+62 812 3456 {{ str_pad($i * 100, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-blue-800">Jl. Contoh {{ $i }}, Kota {{ $i }}</div>
                                    <div class="text-xs text-blue-600">Kec. Demo</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase" style="{{ $i % 2 == 0 ? 'background-color: #d1d5db; color: #1f2937;' : 'background-color: #fef3c7; color: #92400e;' }}">
                                        @if($i % 2 == 0) Aktif @else Tertunda @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('marketing.customers.show', $i) }}" 
                                        class="text-blue-600 hover:text-blue-800 font-bold transition">
                                        Lihat →
                                    </a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card View --}}
            <div class="md:hidden space-y-4 px-4 sm:px-0">
                @for ($i = 1; $i <= 5; $i++)
                    <div class="bg-white rounded-lg border border-blue-200 overflow-hidden shadow-md">
                        <div class="bg-gradient-to-r from-yellow-300 to-yellow-400 p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-blue-900">Pelanggan {{ $i }}</h4>
                                    <p class="text-xs text-blue-700">CUST-{{ str_pad($i, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-bold rounded-full" style="{{ $i % 2 == 0 ? 'background-color: #d1d5db; color: #1f2937;' : 'background-color: #fef3c7; color: #92400e;' }}">
                                    @if($i % 2 == 0) Aktif @else Tertunda @endif
                                </span>
                            </div>
                        </div>
                        <div class="p-4 space-y-2">
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-blue-700">+62 812 3456 {{ str_pad($i * 100, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                <span class="text-blue-700">Jl. Contoh {{ $i }}, Kota {{ $i }}</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-blue-600 text-xs">Konversi: {{ now()->subDays($i)->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-blue-50 border-t border-blue-200">
                            <a href="{{ route('marketing.customers.show', $i) }}" 
                                class="block text-center text-blue-700 font-bold hover:text-blue-900">
                                Lihat Detail →
                            </a>
                        </div>
                    </div>
                @endfor
            </div>

        </div>
    </div>
</x-app-layout>
