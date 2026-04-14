<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-yellow-400">✅ Serah Terima / Handover</h1>
                        <p class="text-slate-400 mt-1">Instalasi: <span class="text-yellow-300 font-semibold">{{ $installation->lead->name }}</span></p>
                    </div>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 mx-4 sm:mx-0 bg-red-900/50 border-l-4 border-red-500 text-red-300 p-4 rounded-r">
                    <p class="font-bold mb-2">⚠️ Terdapat kesalahan:</p>
                    <ul class="list-disc ml-6 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('technician.handover.store', $installation->id) }}" method="POST" class="space-y-6">
                @csrf

                <!-- DATA SERAH TERIMA -->
                <div class="bg-slate-800 rounded-xl shadow-lg border border-slate-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-400 px-6 py-4 flex items-center">
                        <h2 class="text-xl font-bold text-slate-900">DATA SERAH TERIMA INTERNET</h2>
                    </div>
                    <div class="p-6 space-y-6">

                        <!-- Konfirmasi Internet Aktif -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-3">Konfirmasi Internet Aktif <span class="text-red-500">*</span></label>
                            <div class="bg-slate-700 border-2 border-slate-600 rounded-lg p-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="internet_active_confirmation" value="1" {{ old('internet_active_confirmation', $handover->internet_active_confirmation) ? 'checked' : '' }} class="w-5 h-5 text-yellow-400 rounded">
                                    <span class="ml-3 font-semibold text-yellow-300">🟢 Saya konfirmasi bahwa internet pelanggan sudah aktif dan berfungsi dengan baik</span>
                                </label>
                            </div>
                        </div>

                        <!-- Tanggal Serah Terima -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">Tanggal Serah Terima <span class="text-red-500">*</span></label>
                            <input type="date" name="handover_date" value="{{ old('handover_date', $handover->handover_date?->format('Y-m-d')) }}" required
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        </div>

                        <!-- Catatan Akhir Teknisi -->
                        <div>
                            <label class="block text-sm font-bold text-yellow-400 mb-2">📝 Catatan Akhir Teknisi</label>
                            <textarea name="final_technician_notes" rows="5"
                                class="w-full px-4 py-2 bg-slate-700 border border-slate-600 text-slate-100 rounded-lg focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                                placeholder="Catatan final: Semua pekerjaan selesai, kondisi pelanggan puas, rekomendasi maintenance, dll">{{ old('final_technician_notes', $handover->final_technician_notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mx-4 sm:mx-0">
                    <!-- Installation Summary -->
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-4">
                        <h4 class="text-yellow-400 font-bold mb-3 flex items-center">
                            <span class="w-6 h-6 bg-yellow-400 text-slate-900 rounded-full flex items-center justify-center mr-2 text-sm font-bold">✓</span>
                            Ringkasan Instalasi
                        </h4>
                        <ul class="space-y-2 text-sm text-slate-300">
                            <li><strong>Teknisi:</strong> {{ auth()->user()->name }}</li>
                            <li><strong>Tanggal:</strong> {{ $installation->installation_date?->format('d M Y') ?? '-' }}</li>
                            <li><strong>Jenis Koneksi:</strong> {{ $installation->connection_type ?? '-' }}</li>
                            <li><strong>Status:</strong> {{ $installation->installation_status ?? 'Pending' }}</li>
                        </ul>
                    </div>

                    <!-- Network Summary -->
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-4">
                        <h4 class="text-yellow-400 font-bold mb-3 flex items-center">
                            <span class="w-6 h-6 bg-yellow-400 text-slate-900 rounded-full flex items-center justify-center mr-2 text-sm font-bold">✓</span>
                            Ringkasan Jaringan
                        </h4>
                        <ul class="space-y-2 text-sm text-slate-300">
                            <li><strong>Router:</strong> {{ $installation->networkConfig->router_area ?? '-' }}</li>
                            <li><strong>Port:</strong> {{ $installation->networkConfig->port_interface ?? '-' }}</li>
                            <li><strong>Mode:</strong> {{ $installation->networkConfig->connection_mode ?? '-' }}</li>
                            <li><strong>OLT:</strong> {{ $installation->networkConfig->olt_access_point ?? '-' }}</li>
                        </ul>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col md:flex-row gap-4 px-4 sm:mx-0 mx-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-green-500 text-white font-bold py-3 rounded-lg hover:from-green-700 hover:to-green-600 transition shadow-lg">
                        ✓ Selesaikan Instalasi
                    </button>
                    <a href="{{ route('technician.installation.show', $installation->id) }}" class="flex-1 bg-slate-700 border border-slate-600 text-yellow-300 font-bold py-3 rounded-lg hover:bg-slate-600 transition text-center">
                        ← Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
