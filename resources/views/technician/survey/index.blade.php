<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-yellow-400">🔍 Daftar Survey</h1>
                    <p class="text-slate-400 mt-1">Kelola hasil survey lokasi pelanggan</p>
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
                                <th class="px-6 py-3 text-yellow-400 font-bold">Status Survey</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Tanggal Survey</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Teknisi</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse($surveys as $survey)
                                <tr class="hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 font-semibold text-yellow-300">{{ $survey->lead->name }}</td>
                                    <td class="px-6 py-4">
                                        @if($survey->survey_status == 'layak')
                                            <span class="bg-green-900/50 text-green-300 px-3 py-1 rounded-full text-xs font-bold">✅ Layak</span>
                                        @elseif($survey->survey_status == 'tidak_layak')
                                            <span class="bg-red-900/50 text-red-300 px-3 py-1 rounded-full text-xs font-bold">❌ Tidak Layak</span>
                                        @else
                                            <span class="bg-slate-700 text-slate-300 px-3 py-1 rounded-full text-xs">Belum</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $survey->survey_date?->format('d M Y') ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $survey->technician?->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('technician.survey.edit', $survey->lead_id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold text-sm">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                        📭 Tidak ada data survey
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 px-4 sm:px-0">
                {{ $surveys->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
