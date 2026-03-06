<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Keuangan & Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manajemen Tagihan (Billing)</h2>
                <p class="text-gray-500 mt-1">Pantau pembayaran pelanggan, tagihan tertunggak, dan konfirmasi manual.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 px-4 sm:px-0">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-green-100 flex items-center">
                    <div class="p-4 bg-green-50 text-green-600 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-green-500 uppercase tracking-wider">Pendapatan Bulan Ini</p>
                        <h3 class="text-2xl font-black text-green-700 mt-1">Rp {{ number_format($stats['paid_this_month'] ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100 flex items-center">
                    <div class="p-4 bg-red-50 text-red-600 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-red-500 uppercase tracking-wider">Total Tunggakan</p>
                        <h3 class="text-2xl font-black text-red-700 mt-1">Rp {{ number_format($stats['unpaid_total'] ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100 flex items-center">
                    <div class="p-4 bg-orange-50 text-orange-600 rounded-xl mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-orange-500 uppercase tracking-wider">Pelanggan Menunggak</p>
                        <h3 class="text-2xl font-black text-orange-700 mt-1">{{ $stats['unpaid_count'] ?? 0 }} Orang</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mx-4 sm:mx-0">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-900 text-lg">Semua Tagihan (Invoice)</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Invoice</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Tagihan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($invoices as $inv)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-mono text-sm font-bold text-indigo-600">{{ $inv->invoice_number }}</div>
                                        <div class="text-xs text-gray-500">{{ $inv->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-900">{{ $inv->subscription->customer->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $inv->subscription->package->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-gray-800">Rp {{ number_format($inv->amount, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold {{ $inv->due_date < now() && $inv->status == 'unpaid' ? 'text-red-600' : 'text-gray-600' }}">
                                            {{ $inv->due_date ? $inv->due_date->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($inv->status === 'paid')
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200 uppercase">Lunas</span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200 uppercase">Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('admin.billing.show', $inv->id) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-xs leading-4 font-bold rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">Belum ada data tagihan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>