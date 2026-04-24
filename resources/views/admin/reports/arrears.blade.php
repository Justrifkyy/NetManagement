<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center px-4 sm:px-0">
                <div>
                    <a href="{{ route('admin.reports.index') }}" class="text-amber-400 hover:text-amber-300 font-medium">← Kembali</a>
                    <h2 class="text-3xl font-extrabold text-white mt-2">Laporan Tunggakan</h2>
                </div>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-6 mb-6">
                <h3 class="text-lg font-bold text-white mb-4">Filter Laporan</h3>
                <form action="{{ route('admin.reports.arrears') }}" method="GET" class="flex gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Sampai Tanggal</label>
                        <input type="date" name="to_date" value="{{ $toDate }}" class="px-4 py-2 border border-slate-700 rounded-lg bg-slate-800 text-white">
                    </div>
                    <button type="submit" class="self-end px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Filter</button>
                </form>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 px-4 sm:px-0">
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6">
                    <p class="text-slate-300 text-sm font-semibold">Total Tunggakan</p>
                    <p class="text-2xl font-bold text-red-400 mt-2">Rp {{ number_format($totalArrears, 0, ',', '.') }}</p>
                </div>
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6">
                    <p class="text-slate-300 text-sm font-semibold">Jumlah Invoice</p>
                    <p class="text-2xl font-bold text-white mt-2">{{ $arrears->count() }}</p>
                </div>
                <div class="bg-slate-900 rounded-xl border border-slate-800 p-6">
                    <p class="text-slate-300 text-sm font-semibold">Rata-rata per Invoice</p>
                    <p class="text-2xl font-bold text-amber-400 mt-2">Rp {{ number_format($arrears->count() > 0 ? $totalArrears / $arrears->count() : 0, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-800 bg-slate-800">
                    <h3 class="font-bold text-white text-lg">Daftar Tunggakan (Sampai {{ $toDate }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead class="bg-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">No. Invoice</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Jumlah</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Jatuh Tempo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-300 uppercase">Hari Terlambat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($arrears as $invoice)
                                <tr class="hover:bg-slate-800">
                                    <td class="px-6 py-4 whitespace-nowrap font-mono text-amber-400 font-bold">{{ $invoice->invoice_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-semibold text-white">{{ $invoice->subscription->customer->user->name }}</div>
                                        <div class="text-xs text-slate-400">{{ $invoice->subscription->customer->customer_code ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-white font-bold">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-red-400">{{ $invoice->due_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-red-900/20 text-red-400">
                                            {{ now()->diffInDays($invoice->due_date) }} hari
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        Tidak ada tunggakan sampai tanggal ini.
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
