<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Tagihan & Pembayaran</h2>
                <p class="text-slate-500 mt-1">Pantau riwayat tagihan dan lakukan pembayaran layanan internet Anda.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mx-4 sm:mx-0">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 text-lg">Riwayat Tagihan (Invoice)</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-white">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    No. Invoice</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Total Tagihan</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Jatuh Tempo</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @php
                                /** @var \App\Models\Invoice $inv */
                            @endphp
                            @forelse($invoices as $inv)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-mono text-sm font-bold text-blue-600">
                                            {{ $inv->invoice_number }}</div>
                                        <div class="text-xs text-slate-500">{{ $inv->created_at->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-slate-800">Rp
                                            {{ number_format($inv->amount, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="text-sm font-bold {{ $inv->due_date < now() && $inv->status == 'unpaid' ? 'text-red-600' : 'text-slate-600' }}">
                                            {{ $inv->due_date ? \Carbon\Carbon::parse($inv->due_date)->format('d M Y') : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if ($inv->status === 'paid')
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200 uppercase">Lunas</span>
                                        @else
                                            <span
                                                class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200 uppercase">Belum
                                                Bayar</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('client.billing.show', $inv->id) }}"
                                            class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 shadow-sm text-xs font-bold rounded-lg text-slate-700 hover:bg-slate-50 transition">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        Anda belum memiliki riwayat tagihan.
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
