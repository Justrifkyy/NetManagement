<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.tickets.index') }}" class="text-purple-600 hover:text-purple-900 font-medium">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Buat Tiket Baru</h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form action="{{ route('admin.tickets.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Pelanggan <span class="text-red-600">*</span></label>
                            <select name="customer_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Pilih Pelanggan</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->user->name }} - {{ $customer->phone_number }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe Tiket <span class="text-red-600">*</span></label>
                            <select name="type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Pilih Tipe</option>
                                <option value="survey">Survey</option>
                                <option value="installation">Instalasi</option>
                                <option value="troubleshoot">Perbaikan</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                            @error('type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Subjek <span class="text-red-600">*</span></label>
                        <input type="text" name="subject" required placeholder="Masukkan subjek tiket"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('subject') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Status <span class="text-red-600">*</span></label>
                            <select name="status" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="open">Buka</option>
                                <option value="assigned">Ditugaskan</option>
                                <option value="in_progress">Sedang Dikerjakan</option>
                                <option value="resolved">Selesai</option>
                                <option value="closed">Ditutup</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Teknisi (Opsional)</label>
                            <select name="technician_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Belum Ditugaskan</option>
                                @foreach ($technicians as $tech)
                                    <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Catatan (Opsional)</label>
                        <textarea name="notes" rows="4" placeholder="Masukkan catatan tambahan..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">
                            Buat Tiket
                        </button>
                        <a href="{{ route('admin.tickets.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
