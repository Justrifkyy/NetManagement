<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Edit Laporan Tugas #' . $ticket->id) }}
            </h2>
            <a href="{{ route('technician.process.show', $ticket) }}" class="text-white hover:text-slate-300">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-sky-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-lg shadow-lg p-8">

                {{-- Info Header --}}
                <div class="mb-6 pb-6 border-b border-slate-200">
                    <p class="text-sm text-slate-500">Tugas ID: <span class="font-mono font-bold text-blue-600">#{{ $ticket->id }}</span></p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-2">
                        @php
                            $customer = $ticket->customer;
                            $user = $customer->user ?? null;
                        @endphp
                        {{ $user->name ?? 'Pelanggan' }}
                    </h3>
                </div>

                {{-- Form Update --}}
                <form action="{{ route('technician.process.update', $ticket) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Status --}}
                    <div>
                        <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">Status Pekerjaan</label>
                        <select name="status" id="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="assigned" {{ $ticket->status === 'assigned' ? 'selected' : '' }}>📋 Menunggu Dikerjakan</option>
                            <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>⚙️ Sedang Dikerjakan</option>
                            <option value="pending" {{ $ticket->status === 'pending' ? 'selected' : '' }}>⏸️ Tertunda</option>
                            <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>✅ Selesai</option>
                            <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>🔒 Ditutup</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Catatan Pekerjaan --}}
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Pekerjaan</label>
                        <textarea name="notes" id="notes" rows="6" placeholder="Masukkan catatan lengkap tentang pekerjaan yang telah dilakukan..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $ticket->notes ?? '' }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div>
                        <label for="completion_date" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Penyelesaian (Opsional)</label>
                        <input type="date" name="completion_date" id="completion_date" value="{{ $ticket->completion_date ? $ticket->completion_date->format('Y-m-d') : '' }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('completion_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-4 pt-6 border-t border-slate-200">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                            💾 Simpan Perubahan
                        </button>
                        <a href="{{ route('technician.process.show', $ticket) }}" class="flex-1 px-6 py-3 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-semibold transition text-center">
                            ❌ Batal
                        </a>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
