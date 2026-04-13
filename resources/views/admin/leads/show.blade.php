<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.leads.index') }}" class="text-amber-400 hover:text-amber-300 font-medium">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-white mt-2">Detail Lead</h2>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-8 border-b border-slate-800">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Nama Pelanggan</h3>
                            <p class="text-lg font-bold text-white mt-1">{{ $lead->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Kontak</h3>
                            <p class="text-white mt-1">{{ $lead->phone }}</p>
                            @if ($lead->email)
                                <p class="text-white">{{ $lead->email }}</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Jenis Pelanggan</h3>
                            <p class="text-white mt-1">{{ ucfirst($lead->customer_type ?? '-') }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Alamat Instalasi</h3>
                            <p class="text-white mt-1 text-sm">{{ $lead->address_installation ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Status</h3>
                            <x-status-badge :status="$lead->status" variant="md" class="mt-1" />
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Paket</h3>
                            <p class="text-white mt-1">{{ $lead->package->name ?? '-' }}</p>
                            @if ($lead->package)
                                <p class="text-sm text-slate-300">Rp. {{ number_format($lead->package->price, 0, ',', '.') }} / bulan</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Marketing</h3>
                            <p class="text-white mt-1">{{ $lead->marketing->name ?? '-' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Sumber</h3>
                            <p class="text-white mt-1">{{ ucfirst($lead->source ?? '-') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if ($lead->notes_summary || $lead->notes_obstacle || $lead->notes_special)
                    <div class="mt-8 pt-8 border-b border-slate-800">
                        <h3 class="text-lg font-bold text-white mb-4">Catatan</h3>
                        
                        @if ($lead->notes_summary)
                            <div class="mb-3">
                                <p class="text-sm font-semibold text-slate-300">Ringkas:</p>
                                <p class="text-slate-300">{{ $lead->notes_summary }}</p>
                            </div>
                        @endif

                        @if ($lead->notes_obstacle)
                            <div class="mb-3">
                                <p class="text-sm font-semibold text-slate-300">Hambatan:</p>
                                <p class="text-slate-300">{{ $lead->notes_obstacle }}</p>
                            </div>
                        @endif

                        @if ($lead->notes_special)
                            <div>
                                <p class="text-sm font-semibold text-slate-300">Khusus:</p>
                                <p class="text-slate-300">{{ $lead->notes_special }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex gap-4 mt-8 pt-8 border-t border-slate-800">
                    <a href="{{ route('admin.leads.edit', $lead) }}" class="px-6 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 font-medium">
                        Edit
                    </a>
                    <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="inline" onsubmit="return confirm('Hapus lead ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
