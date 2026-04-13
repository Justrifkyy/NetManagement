<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 px-4 sm:px-0 flex justify-between items-center">
                <a href="{{ route('client.billing.index') }}" class="text-slate-600 hover:text-slate-900 font-bold flex items-center transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Tagihan
                </a>
            </div>

            <div class="bg-white shadow-xl sm:rounded-2xl border border-slate-200 overflow-hidden relative">
                
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
                    <div class="flex justify-between items-start border-b border-slate-200 pb-8 mb-8">
                        <div>
                            <h1 class="text-3xl font-black text-blue-700 tracking-tighter uppercase">INVOICE</h1>
                            <p class="text-slate-500 mt-1 font-mono font-bold">#{{ $invoice->invoice_number }}</p>
                        </div>
                        <div class="text-right text-sm text-slate-500 space-y-1">
                            <p><strong>Tanggal Terbit:</strong> {{ $invoice->created_at->format('d F Y') }}</p>
                            <p><strong>Jatuh Tempo:</strong> <span class="{{ $invoice->due_date < now() && $invoice->status == 'unpaid' ? 'text-red-600 font-bold' : '' }}">{{ $invoice->due_date ? $invoice->due_date->format('d F Y') : '-' }}</span></p>
                            @if($invoice->status === 'paid')
                                <p class="text-green-600 font-bold mt-2">Dibayar pada: {{ $invoice->paid_at ? $invoice->paid_at->format('d F Y, H:i') : '-' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ditagihkan Kepada:</span>
                            <h3 class="text-xl font-bold text-slate-900 mt-2">{{ Auth::user()->name }}</h3>
                            <p class="text-slate-600 text-sm mt-1 leading-relaxed">{{ $invoice->subscription->customer->address_installation ?? '-' }}</p>
                            <p class="text-slate-600 text-sm font-bold mt-1">{{ $invoice->subscription->customer->phone_number ?? '-' }}</p>
                        </div>
                        <div class="md:text-right">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Info Layanan:</span>
                            <p class="text-slate-800 font-bold mt-2 text-lg">{{ $invoice->subscription->package->name ?? '-' }}</p>
                            <p class="text-slate-500 text-sm font-mono mt-1">PPPoE: {{ $invoice->subscription->pppoe_username ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="border border-slate-200 rounded-xl overflow-hidden mb-8">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase">Deskripsi Layanan</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                <tr>
                                    <td class="px-6 py-4 text-sm text-slate-800 font-medium">Biaya Berlangganan Internet - {{ $invoice->subscription->package->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-800 font-bold text-right">Rp {{ number_format($invoice->subscription->package->price ?? 0, 0, ',', '.') }}</td>
                                </tr>
                                @if($invoice->amount > ($invoice->subscription->package->price ?? 0))
                                <tr>
                                    <td class="px-6 py-4 text-sm text-slate-800 font-medium">Biaya Instalasi / Penyesuaian / Denda</td>
                                    <td class="px-6 py-4 text-sm text-slate-800 font-bold text-right">Rp {{ number_format($invoice->amount - ($invoice->subscription->package->price ?? 0), 0, ',', '.') }}</td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot class="bg-blue-50">
                                <tr>
                                    <td class="px-6 py-4 text-right font-black text-blue-900 uppercase">Total Keseluruhan</td>
                                    <td class="px-6 py-4 text-right font-black text-xl text-blue-700">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="border-t border-dashed border-slate-700 pt-8 mt-8 flex flex-col items-center">
                        @if($invoice->status === 'unpaid')
                            <p class="text-sm text-slate-500 mb-4 text-center">Silakan selesaikan pembayaran sebelum tanggal jatuh tempo agar layanan internet Anda tidak terputus.</p>
                            
                            <button class="w-full sm:w-auto px-10 py-4 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-800 transition transform hover:-translate-y-1 flex items-center justify-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Bayar Sekarang
                            </button>
                        @else
                            <div class="w-full sm:w-auto flex items-center justify-center text-green-600 font-black text-lg bg-green-50 px-8 py-4 rounded-xl border border-green-200">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                TAGIHAN TELAH LUNAS
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
