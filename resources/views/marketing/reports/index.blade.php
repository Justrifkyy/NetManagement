<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0">
                <h3 class="text-3xl font-bold text-blue-900">Laporan Kinerja</h3>
                <p class="text-blue-600 mt-1">Analisis performa penjualan dan marketing Anda</p>
            </div>

            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 px-4 sm:px-0">
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-blue-600 uppercase">Lead Total</h4>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-700 font-bold">
                            📊
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-blue-900">127</p>
                    <p class="text-xs text-green-600 mt-2">↑ 12% dari bulan lalu</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-blue-600 uppercase">Konversi</h4>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center text-yellow-700 font-bold">
                            Target
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-yellow-700">18</p>
                    <p class="text-xs text-green-600 mt-2">↑ 8% dari bulan lalu</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-blue-600 uppercase">Conversion Rate</h4>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center text-green-700 font-bold">
                            %
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-green-700">14.2%</p>
                    <p class="text-xs text-red-600 mt-2">↓ 2% dari target</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-sm font-semibold text-blue-600 uppercase">Revenue</h4>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-700 font-bold">
                            Revenue
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-purple-700">Rp 5.4M</p>
                    <p class="text-xs text-green-600 mt-2">↑ 18% dari bulan lalu</p>
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 px-4 sm:px-0">

                {{-- Lead Trend Chart --}}
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                    <h4 class="text-lg font-bold text-blue-900 mb-6">📈 Tren Lead 3 Bulan Terakhir</h4>
                    <div class="space-y-4">
                        @for ($month = 1; $month <= 3; $month++)
                            @php $count = rand(80, 130); @endphp
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-blue-900">{{ now()->subMonths(3 - $month)->format('M Y') }}</span>
                                    <span class="font-bold text-blue-700">{{ $count }} lead</span>
                                </div>
                                <div class="w-full bg-blue-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 h-3 rounded-full transition" style="width: {{ ($count / 130) * 100 }}%"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                {{-- Conversion by Status --}}
                <div class="bg-white rounded-xl shadow-lg border border-blue-200 p-6">
                    <h4 class="text-lg font-bold text-blue-900 mb-6">Status Prospek</h4>
                    <div class="space-y-4">
                        @php
                            $statuses = [
                                ['label' => 'Prospek', 'count' => 45, 'color' => 'blue'],
                                ['label' => 'Survey', 'count' => 28, 'color' => 'yellow'],
                                ['label' => 'Instalasi', 'count' => 36, 'color' => 'purple'],
                                ['label' => 'Aktif', 'count' => 18, 'color' => 'green'],
                            ];
                        @endphp
                        @foreach($statuses as $status)
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-semibold text-blue-900">{{ $status['label'] }}</span>
                                    <span class="font-bold text-{{ $status['color'] }}-700">{{ $status['count'] }}</span>
                                </div>
                                <div class="w-full bg-{{ $status['color'] }}-200 rounded-full h-3">
                                    <div class="bg-gradient-to-r from-{{ $status['color'] }}-400 to-{{ $status['color'] }}-500 h-3 rounded-full" style="width: {{ ($status['count'] / 127) * 100 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Performance Table --}}
            <div class="bg-white rounded-xl shadow-lg border border-blue-200 overflow-hidden px-4 sm:px-0">
                <div class="p-6 border-b border-blue-200">
                    <h4 class="text-lg font-bold text-blue-900">📋 Detail Harian</h4>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gradient-to-r from-yellow-100 to-yellow-50 border-b border-blue-200">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-blue-900">Tanggal</th>
                                <th class="px-6 py-4 text-center font-bold text-blue-900">Lead Baru</th>
                                <th class="px-6 py-4 text-center font-bold text-blue-900">Follow-up</th>
                                <th class="px-6 py-4 text-center font-bold text-blue-900">Konversi</th>
                                <th class="px-6 py-4 text-center font-bold text-blue-900">Conv. Rate</th>
                                <th class="px-6 py-4 text-center font-bold text-blue-900">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-100">
                            @for ($i = 1; $i <= 10; $i++)
                                @php
                                    $leads = rand(3, 10);
                                    $followup = rand(5, 15);
                                    $converted = rand(0, 3);
                                    $rate = $leads > 0 ? round(($converted / $leads) * 100, 1) : 0;
                                    $revenue = $converted * 299000;
                                @endphp
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4 font-semibold text-blue-900 whitespace-nowrap">
                                        {{ now()->subDays($i)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-bold">{{ $leads }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full font-bold">{{ $followup }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full font-bold">{{ $converted }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-blue-900">{{ $rate }}%</td>
                                    <td class="px-6 py-4 text-center font-bold text-purple-700">Rp {{ number_format($revenue, 0, ',', '.') }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-blue-50 border-t border-blue-200 flex items-center justify-between">
                    <span class="text-sm text-blue-600 font-semibold">Menampilkan 10 baris terbaru dari 30 total</span>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                        Lihat Semua →
                    </button>
                </div>
            </div>

            {{-- Export Options --}}
            <div class="mt-8 px-4 sm:px-0 flex flex-col md:flex-row gap-3 justify-center">
                <button class="px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 rounded-lg font-bold hover:bg-blue-50 transition flex items-center justify-center gap-2">
                    📥 Download PDF
                </button>
                <button class="px-6 py-3 bg-white border-2 border-yellow-400 text-yellow-700 rounded-lg font-bold hover:bg-yellow-50 transition flex items-center justify-center gap-2">
                    📊 Download Excel
                </button>
                <button class="px-6 py-3 bg-white border-2 border-green-500 text-green-700 rounded-lg font-bold hover:bg-green-50 transition flex items-center justify-center gap-2">
                    📧 Kirim Email
                </button>
            </div>

        </div>
    </div>
</x-app-layout>
