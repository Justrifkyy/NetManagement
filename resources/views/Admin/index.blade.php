<x-app-layout>
    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-8 px-4 sm:px-0 flex flex-col md:flex-row justify-between items-start md:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard Admin</h2>
                    <p class="text-gray-500 mt-1">Pusat kontrol operasional, verifikasi QC, dan ringkasan keuangan.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 border border-purple-200 shadow-sm">
                        <span class="flex w-2 h-2 bg-purple-600 rounded-full mr-2"></span>
                        Akses Level: {{ str_replace('_', ' ', strtoupper(Auth::user()->role)) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-4 sm:px-0 mb-8">
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition flex items-center relative overflow-hidden">
                    <div class="absolute right-0 top-0 mt-4 mr-4 text-green-100">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    </div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-xl mr-4 z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="z-10">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pelanggan Aktif</p>
                        <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $stats['active_subs'] }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition flex items-center relative overflow-hidden">
                    <div class="absolute right-0 top-0 mt-4 mr-4 text-blue-100">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                    </div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl mr-4 z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="z-10">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-red-100 hover:shadow-md transition flex items-center relative overflow-hidden">
                    <div class="absolute right-0 top-0 mt-4 mr-4 text-red-50">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="p-3 bg-red-50 text-red-600 rounded-xl mr-4 z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="z-10">
                        <p class="text-xs font-bold text-red-400 uppercase tracking-wider">Menunggu QC</p>
                        <h3 class="text-3xl font-black text-red-600 mt-1">{{ $stats['pending_qc'] }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition flex items-center relative overflow-hidden">
                    <div class="absolute right-0 top-0 mt-4 mr-4 text-yellow-50">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
                    </div>
                    <div class="p-3 bg-yellow-50 text-yellow-600 rounded-xl mr-4 z-10">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                    </div>
                    <div class="z-10">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Prospek Baru</p>
                        <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $stats['new_leads'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-0">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Laporan Teknisi Menunggu Verifikasi (QC)
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Cek foto bukti pasang sebelum mengaktifkan internet pelanggan.</p>
                        </div>
                        <a href="{{ route('admin.tickets.index') }}" class="text-sm font-bold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-lg border border-red-100 transition shadow-sm">Lihat Semua QC &rarr;</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-white">
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
                                @forelse($pendingTickets as $ticket)
                                    <tr class="hover:bg-red-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $ticket->subject }}</div>
                                            <div class="text-xs text-gray-500 mt-1">Status Laporan: <span class="text-green-600 font-bold">{{ $ticket->installation_status }}</span></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-semibold text-gray-800">{{ $ticket->customer->user->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">{{ $ticket->customer->phone_number ?? '-' }}</div>
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
                                                Lakukan QC
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mb-3">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                                <p class="font-bold text-gray-700">Tidak ada tiket yang menunggu verifikasi.</p>
                                                <p class="text-sm">Semua pekerjaan teknisi sudah diperiksa.</p>
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
    </div>
</x-app-layout>