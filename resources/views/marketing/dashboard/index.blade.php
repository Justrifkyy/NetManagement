<x-app-layout>
    <div class="py-10 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-bold text-blue-900">Dashboard Marketing</h2>
                <p class="text-blue-600 mt-1">Pantau performa prospek dan konversi Anda bulan ini.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-0 mb-8">

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-blue-200 flex items-center">
                    <div class="p-4 bg-blue-100 text-blue-700 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-blue-600 uppercase">Total Leads</p>
                        <h3 class="text-3xl font-extrabold text-blue-900">{{ $stats['total'] ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-blue-200 flex items-center">
                    <div class="p-4 bg-blue-100 text-blue-700 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-blue-600 uppercase">Prospek Baru</p>
                        <h3 class="text-3xl font-extrabold text-blue-900">{{ $stats['prospek'] ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-yellow-200 flex items-center">
                    <div class="p-4 bg-yellow-100 text-yellow-600 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-yellow-600 uppercase">Sedang Proses</p>
                        <h3 class="text-3xl font-extrabold text-yellow-700">{{ $stats['proses'] ?? 0 }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-green-100 flex items-center">
                    <div class="p-4 bg-green-50 text-green-600 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-green-500 uppercase">Berhasil Deal</p>
                        <h3 class="text-3xl font-extrabold text-green-700">{{ $stats['converted'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-0">
                <div class="bg-white rounded-2xl shadow-sm border border-blue-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-blue-200 bg-gradient-to-r from-yellow-400 to-yellow-500 flex justify-between items-center">
                        <h3 class="font-bold text-blue-900 text-lg flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            5 Prospek Terakhir
                        </h3>
                        <a href="{{ route('marketing.leads.index') }}"
                            class="text-sm text-blue-900 hover:text-blue-700 font-bold bg-white px-3 py-1 rounded-lg border border-blue-200 shadow-sm transition">Lihat
                            Semua &rarr;</a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                        Nama Pelanggan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                        Paket</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                        Tanggal Masuk</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-bold text-blue-700 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @php
                                    /** @var \App\Models\Lead $lead */
                                @endphp
                                @forelse($recentLeads as $lead)
                                    <tr class="hover:bg-blue-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-blue-900">{{ $lead->name }}</div>
                                            <div class="text-sm text-blue-600">{{ $lead->phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-700 border border-blue-200">
                                                {{ $lead->package->name ?? 'Belum Pilih' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                                            {{ $lead->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full uppercase tracking-wide
                                                {{ $lead->status == 'converted' || $lead->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ $lead->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-blue-600">
                                            Belum ada prospek baru yang diinput.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
