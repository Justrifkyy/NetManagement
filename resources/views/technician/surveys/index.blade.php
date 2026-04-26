<x-app-layout>
    <div class="py-10 bg-slate-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-8 px-4 sm:px-0 flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-yellow-400">🔍 Calon Pelanggan untuk Survey</h1>
                    <p class="text-slate-400 mt-1">Daftar prospek yang memerlukan survey lokasi</p>
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
                                <th class="px-6 py-3 text-yellow-400 font-bold">Telepon</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Alamat Instalasi</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Paket</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Status</th>
                                <th class="px-6 py-3 text-yellow-400 font-bold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @forelse($available_leads as $lead)
                                <tr class="hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 font-semibold text-yellow-300">{{ $lead->name }}</td>
                                    <td class="px-6 py-4">{{ $lead->phone ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ Str::limit($lead->address_installation ?? '-', 40) }}</td>
                                    <td class="px-6 py-4">{{ $lead->package->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-900/50 text-blue-300 px-3 py-1 rounded-full text-xs font-bold">
                                            {{ ucfirst($lead->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('technician.survey.create', $lead->id) }}" class="text-yellow-400 hover:text-yellow-300 font-semibold text-sm">
                                            📋 Mulai Survey
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                        📭 Tidak ada calon pelanggan yang memerlukan survey
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 px-4 sm:px-0">
                {{ $available_leads->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
