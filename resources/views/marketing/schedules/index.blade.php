<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Jadwal & Timeline') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 px-4 sm:px-0">
                <div>
                    <h3 class="text-3xl font-bold text-blue-900">Jadwal & Follow-up</h3>
                    <p class="text-blue-600 mt-1">Kelola jadwal follow-up dan timeline dengan prospek & pelanggan</p>
                </div>
                <button class="mt-4 md:mt-0 px-6 py-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-blue-900 rounded-lg font-bold hover:from-yellow-500 hover:to-yellow-600 transition">
                    + Tambah Jadwal
                </button>
            </div>

            {{-- Filter & View Toggle --}}
            <div class="bg-white rounded-xl shadow-md p-4 mb-6 border border-blue-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-blue-600 uppercase mb-2">Filter Tipe</label>
                        <select class="w-full px-3 py-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option>Semua Jadwal</option>
                            <option>Follow-up</option>
                            <option>Survei</option>
                            <option>Presentasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-600 uppercase mb-2">Status</label>
                        <select class="w-full px-3 py-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option>Semua Status</option>
                            <option>Belum Dijadwalkan</option>
                            <option>Terjadwal</option>
                            <option>Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-600 uppercase mb-2">Periode</label>
                        <select class="w-full px-3 py-2 text-sm border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                            <option>Minggu Ini</option>
                            <option>Bulan Ini</option>
                            <option>Semua</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-blue-600 uppercase mb-2">&nbsp;</label>
                        <button class="w-full px-3 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                            🔍 Terapkan
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                {{-- Timeline View --}}
                <div class="lg:col-span-3">

                    {{-- Day Sections --}}
                    <div class="space-y-6">

                        @for ($day = 0; $day < 7; $day++)
                            @php
                                $date = now()->addDays($day);
                                $isToday = $day === 0;
                                $count = rand(1, 4);
                            @endphp

                            <div class="bg-white rounded-xl shadow-lg border-l-4 {{ $isToday ? 'border-l-yellow-500' : 'border-l-blue-300' }} border border-blue-200 overflow-hidden">
                                <div class="px-6 py-4 {{ $isToday ? 'bg-yellow-50' : 'bg-blue-50' }}">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-lg font-bold {{ $isToday ? 'text-yellow-700' : 'text-blue-900' }}">
                                                {{ $date->format('l, d F Y') }}
                                            </h4>
                                            <span class="text-xs {{ $isToday ? 'text-yellow-600' : 'text-blue-600' }} font-semibold">
                                                @if($isToday) 📌 Hari Ini @endif
                                            </span>
                                        </div>
                                        <span class="inline-block px-3 py-1 {{ $isToday ? 'bg-yellow-200 text-yellow-700' : 'bg-blue-100 text-blue-700' }} rounded-full font-bold text-sm">
                                            {{ $count }} jadwal
                                        </span>
                                    </div>
                                </div>

                                <div class="p-6 space-y-4">
                                    @for ($i = 0; $i < $count; $i++)
                                        @php
                                            $types = ['Follow-up', 'Survei', 'Presentasi', 'Instalasi'];
                                            $type = $types[$i % count($types)];
                                            $time = sprintf('%02d:%02d', rand(8, 17), [0, 30][$i % 2]);
                                            $status = ['Belum Dimulai', 'Sedang Berlangsung', 'Selesai'][$i % 3];
                                        @endphp

                                        <div class="flex gap-4 pb-4 border-b border-blue-100 last:border-b-0 last:pb-0 hover:bg-blue-50 p-3 rounded-lg transition">
                                            <div class="flex-shrink-0 text-center w-16">
                                                <div class="font-bold text-blue-700 text-lg">{{ $time }}</div>
                                                <div class="text-xs text-blue-600 mt-1">WIB</div>
                                            </div>

                                            <div class="flex-grow">
                                                <h5 class="font-bold text-blue-900">{{ $type }} - Prospek {{ $i + 1 }}</h5>
                                                <p class="text-sm text-blue-600 mt-1">
                                                    Nama Pelanggan {{ $i + 1 }}
                                                    <span class="text-xs">| +62 812 3456 {{ str_pad($i * 100, 4, '0', STR_PAD_LEFT) }}</span>
                                                </p>
                                                <p class="text-xs text-blue-500 mt-1 line-clamp-1">
                                                    📍 Jl. Demo {{ $i + 1 }}, Kota Demo
                                                </p>

                                                <div class="flex items-center gap-2 mt-3">
                                                    @php
                                                        $statusColor = match($status) {
                                                            'Belum Dimulai' => 'yellow',
                                                            'Sedang Berlangsung' => 'blue',
                                                            'Selesai' => 'green',
                                                        };
                                                    @endphp
                                                    <span class="px-2 py-1 text-xs font-bold rounded bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700">
                                                        ● {{ $status }}
                                                    </span>
                                                    <span class="text-xs text-blue-500">Durasi: 30 menit</span>
                                                </div>
                                            </div>

                                            <div class="flex-shrink-0 flex items-center gap-2">
                                                <button class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-7-4a3 3 0 00-3 3m3-3h6m0 0v6m0-6a3 3 0 013 3v6"></path>
                                                    </svg>
                                                </button>
                                                <button class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endfor

                    </div>

                </div>

                {{-- Sidebar: Summary & Upcoming --}}
                <div class="space-y-6">

                    {{-- Today Summary --}}
                    <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-xl shadow-lg p-6 border border-yellow-300">
                        <h4 class="text-lg font-bold text-yellow-900 mb-4">📅 Hari Ini</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-yellow-800 font-medium">Total Jadwal</span>
                                <span class="text-2xl font-bold text-yellow-700">4</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-yellow-800 font-medium">Selesai</span>
                                <span class="text-2xl font-bold text-green-600">2</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-yellow-800 font-medium">Sisa</span>
                                <span class="text-2xl font-bold text-orange-600">2</span>
                            </div>
                        </div>
                    </div>

                    {{-- Week Overview --}}
                    <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                        <h4 class="text-lg font-bold text-blue-900 mb-4">Minggu Depan</h4>
                        <div class="space-y-3">
                            @for ($i = 1; $i <= 7; $i++)
                                <div class="flex items-center text-sm">
                                    <span class="text-xs text-blue-600 font-semibold w-8">{{ now()->addDays($i)->format('l')|substr(0,3) }}</span>
                                    <div class="flex-grow ml-2">
                                        <div class="flex gap-1">
                                            @for ($j = 0; $j < rand(2, 5); $j++)
                                                <div class="h-2 flex-1 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-full"></div>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-xs text-blue-700 font-bold ml-2">{{ rand(2, 5) }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>

                    {{-- Quick Add --}}
                    <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                        <h4 class="text-lg font-bold text-blue-900 mb-4">⚡ Aksi Cepat</h4>
                        <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition text-sm mb-2">
                            + Follow-up Email
                        </button>
                        <button class="w-full px-4 py-2 bg-blue-100 text-blue-700 rounded-lg font-bold hover:bg-blue-200 transition text-sm mb-2">
                            + Meeting Video Call
                        </button>
                        <button class="w-full px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-bold hover:bg-yellow-200 transition text-sm">
                            + Reminder
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
