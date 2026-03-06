<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Invoice') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 px-4 sm:px-0">
                <a href="{{ route('admin.billing.index') }}" class="text-gray-600 hover:text-gray-900 font-bold flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Tagihan
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded shadow-sm font-bold">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 p-4 rounded shadow-sm font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-xl sm:rounded-2xl border border-gray-200 overflow-hidden relative">
                
                @if($invoice->status === 'paid')
                    <div class="absolute top-0 right-0 -mr-10 mt-6 transform rotate-45 bg-green-500 text-white font-bold py-1 px-12 shadow-md uppercase tracking-widest text-sm z-10">
                        LUNAS
                    </div>
                @else
                    <div class="absolute top-0 right-0 -mr-10 mt-6 transform rotate-45 bg-red-500 text-white font-bold py-1 px-12 shadow-md uppercase tracking-widest text-sm z-10">
                        UNPAID
                    </div>
                @endif

                <div class="p-8 md:p-12">
                    <div class="flex justify-between items-start border-b border-gray-200 pb-8 mb-8">
                        <div>
                            <h1 class="text-3xl font-black text-indigo-700 tracking-tighter uppercase">INVOICE</h1>
                            <p class="text-gray-500 mt-1 font-mono font-bold">#{{ $invoice->invoice_number }}</p>
                        </div>
                        <div class="text-right text-sm text-gray-500 space-y-1">
                            <p><strong>Tanggal Terbit:</strong> {{ $invoice->created_at->format('d F Y') }}</p>
                            <p><strong>Jatuh Tempo:</strong> <span class="{{ $invoice->due_date < now() && $invoice->status == 'unpaid' ? 'text-red-600 font-bold' : '' }}">{{ $invoice->due_date ? $invoice->due_date->format('d F Y') : '-' }}</span></p>
                            @if($invoice->status === 'paid')
                                <p class="text-green-600 font-bold mt-2">Dibayar pada: {{ $invoice->paid_at ? $invoice->paid_at->format('d F Y, H:i') : '-' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Ditagihkan Kepada:</span>
                            <h3 class="text-xl font-bold text-gray-900 mt-2">{{ $invoice->subscription->customer->user->name ?? 'N/A' }}</h3>
                            <p class="text-gray-600 text-sm mt-1 leading-relaxed">{{ $invoice->subscription->customer->address_installation }}</p>
                            <p class="text-gray-600 text-sm font-bold mt-1">{{ $invoice->subscription->customer->phone_number }}</p>
                        </div>
                        <div class="md:text-right">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Info Layanan:</span>
                            <p class="text-gray-800 font-bold mt-2 text-lg">{{ $invoice->subscription->package->name ?? '-' }}</p>
                            <p class="text-gray-500 text-sm font-mono mt-1">PPPoE: {{ $invoice->subscription->pppoe_username ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-xl overflow-hidden mb-8">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Deskripsi Layanan</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">Biaya Berlangganan Internet - {{ $invoice->subscription->package->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 font-bold text-right">Rp {{ number_format($invoice->subscription->package->price ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @if($invoice->amount > ($invoice->subscription->package->price ?? 0))
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-800 font-medium">Biaya Instalasi / Perangkat / Penyesuaian Lainnya</td>
                                    <td class="px-6 py-4 text-sm text-gray-800 font-bold text-right">Rp {{ number_format($invoice->amount - ($invoice->subscription->package->price ?? 0), 0, ',', '.') }}</td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot class="bg-indigo-50">
                                <tr>
                                    <td class="px-6 py-4 text-right font-black text-indigo-900 uppercase">Total Keseluruhan</td>
                                    <td class="px-6 py-4 text-right font-black text-xl text-indigo-700">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="border-t border-dashed border-gray-300 pt-8 mt-8 flex flex-col items-center">
                        <div class="flex flex-wrap justify-center gap-4 w-full">
                            <a href="{{ route('admin.billing.edit', $invoice->id) }}" class="w-full sm:w-auto px-6 py-4 bg-white border-2 border-yellow-500 text-yellow-600 font-bold rounded-xl shadow-sm hover:bg-yellow-50 transition flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Edit Tagihan
                            </a>

                            @if($invoice->status === 'unpaid')
                                <form action="{{ route('admin.billing.pay', $invoice->id) }}" method="POST" class="w-full sm:w-auto">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Tandai tagihan ini sebagai Lunas?')" class="w-full px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition transform hover:-translate-y-1 flex items-center justify-center">
                                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Konfirmasi Lunas Manual
                                    </button>
                                </form>
                            @else
                                <div class="w-full sm:w-auto flex items-center justify-center text-green-600 font-black text-lg bg-green-50 px-8 py-4 rounded-xl border border-green-200">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    TELAH LUNAS
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>