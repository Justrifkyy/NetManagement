<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.tickets.index') }}" class="text-purple-600 hover:text-purple-900 font-medium">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Edit Tiket #{{ $ticket->id }}</h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form action="{{ route('admin.tickets.update', $ticket) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Pelanggan <span class="text-red-600">*</span></label>
                            <select name="customer_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" @selected($ticket->customer_id === $customer->id)>
                                        {{ $customer->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe Tiket <span class="text-red-600">*</span></label>
                            <select name="type" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="survey" @selected($ticket->type === 'survey')>Survey</option>
                                <option value="installation" @selected($ticket->type === 'installation')>Instalasi</option>
                                <option value="troubleshoot" @selected($ticket->type === 'troubleshoot')>Perbaikan</option>
                                <option value="maintenance" @selected($ticket->type === 'maintenance')>Maintenance</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Subjek <span class="text-red-600">*</span></label>
                        <input type="text" name="subject" value="{{ $ticket->subject }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Status <span class="text-red-600">*</span></label>
                            <select name="status" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="open" @selected($ticket->status === 'open')>Buka</option>
                                <option value="assigned" @selected($ticket->status === 'assigned')>Ditugaskan</option>
                                <option value="in_progress" @selected($ticket->status === 'in_progress')>Sedang Dikerjakan</option>
                                <option value="resolved" @selected($ticket->status === 'resolved')>Selesai</option>
                                <option value="closed" @selected($ticket->status === 'closed')>Ditutup</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-2">Teknisi</label>
                            <select name="technician_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="">Belum Ditugaskan</option>
                                @foreach ($technicians as $tech)
                                    <option value="{{ $tech->id }}" @selected($ticket->technician_id === $tech->id)>{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Conditional fields based on ticket type -->
                    @if ($ticket->type === 'survey')
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Survey</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Tanggal Survey</label>
                                    <input type="date" name="survey_date" value="{{ $ticket->survey_date }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Status Survey</label>
                                    <input type="text" name="survey_status" value="{{ $ticket->survey_status }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2 mt-4">Catatan Survey</label>
                                <textarea name="survey_notes" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg">{{ $ticket->survey_notes }}</textarea>
                            </div>
                        </div>
                    @endif

                    @if ($ticket->type === 'installation')
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Instalasi</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Tanggal Instalasi</label>
                                    <input type="date" name="installation_date" value="{{ $ticket->installation_date }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe Koneksi</label>
                                    <input type="text" name="connection_type" value="{{ $ticket->connection_type }}" placeholder="FTTH, Coaxial, dll"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Panjang Kabel (m)</label>
                                    <input type="number" name="cable_length" value="{{ $ticket->cable_length }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-900 mb-2">Status Instalasi</label>
                                    <select name="installation_status"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                                        <option value="">Pilih Status</option>
                                        <option value="pending" @selected($ticket->installation_status === 'pending')>Pending</option>
                                        <option value="ongoing" @selected($ticket->installation_status === 'ongoing')>Sedang Berjalan</option>
                                        <option value="completed" @selected($ticket->installation_status === 'completed')>Selesai</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 mb-2 mt-4">Catatan Instalasi</label>
                                <textarea name="installation_notes" rows="4"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg">{{ $ticket->installation_notes }}</textarea>
                            </div>
                        </div>
                    @endif

                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
