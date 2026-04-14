<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-yellow-400">🔨 Daftar Instalasi</h1>
                    <p class="text-slate-400 mt-1">Kelola pekerjaan instalasi jaringan pelanggan</p>
                </div>
                <a href="{{ route('technician.dashboard') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">← Kembali</a>
            </div>

            @if(session('success'))
                <div class="mb-6 mx-4 sm:mx-0 bg-green-900/50 border border-green-500 text-green-300 p-4 rounded-lg">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- Table -->
            <div class="bg-slate-800 rounded-xl shadow-lg overflow-hidden mx-4 sm:mx-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-300">
                        <thead class="bg-slate-700 border-b border-yellow-400">
                            <tr>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Nama Pelanggan</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Jenis Koneksi</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Tanggal</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Status</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Teknisi</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse($installations as $installation)
                                <tr class="hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 font-semibold text-yellow-300">{{ $installation->lead->name }}</td>
                                    <td class="px-6 py-4">
                                        @if($installation->connection_type == 'fiber')
                                            <span class="bg-blue-900/50 text-blue-300 px-2 py-1 rounded text-xs font-bold">🔌 Fiber</span>
                                        @elseif($installation->connection_type == 'wireless')
                                            <span class="bg-purple-900/50 text-purple-300 px-2 py-1 rounded text-xs font-bold">📡 Wireless</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $installation->installation_date?->format('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if($installation->installation_status == 'berhasil')
                                            <span class="bg-green-900/50 text-green-300 px-3 py-1 rounded-full text-xs font-bold">✅ Berhasil</span>
                                        @elseif($installation->installation_status == 'gagal')
                                            <span class="bg-red-900/50 text-red-300 px-3 py-1 rounded-full text-xs font-bold">❌ Gagal</span>
                                        @else
                                            <span class="bg-yellow-900/50 text-yellow-300 px-3 py-1 rounded-full text-xs font-bold">⏳ Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $installation->technician?->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="space-x-2">
                                            <a href="{{ route('technician.installation.show', $installation->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold text-sm">Detail</a>
                                            <a href="{{ route('technician.installation.edit', $installation->id) }}" class="text-cyan-400 hover:text-cyan-300 font-semibold text-sm">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                        📭 Tidak ada data instalasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 px-4 sm:px-0">
                {{ $installations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
