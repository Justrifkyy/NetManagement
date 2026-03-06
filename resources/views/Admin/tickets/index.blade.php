<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Instalasi (QC)') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Antrean Verifikasi (QC)</h2>
                    <p class="text-gray-500 mt-1">Periksa laporan teknisi, aktifkan layanan, dan terbitkan tagihan.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 mx-4 sm:mx-0 bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded shadow-sm flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('warning'))
                <div class="mb-6 mx-4 sm:mx-0 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow-sm flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="font-bold">{{ session('warning') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mx-4 sm:mx-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tiket / Layanan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Teknisi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Waktu Selesai</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @php
                                /** @var \App\Models\Ticket $ticket */
                            @endphp
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-red-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $ticket->subject }}</div>
                                        <div class="text-xs text-gray-500 mt-1">Status Laporan: <span class="text-green-600 font-bold">{{ $ticket->installation_status }}</span></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-semibold text-gray-800">{{ $ticket->customer->user->name ?? 'N/A' }}</div>
                                        <div class="text-xs text-blue-600 font-bold">{{ $ticket->customer->lead->package->name ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-700 border border-gray-200">
                                            {{ $ticket->technician->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $ticket->completed_at ? $ticket->completed_at->format('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-500 to-pink-600 text-white font-bold text-xs rounded-lg hover:from-red-600 hover:to-pink-700 shadow-md transform hover:-translate-y-0.5 transition">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Review & Aktifkan
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <p class="font-bold text-gray-700 text-lg">Tidak ada antrean QC.</p>
                                            <p class="text-sm mt-1">Semua pekerjaan teknisi sudah diverifikasi dan diaktifkan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>