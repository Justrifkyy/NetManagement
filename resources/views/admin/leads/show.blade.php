<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.leads.index') }}" class="text-blue-600 hover:text-blue-900 font-medium">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-gray-900 mt-2">Detail Lead</h2>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-8 border-b border-gray-200">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase">Nama Pelanggan</h3>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ $lead->name }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase">Kontak</h3>
                            <p class="text-gray-900 mt-1">{{ $lead->phone }}</p>
                            @if ($lead->email)
                                <p class="text-gray-900">{{ $lead->email }}</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase">Jenis Pelanggan</h3>
                            <p class="text-gray-900 mt-1">{{ ucfirst($lead->customer_type ?? '-') }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase">Alamat Instalasi</h3>
                            <p class="text-gray-900 mt-1 text-sm">{{ $lead->address_installation ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase">Status</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1 @switch($lead->status)
                                @case('prospect') bg-gray-100 text-gray-800 @break
                                @case('contacted') bg-blue-100 text-blue-800 @break
                                @case('qualified') bg-indigo-100 text-indigo-800 @break
                                @case('proposal_sent') bg-purple-100 text-purple-800 @break
                                @case('negotiation') bg-yellow-100 text-yellow-800 @break
                                @case('converted') bg-green-100 text-green-800 @break
                                @case('lost') bg-red-100 text-red-800 @break
                            @endswitch">
                                {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase">Paket</h3>
                            <p class="text-gray-900 mt-1">{{ $lead->package->name ?? '-' }}</p>
                            @if ($lead->package)
                                <p class="text-sm text-gray-600">Rp. {{ number_format($lead->package->price, 0, ',', '.') }} / bulan</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase">Marketing</h3>
                            <p class="text-gray-900 mt-1">{{ $lead->marketing->name ?? '-' }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-gray-600 uppercase">Sumber</h3>
                            <p class="text-gray-900 mt-1">{{ ucfirst($lead->source ?? '-') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Notes Section -->
                @if ($lead->notes_summary || $lead->notes_obstacle || $lead->notes_special)
                    <div class="mt-8 pt-8 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Catatan</h3>
                        
                        @if ($lead->notes_summary)
                            <div class="mb-3">
                                <p class="text-sm font-semibold text-gray-600">Ringkas:</p>
                                <p class="text-gray-700">{{ $lead->notes_summary }}</p>
                            </div>
                        @endif

                        @if ($lead->notes_obstacle)
                            <div class="mb-3">
                                <p class="text-sm font-semibold text-gray-600">Hambatan:</p>
                                <p class="text-gray-700">{{ $lead->notes_obstacle }}</p>
                            </div>
                        @endif

                        @if ($lead->notes_special)
                            <div>
                                <p class="text-sm font-semibold text-gray-600">Khusus:</p>
                                <p class="text-gray-700">{{ $lead->notes_special }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex gap-4 mt-8 pt-8 border-t border-gray-200">
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
