<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Tagihan (Invoice)') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.billing.update', $invoice->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded shadow-sm mb-6">
                    <p class="font-bold text-yellow-800">Mode Edit Admin</p>
                    <p class="text-sm text-yellow-700">Anda dapat memodifikasi total tagihan (misal: penambahan diskon/denda), tanggal jatuh tempo, dan status pembayaran.</p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden border border-gray-200">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 font-bold text-gray-800 flex justify-between items-center">
                        <span>Detail Invoice #{{ $invoice->invoice_number }}</span>
                        <span class="text-xs text-gray-500 bg-gray-200 px-2 py-1 rounded">Pelanggan: {{ $invoice->subscription->customer->user->name ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Total Tagihan (Rp)</label>
                            <input type="number" name="amount" value="{{ old('amount', $invoice->amount) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 font-bold text-lg text-indigo-700" required>
                            <p class="text-xs text-gray-500 mt-1">Ganti angka ini jika ada biaya tambahan atau diskon.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                            <input type="date" name="due_date" value="{{ old('due_date', $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 font-bold">
                                <option value="unpaid" {{ $invoice->status === 'unpaid' ? 'selected' : '' }}>Belum Lunas (Unpaid)</option>
                                <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Dibayar (Hanya jika Lunas)</label>
                            <input type="datetime-local" name="paid_at" value="{{ old('paid_at', $invoice->paid_at ? $invoice->paid_at->format('Y-m-d\TH:i') : '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran</label>
                            <input type="text" name="payment_method" value="{{ old('payment_method', $invoice->payment_method) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="Contoh: Transfer BCA Manual, Tunai di Kantor">
                        </div>

                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.billing.show', $invoice->id) }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-bold rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" onclick="return confirm('Simpan perubahan invoice?')" class="px-8 py-3 bg-yellow-500 text-white font-bold rounded-xl shadow-lg hover:bg-yellow-600 transition">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>