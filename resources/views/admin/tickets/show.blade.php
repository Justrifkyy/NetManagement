<x-app-layout>
    <div class="py-10 bg-slate-950 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('admin.tickets.index') }}" class="text-purple-400 hover:text-purple-300 font-medium">← Kembali</a>
                <h2 class="text-3xl font-extrabold text-white mt-2">Detail Tiket #{{ $ticket->id }}</h2>
            </div>

            <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Pelanggan</h3>
                            <p class="text-lg font-bold text-white mt-1">{{ $ticket->customer->user->name }}</p>
                            <p class="text-sm text-slate-300">{{ $ticket->customer->phone_number }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Tipe Tiket</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1 @switch($ticket->type)
                                @case('survey') bg-blue-900 text-blue-200 @break
                                @case('installation') @break
                                @case('troubleshoot') @break
                                @default
                            @endswitch">
                                {{ ucfirst($ticket->type) }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Subjek</h3>
                            <p class="text-white mt-1">{{ $ticket->subject }}</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Status</h3>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1 @switch($ticket->status)
                                @case('open') bg-red-900 text-red-200 @break
                                @case('assigned') @break
                                @case('in_progress') @break
                                @case('resolved') @break
                                @case('closed') @break
                            @endswitch">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Teknisi</h3>
                            <p class="text-white mt-1">
                                @if ($ticket->technician)
                                    {{ $ticket->technician->name }}
                                @else
                                    <span class="text-slate-400">Belum ditugaskan</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-slate-300 uppercase">Dibuat Pada</h3>
                            <p class="text-white mt-1">{{ $ticket->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Details -->
                @if ($ticket->survey_notes || $ticket->installation_notes)
                    <div class="border-t border-slate-800 mt-8 pt-8">
                        <h3 class="text-lg font-bold text-white mb-4">Detail Pekerjaan</h3>
                        
                        @if ($ticket->survey_notes)
                            <div class="mb-4 p-4 bg-blue-900/30 rounded-lg border border-blue-700">
                                <h4 class="font-semibold text-blue-300">🔍 Catatan Survey:</h4>
                                <p class="text-blue-200 mt-2">{{ $ticket->survey_notes }}</p>
                            </div>
                        @endif

                        @if ($ticket->installation_notes)
                            <div class="p-4 bg-green-900/30 rounded-lg border border-green-700">
                                <h4 class="font-semibold text-green-300">🔧 Catatan Instalasi:</h4>
                                <p class="text-green-200 mt-2">{{ $ticket->installation_notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex gap-4 mt-8 pt-8 border-t border-slate-800">
                    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium">
                        Edit
                    </a>
                    <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('Hapus tiket ini?')">
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
