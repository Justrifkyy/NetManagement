<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-white tracking-tight">Manajemen Tagihan</h2>
                    <p class="text-slate-400 mt-1">Pantau semua invoices dari pelanggan dan kelola status pembayaran.</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 px-4 sm:px-0">
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6">
                    <p class="text-slate-300 text-sm font-semibold">Total Lunas (Bulan Ini)</p>
                    <p class="text-2xl font-bold text-amber-400 mt-2">Rp {{ number_format($stats['paid_this_month'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6">
                    <p class="text-slate-300 text-sm font-semibold">Total Hutang</p>
                    <p class="text-2xl font-bold text-red-400 mt-2">Rp {{ number_format($stats['unpaid_total'] ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6">
                    <p class="text-slate-300 text-sm font-semibold">Jumlah Invoice Belum Bayar</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $stats['unpaid_count'] ?? 0 }}</p>
                </div>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 overflow-hidden mx-4 sm:mx-0">
                <div class="px-6 py-5 border-b border-slate-800 bg-slate-800 flex justify-between items-center">
                    <h3 class="font-bold text-white text-lg">Daftar Semua Tagihan</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead class="bg-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">No. Invoice</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Total Tagihan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase tracking-wider">Jatuh Tempo</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @php
                                /** @var \App\Models\Invoice $inv */
                            @endphp
                            @forelse($invoices as $inv)
                                <tr class="hover:bg-slate-800 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-mono text-sm font-bold text-amber-400">
                                            {{ $inv->invoice_number }}</div>
                                        <div class="text-xs text-slate-400">{{ $inv->created_at->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-semibold text-white">
                                            {{ $inv->subscription->customer->user->name ?? '-' }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            {{ $inv->subscription->customer->customer_code ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-white">Rp
                                            {{ number_format($inv->amount, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="text-sm font-bold {{ $inv->due_date < now() && $inv->status == 'unpaid' ? 'text-red-400' : 'text-slate-300' }}">
                                            {{ $inv->due_date ? \Carbon\Carbon::parse($inv->due_date)->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($inv->status === 'paid')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-900/20 text-green-400 border border-green-700 uppercase">Lunas</span>
                                        @else
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-900/20 text-red-400 border border-red-700 uppercase">! Belum Bayar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex gap-2 justify-center">
                                            <a href="{{ route('admin.billing.show', $inv->id) }}"
                                                class="inline-flex items-center px-3 py-2 bg-slate-800 border border-slate-700 shadow-sm text-xs font-bold rounded-lg text-slate-300 hover:bg-slate-700 transition">
                                                Lihat
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                        Tidak ada data tagihan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
