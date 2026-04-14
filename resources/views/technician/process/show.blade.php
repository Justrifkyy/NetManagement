<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Detail Tugas #' . $ticket->id) }}
            </h2>
            <a href="{{ route('technician.process.index') }}" class="text-white hover:text-slate-300">
                &larr; Kembali ke Daftar Tugas
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-sky-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Status Bar --}}
            <div class="mb-6 bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase">Status Tugas</p>
                        <div class="mt-2 flex items-center gap-4">
                            @php
                                $statusColors = [
                                    'assigned' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Menunggu Dikerjakan'],
                                    'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Sedang Dikerjakan'],
                                    'pending' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-700', 'label' => 'Tertunda'],
                                    'resolved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Selesai'],
                                    'closed' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'label' => 'Ditutup'],
                                ];
                                $color = $statusColors[$ticket->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'label' => 'Unknown'];
                            @endphp
                            <span class="px-4 py-2 {{ $color['bg'] }} {{ $color['text'] }} text-sm font-bold rounded-lg">
                                {{ $color['label'] }}
                            </span>
                            <p class="text-slate-600">
                                Dibuat: <span class="font-semibold">{{ $ticket->created_at->format('d M Y H:i') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">

                {{-- Kolom Kiri: Informasi Pelanggan --}}
                <div class="col-span-2">
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Pelanggan</h3>
                        @php
                            $customer = $ticket->customer;
                            $user = $customer->user ?? null;
                        @endphp
                        <div class="space-y-3">
                            <div class="flex justify-between py-2 border-b border-slate-200">
                                <span class="text-slate-600 font-semibold">Nama:</span>
                                <span class="text-slate-800">{{ $user->name ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-200">
                                <span class="text-slate-600 font-semibold">No. Telepon:</span>
                                <span class="text-slate-800">{{ $customer->phone ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-200">
                                <span class="text-slate-600 font-semibold">Email:</span>
                                <span class="text-slate-800">{{ $user->email ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-200">
                                <span class="text-slate-600 font-semibold">Alamat:</span>
                                <span class="text-slate-800">{{ $customer->address ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Tugas --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Detail Pekerjaan</h3>
                        <div class="space-y-3">
                            <div class="py-2 border-b border-slate-200">
                                <p class="text-sm text-slate-600 font-semibold uppercase">Tipe Pekerjaan</p>
                                <p class="text-slate-800 mt-1">{{ ucfirst($ticket->type ?? 'General') }}</p>
                            </div>
                            <div class="py-2 border-b border-slate-200">
                                <p class="text-sm text-slate-600 font-semibold uppercase">Deskripsi</p>
                                <p class="text-slate-800 mt-1">{{ $ticket->description ?? '-' }}</p>
                            </div>
                            <div class="py-2">
                                <p class="text-sm text-slate-600 font-semibold uppercase">Catatan Teknis</p>
                                <p class="text-slate-800 mt-1">{{ $ticket->technical_notes ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Aksi --}}
                <div>
                    <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4">Aksi</h3>
                        <div class="space-y-3">
                            @if($ticket->status !== 'assigned')
                                <a href="{{ route('technician.process.edit', $ticket) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                                    ✏️ Edit Laporan
                                </a>
                            @endif

                            @if($ticket->status === 'assigned')
                                <form action="{{ route('technician.process.update', $ticket) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="in_progress">
                                    <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-semibold">
                                        ▶️ Mulai Pengerjaan
                                    </button>
                                </form>
                            @endif

                            @if(in_array($ticket->status, ['assigned', 'in_progress']))
                                <a href="{{ route('technician.process.edit', $ticket) }}" class="block w-full text-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 font-semibold">
                                    📝 Input Laporan
                                </a>
                            @endif

                            @if($ticket->status === 'in_progress')
                                <form action="{{ route('technician.process.update', $ticket) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="resolved">
                                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
                                        ✅ Tandai Selesai
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('technician.process.index') }}" class="block w-full text-center px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 font-semibold">
                                ← Kembali
                            </a>
                        </div>

                        {{-- Info Status Timeline --}}
                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <p class="text-sm font-semibold text-slate-600 uppercase mb-3">Timeline</p>
                            <div class="space-y-2 text-xs text-slate-600">
                                <div>📅 Dibuat: {{ $ticket->created_at->format('d M Y H:i') }}</div>
                                @if($ticket->updated_at)
                                    <div>🔄 Diperbarui: {{ $ticket->updated_at->format('d M Y H:i') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
